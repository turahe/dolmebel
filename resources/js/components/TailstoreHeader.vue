<template>
    <!-- Header -->
    <header class="sticky top-0 z-50 bg-white shadow-sm">
        <!-- Top Bar -->
        <div class="bg-primary py-2 text-white">
            <div class="container mx-auto px-4">
                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center space-x-4">
                        <span>📞 +1 (555) 123-4567</span>
                        <span>📧 info@dolmebel.com</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <Link href="#" class="hover:text-gray-200"
                            >Track Order</Link
                        >
                        <Link href="#" class="hover:text-gray-200"
                            >Store Locator</Link
                        >
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
                    <Link href="/" class="text-primary text-2xl font-bold">
                        Dolmebel
                    </Link>
                </div>

                <!-- Search Bar -->
                <div class="mx-8 hidden max-w-md flex-1 md:flex">
                    <div class="relative w-full">
                        <input
                            v-model="searchQuery"
                            @keyup.enter="performSearch"
                            type="text"
                            placeholder="Search for products..."
                            class="focus:ring-primary w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-transparent focus:ring-2"
                        />
                        <button
                            @click="performSearch"
                            class="hover:text-primary absolute top-1/2 right-2 -translate-y-1/2 transform text-gray-400"
                        >
                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                ></path>
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
                            class="hover:text-primary flex items-center space-x-2 text-gray-700"
                        >
                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                ></path>
                            </svg>
                            <span>{{ user.name }}</span>
                        </button>
                        <div
                            v-show="userMenuOpen"
                            @click.away="userMenuOpen = false"
                            class="absolute right-0 z-50 mt-2 w-48 rounded-md bg-white py-1 shadow-lg"
                        >
                            <Link
                                href="/profile"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                >Profile</Link
                            >
                            <Link
                                href="/dashboard"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                >Dashboard</Link
                            >
                            <button
                                @click="logout"
                                class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100"
                            >
                                Logout
                            </button>
                        </div>
                    </div>
                    <div v-else class="flex items-center space-x-4">
                        <Link
                            href="/login"
                            class="hover:text-primary text-gray-700"
                            >Login</Link
                        >
                        <Link
                            href="/register"
                            class="hover:text-primary text-gray-700"
                            >Register</Link
                        >
                    </div>

                    <!-- Wishlist -->
                    <Link
                        href="/wishlist"
                        class="hover:text-primary relative text-gray-700"
                    >
                        <svg
                            class="h-6 w-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                            ></path>
                        </svg>
                        <span
                            class="absolute -top-2 -right-2 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs text-white"
                            >{{ wishlistCount }}</span
                        >
                    </Link>

                    <!-- Cart -->
                    <Link
                        href="/cart"
                        class="hover:text-primary relative text-gray-700"
                    >
                        <svg
                            class="h-6 w-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"
                            ></path>
                        </svg>
                        <span
                            class="bg-primary absolute -top-2 -right-2 flex h-5 w-5 items-center justify-center rounded-full text-xs text-white"
                            >{{ cartCount }}</span
                        >
                    </Link>

                    <!-- Mobile Menu Button -->
                    <button
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        class="hover:text-primary text-gray-700 md:hidden"
                    >
                        <svg
                            class="h-6 w-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            ></path>
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
                    <div class="hidden items-center space-x-8 md:flex">
                        <Link
                            href="/shop"
                            class="hover:text-primary font-medium text-gray-700"
                            >All Products</Link
                        >
                        <Link
                            href="/category/bedroom"
                            class="hover:text-primary text-gray-700"
                            >Bedroom</Link
                        >
                        <Link
                            href="/category/living-room"
                            class="hover:text-primary text-gray-700"
                            >Living Room</Link
                        >
                        <Link
                            href="/category/dining-room"
                            class="hover:text-primary text-gray-700"
                            >Dining Room</Link
                        >
                        <Link
                            href="/category/office"
                            class="hover:text-primary text-gray-700"
                            >Office</Link
                        >
                        <Link
                            href="/category/outdoor"
                            class="hover:text-primary text-gray-700"
                            >Outdoor</Link
                        >
                        <Link
                            href="/sale"
                            class="hover:text-primary text-gray-700"
                            >Sale</Link
                        >
                    </div>

                    <!-- Mobile Search -->
                    <div class="mx-4 flex-1 md:hidden">
                        <div class="relative">
                            <input
                                v-model="mobileSearchQuery"
                                @keyup.enter="performSearch"
                                type="text"
                                placeholder="Search..."
                                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm"
                            />
                            <button
                                @click="performSearch"
                                class="absolute top-1/2 right-2 -translate-y-1/2 transform text-gray-400"
                            >
                                <svg
                                    class="h-4 w-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                    ></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div
            v-show="mobileMenuOpen"
            class="border-t border-gray-200 bg-white md:hidden"
        >
            <div class="space-y-2 px-4 py-2">
                <Link
                    href="/shop"
                    class="hover:text-primary block py-2 text-gray-700"
                    >All Products</Link
                >
                <Link
                    href="/category/bedroom"
                    class="hover:text-primary block py-2 text-gray-700"
                    >Bedroom</Link
                >
                <Link
                    href="/category/living-room"
                    class="hover:text-primary block py-2 text-gray-700"
                    >Living Room</Link
                >
                <Link
                    href="/category/dining-room"
                    class="hover:text-primary block py-2 text-gray-700"
                    >Dining Room</Link
                >
                <Link
                    href="/category/office"
                    class="hover:text-primary block py-2 text-gray-700"
                    >Office</Link
                >
                <Link
                    href="/category/outdoor"
                    class="hover:text-primary block py-2 text-gray-700"
                    >Outdoor</Link
                >
                <Link
                    href="/sale"
                    class="hover:text-primary block py-2 text-gray-700"
                    >Sale</Link
                >
            </div>
        </div>
    </header>
</template>

<script setup>
import { ref } from "vue";
import { Link, router } from "@inertiajs/vue3";

// Props
const props = defineProps({
    user: {
        type: Object,
        default: null,
    },
    cartCount: {
        type: Number,
        default: 0,
    },
    wishlistCount: {
        type: Number,
        default: 0,
    },
});

// Reactive data
const searchQuery = ref("");
const mobileSearchQuery = ref("");
const userMenuOpen = ref(false);
const mobileMenuOpen = ref(false);

// Methods
const performSearch = () => {
    const query = searchQuery.value || mobileSearchQuery.value;
    if (query.trim()) {
        router.get("/search", { q: query });
    }
};

const logout = () => {
    router.post("/logout");
};
</script>
