<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\CartRepositoryInterface;
use App\Http\Requests\Cart\CreateCartRequest;
use App\Http\Requests\Cart\UpdateCartRequest;
use App\Models\Cart;
use App\Repositories\CartRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

/**
 * @group Cart
 */
class CartController
{
    use AuthorizesRequests;

    /**
     * construct
     */
    public function __construct(private CartRepositoryInterface $cart) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View
     *
     * @throws AuthorizationException
     *
     * @apiResourceCollection App\Http\Resources\CartResource
     *
     * @apiResourceModel App\Models\Cart
     */
    public function index()
    {
        $this->authorize('viewAny', Cart::class);
        $carts = $this->cart->getUserCarts();

        return view('cart.index', compact('carts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws AuthorizationException
     */
    public function store(CreateCartRequest $request)
    {
        $this->authorize('create', Cart::class);
        $cart = $this->cart->createCart($request->validated());

        return redirect()->route('cart.index');
    }

    /**
     * Display the specified resource.
     *
     * @throws AuthorizationException
     */
    public function show(string $id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View
    {
        $cart = $this->cart->getCart($id);
        $this->authorize('view', $cart);

        return view('cart.show', compact('cart'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws AuthorizationException
     * @throws \Exception
     */
    public function update(UpdateCartRequest $request, string $id)
    {
        $cart = $this->cart->getCart($id);
        $this->authorize('update', $cart);
        $cartRepo = new CartRepository($cart);
        $cartRepo->updateCart($request->all());

        return redirect()->route('cart.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws AuthorizationException
     * @throws \Exception
     */
    public function destroy(string $id)
    {
        $cart = $this->cart->getCart($id);
        $this->authorize('delete', $cart);
        $cartRepo = new CartRepository($cart);
        $cartRepo->deleteCart();

        return redirect()->route('cart.index');
    }

    /**
     * Trash the mass resources.
     *
     * @throws AuthorizationException
     */
    public function massDestroy(Request $request)
    {
        $this->authorize('delete', Cart::class);
        $request->validate(['ids' => 'required|array']);
        $this->cart->massDestroy($request->ids);

        return response()->noContent();
    }
}
