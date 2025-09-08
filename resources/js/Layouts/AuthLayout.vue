<template>
    <div
        class="flex min-h-screen flex-col items-center bg-gray-100 pt-6 sm:justify-center sm:pt-0 dark:bg-gray-900"
    >
        <!-- Logo -->
        <div class="mb-6">
            <Link href="/" class="block">
                <div class="mx-auto h-24 w-24">
                    <div
                        class="bg-primary flex h-full w-full items-center justify-center rounded-lg"
                    >
                        <span class="text-2xl font-bold text-white">D</span>
                    </div>
                </div>
            </Link>
        </div>

        <!-- Auth Card -->
        <div
            class="w-full max-w-md rounded-lg bg-white px-6 py-8 shadow-md dark:bg-gray-800"
        >
            <slot />
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
</script>
