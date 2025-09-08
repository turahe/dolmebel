<template>
    <TailstoreLayout>
        <!-- Page Header -->
        <section class="bg-gray-50 py-12">
            <div class="container mx-auto px-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Shop</h1>
                        <p class="mt-2 text-gray-600">
                            Discover our collection of premium furniture
                        </p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600"
                            >Showing {{ startItem }}-{{ endItem }} of
                            {{ totalProducts }} products</span
                        >
                    </div>
                </div>
            </div>
        </section>

        <!-- Filters and Products -->
        <section class="py-8">
            <div class="container mx-auto px-4">
                <div class="flex flex-col gap-8 lg:flex-row">
                    <!-- Sidebar Filters -->
                    <div class="lg:w-1/4">
                        <div class="rounded-lg bg-white p-6 shadow-md">
                            <h3 class="mb-4 text-lg font-semibold">Filters</h3>

                            <!-- Categories -->
                            <div class="mb-6">
                                <h4 class="mb-3 font-medium">Categories</h4>
                                <div class="space-y-2">
                                    <label
                                        v-for="category in categories"
                                        :key="category.id"
                                        class="flex items-center"
                                    >
                                        <input
                                            v-model="selectedCategories"
                                            :value="category.id"
                                            type="checkbox"
                                            class="text-primary focus:ring-primary rounded border-gray-300"
                                        />
                                        <span class="ml-2 text-gray-700"
                                            >{{ category.name }} ({{
                                                category.count
                                            }})</span
                                        >
                                    </label>
                                </div>
                            </div>

                            <!-- Price Range -->
                            <div class="mb-6">
                                <h4 class="mb-3 font-medium">Price Range</h4>
                                <div class="space-y-2">
                                    <label
                                        v-for="range in priceRanges"
                                        :key="range.id"
                                        class="flex items-center"
                                    >
                                        <input
                                            v-model="selectedPriceRange"
                                            :value="range.id"
                                            type="radio"
                                            name="price"
                                            class="text-primary focus:ring-primary"
                                        />
                                        <span class="ml-2 text-gray-700">{{
                                            range.label
                                        }}</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Rating -->
                            <div class="mb-6">
                                <h4 class="mb-3 font-medium">Rating</h4>
                                <div class="space-y-2">
                                    <label
                                        v-for="rating in ratings"
                                        :key="rating.value"
                                        class="flex items-center"
                                    >
                                        <input
                                            v-model="selectedRatings"
                                            :value="rating.value"
                                            type="checkbox"
                                            class="text-primary focus:ring-primary rounded border-gray-300"
                                        />
                                        <div class="ml-2 flex text-yellow-400">
                                            <svg
                                                v-for="i in rating.value"
                                                :key="i"
                                                class="h-4 w-4"
                                                fill="currentColor"
                                                viewBox="0 0 20 20"
                                            >
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                                                ></path>
                                            </svg>
                                        </div>
                                        <span class="ml-2 text-sm text-gray-500"
                                            >({{ rating.count }})</span
                                        >
                                    </label>
                                </div>
                            </div>

                            <!-- Clear Filters -->
                            <button
                                @click="clearFilters"
                                class="w-full rounded-lg bg-gray-100 px-4 py-2 text-gray-700 transition-colors hover:bg-gray-200"
                            >
                                Clear All Filters
                            </button>
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <div class="lg:w-3/4">
                        <!-- Sort and View Options -->
                        <div
                            class="mb-6 flex flex-col items-center justify-between sm:flex-row"
                        >
                            <div
                                class="mb-4 flex items-center space-x-4 sm:mb-0"
                            >
                                <span class="text-gray-600">Sort by:</span>
                                <select
                                    v-model="sortBy"
                                    @change="applyFilters"
                                    class="focus:ring-primary rounded-lg border border-gray-300 px-3 py-2 focus:border-transparent focus:ring-2"
                                >
                                    <option value="featured">Featured</option>
                                    <option value="price_low">
                                        Price: Low to High
                                    </option>
                                    <option value="price_high">
                                        Price: High to Low
                                    </option>
                                    <option value="newest">Newest</option>
                                    <option value="rating">Best Rating</option>
                                </select>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button
                                    @click="viewMode = 'list'"
                                    :class="
                                        viewMode === 'list'
                                            ? 'bg-primary text-white'
                                            : 'hover:bg-gray-50'
                                    "
                                    class="rounded-lg border border-gray-300 p-2"
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
                                            d="M4 6h16M4 10h16M4 14h16M4 18h16"
                                        ></path>
                                    </svg>
                                </button>
                                <button
                                    @click="viewMode = 'grid'"
                                    :class="
                                        viewMode === 'grid'
                                            ? 'bg-primary text-white'
                                            : 'hover:bg-gray-50'
                                    "
                                    class="rounded-lg border border-gray-300 p-2"
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
                                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"
                                        ></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Products Grid -->
                        <div
                            :class="
                                viewMode === 'grid'
                                    ? 'grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3'
                                    : 'space-y-6'
                            "
                        >
                            <div
                                v-for="product in filteredProducts"
                                :key="product.id"
                                :class="
                                    viewMode === 'grid'
                                        ? 'overflow-hidden rounded-lg bg-white shadow-md transition-shadow hover:shadow-lg'
                                        : 'flex overflow-hidden rounded-lg bg-white shadow-md transition-shadow hover:shadow-lg'
                                "
                            >
                                <div
                                    :class="
                                        viewMode === 'grid'
                                            ? 'relative'
                                            : 'relative w-64 flex-shrink-0'
                                    "
                                >
                                    <img
                                        :src="product.image"
                                        :alt="product.name"
                                        :class="
                                            viewMode === 'grid'
                                                ? 'h-64 w-full object-cover'
                                                : 'h-48 w-full object-cover'
                                        "
                                    />
                                    <div class="absolute top-2 right-2">
                                        <button
                                            @click="toggleWishlist(product.id)"
                                            :class="
                                                product.isWishlisted
                                                    ? 'bg-red-500 text-white'
                                                    : 'bg-white hover:bg-gray-100'
                                            "
                                            class="rounded-full p-2 shadow-md"
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
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                                                ></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div
                                        v-if="product.isOnSale"
                                        class="absolute top-2 left-2"
                                    >
                                        <span
                                            class="rounded bg-red-500 px-2 py-1 text-sm font-semibold text-white"
                                            >Sale</span
                                        >
                                    </div>
                                </div>
                                <div
                                    :class="
                                        viewMode === 'grid'
                                            ? 'p-4'
                                            : 'flex-1 p-4'
                                    "
                                >
                                    <h3
                                        class="mb-2 font-semibold text-gray-800"
                                    >
                                        {{ product.name }}
                                    </h3>
                                    <div class="mb-2 flex items-center">
                                        <div class="flex text-yellow-400">
                                            <svg
                                                v-for="i in 5"
                                                :key="i"
                                                class="h-4 w-4"
                                                fill="currentColor"
                                                viewBox="0 0 20 20"
                                            >
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                                                ></path>
                                            </svg>
                                        </div>
                                        <span class="ml-2 text-sm text-gray-500"
                                            >({{ product.reviews_count }})</span
                                        >
                                    </div>
                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <div class="flex items-center">
                                            <span
                                                v-if="product.isOnSale"
                                                class="mr-2 text-gray-400 line-through"
                                                >${{
                                                    product.originalPrice
                                                }}</span
                                            >
                                            <span
                                                class="text-primary text-lg font-bold"
                                                >${{ product.price }}</span
                                            >
                                        </div>
                                        <button
                                            @click="addToCart(product.id)"
                                            class="bg-primary hover:bg-primary-dark rounded-lg px-4 py-2 text-white transition-colors"
                                        >
                                            Add to Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-12 flex justify-center">
                            <nav class="flex items-center space-x-2">
                                <button
                                    @click="goToPage(currentPage - 1)"
                                    :disabled="currentPage === 1"
                                    class="rounded-lg border border-gray-300 px-3 py-2 hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-50"
                                >
                                    Previous
                                </button>
                                <button
                                    v-for="page in visiblePages"
                                    :key="page"
                                    @click="goToPage(page)"
                                    :class="
                                        page === currentPage
                                            ? 'bg-primary text-white'
                                            : 'hover:bg-gray-50'
                                    "
                                    class="rounded-lg border border-gray-300 px-3 py-2"
                                >
                                    {{ page }}
                                </button>
                                <button
                                    @click="goToPage(currentPage + 1)"
                                    :disabled="currentPage === totalPages"
                                    class="rounded-lg border border-gray-300 px-3 py-2 hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-50"
                                >
                                    Next
                                </button>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </TailstoreLayout>
