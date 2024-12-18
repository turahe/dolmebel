<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __("Profile Information") }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form
        id="send-verification"
        method="post"
        action="{{ route("verification.send") }}"
    >
        @csrf
    </form>

    <form
        method="post"
        action="{{ route("profile.update") }}"
        class="mt-6 space-y-6"
    >
        @csrf
        @method("patch")

        <div>
            <x-input-label for="username" :value="__('Username')" />
            <div class="relative">
                <div
                    class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5"
                >
                    <svg
                        class="h-3 w-3 text-gray-500 dark:text-gray-400"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        viewBox="0 0 20 16"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"
                        />
                    </svg>
                </div>
                <x-text-input
                    id="username"
                    name="username"
                    type="text"
                    class="mt-1 block w-full p-2.5 ps-10"
                    :value="old('username', $user->username)"
                    required
                    autofocus
                    autocomplete="username"
                />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>

        <div>
            <x-input-label for="phone" :value="__('Phone')" />
            <div class="relative">
                <div
                    class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5"
                >
                    <svg
                        class="h-3 w-3 text-gray-500 dark:text-gray-400"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        viewBox="0 0 20 16"
                    >
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                    </svg>
                </div>
                <x-text-input
                    x-mask:dynamic="phoneNumberMask"
                    id="phone"
                    name="phone"
                    type="text"
                    class="mt-1 block w-full p-2.5 ps-10"
                    :value="old('phone', $user->phone)"
                    requiredrr
                    autofocus
                    autocomplete="phone"
                />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <div class="relative">
                <div
                    class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5"
                >
                    <svg
                        class="h-3 w-3 text-gray-500 dark:text-gray-400"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        viewBox="0 0 20 16"
                    >
                        <path
                            d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z"
                        />
                        <path
                            d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z"
                        />
                    </svg>
                </div>
                <x-text-input
                    id="email"
                    name="email"
                    type="email"
                    class="mt-1 block w-full p-2.5 ps-10"
                    :value="old('email', $user->email)"
                    required
                    autocomplete="username"
                />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="mt-2 text-sm text-gray-800 dark:text-gray-200">
                        {{ __("Your email address is unverified.") }}

                        <button
                            form="send-verification"
                            class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
                        >
                            {{ __("Click here to re-send the verification email.") }}
                        </button>
                    </p>

                    @if (session("status") === "verification-link-sent")
                        <p
                            class="mt-2 text-sm font-medium text-green-600 dark:text-green-400"
                        >
                            {{ __("A new verification link has been sent to your email address.") }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __("Save") }}</x-primary-button>

            @if (session("status") === "profile-updated")
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => (show = false), 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >
                    {{ __("Saved.") }}
                </p>
            @endif
        </div>
    </form>
</section>
