<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Delete Account
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Once your account is deleted, all of its resources and data will
                be permanently deleted. Before deleting your account, please
                download any data or information that you wish to retain.
            </p>
        </header>

        <button
            @click="showModal = true"
            class="inline-flex items-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out hover:bg-red-700 focus:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:outline-none active:bg-red-700"
        >
            Delete Account
        </button>

        <!-- Modal -->
        <div v-if="showModal" class="fixed inset-0 z-50 overflow-y-auto">
            <div
                class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0"
            >
                <!-- Background overlay -->
                <div
                    class="fixed inset-0 transition-opacity"
                    aria-hidden="true"
                >
                    <div
                        class="absolute inset-0 bg-gray-500 opacity-75"
                        @click="showModal = false"
                    ></div>
                </div>

                <!-- Modal panel -->
                <div
                    class="inline-block transform overflow-hidden rounded-lg bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle dark:bg-gray-800"
                >
                    <form @submit.prevent="submit" class="p-6">
                        <h2
                            class="text-lg font-medium text-gray-900 dark:text-gray-100"
                        >
                            Are you sure you want to delete your account?
                        </h2>

                        <p
                            class="mt-1 text-sm text-gray-600 dark:text-gray-400"
                        >
                            Once your account is deleted, all of its resources
                            and data will be permanently deleted. Please enter
                            your password to confirm you would like to
                            permanently delete your account.
                        </p>

                        <div class="mt-6">
                            <label
                                for="password"
                                class="sr-only block text-sm font-medium text-gray-700 dark:text-gray-300"
                            >
                                Password
                            </label>
                            <input
                                id="password"
                                v-model="form.password"
                                type="password"
                                placeholder="Password"
                                class="focus:ring-primary focus:border-primary mt-1 block w-3/4 rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                            />
                            <div
                                v-if="form.errors.password"
                                class="mt-2 text-sm text-red-600"
                            >
                                {{ form.errors.password }}
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button
                                type="button"
                                @click="showModal = false"
                                class="inline-flex items-center rounded-md border border-transparent bg-gray-300 px-4 py-2 text-xs font-semibold tracking-widest text-gray-700 uppercase transition duration-150 ease-in-out hover:bg-gray-400 focus:bg-gray-400 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:outline-none active:bg-gray-400"
                            >
                                Cancel
                            </button>

                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="ml-3 inline-flex items-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out hover:bg-red-700 focus:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:outline-none active:bg-red-700 disabled:opacity-50"
                            >
                                {{
                                    form.processing
                                        ? "Deleting..."
                                        : "Delete Account"
                                }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

const showModal = ref(false);

const form = useForm({
    password: "",
});

const submit = () => {
    form.delete(route("profile.destroy"), {
        onSuccess: () => {
            showModal.value = false;
        },
    });
};
</script>
