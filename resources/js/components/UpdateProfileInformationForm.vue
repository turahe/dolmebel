<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Profile Information
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Update your account's profile information and email address.
            </p>
        </header>

        <form @submit.prevent="submit" class="mt-6 space-y-6">
            <!-- Username -->
            <div>
                <label
                    for="username"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                    Username
                </label>
                <div class="relative mt-1">
                    <div
                        class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5"
                    >
                        <svg
                            class="h-3 w-3 text-gray-500 dark:text-gray-400"
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
                    <input
                        id="username"
                        v-model="form.username"
                        type="text"
                        class="focus:ring-primary focus:border-primary block w-full rounded-md border border-gray-300 p-2.5 ps-10 placeholder-gray-400 shadow-sm focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        required
                        autofocus
                        autocomplete="username"
                    />
                </div>
                <div
                    v-if="form.errors.username"
                    class="mt-2 text-sm text-red-600"
                >
                    {{ form.errors.username }}
                </div>
            </div>

            <!-- Phone -->
            <div>
                <label
                    for="phone"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                    Phone
                </label>
                <div class="relative mt-1">
                    <div
                        class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5"
                    >
                        <svg
                            class="h-3 w-3 text-gray-500 dark:text-gray-400"
                            fill="currentColor"
                            viewBox="0 0 20 16"
                        >
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"
                            />
                        </svg>
                    </div>
                    <input
                        id="phone"
                        v-model="form.phone"
                        type="text"
                        class="focus:ring-primary focus:border-primary block w-full rounded-md border border-gray-300 p-2.5 ps-10 placeholder-gray-400 shadow-sm focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        required
                        autocomplete="phone"
                    />
                </div>
                <div v-if="form.errors.phone" class="mt-2 text-sm text-red-600">
                    {{ form.errors.phone }}
                </div>
            </div>

            <!-- Email -->
            <div>
                <label
                    for="email"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                    Email
                </label>
                <div class="relative mt-1">
                    <div
                        class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5"
                    >
                        <svg
                            class="h-3 w-3 text-gray-500 dark:text-gray-400"
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
                    <input
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="focus:ring-primary focus:border-primary block w-full rounded-md border border-gray-300 p-2.5 ps-10 placeholder-gray-400 shadow-sm focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        required
                        autocomplete="username"
                    />
                </div>
                <div v-if="form.errors.email" class="mt-2 text-sm text-red-600">
                    {{ form.errors.email }}
                </div>

                <!-- Email Verification -->
                <div
                    v-if="mustVerifyEmail && !user.email_verified_at"
                    class="mt-2"
                >
                    <p class="text-sm text-gray-800 dark:text-gray-200">
                        Your email address is unverified.
                        <button
                            @click="sendVerification"
                            class="focus:ring-primary rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:ring-2 focus:ring-offset-2 focus:outline-none dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
                        >
                            Click here to re-send the verification email.
                        </button>
                    </p>

                    <div
                        v-if="verificationLinkSent"
                        class="mt-2 text-sm font-medium text-green-600 dark:text-green-400"
                    >
                        A new verification link has been sent to your email
                        address.
                    </div>
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
                    v-if="status === 'profile-updated'"
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
import { useForm, router } from "@inertiajs/vue3";

const props = defineProps({
    user: Object,
    status: String,
});

const mustVerifyEmail = ref(props.user.must_verify_email ?? false);
const verificationLinkSent = ref(false);

const form = useForm({
    username: props.user.username,
    phone: props.user.phone,
    email: props.user.email,
});

const submit = () => {
    form.patch(route("profile.update"), {
        onSuccess: () => {
            if (form.email !== props.user.email) {
                mustVerifyEmail.value = true;
            }
        },
    });
};

const sendVerification = () => {
    router.post(
        route("verification.send"),
        {},
        {
            onSuccess: () => {
                verificationLinkSent.value = true;
            },
        },
    );
};
</script>
