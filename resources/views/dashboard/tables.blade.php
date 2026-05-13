@extends('layouts.dashboard')

@section('title', 'Tables')
@section('page_title', 'Tables')

@section('content')
<div class="space-y-6" x-data="{ isAddTableModalOpen: false }">
    <div class="flex justify-between items-center">
        <p class="text-sm text-gray-600">Manage restaurant tables and their availability</p>
        <button @click="isAddTableModalOpen = true" class="bg-[#8B1C3A] text-white px-4 py-2 rounded-lg hover:bg-[#a01c3a] transition-colors flex items-center text-sm font-medium">
            <i data-lucide="plus" class="h-4 w-4 mr-2"></i>
            Add Table
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @php
            $tables = [
                ['id' => 1, 'title' => 'Table 1', 'places' => 4, 'category' => 'Standard', 'price' => '25,000', 'area' => '15 m²', 'available' => true],
                ['id' => 2, 'title' => 'Table 2', 'places' => 2, 'category' => 'Standard', 'price' => '25,000', 'area' => '10 m²', 'available' => true],
                ['id' => 3, 'title' => 'Table 3', 'places' => 6, 'category' => 'Medium', 'price' => '35,000', 'area' => '20 m²', 'available' => false],
                ['id' => 4, 'title' => 'Table 4', 'places' => 8, 'category' => 'First Class', 'price' => '50,000', 'area' => '30 m²', 'available' => true],
                ['id' => 5, 'title' => 'Table 5', 'places' => 4, 'category' => 'Medium', 'price' => '35,000', 'area' => '18 m²', 'available' => false],
                ['id' => 6, 'title' => 'Table 6', 'places' => 2, 'category' => 'First Class', 'price' => '50,000', 'area' => '25 m²', 'available' => true],
            ];
        @endphp

        @foreach($tables as $table)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden relative">
                <div class="absolute top-0 right-0 px-3 py-1 text-xs font-bold text-white {{ $table['available'] ? 'bg-green-500' : 'bg-red-500' }}">
                    {{ $table['available'] ? 'Available' : 'Occupied' }}
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">{{ $table['title'] }}</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 font-medium">Category:</span>
                            <span class="px-2.5 py-1 rounded-md text-xs font-bold 
                                {{ $table['category'] === 'Standard' ? 'bg-gray-100 text-gray-600' : 
                                   ($table['category'] === 'Medium' ? 'bg-blue-100 text-blue-800' : 'bg-[#ffd700] text-[#8B1C3A]') }}">
                                {{ $table['category'] }}
                            </span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 font-medium">Places:</span>
                            <span class="text-gray-900 font-semibold">{{ $table['places'] }} seats</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 font-medium">Price:</span>
                            <span class="text-[#8B1C3A] font-bold">{{ $table['price'] }} FCFA</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 font-medium">Area:</span>
                            <span class="text-gray-900 font-semibold">{{ $table['area'] }}</span>
                        </div>
                    </div>
                    <button class="w-full mt-6 py-2.5 rounded-xl font-bold transition-all
                        {{ $table['available'] ? 'bg-[#8B1C3A] text-white hover:bg-[#a01c3a]' : 'border-2 border-gray-100 text-gray-400 cursor-not-allowed' }}">
                        {{ $table['available'] ? 'Reserve Table' : 'View Details' }}
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Add Table Modal -->
    <div x-show="isAddTableModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
        <div @click="isAddTableModalOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>
        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">Add New Table</h2>
                <button @click="isAddTableModalOpen = false"><i data-lucide="x" class="w-6 h-6 text-gray-400"></i></button>
            </div>
            <form class="p-6 space-y-4">
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Table Title/Number</label>
                    <input type="text" placeholder="e.g. Table 10" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Places (Seats)</label>
                        <input type="number" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Category</label>
                        <select class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                            <option>Standard</option>
                            <option>Medium</option>
                            <option>First Class</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Price (FCFA)</label>
                        <input type="number" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Area (m²)</label>
                        <input type="text" placeholder="e.g. 15 m²" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                    </div>
                </div>
                <div class="flex justify-end pt-4">
                    <button type="submit" class="px-6 py-2.5 bg-[#8B1C3A] text-white font-bold rounded-xl hover:bg-[#a01c3a] transition-all">Add Table</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
