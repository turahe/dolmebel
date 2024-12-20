<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        {!! app('seotools')->generate() !!}

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.ts'])
    </head>

    <body x-data="{ desktopMenuOpen: false, mobileMenuOpen: false }">
        <x-header />

        <!-- Burger menu  -->
        <x-menu />
        <!-- /Burger menu  -->

        <!-- Nav bar -->
        <!-- hidden on small devices -->

        <x-navbar />
        <!-- /Nav bar -->

        {{ $slot }}
        <x-footer />
    </body>
</html>