</template>

<script setup>
import { ref, computed, watch } from "vue";
import { Link } from "@inertiajs/vue3";
import TailstoreLayout from "@/Layouts/TailstoreLayout.vue";

// Reactive data
const selectedCategories = ref([]);
const selectedPriceRange = ref("");
const selectedRatings = ref([]);
const sortBy = ref("featured");
const viewMode = ref("grid");
const currentPage = ref(1);
const itemsPerPage = ref(12);

// Sample data - replace with actual data from your backend
const categories = ref([
    { id: 1, name: "Bedroom", count: 12 },
    { id: 2, name: "Living Room", count: 8 },
    { id: 3, name: "Dining Room", count: 6 },
    { id: 4, name: "Office", count: 4 },
]);

const priceRanges = ref([
    { id: "0-100", label: "$0 - $100" },
    { id: "100-300", label: "$100 - $300" },
    { id: "300-500", label: "$300 - $500" },
    { id: "500+", label: "$500+" },
]);

const ratings = ref([
    { value: 5, count: 15 },
    { value: 4, count: 25 },
    { value: 3, count: 18 },
    { value: 2, count: 8 },
    { value: 1, count: 3 },
]);

const products = ref([
    {
        id: 1,
        name: "Modern Chair 1",
        price: 199,
        originalPrice: 299,
        image: "https://via.placeholder.com/300x300/3B82F6/FFFFFF?text=Product+1",
        category_id: 1,
        rating: 4.5,
        reviews_count: 25,
        isOnSale: true,
        isWishlisted: false,
    },
    {
        id: 2,
        name: "Modern Chair 2",
        price: 249,
        originalPrice: null,
        image: "https://via.placeholder.com/300x300/3B82F6/FFFFFF?text=Product+2",
        category_id: 2,
        rating: 4.2,
        reviews_count: 18,
        isOnSale: false,
        isWishlisted: false,
    },
    {
        id: 3,
        name: "Modern Chair 3",
        price: 179,
        originalPrice: 229,
        image: "https://via.placeholder.com/300x300/3B82F6/FFFFFF?text=Product+3",
        category_id: 1,
        rating: 4.8,
        reviews_count: 32,
        isOnSale: true,
        isWishlisted: false,
    },
    {
        id: 4,
        name: "Modern Chair 4",
        price: 299,
        originalPrice: 399,
        image: "https://via.placeholder.com/300x300/3B82F6/FFFFFF?text=Product+4",
        category_id: 3,
        rating: 4.3,
        reviews_count: 21,
        isOnSale: true,
        isWishlisted: false,
    },
    {
        id: 5,
        name: "Modern Chair 5",
        price: 159,
        originalPrice: null,
        image: "https://via.placeholder.com/300x300/3B82F6/FFFFFF?text=Product+5",
        category_id: 2,
        rating: 4.0,
        reviews_count: 14,
        isOnSale: false,
        isWishlisted: false,
    },
    {
        id: 6,
        name: "Modern Chair 6",
        price: 219,
        originalPrice: null,
        image: "https://via.placeholder.com/300x300/3B82F6/FFFFFF?text=Product+6",
        category_id: 4,
        rating: 4.6,
        reviews_count: 28,
        isOnSale: false,
        isWishlisted: false,
    },
    {
        id: 7,
        name: "Modern Chair 7",
        price: 189,
        originalPrice: 249,
        image: "https://via.placeholder.com/300x300/3B82F6/FFFFFF?text=Product+7",
        category_id: 1,
        rating: 4.4,
        reviews_count: 19,
        isOnSale: true,
        isWishlisted: false,
    },
    {
        id: 8,
        name: "Modern Chair 8",
        price: 269,
        originalPrice: null,
        image: "https://via.placeholder.com/300x300/3B82F6/FFFFFF?text=Product+8",
        category_id: 3,
        rating: 4.7,
        reviews_count: 35,
        isOnSale: false,
        isWishlisted: false,
    },
    {
        id: 9,
        name: "Modern Chair 9",
        price: 139,
        originalPrice: null,
        image: "https://via.placeholder.com/300x300/3B82F6/FFFFFF?text=Product+9",
        category_id: 2,
        rating: 3.9,
        reviews_count: 12,
        isOnSale: false,
        isWishlisted: false,
    },
    {
        id: 10,
        name: "Modern Chair 10",
        price: 229,
        originalPrice: 299,
        image: "https://via.placeholder.com/300x300/3B82F6/FFFFFF?text=Product+10",
        category_id: 4,
        rating: 4.5,
        reviews_count: 24,
        isOnSale: true,
        isWishlisted: false,
    },
    {
        id: 11,
        name: "Modern Chair 11",
        price: 199,
        originalPrice: null,
        image: "https://via.placeholder.com/300x300/3B82F6/FFFFFF?text=Product+11",
        category_id: 1,
        rating: 4.2,
        reviews_count: 17,
        isOnSale: false,
        isWishlisted: false,
    },
    {
        id: 12,
        name: "Modern Chair 12",
        price: 279,
        originalPrice: null,
        image: "https://via.placeholder.com/300x300/3B82F6/FFFFFF?text=Product+12",
        category_id: 3,
        rating: 4.8,
        reviews_count: 41,
        isOnSale: false,
        isWishlisted: false,
    },
]);

