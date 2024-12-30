<nav class="relative bg-violet-900">
    <div class="mx-auto hidden h-12 w-full max-w-[1200px] items-center md:flex">
        <button
            @click="desktopMenuOpen = ! desktopMenuOpen"
            class="ml-5 flex h-full w-40 cursor-pointer items-center justify-center bg-amber-400"
        >
            <div
                class="flex justify-around"
                href="#"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="mx-1 h-6 w-6"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
                    />
                </svg>

                {{ __('All categories') }}
            </div>
        </button>

        <div class="mx-7 flex gap-8">
            <a
                class="font-light text-white duration-100 hover:text-yellow-400 hover:underline"
                href="/"
            >
                {{ __('Home') }}
            </a>
            <a
                class="font-light text-white duration-100 hover:text-yellow-400 hover:underline"
                href="{{ route('catalog') }}"
            >
                {{ __('Catalog') }}
            </a>
        </div>

        @guest
            <div class="ml-auto flex gap-4 px-5">
                <a
                    class="font-light text-white duration-100 hover:text-yellow-400 hover:underline"
                    href="{{ route('login') }}"
                >
                    {{ __('Login') }}
                </a>

                <span class="text-white">&#124;</span>

                <a
                    class="font-light text-white duration-100 hover:text-yellow-400 hover:underline"
                    href="{{ route('register') }}"
                >
                    {{ __('Sign Up') }}
                </a>
            </div>
        @endguest
    </div>
</nav>

<section
    x-show="desktopMenuOpen"
    @click.outside="desktopMenuOpen = false"
    class="absolute left-0 right-0 z-10 w-full border-b border-l border-r bg-white"
    style="display: none"
>
    <div class="mx-auto flex max-w-[1200px] py-10">
        <div
            class="w-[300px] border-r"
            x-data="theCategories('/categories?parent_id=&relation=products')"
            x-init="fetchCategories()"
        >
            <template x-if="loading">
                <div>Loading...</div>
            </template>
            <template x-if="categories.length > 0">
                <ul class="px-5">
                    <template x-for="item in categories">
                        <li class="active:blue-900 flex items-center gap-2 active:bg-amber-400">
                            <img
                                class="h-4 w-4"
                                :src="item.icon"
                                alt="Bedroom icon"
                            />
                            <span x-text="item.name"></span>
                            <span class="ml-auto">
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
                                        d="M8.25 4.5l7.5 7.5-7.5 7.5"
                                    />
                                </svg>
                            </span>
                        </li>
                    </template>
                </ul>
            </template>
        </div>

        <div class="flex w-full justify-between">
            <div class="flex gap-6">
                <div class="mx-5">
                    <p class="font-medium text-gray-500">BEDS</p>
                    <ul class="text-sm leading-8">
                        <li>
                            <a href="product-overview.html">Italian bed</a>
                        </li>
                        <li>
                            <a href="product-overview.html">Queen-size bed</a>
                        </li>
                        <li>
                            <a href="product-overview.html">Wooden craft bed</a>
                        </li>
                        <li>
                            <a href="product-overview.html">King-size bed</a>
                        </li>
                    </ul>
                </div>

                <div class="mx-5">
                    <p class="font-medium text-gray-500">LAMPS</p>
                    <ul class="text-sm leading-8">
                        <li>
                            <a href="product-overview.html">Italian Purple Lamp</a>
                        </li>
                        <li>
                            <a href="product-overview.html">APEX Lamp</a>
                        </li>
                        <li>
                            <a href="product-overview.html">PIXAR lamp</a>
                        </li>
                        <li>
                            <a href="product-overview.html">Ambient Nightlamp</a>
                        </li>
                    </ul>
                </div>

                <div class="mx-5">
                    <p class="font-medium text-gray-500">BEDSIDE TABLES</p>
                    <ul class="text-sm leading-8">
                        <li>
                            <a href="product-overview.html">Purple Table</a>
                        </li>
                        <li>
                            <a href="product-overview.html">Easy Bedside</a>
                        </li>
                        <li>
                            <a href="product-overview.html">Soft Table</a>
                        </li>
                        <li>
                            <a href="product-overview.html">Craft Table</a>
                        </li>
                    </ul>
                </div>

                <div class="mx-5">
                    <p class="font-medium text-gray-500">SPECIAL</p>
                    <ul class="text-sm leading-8">
                        <li>
                            <a href="product-overview.html">Humidifier</a>
                        </li>
                        <li>
                            <a href="product-overview.html">Bed Cleaner</a>
                        </li>
                        <li>
                            <a href="product-overview.html">Vacuum Cleaner</a>
                        </li>
                        <li><a href="product-overview.html">Pillow</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
