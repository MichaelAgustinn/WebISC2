@extends('layouts.app')

@section('title', 'Kelola Landing Page')

@section('content')
    <div x-data="{ activeTab: 'home' }">

        <div class="mb-6 flex space-x-2 overflow-x-auto border-b border-gray-200 pb-2">
            @foreach (['home' => 'Home', 'about' => 'About', 'visimisi' => 'Visi & Misi', 'footer' => 'Footer & Kontak'] as $key => $label)
                <button @click="activeTab = '{{ $key }}'" type="button"
                    :class="activeTab === '{{ $key }}' ? 'border-indigo-500 text-indigo-600' :
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="whitespace-nowrap border-b-2 py-2 px-4 text-sm font-medium transition-colors duration-200">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        <form action="{{ route('landing.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">

                <div x-show="activeTab === 'home'" class="space-y-6">
                    <h3 class="text-lg font-bold text-gray-800 border-b pb-2">Konfigurasi Home</h3>

                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Besar (Hero Title)</label>
                            <input type="text" name="home_title" value="{{ $contents['home_title'] ?? '' }}"
                                class="w-full rounded-lg border-gray-300 border px-3 py-2">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sub Judul</label>
                            <textarea name="home_subtitle" rows="3" class="w-full rounded-lg border-gray-300 border px-3 py-2">{{ $contents['home_subtitle'] ?? '' }}</textarea>
                        </div>

                    </div>
                </div>

                <div x-show="activeTab === 'about'" class="space-y-6" style="display: none;">
                    <h3 class="text-lg font-bold text-gray-800 border-b pb-2">Konfigurasi About Us</h3>

                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Section</label>
                            <input type="text" name="about_title" value="{{ $contents['about_title'] ?? '' }}"
                                class="w-full rounded-lg border-gray-300 border px-3 py-2">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Lengkap</label>
                            <textarea name="about_description" rows="5" class="w-full rounded-lg border-gray-300 border px-3 py-2">{{ $contents['about_description'] ?? '' }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Gambar About</label>
                            <div class="flex items-center gap-4">
                                @if (isset($contents['about_image']) && $contents['about_image'])
                                    <img src="{{ asset('uploads/landing/' . $contents['about_image']) }}"
                                        class="w-20 h-20 object-cover rounded border">
                                @endif
                                <input type="file" name="about_image"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            </div>
                        </div>
                    </div>
                </div>

                <div x-show="activeTab === 'visimisi'" class="space-y-6" style="display: none;">
                    <h3 class="text-lg font-bold text-gray-800 border-b pb-2">Visi & Misi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Visi</label>
                            <textarea name="visi" rows="6" class="w-full rounded-lg border-gray-300 border px-3 py-2">{{ $contents['visi'] ?? '' }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Misi</label>
                            <textarea name="misi" rows="6" class="w-full rounded-lg border-gray-300 border px-3 py-2">{{ $contents['misi'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <div x-show="activeTab === 'footer'" class="space-y-6" style="display: none;">
                    <h3 class="text-lg font-bold text-gray-800 border-b pb-2">Kontak & Sosmed</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                            <input type="text" name="contact_address" value="{{ $contents['contact_address'] ?? '' }}"
                                class="w-full rounded-lg border-gray-300 border px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="text" name="contact_email" value="{{ $contents['contact_email'] ?? '' }}"
                                class="w-full rounded-lg border-gray-300 border px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">No HP</label>
                            <input type="text" name="contact_phone" value="{{ $contents['contact_phone'] ?? '' }}"
                                class="w-full rounded-lg border-gray-300 border px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Instagram</label>
                            <input type="text" name="social_instagram" value="{{ $contents['social_instagram'] ?? '' }}"
                                class="w-full rounded-lg border-gray-300 border px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Youtube</label>
                            <input type="text" name="social_youtube" value="{{ $contents['social_youtube'] ?? '' }}"
                                class="w-full rounded-lg border-gray-300 border px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Facebook</label>
                            <input type="text" name="social_facebook" value="{{ $contents['social_facebook'] ?? '' }}"
                                class="w-full rounded-lg border-gray-300 border px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">TikTok</label>
                            <input type="text" name="social_tiktok" value="{{ $contents['social_tiktok'] ?? '' }}"
                                class="w-full rounded-lg border-gray-300 border px-3 py-2">
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
                    <button type="submit"
                        class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg hover:bg-indigo-700 transition shadow-lg">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
