<template>
    <AppLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Profile
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <!-- Profile Information -->
                <div class="bg-white p-4 shadow dark:bg-gray-800 sm:rounded-lg sm:p-8">
                    <div class="max-w-xl">
                        <UpdateProfileInformationForm :user="user" :status="status" />
                    </div>
                </div>

                <!-- Update Password -->
                <div class="bg-white p-4 shadow dark:bg-gray-800 sm:rounded-lg sm:p-8">
                    <div class="max-w-xl">
                        <UpdatePasswordForm :status="status" />
                    </div>
                </div>

                <!-- Delete Account -->
                <div class="bg-white p-4 shadow dark:bg-gray-800 sm:rounded-lg sm:p-8">
                    <div class="max-w-xl">
                        <DeleteUserForm />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import UpdateProfileInformationForm from '@/Components/UpdateProfileInformationForm.vue'
import UpdatePasswordForm from '@/Components/UpdatePasswordForm.vue'
import DeleteUserForm from '@/Components/DeleteUserForm.vue'

defineProps({
    user: Object,
    status: String,
})
</script>
