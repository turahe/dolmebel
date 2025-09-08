<template>
    <TailstoreLayout>
        <!-- Page Header -->
        <section class="bg-gray-50 py-12">
            <div class="container mx-auto px-4">
                <h1 class="text-3xl font-bold text-gray-800">Shopping Cart</h1>
            </div>
        </section>

        <!-- Cart Content -->
        <section class="py-8">
            <div class="container mx-auto px-4">
                <div v-if="cartItems.length === 0" class="py-16 text-center">
                    <div
                        class="mx-auto mb-6 flex h-24 w-24 items-center justify-center rounded-full bg-gray-100"
                    >
                        <svg
                            class="h-12 w-12 text-gray-400"
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
                    </div>
                    <h2 class="mb-4 text-2xl font-bold text-gray-800">
                        Your cart is empty
                    </h2>
                    <p class="mb-8 text-gray-600">
                        Looks like you haven't added any items to your cart yet.
                    </p>
                    <Link
                        href="/shop"
                        class="bg-primary hover:bg-primary-dark rounded-lg px-8 py-3 font-semibold text-white transition-colors"
                    >
                        Start Shopping
                    </Link>
                </div>

                <div v-else class="flex flex-col gap-8 lg:flex-row">
                    <!-- Cart Items -->
                    <div class="lg:w-2/3">
                        <div class="rounded-lg bg-white shadow-md">
                            <div class="border-b border-gray-200 p-6">
                                <h2 class="text-xl font-semibold">
                                    Cart Items ({{ cartItems.length }})
                                </h2>
                            </div>

                            <!-- Cart Items List -->
                            <div class="divide-y divide-gray-200">
                                <div
                                    v-for="item in cartItems"
                                    :key="item.id"
                                    class="p-6"
                                >
                                    <div class="flex items-center">
                                        <img
                                            :src="item.image"
                                            :alt="item.name"
                                            class="h-20 w-20 rounded-lg object-cover"
                                        />
                                        <div class="ml-4 flex-1">
                                            <h3
                                                class="font-semibold text-gray-800"
                                            >
                                                {{ item.name }}
                                            </h3>
                                            <p class="text-sm text-gray-600">
                                                Color: {{ item.color }}
                                            </p>
                                            <div class="mt-2 flex items-center">
                                                <span
                                                    class="text-primary font-bold"
                                                    >${{ item.price }}</span
                                                >
                                                <span
                                                    v-if="item.originalPrice"
                                                    class="ml-2 text-gray-400 line-through"
                                                    >${{
                                                        item.originalPrice
                                                    }}</span
                                                >
                                                <span
                                                    v-if="item.isOnSale"
                                                    class="ml-2 rounded bg-red-500 px-2 py-1 text-xs text-white"
                                                    >Sale</span
                                                >
                                            </div>
                                        </div>
                                        <div
                                            class="flex items-center space-x-4"
                                        >
                                            <div
                                                class="flex items-center rounded-lg border border-gray-300"
                                            >
                                                <button
                                                    @click="
                                                        updateQuantity(
                                                            item.id,
                                                            item.quantity - 1,
                                                        )
                                                    "
                                                    :disabled="
                                                        item.quantity <= 1
                                                    "
                                                    class="px-3 py-1 hover:bg-gray-100 disabled:cursor-not-allowed disabled:opacity-50"
                                                >
                                                    -
                                                </button>
                                                <span
                                                    class="border-x border-gray-300 px-3 py-1"
                                                    >{{ item.quantity }}</span
                                                >
                                                <button
                                                    @click="
                                                        updateQuantity(
                                                            item.id,
                                                            item.quantity + 1,
                                                        )
                                                    "
                                                    class="px-3 py-1 hover:bg-gray-100"
                                                >
                                                    +
                                                </button>
                                            </div>
                                            <button
                                                @click="removeItem(item.id)"
                                                class="text-red-500 hover:text-red-700"
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
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                    ></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Continue Shopping -->
                        <div class="mt-6">
                            <Link
                                href="/shop"
                                class="text-primary hover:text-primary-dark inline-flex items-center"
                            >
                                <svg
                                    class="mr-2 h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18"
                                    ></path>
                                </svg>
                                Continue Shopping
                            </Link>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:w-1/3">
                        <div class="rounded-lg bg-white p-6 shadow-md">
                            <h2 class="mb-6 text-xl font-semibold">
                                Order Summary
                            </h2>

                            <!-- Summary Items -->
                            <div class="mb-6 space-y-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-600"
                                        >Subtotal ({{ totalItems }} items)</span
                                    >
                                    <span class="font-semibold"
                                        >${{ subtotal.toFixed(2) }}</span
                                    >
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Shipping</span>
                                    <span class="font-semibold"
                                        >${{ shipping.toFixed(2) }}</span
                                    >
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tax</span>
                                    <span class="font-semibold"
                                        >${{ tax.toFixed(2) }}</span
                                    >
                                </div>
                                <div
                                    v-if="couponDiscount > 0"
                                    class="flex justify-between text-green-600"
                                >
                                    <span>Coupon Discount</span>
                                    <span class="font-semibold"
                                        >-${{ couponDiscount.toFixed(2) }}</span
                                    >
                                </div>
                                <div class="border-t border-gray-200 pt-4">
                                    <div class="flex justify-between">
                                        <span class="text-lg font-semibold"
                                            >Total</span
                                        >
                                        <span
                                            class="text-primary text-lg font-bold"
                                            >${{ total.toFixed(2) }}</span
                                        >
                                    </div>
                                </div>
                            </div>

                            <!-- Coupon Code -->
                            <div class="mb-6">
                                <h3 class="mb-3 font-medium">Have a coupon?</h3>
                                <div class="flex">
                                    <input
                                        v-model="couponCode"
                                        type="text"
                                        placeholder="Enter coupon code"
                                        class="focus:ring-primary flex-1 rounded-l-lg border border-gray-300 px-3 py-2 focus:border-transparent focus:ring-2"
                                    />
                                    <button
                                        @click="applyCoupon"
                                        :disabled="!couponCode.trim()"
                                        class="bg-primary hover:bg-primary-dark rounded-r-lg px-4 py-2 text-white transition-colors disabled:cursor-not-allowed disabled:opacity-50"
                                    >
                                        Apply
                                    </button>
                                </div>
                                <div
                                    v-if="appliedCoupon"
                                    class="mt-2 text-sm text-green-600"
                                >
                                    Coupon "{{ appliedCoupon }}" applied
                                    successfully!
                                </div>
                            </div>

                            <!-- Checkout Button -->
                            <Link
                                href="/checkout"
                                class="bg-primary hover:bg-primary-dark block w-full rounded-lg px-6 py-3 text-center font-semibold text-white transition-colors"
                            >
                                Proceed to Checkout
                            </Link>

                            <!-- Payment Methods -->
                            <div class="mt-6 border-t border-gray-200 pt-6">
                                <h3 class="mb-3 font-medium">We Accept</h3>
                                <div class="flex space-x-2">
                                    <div
                                        class="flex h-6 w-10 items-center justify-center rounded bg-gray-200"
                                    >
                                        <span class="text-xs font-semibold"
                                            >VISA</span
                                        >
                                    </div>
                                    <div
                                        class="flex h-6 w-10 items-center justify-center rounded bg-gray-200"
                                    >
                                        <span class="text-xs font-semibold"
                                            >MC</span
                                        >
                                    </div>
                                    <div
                                        class="flex h-6 w-10 items-center justify-center rounded bg-gray-200"
                                    >
                                        <span class="text-xs font-semibold"
                                            >PP</span
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Related Products -->
        <section v-if="cartItems.length > 0" class="bg-gray-50 py-16">
            <div class="container mx-auto px-4">
                <h2 class="mb-8 text-center text-2xl font-bold">
                    You Might Also Like
                </h2>
                <div
                    class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4"
                >
                    <div
                        v-for="product in relatedProducts"
                        :key="product.id"
                        class="overflow-hidden rounded-lg bg-white shadow-md transition-shadow hover:shadow-lg"
                    >
                        <div class="relative">
                            <img
                                :src="product.image"
                                :alt="product.name"
                                class="h-48 w-full object-cover"
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
                        </div>
                        <div class="p-4">
                            <h3 class="mb-2 font-semibold text-gray-800">
                                {{ product.name }}
                            </h3>
                            <div class="flex items-center justify-between">
                                <span class="text-primary font-bold"
                                    >${{ product.price }}</span
                                >
                                <button
                                    @click="addToCart(product.id)"
                                    class="bg-primary hover:bg-primary-dark rounded px-3 py-1 text-sm text-white transition-colors"
                                >
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </TailstoreLayout>
</template>

