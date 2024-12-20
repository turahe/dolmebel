<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        {!! app('seotools')->generate() !!}

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.ts'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div
            class="flex min-h-screen flex-col items-center bg-gray-100 pt-6 dark:bg-gray-900 sm:justify-center sm:pt-0"
        >
            <div>
                <a href="/">
                    <x-application-logo class="-mb-20 h-96 w-96 fill-current text-gray-500" />
                </a>
            </div>

            <div
                class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md dark:bg-gray-800 sm:max-w-md sm:rounded-lg"
            >
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
