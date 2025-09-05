<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <TailstoreHeader />
        
        <!-- Main Content -->
        <main>
            <slot />
        </main>
        
        <!-- Footer -->
        <TailstoreFooter />
    </div>
</template>

<script setup>
import TailstoreHeader from '@/Components/Tailstore/Header.vue'
import TailstoreFooter from '@/Components/Tailstore/Footer.vue'
</script>
