<template>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col items-center pt-6 sm:justify-center sm:pt-0">
        <!-- Logo -->
        <div class="mb-6">
            <Link href="/" class="block">
                <div class="h-24 w-24 mx-auto">
                    <div class="w-full h-full bg-primary rounded-lg flex items-center justify-center">
                        <span class="text-white text-2xl font-bold">D</span>
                    </div>
                </div>
            </Link>
        </div>

        <!-- Auth Card -->
        <div class="w-full max-w-md bg-white dark:bg-gray-800 shadow-md rounded-lg px-6 py-8">
            <slot />
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>
