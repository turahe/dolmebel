<template>
    <AuthLayout>
        <!-- Instructions -->
        <div class="mb-6 text-sm text-gray-600 dark:text-gray-400">
            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
        </div>

        <!-- Verification Link Sent Status -->
        <div v-if="status === 'verification-link-sent'" class="mb-4 text-sm font-medium text-green-600 dark:text-green-400">
            A new verification link has been sent to the email address you provided during registration.
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between">
            <form @submit.prevent="submit">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-dark focus:bg-primary-dark active:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50"
                >
                    {{ form.processing ? 'Sending...' : 'Resend Verification Email' }}
                </button>
            </form>

            <form @submit.prevent="logout">
                <button
                    type="submit"
                    class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 underline"
                >
                    Log Out
                </button>
            </form>
        </div>

        <!-- Additional Help -->
        <div class="mt-8 text-center">
            <div class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                Didn't receive the email? Check your spam folder or try again.
            </div>
            
            <!-- Contact Support -->
            <div class="text-sm text-gray-500 dark:text-gray-500">
                Need help? 
                <Link href="/contact" class="text-primary hover:text-primary-dark underline">
                    Contact Support
                </Link>
            </div>
        </div>
    </AuthLayout>
</template>

<script setup>
import { useForm, router } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'
import AuthLayout from '@/Layouts/AuthLayout.vue'

const props = defineProps({
    status: String,
})

const form = useForm({})

const submit = () => {
    form.post(route('verification.send'))
}

const logout = () => {
    router.post(route('logout'))
}
</script>