// Computed properties
const filteredProducts = computed(() => {
    let filtered = [...products.value];

    // Filter by categories
    if (selectedCategories.value.length > 0) {
        filtered = filtered.filter((product) =>
            selectedCategories.value.includes(product.category_id),
        );
    }

    // Filter by price range
    if (selectedPriceRange.value) {
        const [min, max] = selectedPriceRange.value.split("-").map(Number);
        filtered = filtered.filter((product) => {
            if (max) {
                return product.price >= min && product.price <= max;
            } else {
                return product.price >= min;
            }
        });
    }

    // Filter by ratings
    if (selectedRatings.value.length > 0) {
        filtered = filtered.filter((product) =>
            selectedRatings.value.includes(Math.floor(product.rating)),
        );
    }

    // Sort products
    switch (sortBy.value) {
        case "price_low":
            filtered.sort((a, b) => a.price - b.price);
            break;
        case "price_high":
            filtered.sort((a, b) => b.price - a.price);
            break;
        case "rating":
            filtered.sort((a, b) => b.rating - a.rating);
            break;
        case "newest":
            // Assuming newer products have higher IDs
            filtered.sort((a, b) => b.id - a.id);
            break;
        default:
            // Featured - keep original order
            break;
    }

    return filtered;
});

const totalProducts = computed(() => filteredProducts.value.length);
const totalPages = computed(() =>
    Math.ceil(totalProducts.value / itemsPerPage.value),
);
const startItem = computed(
    () => (currentPage.value - 1) * itemsPerPage.value + 1,
);
const endItem = computed(() =>
    Math.min(currentPage.value * itemsPerPage.value, totalProducts.value),
);

const visiblePages = computed(() => {
    const pages = [];
    const start = Math.max(1, currentPage.value - 2);
    const end = Math.min(totalPages.value, start + 4);

    for (let i = start; i <= end; i++) {
        pages.push(i);
    }
    return pages;
});

// Methods
const clearFilters = () => {
    selectedCategories.value = [];
    selectedPriceRange.value = "";
    selectedRatings.value = [];
    sortBy.value = "featured";
    currentPage.value = 1;
};

const applyFilters = () => {
    currentPage.value = 1;
};

const goToPage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
    }
};

const toggleWishlist = (productId) => {
    const product = products.value.find((p) => p.id === productId);
    if (product) {
        product.isWishlisted = !product.isWishlisted;
    }
};

const addToCart = (productId) => {
    // Handle add to cart functionality
    console.log("Adding product to cart:", productId);
};

// Watch for filter changes
watch([selectedCategories, selectedPriceRange, selectedRatings], () => {
    currentPage.value = 1;
});
</script>
