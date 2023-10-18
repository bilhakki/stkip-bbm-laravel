<!DOCTYPE html>
<html
    class="{{ isset($_COOKIE['color-theme']) && $_COOKIE['color-theme'] == 'dark' ? 'dark' : 'light' }}"
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
>

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >
    <meta
        name="description"
        content="Deskripsi halaman Anda di sini"
    >
    <meta
        name="keywords"
        content="kata kunci, yang, relevan, dengan, halaman, Anda"
    >
    <meta
        property="og:title"
        content="{{ config('app.name', 'Laravel') }}"
    >
    <meta
        property="og:description"
        content="Deskripsi halaman Anda di sini"
    >

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link
        rel="icon"
        type="image/png"
        sizes="16x16"
        href="{{ asset('logo/favicon/favicon-16x16.png') }}"
    >
    <link
        rel="icon"
        type="image/png"
        sizes="32x32"
        href="{{ asset('logo/favicon/favicon-32x32.png') }}"
    >
    <link
        rel="icon"
        type="image/png"
        sizes="192x192"
        href="{{ asset('logo/favicon/android-chrome-192x192.png') }}"
    >
    <link
        rel="icon"
        type="image/png"
        sizes="512x512"
        href="{{ asset('logo/favicon/android-chrome-512x512.png') }}"
    >
    <link
        rel="apple-touch-icon"
        sizes="180x180"
        href="{{ asset('logo/favicon/apple-touch-icon.png') }}"
    >

    <!-- For IE -->
    <link
        rel="shortcut icon"
        href="{{ asset('logo/favicon/favicon.ico') }}"
    >

    <!-- Web App Manifest -->
    <link
        rel="manifest"
        href="{{ asset('logo/favicon/site.webmanifest') }}"
    >

    <link
        href="https://unpkg.com/slim-select@latest/dist/slimselect.css"
        rel="stylesheet"
    />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css"
    />

    <!-- Scripts -->
    @vite(['resources/scss/style.scss', 'resources/js/script.js'])

    @vite(['resources/js/alpine/layout/app.js'])

    @stack('head')

    <!-- Styles -->
    @livewireStyles


</head>

<body
    class="{{ isset($_COOKIE['color-theme']) && $_COOKIE['color-theme'] == 'dark' ? 'dark' : 'light' }} font-sans antialiased"
    x-data="layoutApp"
    x-init="layoutAppInit"
>
    <x-banner />

    <div
        class="fixed inset-0 z-10 bg-black/70 backdrop-blur-sm"
        x-show="showBackdrop"
        x-transition.opacity.duration.300ms
        @click="closeBackdrop"
        x-cloak
    >

    </div>

    @include('layouts._app.navigation')

    @if (auth()->user()->role === UserRole::ADMIN)
        @include('layouts._app.sidebar-admin')
    @elseif(auth()->user()->role === UserRole::ACADEMIC_UNIVERSITY)
        @include('layouts._app.sidebar-admin')
    @elseif(auth()->user()->role === UserRole::ACADEMIC_FACULTY)
        @include('layouts._app.sidebar-admin')
    @elseif(auth()->user()->role === UserRole::ACADEMIC_MAJOR)
        @include('layouts._app.sidebar-admin')
    @elseif(auth()->user()->role === UserRole::LECTURER)
        @include('layouts._app.sidebar-lecturer')
    @else
        @include('layouts._app.sidebar-student')
    @endif

    <main class="mt-16 p-4 md:ml-64">
        {{ $slot }}
    </main>

    @stack('modals')

    @livewireScripts
</body>

</html>
