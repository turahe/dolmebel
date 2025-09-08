<template>
    <AuthLayout>
        <!-- Session Status -->
        <div
            v-if="status"
            class="mb-4 text-sm text-green-600 dark:text-green-400"
        >
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <!-- Email Address -->
            <div>
                <label
                    for="email"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                    Email
                </label>
                <input
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="focus:ring-primary focus:border-primary mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    required
                    autofocus
                    autocomplete="username"
                />
                <div v-if="form.errors.email" class="mt-2 text-sm text-red-600">
                    {{ form.errors.email }}
                </div>
            </div>

            <!-- Password -->
            <div>
                <label
                    for="password"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                    Password
                </label>
                <div class="relative mt-1">
                    <input
                        id="password"
                        v-model="form.password"
                        :type="showPassword ? 'text' : 'password'"
                        class="focus:ring-primary focus:border-primary block w-full rounded-md border border-gray-300 px-3 py-2 pr-10 placeholder-gray-400 shadow-sm focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        required
                        autocomplete="current-password"
                    />
                    <button
                        type="button"
                        @click="showPassword = !showPassword"
                        class="absolute inset-y-0 right-0 flex items-center pr-3"
                    >
                        <svg
                            v-if="showPassword"
                            class="h-5 w-5 text-gray-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                            ></path>
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                            ></path>
                        </svg>
                        <svg
                            v-else
                            class="h-5 w-5 text-gray-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"
                            ></path>
                        </svg>
                    </button>
                </div>
                <div
                    v-if="form.errors.password"
                    class="mt-2 text-sm text-red-600"
                >
                    {{ form.errors.password }}
                </div>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input
                    id="remember_me"
                    v-model="form.remember"
                    type="checkbox"
                    class="text-primary focus:ring-primary h-4 w-4 rounded border-gray-300 dark:border-gray-600"
                />
                <label
                    for="remember_me"
                    class="ml-2 block text-sm text-gray-700 dark:text-gray-300"
                >
                    Remember me
                </label>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-sm text-gray-600 underline hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100"
                >
                    Forgot your password?
                </Link>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="bg-primary hover:bg-primary-dark focus:bg-primary-dark active:bg-primary-dark focus:ring-primary inline-flex items-center rounded-md border border-transparent px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out focus:ring-2 focus:ring-offset-2 focus:outline-none disabled:opacity-50"
                >
                    {{ form.processing ? "Logging in..." : "Log in" }}
                </button>
            </div>

            <!-- Register Link -->
            <div class="text-center">
                <span class="text-sm text-gray-600 dark:text-gray-400">
                    Don't have an account?
                </span>
                <Link
                    :href="route('register')"
                    class="text-primary hover:text-primary-dark ml-1 text-sm underline"
                >
                    Register here
                </Link>
            </div>
        </form>
    </AuthLayout>
</template>

<script setup>
import { ref } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import AuthLayout from "@/Layouts/AuthLayout.vue";

const props = defineProps({
    status: String,
    canResetPassword: Boolean,
});

const showPassword = ref(false);

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>
