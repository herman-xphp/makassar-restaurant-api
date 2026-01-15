<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- SEO Meta Tags -->
    <title>{{ $metaTitle ?? 'Makassar Restaurant - Apps' }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'Aplikasi pencarian restoran terbaik di Makassar.' }}">
    <meta name="keywords" content="kuliner makassar, restoran makassar, coto makassar, konro, pallubasa, tempat makan enak makassar">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $metaTitle ?? 'Makassar Restaurant' }}">
    <meta property="og:description" content="{{ $metaDescription ?? 'Temukan kuliner terbaik di Makassar.' }}">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $metaTitle ?? 'Makassar Restaurant' }}">
    <meta property="twitter:description" content="{{ $metaDescription ?? 'Temukan kuliner terbaik di Makassar.' }}">
    <meta property="twitter:image" content="{{ asset('images/og-image.jpg') }}">

    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-gray-50 font-sans text-gray-900 scroll-smooth">
    <!-- Navigation -->
    <nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <a href="#" class="flex items-center group">
                        <x-application-logo class="h-10 w-10 text-emerald-500 group-hover:scale-110 transition-transform" />
                        <span class="ml-3 text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-emerald-600 to-teal-500">Makassar Restaurant</span>
                    </a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="text-sm font-medium text-gray-600 hover:text-emerald-500 transition">Beranda</a>
                    <a href="#features" class="text-sm font-medium text-gray-600 hover:text-emerald-500 transition">Fitur</a>
                    <a href="#popular" class="text-sm font-medium text-gray-600 hover:text-emerald-500 transition">Populer</a>
                    <a href="#download" class="text-sm font-medium text-gray-600 hover:text-emerald-500 transition">Download</a>
                    
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="px-5 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 rounded-full shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                            Dashboard
                        </a>
                    @else
                        <a href="https://www.mediafire.com/file/j5d7v1q36mr7813/Makassar_Restaurant.apk"
                            class="px-5 py-2.5 text-sm font-bold text-emerald-600 bg-emerald-50 border-2 border-emerald-100 hover:bg-emerald-100 rounded-full transition-colors">
                            Masuk
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div id="home" class="relative bg-gray-900 overflow-hidden pt-20">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2070&auto=format&fit=crop" 
                 alt="Background" 
                 class="w-full h-full object-cover opacity-40">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-900/90 to-teal-900/80"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Column - Tagline & CTA -->
                <div class="text-center lg:text-left">
                    <h1 class="text-4xl md:text-5xl lg:text-5xl font-bold text-white mb-6 leading-tight">
                        Temukan Restoran Terbaik di Makassar
                    </h1>
                    <p class="text-lg text-emerald-100 mb-8">
                        Jelajahi kuliner khas Makassar dari Coto, Pallubasa, hingga Konro. Temukan restoran favoritmu
                        dengan mudah.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="https://www.mediafire.com/file/j5d7v1q36mr7813/Makassar_Restaurant.apk"
                            class="inline-flex items-center justify-center px-8 py-3 bg-white text-emerald-600 font-semibold rounded-lg hover:bg-gray-100 transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Download Sekarang
                        </a>
                        <a href="#features"
                            class="inline-flex items-center justify-center px-8 py-3 border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-emerald-600 transition">
                            Pelajari Lebih
                        </a>
                    </div>
                </div>

                <!-- Right Column - Phone Mockup -->
                <div class="flex justify-center lg:justify-end">
                    <div class="relative">
                        <!-- Phone Frame -->
                        <div class="relative w-64 h-[500px] bg-gray-900 rounded-[3rem] p-2 shadow-2xl">
                            <!-- Phone Inner Frame -->
                            <div class="w-full h-full bg-gray-800 rounded-[2.5rem] p-1">
                                <!-- Phone Screen -->
                                <div class="w-full h-full bg-white rounded-[2.3rem] overflow-hidden relative">
                                    <!-- Status Bar -->
                                    <div class="bg-emerald-500 px-6 py-2 flex justify-between items-center">
                                        <span class="text-white text-xs font-medium">9:41</span>
                                        <div class="flex space-x-1">
                                            <div class="w-4 h-2 bg-white rounded-sm opacity-80"></div>
                                            <div class="w-4 h-2 bg-white rounded-sm opacity-80"></div>
                                            <div class="w-6 h-3 bg-white rounded-sm"></div>
                                        </div>
                                    </div>

                                    <!-- App Header -->
                                    <div class="bg-emerald-500 px-4 pb-4">
                                        <h3 class="text-white font-bold text-lg">Makassar Restaurant</h3>
                                        <div class="mt-2 bg-white/20 rounded-lg px-3 py-2 flex items-center">
                                            <svg class="w-4 h-4 text-white/70 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                            <span class="text-white/70 text-sm">Cari restoran...</span>
                                        </div>
                                    </div>

                                    <!-- App Content -->
                                    <div class="p-4 space-y-3">
                                        <p class="text-xs text-gray-500 font-medium">RESTORAN TERDEKAT</p>

                                        <!-- Restaurant Card 1 -->
                                        <div class="bg-gray-50 rounded-xl p-3 flex items-center space-x-3">
                                            <div
                                                class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-semibold text-gray-800 text-sm">Coto Makassar Daeng</p>
                                                <p class="text-xs text-gray-500">0.5 km</p>
                                            </div>
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                                <span class="text-xs text-gray-600 ml-1">4.8</span>
                                            </div>
                                        </div>

                                        <!-- Restaurant Card 2 -->
                                        <div class="bg-gray-50 rounded-xl p-3 flex items-center space-x-3">
                                            <div
                                                class="w-12 h-12 bg-gradient-to-br from-green-400 to-teal-500 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-semibold text-gray-800 text-sm">Pallubasa Serigala</p>
                                                <p class="text-xs text-gray-500">1.2 km</p>
                                            </div>
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                                <span class="text-xs text-gray-600 ml-1">4.6</span>
                                            </div>
                                        </div>

                                        <!-- Restaurant Card 3 -->
                                        <div class="bg-gray-50 rounded-xl p-3 flex items-center space-x-3">
                                            <div
                                                class="w-12 h-12 bg-gradient-to-br from-purple-400 to-pink-500 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-semibold text-gray-800 text-sm">Konro Karebosi</p>
                                                <p class="text-xs text-gray-500">2.0 km</p>
                                            </div>
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                                <span class="text-xs text-gray-600 ml-1">4.9</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bottom Navigation -->
                                    <div
                                        class="absolute bottom-0 left-0 right-0 bg-white border-t border-gray-100 px-6 py-3 flex justify-around">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-5 h-5 text-emerald-500" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                                </path>
                                            </svg>
                                            <span class="text-xs text-emerald-500 mt-1">Home</span>
                                        </div>
                                        <div class="flex flex-col items-center">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                            <span class="text-xs text-gray-400 mt-1">Cari</span>
                                        </div>
                                        <div class="flex flex-col items-center">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                                </path>
                                            </svg>
                                            <span class="text-xs text-gray-400 mt-1">Favorit</span>
                                        </div>
                                        <div class="flex flex-col items-center">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                </path>
                                            </svg>
                                            <span class="text-xs text-gray-400 mt-1">Profil</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Phone Notch -->
                            <div
                                class="absolute top-0 left-1/2 transform -translate-x-1/2 w-32 h-6 bg-gray-900 rounded-b-2xl">
                            </div>
                        </div>

                        <!-- Decorative Elements -->
                        <div class="absolute -top-4 -right-4 w-20 h-20 bg-yellow-400 rounded-full opacity-20 blur-xl">
                        </div>
                        <div
                            class="absolute -bottom-4 -left-4 w-32 h-32 bg-emerald-300 rounded-full opacity-20 blur-xl">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z"
                    fill="#F9FAFB" />
            </svg>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                <div class="text-4xl font-bold text-emerald-500">{{ $totalRestaurants }}</div>
                <div class="text-gray-600 mt-2">Restoran Terdaftar</div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                <div class="text-4xl font-bold text-emerald-500">
                    {{ $cuisineTypes }}</div>
                <div class="text-gray-600 mt-2">Jenis Masakan</div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                <div class="text-4xl font-bold text-emerald-500">
                    {{ number_format($avgRating, 1) }}</div>
                <div class="text-gray-600 mt-2">Rating Rata-rata</div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Fitur Unggulan</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Platform manajemen restoran yang lengkap untuk kebutuhan
                    bisnis kuliner Anda</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl p-8 shadow-sm hover:shadow-lg transition">
                    <div class="w-14 h-14 bg-emerald-100 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Pencarian Lokasi</h3>
                    <p class="text-gray-600">Temukan restoran terdekat dengan fitur pencarian berbasis lokasi GPS yang
                        akurat.</p>
                </div>
                <div class="bg-white rounded-xl p-8 shadow-sm hover:shadow-lg transition">
                    <div class="w-14 h-14 bg-emerald-100 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Rating & Review</h3>
                    <p class="text-gray-600">Lihat rating dan review dari pengunjung untuk memilih restoran terbaik.</p>
                </div>
                <div class="bg-white rounded-xl p-8 shadow-sm hover:shadow-lg transition">
                    <div class="w-14 h-14 bg-emerald-100 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Kelola Mudah</h3>
                    <p class="text-gray-600">Dashboard admin yang intuitif untuk mengelola data restoran dengan mudah.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Restaurant Preview -->
    <div id="popular" class="bg-white py-20 relative">
        <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Restoran Populer</h2>
                <p class="text-gray-600">Beberapa restoran terbaik yang bisa Anda temukan</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($popularRestaurants as $restaurant)
                    <div class="bg-gray-50 rounded-xl overflow-hidden hover:shadow-lg transition">
                        @if($restaurant->image_url)
                            <img src="{{ $restaurant->image_url }}" alt="{{ $restaurant->name }}"
                                class="w-full h-48 object-cover">
                        @else
                            <div
                                class="w-full h-48 bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center">
                                <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                            </div>
                        @endif
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-semibold text-gray-900">{{ $restaurant->name }}</h3>
                                <span class="flex items-center text-sm text-emerald-500">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                    {{ number_format($restaurant->rating, 1) }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-500 mb-3">{{ $restaurant->cuisine_type ?? 'Kuliner Makassar' }}</p>
                            <p class="text-sm text-gray-600 line-clamp-2">{{ Str::limit($restaurant->address, 50) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div id="download" class="bg-gradient-to-br from-emerald-600 to-teal-700 py-24 relative overflow-hidden">
        <!-- Abstract Shapes -->
        <div class="absolute top-0 left-0 w-64 h-64 bg-white opacity-5 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-emerald-400 opacity-10 rounded-full translate-x-1/3 translate-y-1/3"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">Jelajahi Kuliner Makassar</h2>
            <p class="text-emerald-100 mb-8 max-w-xl mx-auto">Download aplikasi sekarang dan temukan restoran terbaik di
                sekitarmu. Gratis!</p>
            <a href="https://www.mediafire.com/file/j5d7v1q36mr7813/Makassar_Restaurant.apk"
                class="inline-flex items-center px-8 py-3 bg-white text-emerald-600 font-semibold rounded-lg hover:bg-gray-100 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Download Sekarang
            </a>
        </div>
    </div>

    <!-- Professional Footer -->
    <footer class="bg-gray-900 text-gray-300 pt-20 pb-10 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                <!-- Brand Column -->
                <div class="col-span-1 lg:col-span-1">
                    <div class="flex items-center mb-6">
                        <x-application-logo class="h-10 w-10 text-emerald-500" />
                        <span class="ml-3 text-2xl font-bold text-white">Makassar<br>Restaurant</span>
                    </div>
                    <p class="text-sm leading-relaxed text-gray-400 mb-6">
                        Platform referensi kuliner nomor satu di Makassar. Kami menghubungkan Anda dengan cita rasa otentik yang tak terlupakan.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition"><span class="sr-only">Facebook</span><svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"/></svg></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><span class="sr-only">Instagram</span><svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772 4.902 4.902 0 011.772-1.153c.636-.247 1.363-.416 2.427-.465C9.673 2.013 10.03 2 12.48 2h-.165zm-3.77 1.795c-.95.043-1.458.204-1.8.336-.452.175-.776.383-1.115.722-.338.339-.546.663-.722 1.115-.132.342-.293.85-.336 1.8-.043.95-.045 1.232-.045 3.79s.002 2.84.045 3.79c.043.95.204 1.458.336 1.8.175.453.383.776.722 1.115.339.338.663.546 1.115.722.342.132.85.293 1.8.336.95.043 1.232.045 3.79.045s2.84-.002 3.79-.045c.95-.043 1.458-.204 1.8-.336.452-.175.776-.383 1.115-.722.339-.338.546-.663.722-1.115.132-.342.293-.85.336-1.8.043-.95.045-1.232.045-3.79s-.002-2.84-.045-3.79c-.043-.95-.204-1.458-.336-1.8-.175-.453-.383-.776-1.115-.722-.342-.132-.85-.293-1.8-.336-.95-.043-1.232-.045-3.79-.045s-2.84.002-3.79.045zM12.315 6.845a5.155 5.155 0 110 10.31 5.155 5.155 0 010-10.31zm0 1.884a3.271 3.271 0 100 6.542 3.271 3.271 0 000-6.542zm5.722-3.858a1.258 1.258 0 110 2.516 1.258 1.258 0 010-2.516z" clip-rule="evenodd" /></svg></a>
                    </div>
                </div>

                <!-- Product -->
                <div>
                    <h3 class="text-sm font-semibold text-white tracking-wider uppercase mb-4">Produk</h3>
                    <ul class="space-y-3">
                        <li><a href="#features" class="text-gray-400 hover:text-emerald-500 transition">Fitur Utama</a></li>
                        <li><a href="#popular" class="text-gray-400 hover:text-emerald-500 transition">Restoran Populer</a></li>
                        <li><a href="#download" class="text-gray-400 hover:text-emerald-500 transition">Download App</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-emerald-500 transition">Roadmap</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h3 class="text-sm font-semibold text-white tracking-wider uppercase mb-4">Dukungan</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-emerald-500 transition">Pusat Bantuan</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-emerald-500 transition">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-emerald-500 transition">Kebijakan Privasi</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-emerald-500 transition">FAQ</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="text-sm font-semibold text-white tracking-wider uppercase mb-4">Newsletter</h3>
                    <p class="text-xs text-gray-400 mb-4">Dapatkan info kuliner terbaru setiap minggu.</p>
                    <form class="flex flex-col space-y-2">
                        <input type="email" placeholder="Email Anda" class="bg-gray-800 border-gray-700 text-white text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5">
                        <button type="button" class="text-white bg-emerald-600 hover:bg-emerald-700 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center transition">Langganan</button>
                    </form>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm text-gray-500">&copy; {{ date('Y') }} Makassar Restaurant. Dibuat dengan ❤ untuk Pecinta Kuliner.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="text-sm text-gray-500 hover:text-white transition">Privacy</a>
                    <a href="#" class="text-sm text-gray-500 hover:text-white transition">Terms</a>
                    <a href="#" class="text-sm text-gray-500 hover:text-white transition">Cookies</a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>