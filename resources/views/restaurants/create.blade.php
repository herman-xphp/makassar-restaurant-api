<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Restoran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('restaurants.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="name" :value="__('Nama Restoran')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="cuisine_type" :value="__('Jenis Masakan')" />
                                <x-text-input id="cuisine_type" name="cuisine_type" type="text" class="mt-1 block w-full" :value="old('cuisine_type')" placeholder="Contoh: Makassar, Seafood, dll" />
                                <x-input-error :messages="$errors->get('cuisine_type')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="description" :value="__('Deskripsi')" />
                                <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="address" :value="__('Alamat')" />
                                <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address')" required />
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="latitude" :value="__('Latitude')" />
                                <x-text-input id="latitude" name="latitude" type="number" step="any" class="mt-1 block w-full" :value="old('latitude')" required placeholder="-5.135399" />
                                <x-input-error :messages="$errors->get('latitude')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="longitude" :value="__('Longitude')" />
                                <x-text-input id="longitude" name="longitude" type="number" step="any" class="mt-1 block w-full" :value="old('longitude')" required placeholder="119.423790" />
                                <x-input-error :messages="$errors->get('longitude')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="phone" :value="__('Nomor Telepon')" />
                                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone')" placeholder="08123456789" />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="rating" :value="__('Rating (0-5)')" />
                                <x-text-input id="rating" name="rating" type="number" step="0.1" min="0" max="5" class="mt-1 block w-full" :value="old('rating', 0)" />
                                <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="review_count" :value="__('Jumlah Review')" />
                                <x-text-input id="review_count" name="review_count" type="number" min="0" class="mt-1 block w-full" :value="old('review_count', 0)" />
                                <x-input-error :messages="$errors->get('review_count')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="image" :value="__('Gambar')" />
                                <input id="image" name="image" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 gap-4">
                            <a href="{{ route('restaurants.index') }}" class="text-gray-600 hover:text-gray-900">Batal</a>
                            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
