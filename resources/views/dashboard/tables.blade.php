{{-- Tables View --}}
{{-- This view handles the display and user interaction for Tables. --}}
@extends('layouts.dashboard')

@section('title', 'Tables')
@section('page_title', 'Tables')

@section('content')
<div class="space-y-6" x-data="{ 
    isAddTableModalOpen: false, 
    isDeleteModalOpen: false,
    tableToDelete: null,
    confirmDelete(id) {
        this.tableToDelete = id;
        this.isDeleteModalOpen = true;
    }
}">
    <!-- Header & Filter Bar -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <p class="text-sm text-gray-600">Manage restaurant tables and their real-time availability</p>
        </div>
        
        <div class="flex flex-wrap items-center gap-3">
            <!-- Filter Form -->
            <form action="{{ route('dashboard.tables') }}" method="GET" class="flex items-center gap-2 bg-white p-1 rounded-lg border border-gray-100 shadow-sm">
                <select name="category" onchange="this.form.submit()" class="text-xs font-bold px-3 py-1.5 outline-none bg-transparent">
                    <option value="">All Categories</option>
                    <option value="Standard" {{ request('category') == 'Standard' ? 'selected' : '' }}>Standard</option>
                    <option value="Medium" {{ request('category') == 'Medium' ? 'selected' : '' }}>Medium</option>
                    <option value="First Class" {{ request('category') == 'First Class' ? 'selected' : '' }}>First Class</option>
                </select>
                <div class="h-4 w-px bg-gray-200"></div>
                <select name="status" onchange="this.form.submit()" class="text-xs font-bold px-3 py-1.5 outline-none bg-transparent">
                    <option value="">All Status</option>
                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="occupied" {{ request('status') == 'occupied' ? 'selected' : '' }}>Occupied</option>
                </select>
            </form>

            <button @click="isAddTableModalOpen = true" class="bg-[#8B1C3A] text-white px-4 py-2 rounded-lg hover:bg-[#a01c3a] transition-colors flex items-center text-sm font-medium shadow-lg shadow-[#8B1C3A]/20">
                <i data-lucide="plus" class="h-4 w-4 mr-2"></i>
                Add Table
            </button>
        </div>
    </div>

    <!-- Tables Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($tables as $table)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden relative group hover:shadow-md transition-all">
                <!-- Status Badge -->
                <div class="absolute top-0 right-0 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-white {{ $table->status === 'available' ? 'bg-green-500' : 'bg-red-500' }}">
                    {{ $table->status }}
                </div>
                
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg font-bold text-gray-900">{{ $table->title }}</h3>
                        <div class="flex space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button @click="confirmDelete('{{ $table->id }}')" class="p-1.5 text-gray-400 hover:text-red-600 rounded-lg transition-colors">
                                <i data-lucide="trash-2" class="h-4 w-4"></i>
                            </button>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 font-medium">Category:</span>
                            <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider
                                {{ $table->category === 'Standard' ? 'bg-gray-100 text-gray-600' : 
                                   ($table->category === 'Medium' ? 'bg-blue-50 text-blue-600' : 'bg-[#ffd700]/20 text-[#8B1C3A]') }}">
                                {{ $table->category }}
                            </span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 font-medium">Seats:</span>
                            <span class="text-gray-900 font-semibold">{{ $table->seats }} seats</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 font-medium">Price:</span>
                            <span class="text-[#8B1C3A] font-bold">{{ number_format($table->price) }} FCFA</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 font-medium">Area:</span>
                            <span class="text-gray-900 font-semibold">{{ $table->area }}</span>
                        </div>
                    </div>

                    <!-- Status Toggle Action -->
                    <form action="{{ route('tables.toggle', $table->id) }}" method="POST" class="mt-6">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full py-2.5 rounded-xl font-bold transition-all shadow-sm
                            {{ $table->status === 'available' ? 'bg-[#8B1C3A] text-white hover:bg-[#a01c3a]' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            {{ $table->status === 'available' ? 'Mark as Occupied' : 'Mark as Available' }}
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center bg-white rounded-2xl border-2 border-dashed border-gray-100">
                <p class="text-gray-400">No tables found matching your filters.</p>
            </div>
        @endforelse
    </div>

    <!-- Add Table Modal -->
    <div x-show="isAddTableModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
        <div @click="isAddTableModalOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm animate-fade-in"></div>
        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden animate-zoom-in" 
             x-data="{ 
                category: 'Standard',
                // Automatic defaults based on category
                get defaults() {
                    if (this.category === 'Standard') return { seats: 2, price: 25000, area: '15 m²' };
                    if (this.category === 'Medium') return { seats: 4, price: 35000, area: '25 m²' };
                    return { seats: 6, price: 50000, area: '40 m²' }; // VIP / First Class
                }
             }">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <div class="flex flex-col">
                    <h2 class="text-xl font-bold text-gray-900">Add New Table</h2>
                    <p class="text-[10px] text-[#8B1C3A] font-bold uppercase tracking-widest">Automatic Specifications Enabled</p>
                </div>
                <button @click="isAddTableModalOpen = false"><i data-lucide="x" class="w-6 h-6 text-gray-400"></i></button>
            </div>
            <form action="{{ route('tables.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Category</label>
                        <select name="category" x-model="category" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                            <option value="Standard">Standard</option>
                            <option value="Medium">Medium</option>
                            <option value="First Class">First Class (VIP)</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Table Number/Title</label>
                        <input type="text" name="title" required placeholder="e.g. Table 10" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                    </div>
                </div>
                
                <div class="grid grid-cols-3 gap-4 bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-gray-400 uppercase">Seats</label>
                        <input type="hidden" name="seats" :value="defaults.seats">
                        <p class="text-lg font-bold text-gray-900" x-text="defaults.seats + ' Seats'"></p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-gray-400 uppercase">Price</label>
                        <input type="hidden" name="price" :value="defaults.price">
                        <p class="text-sm font-bold text-[#8B1C3A]" x-text="defaults.price.toLocaleString() + ' FCFA'"></p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-gray-400 uppercase">Area</label>
                        <input type="hidden" name="area" :value="defaults.area">
                        <p class="text-sm font-bold text-gray-900" x-text="defaults.area"></p>
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="px-8 py-2.5 bg-[#8B1C3A] text-white font-bold rounded-xl hover:bg-[#a01c3a] transition-all shadow-lg shadow-[#8B1C3A]/20">Add Table</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Delete Confirmation Modal -->
    <div x-show="isDeleteModalOpen" class="fixed inset-0 z-[110] flex items-center justify-center p-6" x-cloak>
        <div @click="isDeleteModalOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm animate-fade-in"></div>
        <div class="relative w-full max-w-sm bg-white rounded-2xl shadow-2xl overflow-hidden animate-zoom-in">
            <div class="p-6 text-center">
                <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="alert-triangle" class="w-8 h-8 text-red-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Confirm Deletion</h3>
                <p class="text-gray-500 text-sm mb-6">Are you sure you want to remove this table? This action cannot be undone and will fail if there are active reservations.</p>
                
                <div class="flex space-x-3">
                    <button @click="isDeleteModalOpen = false" class="flex-1 px-4 py-2.5 bg-gray-50 text-gray-700 font-bold rounded-xl hover:bg-gray-100 transition-all">Cancel</button>
                    <form :action="'{{ url('/dashboard/tables') }}/' + tableToDelete" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2.5 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-all shadow-lg shadow-red-600/20">Delete Table</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes fade-in { from { opacity: 0; } to { opacity: 1; } }
@keyframes zoom-in { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
.animate-fade-in { animation: fade-in 0.2s ease-out; }
.animate-zoom-in { animation: zoom-in 0.2s ease-out; }
</style>
@endsection
