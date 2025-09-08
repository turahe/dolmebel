<template>
    <AuthLayout>
        <!-- Instructions -->
        <div class="mb-6 text-sm text-gray-600 dark:text-gray-400">
            Forgot your password? No problem. Just let us know your email
            address and we will email you a password reset link that will allow
            you to choose a new one.
        </div>

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
                />
                <div v-if="form.errors.email" class="mt-2 text-sm text-red-600">
                    {{ form.errors.email }}
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between">
                <Link
                    :href="route('login')"
                    class="text-sm text-gray-600 underline hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100"
                >
                    Back to login
                </Link>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="bg-primary hover:bg-primary-dark focus:bg-primary-dark active:bg-primary-dark focus:ring-primary inline-flex items-center rounded-md border border-transparent px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out focus:ring-2 focus:ring-offset-2 focus:outline-none disabled:opacity-50"
                >
                    {{
                        form.processing
                            ? "Sending..."
                            : "Email Password Reset Link"
                    }}
                </button>
            </div>
        </form>
    </AuthLayout>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import AuthLayout from "@/Layouts/AuthLayout.vue";

const props = defineProps({
    status: String,
});

const form = useForm({
    email: "",
});

const submit = () => {
    form.post(route("password.email"));
};
</script>
