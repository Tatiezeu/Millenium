@extends('layouts.dashboard')

@section('title', 'Gallery Management')
@section('page_title', 'Gallery')

@section('content')
<div class="space-y-6" x-data="{ isAddModalOpen: false }">
    <!-- Header Actions -->
    <div class="flex justify-between items-center">
        <h3 class="font-bold text-gray-900">Gallery Images</h3>
        <button @click="isAddModalOpen = true" class="bg-[#8B1C3A] text-white px-6 py-2.5 rounded-xl hover:bg-[#a01c3a] transition-all flex items-center shadow-lg shadow-[#8B1C3A]/20">
            <i data-lucide="plus" class="h-5 w-5 mr-2"></i>
            Add New Image
        </button>
    </div>

    <!-- Gallery Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($images as $image)
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 group">
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-4">
                        <form action="{{ route('gallery.destroy', $image->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this image?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                                <i data-lucide="trash-2" class="h-5 w-5"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="p-4">
                    <h4 class="font-bold text-gray-900 truncate">{{ $image->title }}</h4>
                    <span class="text-xs font-semibold text-[#8B1C3A] uppercase tracking-wider">{{ $image->category }}</span>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center bg-white rounded-2xl border-2 border-dashed border-gray-200">
                <i data-lucide="image" class="h-12 w-12 text-gray-300 mx-auto mb-4"></i>
                <p class="text-gray-500">No images in your gallery yet.</p>
            </div>
        @endforelse
    </div>

    <!-- Add Image Modal -->
    <div x-show="isAddModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-6" x-cloak>
        <div @click="isAddModalOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm animate-fade-in"></div>
        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden animate-zoom-in">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h2 class="text-xl font-bold text-gray-900">Add Gallery Image</h2>
                <button @click="isAddModalOpen = false" class="p-2 hover:bg-gray-200 rounded-full transition-colors">
                    <i data-lucide="x" class="h-5 w-5 text-gray-400"></i>
                </button>
            </div>
            
            <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Image Title</label>
                    <input type="text" name="title" required placeholder="e.g. Luxury Dining Room" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                </div>

                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Category</label>
                    <select name="category" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                        <option value="interior">Interior</option>
                        <option value="food">Food & Drinks</option>
                        <option value="events">Events</option>
                        <option value="exterior">Exterior</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Image File</label>
                    <input type="file" name="image" required accept="image/*" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#8B1C3A]/10 file:text-[#8B1C3A] hover:file:bg-[#8B1C3A]/20">
                    <p class="text-[10px] text-gray-400 mt-1">Recommended size: 1200x800px. Max 5MB.</p>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="px-8 py-2.5 bg-[#8B1C3A] text-white font-bold rounded-xl hover:bg-[#a01c3a] transition-all shadow-lg shadow-[#8B1C3A]/20">
                        Upload Image
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
    @keyframes fade-in { from { opacity: 0; } to { opacity: 1; } }
    @keyframes zoom-in { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
    .animate-fade-in { animation: fade-in 0.3s ease-out; }
    .animate-zoom-in { animation: zoom-in 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); }
</style>
@endsection
