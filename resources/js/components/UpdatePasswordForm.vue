<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Update Password
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Ensure your account is using a long, random password to stay
                secure.
            </p>
        </header>

        <form @submit.prevent="submit" class="mt-6 space-y-6">
            <!-- Current Password -->
            <div>
                <label
                    for="current_password"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                    Current Password
                </label>
                <div class="relative mt-1">
                    <input
                        id="current_password"
                        v-model="form.current_password"
                        :type="showCurrentPassword ? 'text' : 'password'"
                        class="focus:ring-primary focus:border-primary block w-full rounded-md border border-gray-300 px-3 py-2 pr-10 placeholder-gray-400 shadow-sm focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        autocomplete="current-password"
                    />
                    <button
                        type="button"
                        @click="showCurrentPassword = !showCurrentPassword"
                        class="absolute inset-y-0 right-0 flex items-center pr-3"
                    >
                        <svg
                            v-if="showCurrentPassword"
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
                    v-if="form.errors.current_password"
                    class="mt-2 text-sm text-red-600"
                >
                    {{ form.errors.current_password }}
                </div>
            </div>

            <!-- New Password -->
            <div>
                <label
                    for="password"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                    New Password
                </label>
                <div class="relative mt-1">
                    <input
                        id="password"
                        v-model="form.password"
                        :type="showPassword ? 'text' : 'password'"
                        class="focus:ring-primary focus:border-primary block w-full rounded-md border border-gray-300 px-3 py-2 pr-10 placeholder-gray-400 shadow-sm focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        autocomplete="new-password"
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

            <!-- Confirm Password -->
            <div>
                <label
                    for="password_confirmation"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                    Confirm Password
                </label>
                <div class="relative mt-1">
                    <input
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        :type="showConfirmPassword ? 'text' : 'password'"
                        class="focus:ring-primary focus:border-primary block w-full rounded-md border border-gray-300 px-3 py-2 pr-10 placeholder-gray-400 shadow-sm focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        autocomplete="new-password"
                    />
                    <button
                        type="button"
                        @click="showConfirmPassword = !showConfirmPassword"
                        class="absolute inset-y-0 right-0 flex items-center pr-3"
                    >
                        <svg
                            v-if="showConfirmPassword"
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
                    v-if="form.errors.password_confirmation"
                    class="mt-2 text-sm text-red-600"
                >
                    {{ form.errors.password_confirmation }}
                </div>
            </div>

            <div class="flex items-center gap-4">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="bg-primary hover:bg-primary-dark focus:bg-primary-dark active:bg-primary-dark focus:ring-primary inline-flex items-center rounded-md border border-transparent px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out focus:ring-2 focus:ring-offset-2 focus:outline-none disabled:opacity-50"
                >
                    {{ form.processing ? "Saving..." : "Save" }}
                </button>

                <div
                    v-if="status === 'password-updated'"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >
                    Saved.
                </div>
            </div>
        </form>
    </section>
</template>

<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    status: String,
});

const showCurrentPassword = ref(false);
const showPassword = ref(false);
const showConfirmPassword = ref(false);

const form = useForm({
    current_password: "",
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.put(route("password.update"), {
        onFinish: () => form.reset(),
    });
};
</script>
