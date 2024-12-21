<section class="hidden w-[300px] flex-shrink-0 px-4 lg:block">
    <div class="flex border-b pb-5">
        <div
            class="w-full"
            x-data="theCategories('/api/categories?relation=products&parent_id=notNull')"
            x-init="fetchCategories()"
        >
            <p class="mb-3 font-medium uppercase">{{ __('Categories') }}</p>
            <template x-if="loading">
                <div>Loading...</div>
            </template>
            <template x-if="categories.length > 0">
                <template x-for="item in categories">
                    <div class="flex w-full justify-between">
                        <div class="flex items-center justify-center">
                            <input type="checkbox" />
                            <p class="ml-4" x-text="item.name"></p>
                        </div>
                        <div>
                            <p class="text-gray-500" x-text="'(' + item.count + ')'"></p>
                        </div>
                    </div>
                </template>
            </template>
        </div>
    </div>

    <div class="flex border-b py-5">
        <div class="w-full">
            <p class="mb-3 font-medium uppercase">{{ __('Brands') }}</p>

            <div class="flex w-full justify-between">
                <div class="flex items-center justify-center">
                    <input type="checkbox" />
                    <p class="ml-4">APEX</p>
                </div>
                <div>
                    <p class="text-gray-500">(12)</p>
                </div>
            </div>

            <div class="flex w-full justify-between">
                <div class="flex items-center justify-center">
                    <input type="checkbox" />
                    <p class="ml-4">Call of SOFA</p>
                </div>
                <div>
                    <p class="text-gray-500">(15)</p>
                </div>
            </div>

            <div class="flex w-full justify-between">
                <div class="flex items-center justify-center">
                    <input type="checkbox" />
                    <p class="ml-4">Puff B&G</p>
                </div>
                <div>
                    <p class="text-gray-500">(14)</p>
                </div>
            </div>

            <div class="flex w-full justify-between">
                <div class="flex items-center justify-center">
                    <input type="checkbox" />
                    <p class="ml-4">Fornighte</p>
                </div>
                <div>
                    <p class="text-gray-500">(124)</p>
                </div>
            </div>
        </div>
    </div>

    <div class="flex border-b py-5">
        <div class="w-full">
            <p class="mb-3 font-medium">PRICE</p>

            <div class="flex w-full">
                <div class="flex justify-between">
                    <input x-mask="99999" min="50" type="number" class="h-8 w-[90px] border pl-2" placeholder="50" />
                    <span class="px-3">-</span>
                    <input
                        x-mask="999999"
                        type="number"
                        max="999999"
                        class="h-8 w-[90px] border pl-2"
                        placeholder="99999"
                    />
                </div>
            </div>
        </div>
    </div>

    <div class="flex border-b py-5">
        <div class="w-full" x-data="{ sizes: ['XS', 'S', 'M', 'L', 'XL'] }">
            <p class="mb-3 font-medium uppercase">SIZE</p>

            <div class="flex gap-2">
                <template x-for="size in sizes">
                    <div
                        class="flex h-8 w-8 cursor-pointer items-center justify-center border duration-100 hover:bg-neutral-100 focus:ring-2 focus:ring-gray-500 active:ring-2 active:ring-gray-500"
                    >
                        <span x-text="size"></span>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <div class="flex py-5">
        <div class="w-full">
            <p class="mb-3 font-medium">COLOR</p>

            <div class="flex gap-2">
                <div
                    class="h-8 w-8 cursor-pointer border border-white bg-gray-600 focus:ring-2 focus:ring-gray-500 active:ring-2 active:ring-gray-500"
                ></div>
                <div
                    class="h-8 w-8 cursor-pointer border border-white bg-violet-900 focus:ring-2 focus:ring-gray-500 active:ring-2 active:ring-gray-500"
                ></div>
                <div
                    class="h-8 w-8 cursor-pointer border border-white bg-red-900 focus:ring-2 focus:ring-gray-500 active:ring-2 active:ring-gray-500"
                ></div>
            </div>
        </div>
    </div>
</section>
