@extends('layouts.tailstore')

@section('title', 'Shop')

@section('content')
    <!-- Page Header -->
    <section class="bg-gray-50 py-12">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Shop</h1>
                    <p class="text-gray-600 mt-2">Discover our collection of premium furniture</p>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">Showing 1-12 of 48 products</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Filters and Products -->
    <section class="py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar Filters -->
                <div class="lg:w-1/4">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold mb-4">Filters</h3>
                        
                        <!-- Categories -->
                        <div class="mb-6">
                            <h4 class="font-medium mb-3">Categories</h4>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" class="rounded border-gray-300 text-primary focus:ring-primary">
                                    <span class="ml-2 text-gray-700">Bedroom (12)</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="rounded border-gray-300 text-primary focus:ring-primary">
                                    <span class="ml-2 text-gray-700">Living Room (8)</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="rounded border-gray-300 text-primary focus:ring-primary">
                                    <span class="ml-2 text-gray-700">Dining Room (6)</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="rounded border-gray-300 text-primary focus:ring-primary">
                                    <span class="ml-2 text-gray-700">Office (4)</span>
                                </label>
                            </div>
                        </div>

                        <!-- Price Range -->
                        <div class="mb-6">
                            <h4 class="font-medium mb-3">Price Range</h4>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="price" class="text-primary focus:ring-primary">
                                    <span class="ml-2 text-gray-700">$0 - $100</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="price" class="text-primary focus:ring-primary">
                                    <span class="ml-2 text-gray-700">$100 - $300</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="price" class="text-primary focus:ring-primary">
                                    <span class="ml-2 text-gray-700">$300 - $500</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="price" class="text-primary focus:ring-primary">
                                    <span class="ml-2 text-gray-700">$500+</span>
                                </label>
                            </div>
                        </div>

                        <!-- Rating -->
                        <div class="mb-6">
                            <h4 class="font-medium mb-3">Rating</h4>
                            <div class="space-y-2">
                                @foreach(range(5, 1) as $rating)
                                <label class="flex items-center">
                                    <input type="checkbox" class="rounded border-gray-300 text-primary focus:ring-primary">
                                    <div class="flex text-yellow-400 ml-2">
                                        @foreach(range(1, $rating) as $star)
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        @endforeach
                                    </div>
                                    <span class="text-gray-500 text-sm ml-2">({{ rand(5, 25) }})</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Clear Filters -->
                        <button class="w-full bg-gray-100 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-200 transition-colors">
                            Clear All Filters
                        </button>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="lg:w-3/4">
                    <!-- Sort and View Options -->
                    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
                        <div class="flex items-center space-x-4 mb-4 sm:mb-0">
                            <span class="text-gray-600">Sort by:</span>
                            <select class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option>Featured</option>
                                <option>Price: Low to High</option>
                                <option>Price: High to Low</option>
                                <option>Newest</option>
                                <option>Best Rating</option>
                            </select>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="p-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                </svg>
                            </button>
                            <button class="p-2 border border-gray-300 rounded-lg bg-primary text-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach(range(1, 12) as $i)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                            <div class="relative">
                                <img src="https://via.placeholder.com/300x300/3B82F6/FFFFFF?text=Product+{{ $i }}" alt="Product {{ $i }}" class="w-full h-64 object-cover">
                                <div class="absolute top-2 right-2">
                                    <button class="bg-white rounded-full p-2 shadow-md hover:bg-gray-100">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </button>
                                </div>
                                @if($i <= 4)
                                <div class="absolute top-2 left-2">
                                    <span class="bg-red-500 text-white px-2 py-1 rounded text-sm font-semibold">Sale</span>
                                </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-800 mb-2">Modern Chair {{ $i }}</h3>
                                <div class="flex items-center mb-2">
                                    <div class="flex text-yellow-400">
                                        @foreach(range(1, 5) as $star)
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        @endforeach
                                    </div>
                                    <span class="text-gray-500 text-sm ml-2">({{ rand(10, 50) }})</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        @if($i <= 4)
                                        <span class="text-gray-400 line-through mr-2">${{ rand(200, 400) }}</span>
                                        @endif
                                        <span class="text-primary font-bold text-lg">${{ rand(150, 300) }}</span>
                                    </div>
                                    <button class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors">
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-center mt-12">
                        <nav class="flex items-center space-x-2">
                            <a href="#" class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Previous</a>
                            <a href="#" class="px-3 py-2 bg-primary text-white rounded-lg">1</a>
                            <a href="#" class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">2</a>
                            <a href="#" class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">3</a>
                            <a href="#" class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Next</a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
