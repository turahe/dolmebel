<template>
    <header class="bg-white shadow-sm">
        <!-- Top Bar -->
        <div class="bg-gray-900 text-white py-2">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center text-sm">
                    <div class="flex items-center space-x-4">
                        <span>Free shipping on orders over $100</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="#" class="hover:text-gray-300">Help</a>
                        <a href="#" class="hover:text-gray-300">Track Order</a>
                        <a href="#" class="hover:text-gray-300">Contact</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Header -->
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <Link href="/" class="text-2xl font-bold text-gray-900">
                        Tailstore
                    </Link>
                </div>

                <!-- Search Bar -->
                <div class="flex-1 max-w-lg mx-8">
                    <div class="relative">
                        <input
                            type="text"
                            placeholder="Search products..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        />
                        <button class="absolute right-2 top-2 text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- User Menu -->
                <div class="flex items-center space-x-4">
                    <!-- Wishlist -->
                    <button class="relative p-2 text-gray-600 hover:text-gray-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                    </button>

                    <!-- Cart -->
                    <Link href="/cart" class="relative p-2 text-gray-600 hover:text-gray-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                        </svg>
                        <span class="absolute -top-1 -right-1 bg-blue-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                    </Link>

                    <!-- User Account -->
                    <div class="relative" v-if="!user">
                        <Link href="/login" class="text-gray-600 hover:text-gray-900 px-3 py-2">Login</Link>
                        <Link href="/register" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Register</Link>
                    </div>
                    
                    <div class="relative" v-else>
                        <button @click="showUserMenu = !showUserMenu" class="flex items-center text-gray-600 hover:text-gray-900">
                            <img :src="user.avatar || '/images/default-avatar.png'" :alt="user.name" class="w-8 h-8 rounded-full">
                            <span class="ml-2">{{ user.name }}</span>
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div v-show="showUserMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                            <Link href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</Link>
                            <Link href="/orders" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Orders</Link>
                            <Link href="/settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</Link>
                            <hr class="my-1">
                            <button @click="logout" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="bg-gray-100 border-t">
            <div class="container mx-auto px-4">
                <div class="flex items-center space-x-8 py-3">
                    <Link href="/" class="text-gray-700 hover:text-gray-900 font-medium">Home</Link>
                    <Link href="/shop" class="text-gray-700 hover:text-gray-900 font-medium">Shop</Link>
                    <Link href="/categories" class="text-gray-700 hover:text-gray-900 font-medium">Categories</Link>
                    <Link href="/brands" class="text-gray-700 hover:text-gray-900 font-medium">Brands</Link>
                    <Link href="/about" class="text-gray-700 hover:text-gray-900 font-medium">About</Link>
                    <Link href="/contact" class="text-gray-700 hover:text-gray-900 font-medium">Contact</Link>
                </div>
            </div>
        </nav>
    </header>
</template>

<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'

defineProps({
    user: Object
})

const showUserMenu = ref(false)

const logout = () => {
    // Handle logout logic
    console.log('Logout clicked')
}
</script>
