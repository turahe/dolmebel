@extends('layouts.tailstore')

@section('title', 'Home')

@section('content')
    <!-- Hero Slider -->
    <section class="relative">
        <div class="swiper hero-swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="relative h-[500px] md:h-[600px] bg-gradient-to-r from-blue-600 to-purple-600">
                        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                        <div class="relative container mx-auto px-4 h-full flex items-center">
                            <div class="text-white max-w-2xl">
                                <h1 class="text-4xl md:text-6xl font-bold mb-4">Transform Your Space</h1>
                                <p class="text-xl mb-8">Discover our collection of premium furniture that combines style, comfort, and functionality.</p>
                                <a href="{{ route('products.catalog') }}" class="bg-white text-primary px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                                    Shop Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="relative h-[500px] md:h-[600px] bg-gradient-to-r from-green-600 to-blue-600">
                        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                        <div class="relative container mx-auto px-4 h-full flex items-center">
                            <div class="text-white max-w-2xl">
                                <h1 class="text-4xl md:text-6xl font-bold mb-4">Summer Sale</h1>
                                <p class="text-xl mb-8">Up to 50% off on selected items. Limited time offer!</p>
                                <a href="#" class="bg-white text-primary px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                                    View Sale
                                </a>
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

    <!-- Categories -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Shop by Category</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <a href="#" class="group">
                    <div class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition-shadow">
                        <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-800 group-hover:text-primary">Bedroom</h3>
                    </div>
                </a>
                <a href="#" class="group">
                    <div class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition-shadow">
                        <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-800 group-hover:text-primary">Living Room</h3>
                    </div>
                </a>
                <a href="#" class="group">
                    <div class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition-shadow">
                        <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-800 group-hover:text-primary">Dining Room</h3>
                    </div>
                </a>
                <a href="#" class="group">
                    <div class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition-shadow">
                        <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-800 group-hover:text-primary">Office</h3>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold">Featured Products</h2>
                <a href="{{ route('products.catalog') }}" class="text-primary hover:text-primary-dark font-semibold">
                    View All →
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach(range(1, 8) as $i)
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
                        @if($i <= 3)
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
                                @if($i <= 3)
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
        </div>
    </section>

    <!-- Brand Carousel -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Trusted Brands</h2>
            <div class="swiper brand-swiper">
                <div class="swiper-wrapper">
                    @foreach(range(1, 6) as $i)
                    <div class="swiper-slide">
                        <div class="bg-white rounded-lg shadow-md p-6 flex items-center justify-center h-20">
                            <span class="text-gray-600 font-semibold text-lg">Brand {{ $i }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="py-16 bg-primary">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">Stay Updated</h2>
            <p class="text-white text-lg mb-8">Subscribe to our newsletter for the latest products and exclusive offers.</p>
            <form class="max-w-md mx-auto flex">
                <input 
                    type="email" 
                    placeholder="Enter your email" 
                    class="flex-1 px-4 py-3 rounded-l-lg border-0 focus:ring-2 focus:ring-white"
                >
                <button type="submit" class="bg-white text-primary px-6 py-3 rounded-r-lg font-semibold hover:bg-gray-100 transition-colors">
                    Subscribe
                </button>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Import Swiper modules
    const { Navigation, Pagination, Autoplay } = window.Swiper;
    
    // Hero Slider
    new Swiper('.hero-swiper', {
        modules: [Navigation, Pagination, Autoplay],
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
    });

    // Brand Carousel
    new Swiper('.brand-swiper', {
        modules: [Autoplay],
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
    });
});
</script>
@endpush
