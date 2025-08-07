@extends('layouts.tailstore')

@section('title', 'Shopping Cart')

@section('content')
    <!-- Page Header -->
    <section class="bg-gray-50 py-12">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold text-gray-800">Shopping Cart</h1>
        </div>
    </section>

    <!-- Cart Content -->
    <section class="py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Cart Items -->
                <div class="lg:w-2/3">
                    <div class="bg-white rounded-lg shadow-md">
                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-xl font-semibold">Cart Items (3)</h2>
                        </div>
                        
                        <!-- Cart Items List -->
                        <div class="divide-y divide-gray-200">
                            @foreach(range(1, 3) as $i)
                            <div class="p-6">
                                <div class="flex items-center">
                                    <img src="https://via.placeholder.com/100x100/3B82F6/FFFFFF?text=Product+{{ $i }}" alt="Product {{ $i }}" class="w-20 h-20 object-cover rounded-lg">
                                    <div class="ml-4 flex-1">
                                        <h3 class="font-semibold text-gray-800">Modern Chair {{ $i }}</h3>
                                        <p class="text-gray-600 text-sm">Color: Brown</p>
                                        <div class="flex items-center mt-2">
                                            <span class="text-primary font-bold">${{ rand(150, 300) }}</span>
                                            @if($i == 1)
                                            <span class="text-gray-400 line-through ml-2">$350</span>
                                            <span class="bg-red-500 text-white px-2 py-1 rounded text-xs ml-2">Sale</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <div class="flex items-center border border-gray-300 rounded-lg">
                                            <button class="px-3 py-1 hover:bg-gray-100">-</button>
                                            <span class="px-3 py-1 border-x border-gray-300">{{ rand(1, 3) }}</span>
                                            <button class="px-3 py-1 hover:bg-gray-100">+</button>
                                        </div>
                                        <button class="text-red-500 hover:text-red-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Continue Shopping -->
                    <div class="mt-6">
                        <a href="{{ route('products.catalog') }}" class="inline-flex items-center text-primary hover:text-primary-dark">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Continue Shopping
                        </a>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:w-1/3">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold mb-6">Order Summary</h2>
                        
                        <!-- Summary Items -->
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal (3 items)</span>
                                <span class="font-semibold">$750.00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Shipping</span>
                                <span class="font-semibold">$25.00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tax</span>
                                <span class="font-semibold">$75.00</span>
                            </div>
                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex justify-between">
                                    <span class="text-lg font-semibold">Total</span>
                                    <span class="text-lg font-bold text-primary">$850.00</span>
                                </div>
                            </div>
                        </div>

                        <!-- Coupon Code -->
                        <div class="mb-6">
                            <h3 class="font-medium mb-3">Have a coupon?</h3>
                            <div class="flex">
                                <input 
                                    type="text" 
                                    placeholder="Enter coupon code" 
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                >
                                <button class="bg-primary text-white px-4 py-2 rounded-r-lg hover:bg-primary-dark transition-colors">
                                    Apply
                                </button>
                            </div>
                        </div>

                        <!-- Checkout Button -->
                        <a href="{{ route('checkout') }}" class="w-full bg-primary text-white py-3 px-6 rounded-lg font-semibold hover:bg-primary-dark transition-colors text-center block">
                            Proceed to Checkout
                        </a>

                        <!-- Payment Methods -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <h3 class="font-medium mb-3">We Accept</h3>
                            <div class="flex space-x-2">
                                <div class="w-10 h-6 bg-gray-200 rounded flex items-center justify-center">
                                    <span class="text-xs font-semibold">VISA</span>
                                </div>
                                <div class="w-10 h-6 bg-gray-200 rounded flex items-center justify-center">
                                    <span class="text-xs font-semibold">MC</span>
                                </div>
                                <div class="w-10 h-6 bg-gray-200 rounded flex items-center justify-center">
                                    <span class="text-xs font-semibold">PP</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold text-center mb-8">You Might Also Like</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach(range(1, 4) as $i)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="relative">
                        <img src="https://via.placeholder.com/300x300/3B82F6/FFFFFF?text=Related+{{ $i }}" alt="Related Product {{ $i }}" class="w-full h-48 object-cover">
                        <div class="absolute top-2 right-2">
                            <button class="bg-white rounded-full p-2 shadow-md hover:bg-gray-100">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 mb-2">Related Product {{ $i }}</h3>
                        <div class="flex items-center justify-between">
                            <span class="text-primary font-bold">${{ rand(150, 300) }}</span>
                            <button class="bg-primary text-white px-3 py-1 rounded text-sm hover:bg-primary-dark transition-colors">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
