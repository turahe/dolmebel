<x-guest-layout>
    <div
        x-data="productDetail({
                    sale: {{ $product->price->sale }},
                    cogs: {{ $product->price->cogs }},
                    currency: '{{ $product->price->currency }}',
                })"
        x-init="fetchMedia('123')"
    >
        <section class="container mx-auto max-w-[1200px] flex-grow border-b py-5 lg:grid lg:grid-cols-2 lg:py-10">
            <!-- image gallery -->

            <div class="container mx-auto px-4">
                <img
                    class="w-full"
                    src="{{ $product->image }}"
                    alt="Sofa image"
                />

                <div class="mt-3 grid grid-cols-4 gap-4">
                    <template x-if="loading">
                        <div>Loading...</div>
                    </template>
                    <template x-for="image in media">
                        <img
                            class="cursor-pointer"
                            :src="image.url"
                            :alt="image.name"
                        />
                    </template>
                </div>
                <!-- /image gallery  -->
            </div>

            <!-- description  -->

            <div class="mx-auto px-5 lg:px-5">
                <h2 class="pt-3 text-2xl font-bold lg:pt-0">{{ $product->name }}</h2>
                <div
                    class="mt-1"
                    x-data="{ rating: -1, ratings: [0, 1, 2, 3, 4] }"
                >
                    <div class="flex items-center">
                        <template
                            x-for="(star, index) in ratings"
                            :key="index"
                        >
                            <svg
                                @click="rating = (rating === index) ? -1 : index"
                                :class="{ 'text-yellow-400': index <= rating, 'text-gray-400': index > rating }"
                                class="h-4 w-4"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </template>
                        <span
                            x-text="rating === -1 ? '0 stars' : rating + 1 + ' stars'"
                            class="ml-3 text-sm text-gray-500"
                        >
                            0 stars
                        </span>

                        <span class="ml-3 text-sm text-gray-400">(150 reviews)</span>
                    </div>
                </div>

                <p class="mt-5 font-bold">
                    Availability:
                    <span class="text-green-600">In Stock</span>
                </p>
                @if ($product->brand)
                    <p class="font-bold">
                        Brand:
                        <span class="font-normal">{{ $product->brand->name }}</span>
                    </p>
                @endif

                @if ($product->category)
                    <p class="font-bold">
                        Category:
                        <span class="font-normal">{{ $product->category->name }}</span>
                    </p>
                @endif

                <p class="font-bold">
                    SKU:
                    <span class="font-normal">BE45VGTRK</span>
                </p>

                @if ($product->price)
                    <p class="mt-4 text-4xl font-bold text-violet-900">
                        <span x-text="linePrice"></span>
                        <span
                            class="text-xs text-gray-400 line-through"
                            x-text="lineCogs"
                        ></span>
                    </p>
                @endif

                <p class="pt-5 text-sm leading-5 text-gray-500">
                    {{ $product->description }}
                </p>

                <div
                    class="mt-6"
                    x-data="{ sizes: ['XS', 'S', 'M', 'L', 'XL'], selectedSize: null }"
                >
                    <p class="pb-2 text-xs text-gray-500">{{ __('Size') }}</p>

                    <div class="flex gap-1">
                        <template x-for="size in sizes">
                            <div
                                class="flex h-8 w-8 cursor-pointer items-center justify-center border duration-100 hover:bg-neutral-100 focus:ring-2 focus:ring-gray-500 active:ring-2"
                                :class="{ 'bg-gray-300 active:ring-gray-500': selectedSize === size }"
                                @click="selectedSize = size"
                            >
                                <span x-text="size"></span>
                            </div>
                        </template>
                    </div>
                </div>

                <div
                    class="mt-6"
                    x-data="{ colors: ['gray', 'violet', 'red'], selectedColor: null }"
                >
                    <p class="pb-2 text-xs text-gray-500">{{ __('Color') }}</p>

                    <div class="flex gap-1">
                        <template x-for="color in colors">
                            <div
                                class="h-8 w-8 cursor-pointer border border-white"
                                :class="{
                            'bg-gray-600 active:ring-gray-500': color === 'gray',
                    'bg-violet-600 active:ring-violet-500': color === 'violet',
                    'bg-red-600 active:ring-red-500': color === 'red',
                            'active:ring-2 focus:ring-2 ': selectedColor === color
                            }"
                                @click="selectedColor = color"
                            ></div>
                        </template>
                    </div>
                </div>

                <div class="mt-6">
                    <p class="pb-2 text-xs text-gray-500">{{ __('Quantity') }}</p>

                    <div class="flex">
                        <button
                            class="flex h-8 w-8 cursor-pointer items-center justify-center border duration-100 hover:bg-neutral-100 focus:ring-2 focus:ring-gray-500 active:ring-2 active:ring-gray-500"
                            @click="quantity--"
                        >
                            &minus;
                        </button>
                        <input
                            class="flex h-8 w-8 cursor-text items-center justify-center border-b border-t active:ring-gray-500"
                            name="quantity"
                            x-model.number="quantity"
                        />
                        <button
                            class="flex h-8 w-8 cursor-pointer items-center justify-center border duration-100 hover:bg-neutral-100 focus:ring-2 focus:ring-gray-500 active:ring-2 active:ring-gray-500"
                            @click="quantity++"
                        >
                            &#43;
                        </button>
                    </div>
                </div>

                <div
                    class="mt-7 flex flex-row items-center gap-6"
                    x-data="productApp"
                >
                    <x-primary-button
                        class="flex h-12 w-1/3 items-center justify-center duration-100 hover:bg-blue-800"
                        @click="addToCart({product_id: '{{ $product->id }}', quantity: 1, color: 'RED', size: selectedSize })"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="mr-3 h-4 w-4"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"
                            />
                        </svg>
                        {{ __('Add to cart') }}
                    </x-primary-button>

                    <x-secondary-button
                        class="flex h-12 w-1/3 items-center justify-center duration-100 hover:bg-yellow-300"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="mr-3 h-4 w-4"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"
                            />
                        </svg>

                        {{ __('Wishlist') }}
                    </x-secondary-button>
                </div>
            </div>
        </section>

        <!-- product details  -->

        <section class="container mx-auto max-w-[1200px] px-5 py-5 lg:py-10">
            <h2 class="text-xl">{{ __('Product detail') }}</h2>
            {!! $product->content_html !!}
        </section>
        <!-- /product details  -->
        <x-comment />
        <!-- /description  -->

        <p class="mx-auto mb-5 mt-10 max-w-[1200px] px-5">{{ __('Related Products') }}</p>

        <!-- Recommendations -->
        <section
            class="container mx-auto grid max-w-[1200px] grid-cols-2 gap-3 px-5 pb-10 lg:grid-cols-4"
            x-data="theProducts('/api/products?limit=4')"
            x-init="fetchProducts()"
        >
            <template x-if="loading">
                <div>Loading...</div>
            </template>

            <template x-if="products.length > 0">
                <template x-for="item in products">
                    <div class="relative flex flex-col">
                        <div
                            class="absolute flex h-1/2 w-full justify-center gap-3 pt-16 opacity-0 duration-150 hover:opacity-100"
                        >
                            <span
                                class="flex h-8 w-8 cursor-pointer items-center justify-center rounded-full bg-amber-400"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="h-4 w-4"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"
                                    />
                                </svg>
                            </span>
                            <span
                                class="flex h-8 w-8 cursor-pointer items-center justify-center rounded-full bg-amber-400"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                    class="h-4 w-4"
                                >
                                    <path
                                        d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z"
                                    />
                                </svg>
                            </span>
                        </div>
                        <img
                            :src="item.image"
                            :alt="item.name"
                        />

                        <div>
                            <p
                                class="mt-2"
                                x-text="item.name"
                            ></p>

                            <template x-if="item.price">
                                <p class="font-medium text-violet-900">
                                    <span x-text="item.price.sale"></span>
                                    <span
                                        class="text-sm text-gray-500 line-through"
                                        x-text="item.price.cogs"
                                    ></span>
                                </p>
                            </template>

                            <div class="flex items-center">
                                <template x-for="i in 5">
                                    <x-icons.star class="text-yellow-400" />
                                </template>
                                <p class="text-sm text-gray-400">(38)</p>
                            </div>

                            <div>
                                <x-primary-button class="w-full">
                                    {{ __('Add to cart') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </div>
                </template>
            </template>

            <!-- 2 -->
        </section>
        <!-- /Recommendations -->
    </div>
</x-guest-layout>
