<template>
    <TailstoreLayout>
        <!-- Page Header -->
        <section class="bg-gray-50 py-12">
            <div class="container mx-auto px-4">
                <h1 class="text-3xl font-bold text-gray-800">Checkout</h1>
            </div>
        </section>

        <!-- Checkout Content -->
        <section class="py-8">
            <div class="container mx-auto px-4">
                <div class="flex flex-col gap-8 lg:flex-row">
                    <!-- Checkout Form -->
                    <div class="lg:w-2/3">
                        <form @submit.prevent="placeOrder" class="space-y-8">
                            <!-- Billing Information -->
                            <div class="rounded-lg bg-white p-6 shadow-md">
                                <h2 class="mb-6 text-xl font-semibold">
                                    Billing Information
                                </h2>
                                <div
                                    class="grid grid-cols-1 gap-6 md:grid-cols-2"
                                >
                                    <div>
                                        <label
                                            class="mb-2 block text-sm font-medium text-gray-700"
                                            >First Name *</label
                                        >
                                        <input
                                            v-model="billing.firstName"
                                            type="text"
                                            required
                                            class="focus:ring-primary w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-transparent focus:ring-2"
                                        />
                                    </div>
                                    <div>
                                        <label
                                            class="mb-2 block text-sm font-medium text-gray-700"
                                            >Last Name *</label
                                        >
                                        <input
                                            v-model="billing.lastName"
                                            type="text"
                                            required
                                            class="focus:ring-primary w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-transparent focus:ring-2"
                                        />
                                    </div>
                                    <div class="md:col-span-2">
                                        <label
                                            class="mb-2 block text-sm font-medium text-gray-700"
                                            >Email Address *</label
                                        >
                                        <input
                                            v-model="billing.email"
                                            type="email"
                                            required
                                            class="focus:ring-primary w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-transparent focus:ring-2"
                                        />
                                    </div>
                                    <div class="md:col-span-2">
                                        <label
                                            class="mb-2 block text-sm font-medium text-gray-700"
                                            >Phone Number *</label
                                        >
                                        <input
                                            v-model="billing.phone"
                                            type="tel"
                                            required
                                            class="focus:ring-primary w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-transparent focus:ring-2"
                                        />
                                    </div>
                                    <div class="md:col-span-2">
                                        <label
                                            class="mb-2 block text-sm font-medium text-gray-700"
                                            >Address *</label
                                        >
                                        <input
                                            v-model="billing.address"
                                            type="text"
                                            required
                                            class="focus:ring-primary w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-transparent focus:ring-2"
                                        />
                                    </div>
                                    <div>
                                        <label
                                            class="mb-2 block text-sm font-medium text-gray-700"
                                            >City *</label
                                        >
                                        <input
                                            v-model="billing.city"
                                            type="text"
                                            required
                                            class="focus:ring-primary w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-transparent focus:ring-2"
                                        />
                                    </div>
                                    <div>
                                        <label
                                            class="mb-2 block text-sm font-medium text-gray-700"
                                            >State *</label
                                        >
                                        <input
                                            v-model="billing.state"
                                            type="text"
                                            required
                                            class="focus:ring-primary w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-transparent focus:ring-2"
                                        />
                                    </div>
                                    <div>
                                        <label
                                            class="mb-2 block text-sm font-medium text-gray-700"
                                            >ZIP Code *</label
                                        >
                                        <input
                                            v-model="billing.zipCode"
                                            type="text"
                                            required
                                            class="focus:ring-primary w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-transparent focus:ring-2"
                                        />
                                    </div>
                                    <div>
                                        <label
                                            class="mb-2 block text-sm font-medium text-gray-700"
                                            >Country *</label
                                        >
                                        <select
                                            v-model="billing.country"
                                            required
                                            class="focus:ring-primary w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-transparent focus:ring-2"
                                        >
                                            <option value="">
                                                Select Country
                                            </option>
                                            <option value="US">
                                                United States
                                            </option>
                                            <option value="CA">Canada</option>
                                            <option value="UK">
                                                United Kingdom
                                            </option>
                                            <option value="DE">Germany</option>
                                            <option value="FR">France</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Shipping Information -->
                            <div class="rounded-lg bg-white p-6 shadow-md">
                                <div
                                    class="mb-6 flex items-center justify-between"
                                >
                                    <h2 class="text-xl font-semibold">
                                        Shipping Information
                                    </h2>
                                    <label class="flex items-center">
                                        <input
                                            v-model="sameAsBilling"
                                            type="checkbox"
                                            class="text-primary focus:ring-primary rounded border-gray-300"
                                            @change="copyBillingToShipping"
                                        />
                                        <span class="ml-2 text-sm text-gray-700"
                                            >Same as billing address</span
                                        >
                                    </label>
                                </div>
                                <div
                                    class="grid grid-cols-1 gap-6 md:grid-cols-2"
                                >
                                    <div>
                                        <label
                                            class="mb-2 block text-sm font-medium text-gray-700"
                                            >First Name *</label
                                        >
                                        <input
                                            v-model="shipping.firstName"
                                            type="text"
                                            required
                                            class="focus:ring-primary w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-transparent focus:ring-2"
                                        />
                                    </div>
                                    <div>
                                        <label
                                            class="mb-2 block text-sm font-medium text-gray-700"
                                            >Last Name *</label
                                        >
                                        <input
                                            v-model="shipping.lastName"
                                            type="text"
                                            required
                                            class="focus:ring-primary w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-transparent focus:ring-2"
                                        />
                                    </div>
                                    <div class="md:col-span-2">
                                        <label
                                            class="mb-2 block text-sm font-medium text-gray-700"
                                            >Address *</label
                                        >
                                        <input
                                            v-model="shipping.address"
                                            type="text"
                                            required
                                            class="focus:ring-primary w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-transparent focus:ring-2"
                                        />
                                    </div>
                                    <div>
                                        <label
                                            class="mb-2 block text-sm font-medium text-gray-700"
                                            >City *</label
                                        >
                                        <input
                                            v-model="shipping.city"
                                            type="text"
                                            required
                                            class="focus:ring-primary w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-transparent focus:ring-2"
                                        />
                                    </div>
                                    <div>
                                        <label
                                            class="mb-2 block text-sm font-medium text-gray-700"
                                            >State *</label
                                        >
                                        <input
                                            v-model="shipping.state"
                                            type="text"
                                            required
                                            class="focus:ring-primary w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-transparent focus:ring-2"
                                        />
                                    </div>
                                    <div>
                                        <label
                                            class="mb-2 block text-sm font-medium text-gray-700"
                                            >ZIP Code *</label
                                        >
                                        <input
                                            v-model="shipping.zipCode"
                                            type="text"
                                            required
                                            class="focus:ring-primary w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-transparent focus:ring-2"
                                        />
                                    </div>
                                    <div>
                                        <label
                                            class="mb-2 block text-sm font-medium text-gray-700"
                                            >Country *</label
                                        >
                                        <select
                                            v-model="shipping.country"
                                            required
                                            class="focus:ring-primary w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-transparent focus:ring-2"
                                        >
                                            <option value="">
                                                Select Country
                                            </option>
                                            <option value="US">
                                                United States
                                            </option>
                                            <option value="CA">Canada</option>
                                            <option value="UK">
                                                United Kingdom
                                            </option>
                                            <option value="DE">Germany</option>
                                            <option value="FR">France</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Information -->
                            <div class="rounded-lg bg-white p-6 shadow-md">
                                <h2 class="mb-6 text-xl font-semibold">
                                    Payment Information
                                </h2>
                                <div class="space-y-6">
                                    <div>
                                        <label
                                            class="mb-2 block text-sm font-medium text-gray-700"
                                            >Card Number *</label
                                        >
                                        <input
                                            v-model="payment.cardNumber"
                                            type="text"
                                            placeholder="1234 5678 9012 3456"
                                            required
                                            class="focus:ring-primary w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-transparent focus:ring-2"
                                        />
                                    </div>
                                    <div class="grid grid-cols-2 gap-6">
                                        <div>
                                            <label
                                                class="mb-2 block text-sm font-medium text-gray-700"
                                                >Expiry Date *</label
                                            >
                                            <input
                                                v-model="payment.expiryDate"
                                                type="text"
                                                placeholder="MM/YY"
                                                required
                                                class="focus:ring-primary w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-transparent focus:ring-2"
                                            />
                                        </div>
                                        <div>
                                            <label
                                                class="mb-2 block text-sm font-medium text-gray-700"
                                                >CVV *</label
                                            >
                                            <input
                                                v-model="payment.cvv"
                                                type="text"
                                                placeholder="123"
                                                required
                                                class="focus:ring-primary w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-transparent focus:ring-2"
                                            />
                                        </div>
                                    </div>
                                    <div>
                                        <label
                                            class="mb-2 block text-sm font-medium text-gray-700"
                                            >Name on Card *</label
                                        >
                                        <input
                                            v-model="payment.cardName"
                                            type="text"
                                            required
                                            class="focus:ring-primary w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-transparent focus:ring-2"
                                        />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:w-1/3">
                        <div class="rounded-lg bg-white p-6 shadow-md">
                            <h2 class="mb-6 text-xl font-semibold">
                                Order Summary
                            </h2>

                            <!-- Order Items -->
                            <div class="mb-6 space-y-4">
                                <div
                                    v-for="item in orderItems"
                                    :key="item.id"
                                    class="flex items-center"
                                >
                                    <img
                                        :src="item.image"
                                        :alt="item.name"
                                        class="h-12 w-12 rounded object-cover"
                                    />
                                    <div class="ml-3 flex-1">
                                        <h3 class="font-medium text-gray-800">
                                            {{ item.name }}
                                        </h3>
                                        <p class="text-sm text-gray-600">
                                            Qty: {{ item.quantity }}
                                        </p>
                                    </div>
                                    <span class="font-semibold"
                                        >${{
                                            (
                                                item.price * item.quantity
                                            ).toFixed(2)
                                        }}</span
                                    >
                                </div>
                            </div>

                            <!-- Summary -->
                            <div class="mb-6 space-y-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-semibold"
                                        >${{ subtotal.toFixed(2) }}</span
                                    >
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Shipping</span>
                                    <span class="font-semibold"
                                        >${{ shippingCost.toFixed(2) }}</span
                                    >
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tax</span>
                                    <span class="font-semibold"
                                        >${{ tax.toFixed(2) }}</span
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

                            <!-- Place Order Button -->
                            <button
                                @click="placeOrder"
                                :disabled="isProcessing"
                                class="bg-primary hover:bg-primary-dark w-full rounded-lg px-6 py-3 font-semibold text-white transition-colors disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                {{
                                    isProcessing
                                        ? "Processing..."
                                        : "Place Order"
                                }}
                            </button>

                            <!-- Security Notice -->
                            <div class="mt-6 border-t border-gray-200 pt-6">
                                <div
                                    class="flex items-center text-sm text-gray-600"
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
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                        ></path>
                                    </svg>
                                    Secure checkout powered by Stripe
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </TailstoreLayout>
</template>

