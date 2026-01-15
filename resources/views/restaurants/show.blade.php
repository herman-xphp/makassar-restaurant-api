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
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-100">
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="md:col-span-1">
                            <img src="{{ $restaurant->image_url }}" alt="{{ $restaurant->name }}" class="w-full h-64 object-cover rounded-lg shadow-sm border border-slate-100">
                        </div>

                        <div class="md:col-span-2 space-y-6">
                            <div>
                                <h3 class="text-3xl font-bold text-slate-800">{{ $restaurant->name }}</h3>
                                @if ($restaurant->cuisine_type)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-100 text-emerald-800 mt-2 border border-emerald-200">
                                        {{ $restaurant->cuisine_type }}
                                    </span>
                                @endif
                            </div>

                            <div class="flex items-center gap-2 text-slate-600">
                                <svg class="w-5 h-5 text-yellow-500 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="font-bold text-slate-800">{{ number_format($restaurant->rating, 1) }}</span>
                                <span class="text-slate-400">({{ $restaurant->review_count }} ulasan)</span>
                            </div>

                            @if ($restaurant->description)
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-1">Deskripsi</h4>
                                    <p class="text-slate-600 leading-relaxed">{{ $restaurant->description }}</p>
                                </div>
                            @endif

                            <div>
                                <h4 class="font-semibold text-slate-700 mb-1">Alamat</h4>
                                <p class="text-slate-600">{{ $restaurant->address }}</p>
                            </div>

                            @if ($restaurant->phone)
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-1">Telepon</h4>
                                    <p class="text-slate-600">{{ $restaurant->phone }}</p>
                                </div>
                            @endif

                            <div>
                                <h4 class="font-semibold text-slate-700 mb-1">Koordinat</h4>
                                <p class="text-slate-600 font-mono text-sm mb-1">{{ $restaurant->latitude }}, {{ $restaurant->longitude }}</p>
                                <a href="https://www.google.com/maps?q={{ $restaurant->latitude }},{{ $restaurant->longitude }}" target="_blank" class="inline-flex items-center text-emerald-600 hover:text-emerald-800 text-sm font-medium transition">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Lihat di Google Maps
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <p class="text-xs text-slate-400">
                            DATA RECORD • Dibuat: {{ $restaurant->created_at->format('d M Y H:i') }} • Diperbarui: {{ $restaurant->updated_at->format('d M Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
