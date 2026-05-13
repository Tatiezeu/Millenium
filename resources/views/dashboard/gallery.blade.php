@extends('layouts.dashboard')

@section('title', 'Gallery')
@section('page_title', 'Gallery')

@section('content')
<div class="space-y-6" x-data="{ isAddDialogOpen: false, selectedImage: null }">
    <div class="flex justify-between items-center">
        <p class="text-sm text-gray-600">Manage images displayed on the landing page</p>
        <button @click="isAddDialogOpen = true" class="bg-[#8B1C3A] text-white px-4 py-2 rounded-lg hover:bg-[#a01c3a] transition-colors flex items-center text-sm font-medium">
            <i data-lucide="plus" class="h-4 w-4 mr-2"></i>
            Add Image
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-6">
        <h3 class="font-bold text-gray-900 mb-6">Gallery Images (6)</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $galleryImages = [
                    ['id' => 1, 'title' => 'Restaurant Interior', 'category' => 'Interior', 'url' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=400'],
                    ['id' => 2, 'title' => 'Grilled Salmon Dish', 'category' => 'Food', 'url' => 'https://images.unsplash.com/photo-1467003909585-2f8a72700288?w=400'],
                    ['id' => 3, 'title' => 'Wine Selection', 'category' => 'Drinks', 'url' => 'https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?w=400'],
                    ['id' => 4, 'title' => 'Dining Area', 'category' => 'Interior', 'url' => 'https://images.unsplash.com/photo-1552566626-52f8b828add9?w=400'],
                    ['id' => 5, 'title' => 'Chef Preparing', 'category' => 'Kitchen', 'url' => 'https://images.unsplash.com/photo-1556910103-1c02745aae4d?w=400'],
                    ['id' => 6, 'title' => 'Dessert Platter', 'category' => 'Food', 'url' => 'https://images.unsplash.com/photo-1488477181946-6428a0291777?w=400'],
                ];
            @endphp

            @foreach($galleryImages as $image)
                <div class="relative group rounded-xl overflow-hidden border border-gray-100 shadow-sm transition-all hover:shadow-lg">
                    <img src="{{ $image['url'] }}" alt="{{ $image['title'] }}" class="w-full h-48 object-cover transition-transform group-hover:scale-105 duration-500">
                    <div class="absolute inset-0 bg-black/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="flex space-x-2">
                            <button @click="selectedImage = @js($image)" class="p-2.5 bg-white/20 hover:bg-white/40 text-white rounded-lg backdrop-blur-md transition-colors">
                                <i data-lucide="eye" class="h-5 w-5"></i>
                            </button>
                            <button class="p-2.5 bg-red-500/80 hover:bg-red-600 text-white rounded-lg backdrop-blur-md transition-colors">
                                <i data-lucide="trash-2" class="h-5 w-5"></i>
                            </button>
                        </div>
                    </div>
                    <div class="p-4 bg-white border-t border-gray-50">
                        <h4 class="text-sm font-bold text-gray-900 mb-1">{{ $image['title'] }}</h4>
                        <span class="text-[10px] px-2 py-0.5 bg-gray-100 text-gray-500 rounded font-bold uppercase tracking-wider">{{ $image['category'] }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Image Preview Modal -->
    <template x-if="selectedImage">
        <div class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6">
            <div @click="selectedImage = null" class="fixed inset-0 bg-black/90 backdrop-blur-sm"></div>
            <div class="relative w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden animate-zoomIn">
                <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-900" x-text="selectedImage.title"></h2>
                    <button @click="selectedImage = null" class="p-2 text-gray-400 hover:text-gray-600">
                        <i data-lucide="x" class="h-6 w-6"></i>
                    </button>
                </div>
                <div class="p-4">
                    <img :src="selectedImage.url" class="w-full h-auto max-h-[70vh] object-contain rounded-lg">
                </div>
                <div class="p-4 bg-gray-50 border-t border-gray-100">
                    <p class="text-sm text-gray-500 font-medium">Category: <span class="text-[#8B1C3A]" x-text="selectedImage.category"></span></p>
                </div>
            </div>
        </div>
    </template>
    <!-- Add Image Modal -->
    <div x-show="isAddDialogOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
        <div @click="isAddDialogOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>
        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">Add New Image</h2>
                <button @click="isAddDialogOpen = false"><i data-lucide="x" class="w-6 h-6 text-gray-400"></i></button>
            </div>
            <form class="p-6 space-y-4">
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Image Title</label>
                    <input type="text" placeholder="e.g. Delicious Pasta" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Category</label>
                    <select class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                        <option>Interior</option>
                        <option>Food</option>
                        <option>Drinks</option>
                        <option>Kitchen</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Image File</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 border-dashed rounded-xl hover:border-[#8B1C3A]/40 transition-colors bg-gray-50">
                        <div class="space-y-1 text-center">
                            <i data-lucide="image" class="mx-auto h-12 w-12 text-gray-400"></i>
                            <div class="flex text-sm text-gray-600">
                                <label class="relative cursor-pointer bg-white rounded-md font-bold text-[#8B1C3A] hover:text-[#a01c3a] focus-within:outline-none">
                                    <span>Upload a file</span>
                                    <input type="file" class="sr-only">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end pt-4">
                    <button type="submit" class="px-6 py-2.5 bg-[#8B1C3A] text-white font-bold rounded-xl hover:bg-[#a01c3a] transition-all">Add to Gallery</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
@keyframes zoomIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
.animate-zoomIn { animation: zoomIn 0.3s ease-out; }
</style>
@endsection