<script setup>
import { ref, computed, reactive } from "vue";
import { Link } from "@inertiajs/vue3";
import TailstoreLayout from "@/Layouts/TailstoreLayout.vue";

// Reactive data
const isProcessing = ref(false);
const sameAsBilling = ref(false);

// Form data
const billing = reactive({
    firstName: "",
    lastName: "",
    email: "",
    phone: "",
    address: "",
    city: "",
    state: "",
    zipCode: "",
    country: "",
});

const shipping = reactive({
    firstName: "",
    lastName: "",
    address: "",
    city: "",
    state: "",
    zipCode: "",
    country: "",
});

const payment = reactive({
    cardNumber: "",
    expiryDate: "",
    cvv: "",
    cardName: "",
});

// Sample order data - replace with actual data from your backend
const orderItems = ref([
    {
        id: 1,
        name: "Modern Chair 1",
        price: 199,
        quantity: 2,
        image: "https://via.placeholder.com/50x50/3B82F6/FFFFFF?text=1",
    },
    {
        id: 2,
        name: "Modern Chair 2",
        price: 249,
        quantity: 1,
        image: "https://via.placeholder.com/50x50/3B82F6/FFFFFF?text=2",
    },
    {
        id: 3,
        name: "Modern Chair 3",
        price: 179,
        quantity: 1,
        image: "https://via.placeholder.com/50x50/3B82F6/FFFFFF?text=3",
    },
]);

