<x-app-layout>
    <x-slot name="header">
        <head>
            <!-- Dynamic SEO Meta Tags for Restaurant -->
            <title>{{ $restaurant->name }} - Kuliner Makassar</title>
            <meta name="description" content="Kunjungi {{ $restaurant->name }} di {{ $restaurant->address }}. {{ Str::limit($restaurant->description, 100) }} Rating: {{ $restaurant->rating }}/5.">
            <meta name="keywords" content="{{ $restaurant->name }}, {{ $restaurant->cuisine_type }}, kuliner makassar, makan di makassar">

            <!-- Open Graph -->
            <meta property="og:type" content="restaurant.restaurant">
            <meta property="og:url" content="{{ route('public.restaurant.show', $restaurant->slug) }}">
            <meta property="og:title" content="{{ $restaurant->name }} - Kuliner Makassar">
            <meta property="og:description" content="Nikmati {{ $restaurant->cuisine_type }} terbaik di {{ $restaurant->name }}. Lokasi: {{ $restaurant->address }}.">
            <meta property="og:image" content="{{ $restaurant->image_url ? asset($restaurant->image_url) : asset('images/og-image.jpg') }}">
            
            <!-- Schema.org Structured Data -->
            <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "Restaurant",
                "name": "{{ $restaurant->name }}",
                "image": "{{ $restaurant->image_url ? asset($restaurant->image_url) : '' }}",
                "servesCuisine": "{{ $restaurant->cuisine_type }}",
                "address": {
                    "@type": "PostalAddress",
                    "streetAddress": "{{ $restaurant->address }}",
                    "addressLocality": "Makassar",
                    "addressRegion": "South Sulawesi",
                    "addressCountry": "ID"
                },
                "geo": {
                    "@type": "GeoCoordinates",
                    "latitude": {{ $restaurant->latitude }},
                    "longitude": {{ $restaurant->longitude }}
                },
                "aggregateRating": {
                    "@type": "AggregateRating",
                    "ratingValue": "{{ $restaurant->rating }}",
                    "reviewCount": "{{ $restaurant->review_count }}"
                },
                "telephone": "{{ $restaurant->phone }}"
            }
            </script>
        </head>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            @if($restaurant->image_url)
                                <img src="{{ $restaurant->image_url }}" alt="{{ $restaurant->name }}" class="w-full h-96 object-cover rounded-lg shadow-md">
                            @else
                                <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-400">No Image Available</span>
                                </div>
                            @endif
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $restaurant->name }}</h1>
                            <div class="flex items-center mb-4">
                                <span class="bg-emerald-100 text-emerald-800 text-sm font-semibold px-2.5 py-0.5 rounded mr-2">{{ $restaurant->cuisine_type }}</span>
                                <span class="flex items-center text-yellow-500 font-bold">
                                    <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    {{ $restaurant->rating }} ({{ $restaurant->review_count }} reviews)
                                </span>
                            </div>
                            
                            <p class="text-gray-700 mb-6">{{ $restaurant->description }}</p>

                            <div class="space-y-3 text-gray-600">
                                <div class="flex items-start">
                                    <svg class="w-6 h-6 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span>{{ $restaurant->address }}</span>
                                </div>
                                @if($restaurant->phone)
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    <span>{{ $restaurant->phone }}</span>
                                </div>
                                @endif
                            </div>

                            <div class="mt-8">
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $restaurant->latitude }},{{ $restaurant->longitude }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Lihat di Google Maps
                                </a>
                                <a href="{{ route('home') }}" class="ml-4 inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
                                    Kembali ke Beranda
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
