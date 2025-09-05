<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\UserRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Inertia\Inertia;
use Turahe\SEOTools\Contracts\Tools;

class RegisteredUserController extends Controller
{
    public function __construct(private Tools $meta, private UserRepositoryInterface $userRepository) {}

    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $this->meta->setTitle(__('Register'));

        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request): RedirectResponse
    {

        $user = $this->userRepository->createUser($request->validated());

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