// Computed properties
const subtotal = computed(() => {
    return orderItems.value.reduce(
        (total, item) => total + item.price * item.quantity,
        0,
    );
});

const shippingCost = computed(() => {
    return subtotal.value > 100 ? 0 : 25;
});

const tax = computed(() => {
    return subtotal.value * 0.1; // 10% tax
});

const total = computed(() => {
    return subtotal.value + shippingCost.value + tax.value;
});

// Methods
const copyBillingToShipping = () => {
    if (sameAsBilling.value) {
        shipping.firstName = billing.firstName;
        shipping.lastName = billing.lastName;
        shipping.address = billing.address;
        shipping.city = billing.city;
        shipping.state = billing.state;
        shipping.zipCode = billing.zipCode;
        shipping.country = billing.country;
    }
};

const validateForm = () => {
    // Basic validation - you can enhance this
    const requiredFields = [
        billing.firstName,
        billing.lastName,
        billing.email,
        billing.phone,
        billing.address,
        billing.city,
        billing.state,
        billing.zipCode,
        billing.country,
        shipping.firstName,
        shipping.lastName,
        shipping.address,
        shipping.city,
        shipping.state,
        shipping.zipCode,
        shipping.country,
        payment.cardNumber,
        payment.expiryDate,
        payment.cvv,
        payment.cardName,
    ];

    return requiredFields.every((field) => field.trim() !== "");
};

const placeOrder = async () => {
    if (!validateForm()) {
        alert("Please fill in all required fields");
        return;
    }

    isProcessing.value = true;

    try {
        // Simulate API call
        await new Promise((resolve) => setTimeout(resolve, 2000));

        // Here you would typically make an API call to process the order
        console.log("Order data:", {
            billing,
            shipping,
            payment: {
                ...payment,
                cardNumber: payment.cardNumber.replace(/\d(?=\d{4})/g, "*"), // Mask card number
            },
            orderItems: orderItems.value,
            total: total.value,
        });

        // Redirect to success page or show success message
        alert("Order placed successfully!");
    } catch (error) {
        console.error("Order processing failed:", error);
        alert("Failed to place order. Please try again.");
    } finally {
        isProcessing.value = false;
    }
};
</script>