<script setup>
import { ref, computed } from "vue";
import { Link } from "@inertiajs/vue3";
import TailstoreLayout from "@/Layouts/TailstoreLayout.vue";

// Reactive data
const couponCode = ref("");
const appliedCoupon = ref("");
const couponDiscount = ref(0);

// Sample cart data - replace with actual data from your backend
const cartItems = ref([
    {
        id: 1,
        name: "Modern Chair 1",
        price: 199,
        originalPrice: 299,
        image: "https://via.placeholder.com/100x100/3B82F6/FFFFFF?text=Product+1",
        color: "Brown",
        quantity: 2,
        isOnSale: true,
    },
    {
        id: 2,
        name: "Modern Chair 2",
        price: 249,
        originalPrice: null,
        image: "https://via.placeholder.com/100x100/3B82F6/FFFFFF?text=Product+2",
        color: "Black",
        quantity: 1,
        isOnSale: false,
    },
    {
        id: 3,
        name: "Modern Chair 3",
        price: 179,
        originalPrice: 229,
        image: "https://via.placeholder.com/100x100/3B82F6/FFFFFF?text=Product+3",
        color: "White",
        quantity: 1,
        isOnSale: true,
    },
]);

const relatedProducts = ref([
    {
        id: 4,
        name: "Related Product 1",
        price: 159,
        image: "https://via.placeholder.com/300x300/3B82F6/FFFFFF?text=Related+1",
        isWishlisted: false,
    },
    {
        id: 5,
        name: "Related Product 2",
        price: 219,
        image: "https://via.placeholder.com/300x300/3B82F6/FFFFFF?text=Related+2",
        isWishlisted: false,
    },
    {
        id: 6,
        name: "Related Product 3",
        price: 189,
        image: "https://via.placeholder.com/300x300/3B82F6/FFFFFF?text=Related+3",
        isWishlisted: false,
    },
    {
        id: 7,
        name: "Related Product 4",
        price: 269,
        image: "https://via.placeholder.com/300x300/3B82F6/FFFFFF?text=Related+4",
        isWishlisted: false,
    },
]);

