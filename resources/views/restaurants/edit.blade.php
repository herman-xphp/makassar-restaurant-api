<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Restoran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-100">
                <div class="p-8">
                    <form method="POST" action="{{ route('restaurants.update', $restaurant) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <x-input-label for="name" :value="__('Nama Restoran')" class="text-slate-700 font-medium" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm" :value="old('name', $restaurant->name)" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="cuisine_type" :value="__('Jenis Masakan')" class="text-slate-700 font-medium" />
                                <x-text-input id="cuisine_type" name="cuisine_type" type="text" class="mt-1 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm" :value="old('cuisine_type', $restaurant->cuisine_type)" placeholder="Contoh: Makassar, Seafood, dll" />
                                <x-input-error :messages="$errors->get('cuisine_type')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="description" :value="__('Deskripsi')" class="text-slate-700 font-medium" />
                                <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('description', $restaurant->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="address" :value="__('Alamat')" class="text-slate-700 font-medium" />
                                <x-text-input id="address" name="address" type="text" class="mt-1 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm" :value="old('address', $restaurant->address)" required />
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="latitude" :value="__('Latitude')" class="text-slate-700 font-medium" />
                                <x-text-input id="latitude" name="latitude" type="number" step="any" class="mt-1 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm" :value="old('latitude', $restaurant->latitude)" required />
                                <x-input-error :messages="$errors->get('latitude')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="longitude" :value="__('Longitude')" class="text-slate-700 font-medium" />
                                <x-text-input id="longitude" name="longitude" type="number" step="any" class="mt-1 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm" :value="old('longitude', $restaurant->longitude)" required />
                                <x-input-error :messages="$errors->get('longitude')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="phone" :value="__('Nomor Telepon')" class="text-slate-700 font-medium" />
                                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm" :value="old('phone', $restaurant->phone)" placeholder="08123456789" />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="rating" :value="__('Rating (0-5)')" class="text-slate-700 font-medium" />
                                <x-text-input id="rating" name="rating" type="number" step="0.1" min="0" max="5" class="mt-1 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm" :value="old('rating', $restaurant->rating)" />
                                <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="review_count" :value="__('Jumlah Review')" class="text-slate-700 font-medium" />
                                <x-text-input id="review_count" name="review_count" type="number" min="0" class="mt-1 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm" :value="old('review_count', $restaurant->review_count)" />
                                <x-input-error :messages="$errors->get('review_count')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="image" :value="__('Gambar')" class="text-slate-700 font-medium" />
                                <div class="mt-2 mb-3">
                                    <img src="{{ $restaurant->image_url }}" alt="{{ $restaurant->name }}" class="h-32 w-32 object-cover rounded-lg shadow-sm border border-slate-100">
                                    <p class="text-xs text-slate-500 mt-1">Gambar saat ini</p>
                                </div>
                                <input id="image" name="image" type="file" accept="image/*" class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition file:cursor-pointer" />
                                <p class="text-xs text-slate-500 mt-1">Biarkan kosong jika tidak ingin mengubah gambar</p>
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 gap-4">
                            <a href="{{ route('restaurants.index') }}" class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 shadow-md transition">
                                {{ __('Perbarui Restoran') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
