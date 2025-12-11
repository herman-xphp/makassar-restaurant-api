<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Restoran') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('restaurants.edit', $restaurant) }}" class="bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <a href="{{ route('restaurants.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-1">
                            @if ($restaurant->image_url)
                                <img src="{{ $restaurant->image_url }}" alt="{{ $restaurant->name }}" class="w-full h-64 object-cover rounded-lg">
                            @else
                                <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-400">Tidak ada gambar</span>
                                </div>
                            @endif
                        </div>

                        <div class="md:col-span-2 space-y-4">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">{{ $restaurant->name }}</h3>
                                @if ($restaurant->cuisine_type)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 mt-2">
                                        {{ $restaurant->cuisine_type }}
                                    </span>
                                @endif
                            </div>

                            <div class="flex items-center gap-2 text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                </svg>
                                <span class="font-semibold">{{ number_format($restaurant->rating, 1) }}</span>
                                <span class="text-gray-400">({{ $restaurant->review_count }} reviews)</span>
                            </div>

                            @if ($restaurant->description)
                                <div>
                                    <h4 class="font-semibold text-gray-700">Deskripsi</h4>
                                    <p class="text-gray-600 mt-1">{{ $restaurant->description }}</p>
                                </div>
                            @endif

                            <div>
                                <h4 class="font-semibold text-gray-700">Alamat</h4>
                                <p class="text-gray-600 mt-1">{{ $restaurant->address }}</p>
                            </div>

                            @if ($restaurant->phone)
                                <div>
                                    <h4 class="font-semibold text-gray-700">Telepon</h4>
                                    <p class="text-gray-600 mt-1">{{ $restaurant->phone }}</p>
                                </div>
                            @endif

                            <div>
                                <h4 class="font-semibold text-gray-700">Koordinat</h4>
                                <p class="text-gray-600 mt-1">{{ $restaurant->latitude }}, {{ $restaurant->longitude }}</p>
                                <a href="https://www.google.com/maps?q={{ $restaurant->latitude }},{{ $restaurant->longitude }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm">
                                    Lihat di Google Maps
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <p class="text-sm text-gray-500">
                            Dibuat: {{ $restaurant->created_at->format('d M Y H:i') }} | 
                            Diperbarui: {{ $restaurant->updated_at->format('d M Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