// Computed properties
const totalItems = computed(() => {
    return cartItems.value.reduce((total, item) => total + item.quantity, 0);
});

const subtotal = computed(() => {
    return cartItems.value.reduce(
        (total, item) => total + item.price * item.quantity,
        0,
    );
});

const shipping = computed(() => {
    return subtotal.value > 100 ? 0 : 25;
});

const tax = computed(() => {
    return subtotal.value * 0.1; // 10% tax
});

const total = computed(() => {
    return subtotal.value + shipping.value + tax.value - couponDiscount.value;
});

// Methods
const updateQuantity = (itemId, newQuantity) => {
    if (newQuantity < 1) return;

    const item = cartItems.value.find((item) => item.id === itemId);
    if (item) {
        item.quantity = newQuantity;
    }
};

const removeItem = (itemId) => {
    const index = cartItems.value.findIndex((item) => item.id === itemId);
    if (index > -1) {
        cartItems.value.splice(index, 1);
    }
};

const applyCoupon = () => {
    if (!couponCode.value.trim()) return;

    // Sample coupon logic - replace with actual API call
    const validCoupons = {
        SAVE10: 10,
        WELCOME20: 20,
        SUMMER15: 15,
    };

    const discount = validCoupons[couponCode.value.toUpperCase()];
    if (discount) {
        couponDiscount.value = discount;
        appliedCoupon.value = couponCode.value.toUpperCase();
        couponCode.value = "";
    } else {
        alert("Invalid coupon code");
    }
};

const toggleWishlist = (productId) => {
    const product = relatedProducts.value.find((p) => p.id === productId);
    if (product) {
        product.isWishlisted = !product.isWishlisted;
    }
};

const addToCart = (productId) => {
    // Handle add to cart functionality
    console.log("Adding product to cart:", productId);
};
</script>
