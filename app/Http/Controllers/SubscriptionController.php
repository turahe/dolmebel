<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\ShopRepositoryInterface;
use App\Http\Requests\UpdateTrialPeriodRequest;
use App\Http\Resources\SubscriptionPlanResource;
use App\Jobs\SubscribeShopToNewPlan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Turahe\Subscription\Models\PlanSubscription;

class SubscriptionController
{
    use AuthorizesRequests;

    public function __construct(
        private ShopRepositoryInterface $shopRepository,
    ) {}

    /**
     * Display the subscription features.
     *
     * @return SubscriptionPlanResource
     */
    public function features(PlanSubscription $subscriptionPlan)
    {
        return new SubscriptionPlanResource($subscriptionPlan);
    }

    /**
     * Subscribe Or Swap to the given subscription
     *
     * @param  string  $plan
     * @param  int  $merchant
     * @return SubscriptionPlanResource|\Illuminate\Http\JsonResponse
     */
    public function subscribe($plan, $merchant = null)
    {
        $merchant = $merchant ? User::findOrFail($merchant) : Auth::user();

        if (! $merchant->hasBillingToken()) {
            return response()->json(['error' => trans('messages.no_card_added')]);
        }

        // create the subscription
        try {
            $subscription = PlanSubscription::findOrFail($plan);

            // If the merchant already has any subscription then just swap to new plan
            $currentPlan = $merchant->getCurrentPlan();

            if ($currentPlan) {
                if (! $this->validateSubscriptionSwap($subscription)) {
                    $msg = trans('messages.using_more_resource', ['plan' => $subscription->name]);

                    return response()->json('admin.account.billing')->with('error', $msg);
                }

                $currentPlan->swap($plan)->update(['name' => $subscription->name]);

                $merchant->shop->forceFill([
                    'current_billing_plan' => $plan,
                ])->save();
            } else {
                // Subscribe the merchant to the given plan
                SubscribeShopToNewPlan::dispatchSync($merchant, $plan);
            }
        } catch (\Exception $e) {
            Log::error('Subscription Failed: '.$e->getMessage());

            return response()->json(['error' => trans('messages.subscription_error')]);
        }

        return new SubscriptionPlanResource($subscription);
    }

    /**
     * Update the shop's card info
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCardinfo(Request $request)
    {
        if (config('app.demo') === true && $request->user()->merchantId() <= config('system.demo.shops', 1)) {
            return redirect()->route('admin.account.billing')
                ->with('warning', trans('messages.demo_restriction'));
        }

        // Create Stripe customer if not exist
        if (! $request->user()->hasBillingToken()) {
            $request->user()->shop->createAsStripeCustomer([
                'email' => $request->user()->email,
            ]);
        }

        if ($request->has('payment')) {
            $request->user()->shop->updateDefaultPaymentMethod($request->input('payment'));

            $request->user()->shop->forceFill(['card_holder_name' => $request->input('name')])->save();

            return redirect()->route('admin.account.billing')
                ->with('success', trans('messages.card_updated'));
        }

        return redirect()->route('admin.account.billing')
            ->with('error', trans('messages.trouble_validating_card'))->withInput();
    }

    /**
     * Resume subscription
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resumeSubscription(Request $request)
    {
        if (
            config('app.demo') === true &&
            $request->user()->merchantId() <= config('system.demo.shops', 1)
        ) {
            return redirect()->route('admin.account.billing')
                ->with('warning', trans('messages.demo_restriction'));
        }

        try {
            $request->user()->getCurrentPlan()->resume();
        } catch (\Stripe\Error\Card $e) {
            $response = $e->getJsonBody();

            return redirect()->route('admin.account.billing')
                ->with('error', $response['error']['message']);
        }

        return redirect()->route('admin.account.billing')
            ->with('success', trans('messages.subscription_resumed'));
    }

    /**
     * Cancel subscription
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function cancelSubscription(Request $request)
    {
        if (config('app.demo') === true && $request->user()->merchantId() <= config('system.demo.shops', 1)) {
            return redirect()->route('admin.account.billing')
                ->with('warning', trans('messages.demo_restriction'));
        }

        try {
            $plan = $request->user()->getCurrentPlan();

            if ($plan) {
                $plan->cancel();
            } else {
                throw new \Exception(trans('responses.subscription_404'));
            }
        } catch (\Stripe\Error\Card $e) {
            $response = $e->getJsonBody();

            return redirect()->route('admin.account.billing')
                ->with(['error' => $response['error']['message']]);
        } catch (Exception $e) {
            return redirect()->route('admin.account.billing')
                ->with(['error' => $e->getMessage()]);
        }

        return redirect()->route('admin.account.billing')
            ->with('success', trans('messages.subscription_cancelled'));
    }

    /**
     * Update subscription trial period
     *
     * @param  string  $slug  shop
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateTrial(UpdateTrialPeriodRequest $request, string $slug)
    {
        $shop = $this->shopRepository->getId($slug);
        $new_end_time = Carbon::createFromFormat('Y-m-d h:i a', $request->trial_ends_at);

        try {
            $currentPlan = $shop->owner->getCurrentPlan();

            if ($currentPlan) {
                // Update the local plan
                $currentPlan->update(['trial_ends_at' => $new_end_time->getTimestamp()]);

                // Now update the plan on stripe
                if ($currentPlan->stripe_id || config('system.subscription.billing') === 'stripe') {
                    $currentPlan->extendTrial($new_end_time);
                }
            }

            if ($shop->onGenericTrial() || $shop->hasExpiredPlan()) {
                $shop->forceFill([
                    'trial_ends_at' => $new_end_time->getTimestamp(),
                    'hide_trial_notice' => $request->hide_trial_notice,
                ])->save();
            }
        } catch (\Exception $e) {
            Log::error('Subscription Trial Period Update Failed: '.$e->getMessage());

            return back()->with('error', trans('messages.subscription_update_failed'));
        }

        return back()->with('success', trans('messages.subscription_updated'));
    }
}
