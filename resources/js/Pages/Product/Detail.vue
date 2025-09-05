<template>
    <TailstoreLayout>
        <!-- Product Detail -->
        <div v-if="product" class="py-8">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Product Images -->
                    <div class="space-y-4">
                        <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden">
                            <img 
                                :src="product.image || 'https://via.placeholder.com/600x600/3B82F6/FFFFFF?text=Product+Image'" 
                                :alt="product.name"
                                class="w-full h-full object-cover"
                            >
                        </div>
                        <div class="grid grid-cols-4 gap-2">
                            <div 
                                v-for="(image, index) in productImages" 
                                :key="index"
                                class="aspect-square bg-gray-100 rounded-lg overflow-hidden cursor-pointer hover:ring-2 hover:ring-primary"
                            >
                                <img 
                                    :src="image" 
                                    :alt="`${product.name} ${index + 1}`"
                                    class="w-full h-full object-cover"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="space-y-6">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">{{ product.name }}</h1>
                            <div class="flex items-center mt-2">
                                <div class="flex text-yellow-400">
                                    <svg v-for="i in 5" :key="i" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                </div>
                                <span class="text-gray-500 text-sm ml-2">({{ product.reviews_count || 0 }} reviews)</span>
                            </div>
                        </div>

                        <div class="text-3xl font-bold text-primary">
                            ${{ product.price }}
                            <span v-if="product.original_price" class="text-lg text-gray-400 line-through ml-2">
                                ${{ product.original_price }}
                            </span>
                        </div>

                        <div v-if="product.description" class="text-gray-600">
                            <p>{{ product.description }}</p>
                        </div>

                        <!-- Product Options -->
                        <div class="space-y-4">
                            <div v-if="product.variants && product.variants.length > 0">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Size</label>
                                <div class="flex space-x-2">
                                    <button 
                                        v-for="variant in product.variants" 
                                        :key="variant.id"
                                        @click="selectedVariant = variant"
                                        :class="selectedVariant?.id === variant.id ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700'"
                                        class="px-4 py-2 rounded-lg border hover:bg-gray-200"
                                    >
                                        {{ variant.name }}
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                                <div class="flex items-center border border-gray-300 rounded-lg w-32">
                                    <button 
                                        @click="quantity > 1 ? quantity-- : null"
                                        class="px-3 py-2 hover:bg-gray-100"
                                    >
                                        -
                                    </button>
                                    <span class="px-3 py-2 border-x border-gray-300">{{ quantity }}</span>
                                    <button 
                                        @click="quantity++"
                                        class="px-3 py-2 hover:bg-gray-100"
                                    >
                                        +
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex space-x-4">
                            <button 
                                @click="addToCart"
                                class="flex-1 bg-primary text-white py-3 px-6 rounded-lg font-semibold hover:bg-primary-dark transition-colors"
                            >
                                Add to Cart
                            </button>
                            <button 
                                @click="toggleWishlist"
                                :class="isWishlisted ? 'bg-red-500 text-white' : 'bg-gray-100 text-gray-700'"
                                class="px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition-colors"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Product Details -->
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold mb-4">Product Details</h3>
                            <dl class="grid grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">SKU</dt>
                                    <dd class="text-sm text-gray-900">{{ product.sku || 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Brand</dt>
                                    <dd class="text-sm text-gray-900">{{ product.brand || 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Category</dt>
                                    <dd class="text-sm text-gray-900">{{ product.category || 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Weight</dt>
                                    <dd class="text-sm text-gray-900">{{ product.weight || 'N/A' }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading State -->
        <div v-else class="py-8">
            <div class="container mx-auto px-4">
                <div class="animate-pulse">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div class="space-y-4">
                            <div class="aspect-square bg-gray-200 rounded-lg"></div>
                            <div class="grid grid-cols-4 gap-2">
                                <div v-for="i in 4" :key="i" class="aspect-square bg-gray-200 rounded-lg"></div>
                            </div>
                        </div>
                        <div class="space-y-6">
                            <div class="h-8 bg-gray-200 rounded w-3/4"></div>
                            <div class="h-6 bg-gray-200 rounded w-1/4"></div>
                            <div class="h-4 bg-gray-200 rounded w-full"></div>
                            <div class="h-4 bg-gray-200 rounded w-2/3"></div>
                            <div class="h-12 bg-gray-200 rounded w-full"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <section v-if="relatedProducts && relatedProducts.length > 0" class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <h2 class="text-2xl font-bold text-center mb-8">Related Products</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div v-for="relatedProduct in relatedProducts" :key="relatedProduct.id" class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <Link :href="`/product/${relatedProduct.slug}`">
                            <div class="relative">
                                <img :src="relatedProduct.image" :alt="relatedProduct.name" class="w-full h-48 object-cover">
                                <div class="absolute top-2 right-2">
                                    <button 
                                        @click.prevent="toggleWishlist(relatedProduct.id)"
                                        :class="relatedProduct.isWishlisted ? 'bg-red-500 text-white' : 'bg-white hover:bg-gray-100'"
                                        class="rounded-full p-2 shadow-md"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-800 mb-2">{{ relatedProduct.name }}</h3>
                                <div class="flex items-center justify-between">
                                    <span class="text-primary font-bold">${{ relatedProduct.price }}</span>
                                    <button 
                                        @click.prevent="addToCart(relatedProduct.id)"
                                        class="bg-primary text-white px-3 py-1 rounded text-sm hover:bg-primary-dark transition-colors"
                                    >
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </Link>
                    </div>
                </div>
            </div>
        </section>
    </TailstoreLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import TailstoreLayout from '@/Layouts/TailstoreLayout.vue'

const props = defineProps({
    product: Object,
    relatedProducts: {
        type: Array,
        default: () => []
    }
})

const quantity = ref(1)
const selectedVariant = ref(null)
const isWishlisted = ref(false)

// Sample product images - replace with actual product images
const productImages = ref([
    'https://via.placeholder.com/150x150/3B82F6/FFFFFF?text=Image+1',
    'https://via.placeholder.com/150x150/3B82F6/FFFFFF?text=Image+2',
    'https://via.placeholder.com/150x150/3B82F6/FFFFFF?text=Image+3',
    'https://via.placeholder.com/150x150/3B82F6/FFFFFF?text=Image+4',
])

const addToCart = (productId = null) => {
    const id = productId || props.product?.id
    console.log('Adding product to cart:', id, 'Quantity:', quantity.value)
    // Handle add to cart functionality
}

const toggleWishlist = (productId = null) => {
    const id = productId || props.product?.id
    if (productId) {
        // Toggle wishlist for related products
        const product = props.relatedProducts.find(p => p.id === productId)
        if (product) {
            product.isWishlisted = !product.isWishlisted
        }
    } else {
        // Toggle wishlist for main product
        isWishlisted.value = !isWishlisted.value
    }
}
</script>
