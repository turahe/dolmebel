<template>
    <TailstoreLayout>
        <!-- Hero Slider -->
        <section class="relative">
            <div class="hero-swiper swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-20">
                            <div class="container mx-auto px-4">
                                <div class="max-w-2xl">
                                    <h1 class="text-5xl font-bold mb-6">Welcome to Tailstore</h1>
                                    <p class="text-xl mb-8">Discover amazing products at unbeatable prices</p>
                                    <Link href="/shop" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                                        Shop Now
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="bg-gradient-to-r from-green-600 to-blue-600 text-white py-20">
                            <div class="container mx-auto px-4">
                                <div class="max-w-2xl">
                                    <h1 class="text-5xl font-bold mb-6">New Collection</h1>
                                    <p class="text-xl mb-8">Explore our latest arrivals and trending items</p>
                                    <Link href="/shop" class="bg-white text-green-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                                        Explore
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </section>

        <!-- Categories Section -->
        <section class="py-16 bg-white">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center mb-12">Shop by Category</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
                    <div v-for="category in categories" :key="category.id" class="text-center group">
                        <Link :href="`/category/${category.slug}`" class="block">
                            <div class="bg-gray-100 rounded-lg p-6 mb-4 group-hover:bg-gray-200 transition-colors">
                                <img :src="category.image" :alt="category.name" class="w-16 h-16 mx-auto mb-4">
                            </div>
                            <h3 class="font-semibold text-gray-900">{{ category.name }}</h3>
                        </Link>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Products -->
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center mb-12">
                    <h2 class="text-3xl font-bold">Featured Products</h2>
                    <Link href="/shop" class="text-blue-600 hover:text-blue-700 font-semibold">
                        View All →
                    </Link>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div v-for="product in featuredProducts" :key="product.id" class="bg-white rounded-lg shadow-sm overflow-hidden group">
                        <Link :href="`/product/${product.slug}`">
                            <div class="relative">
                                <img :src="product.image" :alt="product.name" class="w-full h-64 object-cover group-hover:scale-105 transition-transform">
                                <div class="absolute top-4 right-4">
                                    <button class="bg-white rounded-full p-2 shadow-md hover:bg-gray-100">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 mb-2">{{ product.name }}</h3>
                                <div class="flex items-center mb-2">
                                    <div class="flex text-yellow-400">
                                        <span v-for="i in 5" :key="i" class="text-sm">★</span>
                                    </div>
                                    <span class="text-sm text-gray-600 ml-2">({{ product.reviews_count }})</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-lg font-bold text-gray-900">${{ product.price }}</span>
                                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </Link>
                    </div>
                </div>
            </div>
        </section>

        <!-- Brand Carousel -->
        <section class="py-16 bg-white">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center mb-12">Our Brands</h2>
                <div class="brand-swiper swiper">
                    <div class="swiper-wrapper">
                        <div v-for="brand in brands" :key="brand.id" class="swiper-slide">
                            <div class="flex items-center justify-center h-24 bg-gray-100 rounded-lg">
                                <img :src="brand.logo" :alt="brand.name" class="max-h-16 max-w-32 object-contain">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Newsletter Section -->
        <section class="py-16 bg-blue-600 text-white">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold mb-4">Stay Updated</h2>
                <p class="text-xl mb-8">Subscribe to our newsletter for exclusive offers and updates</p>
                <form @submit.prevent="subscribeNewsletter" class="max-w-md mx-auto flex">
                    <input
                        v-model="newsletterEmail"
                        type="email"
                        placeholder="Enter your email"
                        class="flex-1 px-4 py-3 rounded-l-lg text-gray-900 focus:ring-2 focus:ring-blue-300 focus:outline-none"
                        required
                    />
                    <button
                        type="submit"
                        class="bg-white text-blue-600 px-6 py-3 rounded-r-lg font-semibold hover:bg-gray-100 transition-colors"
                    >
                        Subscribe
                    </button>
                </form>
            </div>
        </section>
    </TailstoreLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { Link } from '@inertiajs/vue3'
import TailstoreLayout from '@/Layouts/TailstoreLayout.vue'

// Sample data - replace with actual data from your backend
const categories = ref([
    { id: 1, name: 'Electronics', slug: 'electronics', image: '/images/categories/electronics.jpg' },
    { id: 2, name: 'Clothing', slug: 'clothing', image: '/images/categories/clothing.jpg' },
    { id: 3, name: 'Home & Garden', slug: 'home-garden', image: '/images/categories/home.jpg' },
    { id: 4, name: 'Sports', slug: 'sports', image: '/images/categories/sports.jpg' },
    { id: 5, name: 'Books', slug: 'books', image: '/images/categories/books.jpg' },
    { id: 6, name: 'Beauty', slug: 'beauty', image: '/images/categories/beauty.jpg' },
])

const featuredProducts = ref([
    { id: 1, name: 'Wireless Headphones', slug: 'wireless-headphones', price: 99.99, image: '/images/products/headphones.jpg', reviews_count: 128 },
    { id: 2, name: 'Smart Watch', slug: 'smart-watch', price: 199.99, image: '/images/products/smartwatch.jpg', reviews_count: 89 },
    { id: 3, name: 'Laptop Stand', slug: 'laptop-stand', price: 49.99, image: '/images/products/laptop-stand.jpg', reviews_count: 67 },
    { id: 4, name: 'Bluetooth Speaker', slug: 'bluetooth-speaker', price: 79.99, image: '/images/products/speaker.jpg', reviews_count: 156 },
])

const brands = ref([
    { id: 1, name: 'Apple', logo: '/images/brands/apple.png' },
    { id: 2, name: 'Samsung', logo: '/images/brands/samsung.png' },
    { id: 3, name: 'Sony', logo: '/images/brands/sony.png' },
    { id: 4, name: 'Nike', logo: '/images/brands/nike.png' },
    { id: 5, name: 'Adidas', logo: '/images/brands/adidas.png' },
    { id: 6, name: 'Microsoft', logo: '/images/brands/microsoft.png' },
])

const newsletterEmail = ref('')

const subscribeNewsletter = () => {
    // Handle newsletter subscription
    console.log('Newsletter subscription:', newsletterEmail.value)
    newsletterEmail.value = ''
}

onMounted(() => {
    // Initialize Swiper after component is mounted
    if (window.Swiper) {
        // Hero Slider
        new window.Swiper('.hero-swiper', {
            modules: [window.Swiper.Navigation, window.Swiper.Pagination, window.Swiper.Autoplay],
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        })

        // Brand Carousel
        new window.Swiper('.brand-swiper', {
            modules: [window.Swiper.Autoplay],
            slidesPerView: 2,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            breakpoints: {
                640: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 4,
                },
                1024: {
                    slidesPerView: 6,
                },
            },
        })
    }
})
</script>
