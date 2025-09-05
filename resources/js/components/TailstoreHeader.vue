<template>
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <!-- Top Bar -->
        <div class="bg-primary text-white py-2">
            <div class="container mx-auto px-4">
                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center space-x-4">
                        <span>📞 +1 (555) 123-4567</span>
                        <span>📧 info@dolmebel.com</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <Link href="#" class="hover:text-gray-200">Track Order</Link>
                        <Link href="#" class="hover:text-gray-200">Store Locator</Link>
                        <Link href="#" class="hover:text-gray-200">Help</Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Header -->
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center">
                    <Link href="/" class="text-2xl font-bold text-primary">
                        Dolmebel
                    </Link>
                </div>

                <!-- Search Bar -->
                <div class="hidden md:flex flex-1 max-w-md mx-8">
                    <div class="relative w-full">
                        <input 
                            v-model="searchQuery"
                            @keyup.enter="performSearch"
                            type="text" 
                            placeholder="Search for products..." 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                        >
                        <button 
                            @click="performSearch"
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-primary"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Right Side -->
                <div class="flex items-center space-x-4">
                    <!-- User Menu -->
                    <div v-if="user" class="relative">
                        <button 
                            @click="userMenuOpen = !userMenuOpen"
                            class="flex items-center space-x-2 text-gray-700 hover:text-primary"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>{{ user.name }}</span>
                        </button>
                        <div 
                            v-show="userMenuOpen" 
                            @click.away="userMenuOpen = false"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50"
                        >
                            <Link href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</Link>
                            <Link href="/dashboard" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</Link>
                            <button 
                                @click="logout"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                            >
                                Logout
                            </button>
                        </div>
                    </div>
                    <div v-else class="flex items-center space-x-4">
                        <Link href="/login" class="text-gray-700 hover:text-primary">Login</Link>
                        <Link href="/register" class="text-gray-700 hover:text-primary">Register</Link>
                    </div>

                    <!-- Wishlist -->
                    <Link href="/wishlist" class="relative text-gray-700 hover:text-primary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ wishlistCount }}</span>
                    </Link>

                    <!-- Cart -->
                    <Link href="/cart" class="relative text-gray-700 hover:text-primary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                        </svg>
                        <span class="absolute -top-2 -right-2 bg-primary text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ cartCount }}</span>
                    </Link>

                    <!-- Mobile Menu Button -->
                    <button 
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        class="md:hidden text-gray-700 hover:text-primary"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="border-t border-gray-200">
            <div class="container mx-auto px-4">
                <div class="flex items-center justify-between py-4">
                    <!-- Categories Menu -->
                    <div class="hidden md:flex items-center space-x-8">
                        <Link href="/shop" class="text-gray-700 hover:text-primary font-medium">All Products</Link>
                        <Link href="/category/bedroom" class="text-gray-700 hover:text-primary">Bedroom</Link>
                        <Link href="/category/living-room" class="text-gray-700 hover:text-primary">Living Room</Link>
                        <Link href="/category/dining-room" class="text-gray-700 hover:text-primary">Dining Room</Link>
                        <Link href="/category/office" class="text-gray-700 hover:text-primary">Office</Link>
                        <Link href="/category/outdoor" class="text-gray-700 hover:text-primary">Outdoor</Link>
                        <Link href="/sale" class="text-gray-700 hover:text-primary">Sale</Link>
                    </div>

                    <!-- Mobile Search -->
                    <div class="md:hidden flex-1 mx-4">
                        <div class="relative">
                            <input 
                                v-model="mobileSearchQuery"
                                @keyup.enter="performSearch"
                                type="text" 
                                placeholder="Search..." 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                            >
                            <button 
                                @click="performSearch"
                                class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div v-show="mobileMenuOpen" class="md:hidden bg-white border-t border-gray-200">
            <div class="px-4 py-2 space-y-2">
                <Link href="/shop" class="block py-2 text-gray-700 hover:text-primary">All Products</Link>
                <Link href="/category/bedroom" class="block py-2 text-gray-700 hover:text-primary">Bedroom</Link>
                <Link href="/category/living-room" class="block py-2 text-gray-700 hover:text-primary">Living Room</Link>
                <Link href="/category/dining-room" class="block py-2 text-gray-700 hover:text-primary">Dining Room</Link>
                <Link href="/category/office" class="block py-2 text-gray-700 hover:text-primary">Office</Link>
                <Link href="/category/outdoor" class="block py-2 text-gray-700 hover:text-primary">Outdoor</Link>
                <Link href="/sale" class="block py-2 text-gray-700 hover:text-primary">Sale</Link>
            </div>
        </div>
    </header>
</template>

<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'

// Props
const props = defineProps({
    user: {
        type: Object,
        default: null
    },
    cartCount: {
        type: Number,
        default: 0
    },
    wishlistCount: {
        type: Number,
        default: 0
    }
})

// Reactive data
const searchQuery = ref('')
const mobileSearchQuery = ref('')
const userMenuOpen = ref(false)
const mobileMenuOpen = ref(false)

// Methods
const performSearch = () => {
    const query = searchQuery.value || mobileSearchQuery.value
    if (query.trim()) {
        router.get('/search', { q: query })
    }
}

const logout = () => {
    router.post('/logout')
}
</script>
