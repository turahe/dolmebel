<!-- Desktop Footer  -->

<footer class="mx-auto flex w-full max-w-[1200px] flex-col justify-between pb-10 lg:flex-row">
    <div class="ml-5">
        <x-application-logo class="mb-5 mt-10" />

        <p class="pl-0">
            Lorem ipsum dolor sit amet consectetur
            <br />
            adipisicing elit.
        </p>
        <div class="mt-10 flex gap-3">
            <a href="https://github.com/bbulakh">
                <img
                    class="h-5 w-5 cursor-pointer"
                    src="/assets/images/github.svg"
                    alt="github icon"
                />
            </a>
            <a href="https://t.me/b_bulakh">
                <img
                    class="h-5 w-5 cursor-pointer"
                    src="/assets/images/telegram.svg"
                    alt="telegram icon"
                />
            </a>
            <a href="https://www.linkedin.com/in/bogdan-bulakh-393284190/">
                <img
                    class="h-5 w-5 cursor-pointer"
                    src="/assets/images/linkedin.svg"
                    alt="twitter icon"
                />
            </a>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6 md:grid-cols-4">
        <div class="mx-5 mt-10">
            <p class="font-medium text-gray-500">FEATURES</p>
            <ul class="text-sm leading-8">
                <li><a href="#">Marketing</a></li>
                <li><a href="#">Commerce</a></li>
                <li><a href="#">Analytics</a></li>
                <li><a href="#">Merchendise</a></li>
            </ul>
        </div>

        <div class="mx-5 mt-10">
            <p class="font-medium text-gray-500">SUPPORT</p>
            <ul class="text-sm leading-8">
                <li><a href="#">Pricing</a></li>
                <li><a href="#">Docs</a></li>
                <li><a href="#">Audition</a></li>
                <li><a href="#">Art Status</a></li>
            </ul>
        </div>

        <div class="mx-5 mt-10">
            <p class="font-medium text-gray-500">DOCUMENTS</p>
            <ul class="text-sm leading-8">
                <li><a href="{{ url('contact-us') }}">{{ __('Contact Us') }}</a></li>
                <li><a href="{{ url('about-us') }}">{{ __('About Us') }}</a></li>
                <li><a href="{{ url('/') }}">{{ __('Terms') }}</a></li>
                <li><a href="{{ url('/') }}">{{ __('Conditions') }}</a></li>
                <li><a href="{{ url('/') }}">{{ __('Privacy') }}</a></li>
            </ul>
        </div>

        <div class="mx-5 mt-10">
            <p class="font-medium text-gray-500">DELIVERY</p>
            <ul class="text-sm leading-8">
                <li><a href="#">List of countries</a></li>
                <li><a href="#">Special information</a></li>
                <li><a href="#">Restrictions</a></li>
                <li><a href="#">Payment</a></li>
            </ul>
        </div>
    </div>
</footer>
<!-- /Desktop Footer  -->

<!-- Payment and copyright  -->

<section class="h-11 bg-amber-400">
    <div class="mx-auto flex max-w-[1200px] items-center justify-between px-4 pt-2">
        <p>&copy; {{ config('app.name') }}, {{ date('Y') }}</p>
        <div class="flex items-center space-x-3">
            <img
                class="h-8"
                src="https://cdn-icons-png.flaticon.com/512/5968/5968299.png"
                alt="Visa icon"
            />
            <img
                class="h-8"
                src="https://cdn-icons-png.flaticon.com/512/349/349228.png"
                alt="AE icon"
            />
            <img
                class="h-8"
                src="https://cdn-icons-png.flaticon.com/512/5968/5968144.png"
                alt="Apple pay icon"
            />
        </div>
    </div>
</section>
<!-- /Payment and copyright  -->
