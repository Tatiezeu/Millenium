@extends('layouts.dashboard')

@section('title', 'Services')
@section('page_title', 'Services')

@section('content')
<div class="space-y-6" x-data="{ 
    isAddMenuItemModalOpen: false, 
    isEditMenuItemModalOpen: false, 
    activeTab: 'meals',
    // Data model for editing
    selectedItem: { id: '', name: '', price: '', description: '', type: 'meal', category: 'Main Course' },
    
    /**
     * Prepare the edit modal with item data.
     * Robustly handles MongoDB IDs which may appear as .id or ._id.
     */
    editItem(item) {
        // MongoDB models in JSON often have 'id' as a string or '_id' as an object/string
        const itemId = item.id || (typeof item._id === 'object' ? item._id.$oid : item._id);
        
        this.selectedItem = { 
            id: itemId, 
            name: item.name, 
            price: item.price, 
            description: item.description || '', 
            type: item.type, 
            category: item.category 
        };
        this.isEditMenuItemModalOpen = true;
    }
}">
    <div class="flex justify-between items-center">
        <p class="text-sm text-gray-600">Manage menu items displayed on the landing page</p>
        <button @click="isAddMenuItemModalOpen = true" class="bg-[#8B1C3A] text-white px-4 py-2 rounded-lg hover:bg-[#a01c3a] transition-colors flex items-center text-sm font-medium shadow-lg shadow-[#8B1C3A]/20">
            <i data-lucide="plus" class="h-4 w-4 mr-2"></i>
            Add Menu Item
        </button>
    </div>

    <!-- Menu Item Listing -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50">
            <h3 class="font-bold text-gray-900">Menu Management</h3>
        </div>
        <div class="p-6">
            <!-- Navigation Tabs -->
            <div class="flex space-x-1 bg-gray-100 p-1 rounded-xl mb-6 w-fit">
                <button @click="activeTab = 'meals'" 
                        :class="activeTab === 'meals' ? 'bg-white text-[#8B1C3A] shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                        class="px-6 py-2 text-sm font-bold rounded-lg transition-all">
                    Meals
                </button>
                <button @click="activeTab = 'drinks'" 
                        :class="activeTab === 'drinks' ? 'bg-white text-[#8B1C3A] shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                        class="px-6 py-2 text-sm font-bold rounded-lg transition-all">
                    Drinks
                </button>
            </div>

            <!-- Meals List (Database Driven) -->
            <div x-show="activeTab === 'meals'" class="space-y-3" x-cloak>
                @forelse($meals as $item)
                    <div class="flex items-center justify-between p-4 border border-gray-100 rounded-xl hover:bg-gray-50 transition-colors animate-fade-in group">
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-gray-900 mb-1 group-hover:text-[#8B1C3A] transition-colors">{{ $item->name }}</h4>
                            <p class="text-xs text-gray-500 mb-2 leading-relaxed">{{ $item->description }}</p>
                            <div class="flex items-center space-x-3 text-xs">
                                <span class="px-2 py-0.5 bg-[#8B1C3A]/5 text-[#8B1C3A] rounded font-bold uppercase tracking-wider text-[10px]">{{ $item->category }}</span>
                                <span class="text-gray-900 font-bold">{{ number_format($item->price) }} FCFA</span>
                            </div>
                        </div>
                        <div class="flex space-x-1">
                            <button @click="editItem({{ json_encode($item) }})" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                                <i data-lucide="pencil" class="h-4 w-4"></i>
                            </button>
                            <form action="{{ route('services.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this item?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 border-2 border-dashed border-gray-100 rounded-xl">
                        <p class="text-gray-400 text-sm">No meals registered yet.</p>
                    </div>
                @endforelse
            </div>

            <!-- Drinks List (Database Driven) -->
            <div x-show="activeTab === 'drinks'" class="space-y-3" x-cloak>
                @forelse($drinks as $item)
                    <div class="flex items-center justify-between p-4 border border-gray-100 rounded-xl hover:bg-gray-50 transition-colors animate-fade-in group">
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-gray-900 mb-1 group-hover:text-[#8B1C3A] transition-colors">{{ $item->name }}</h4>
                            <p class="text-xs text-gray-500 mb-2 leading-relaxed">{{ $item->description }}</p>
                            <div class="flex items-center space-x-3 text-xs">
                                <span class="px-2 py-0.5 bg-[#ffd700]/20 text-[#8B1C3A] rounded font-bold uppercase tracking-wider text-[10px]">{{ $item->category }}</span>
                                <span class="text-gray-900 font-bold">{{ number_format($item->price) }} FCFA</span>
                            </div>
                        </div>
                        <div class="flex space-x-1">
                            <button @click="editItem({{ json_encode($item) }})" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                                <i data-lucide="pencil" class="h-4 w-4"></i>
                            </button>
                            <form action="{{ route('services.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this item?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 border-2 border-dashed border-gray-100 rounded-xl">
                        <p class="text-gray-400 text-sm">No drinks registered yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Add Menu Item Modal -->
    <div x-show="isAddMenuItemModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
        <div @click="isAddMenuItemModalOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm animate-fade-in"></div>
        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden animate-zoom-in" x-data="{ addType: 'meal' }">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">Add Menu Item</h2>
                <button @click="isAddMenuItemModalOpen = false"><i data-lucide="x" class="w-6 h-6 text-gray-400"></i></button>
            </div>
            <form action="{{ route('services.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Type</label>
                        <select name="type" x-model="addType" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                            <option value="meal">Meal</option>
                            <option value="drink">Drink</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Category</label>
                        <select name="category" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                            <template x-if="addType === 'meal'">
                                <optgroup label="Meal Categories">
                                    <option>Breakfast</option>
                                    <option>Lunch</option>
                                    <option>Dinner</option>
                                    <option>Appetizer</option>
                                    <option>Dessert</option>
                                    <option>Main Course</option>
                                    <option>Side Dish</option>
                                </optgroup>
                            </template>
                            <template x-if="addType === 'drink'">
                                <optgroup label="Drink Categories">
                                    <option>Spirits</option>
                                    <option>Alcoholic</option>
                                    <option>Non-Alcoholic</option>
                                    <option>Malt</option>
                                    <option>Wine</option>
                                    <option>Champagne</option>
                                    <option>Hot Beverage</option>
                                    <option>Cold Beverage</option>
                                </optgroup>
                            </template>
                        </select>
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Title</label>
                    <input type="text" name="name" required placeholder="e.g. Grilled Salmon" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Price (FCFA)</label>
                    <input type="number" name="price" required placeholder="e.g. 18000" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Description</label>
                    <textarea name="description" rows="3" placeholder="Describe the item..." class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none"></textarea>
                </div>
                <div class="flex justify-end pt-4">
                    <button type="submit" class="px-8 py-2.5 bg-[#8B1C3A] text-white font-bold rounded-xl hover:bg-[#a01c3a] transition-all shadow-lg shadow-[#8B1C3A]/20">Add Item</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Menu Item Modal -->
    <div x-show="isEditMenuItemModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
        <div @click="isEditMenuItemModalOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm animate-fade-in"></div>
        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden animate-zoom-in">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">Edit Menu Item</h2>
                <button @click="isEditMenuItemModalOpen = false"><i data-lucide="x" class="w-6 h-6 text-gray-400"></i></button>
            </div>
            <form :action="`{{ url('dashboard/services') }}/${selectedItem.id}`" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Type</label>
                        <select name="type" x-model="selectedItem.type" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                            <option value="meal">Meal</option>
                            <option value="drink">Drink</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Category</label>
                        <select name="category" x-model="selectedItem.category" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                            <template x-if="selectedItem.type === 'meal'">
                                <optgroup label="Meal Categories">
                                    <option>Breakfast</option>
                                    <option>Lunch</option>
                                    <option>Dinner</option>
                                    <option>Appetizer</option>
                                    <option>Dessert</option>
                                    <option>Main Course</option>
                                    <option>Side Dish</option>
                                </optgroup>
                            </template>
                            <template x-if="selectedItem.type === 'drink'">
                                <optgroup label="Drink Categories">
                                    <option>Spirits</option>
                                    <option>Alcoholic</option>
                                    <option>Non-Alcoholic</option>
                                    <option>Malt</option>
                                    <option>Wine</option>
                                    <option>Champagne</option>
                                    <option>Hot Beverage</option>
                                    <option>Cold Beverage</option>
                                </optgroup>
                            </template>
                        </select>
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Title</label>
                    <input type="text" name="name" x-model="selectedItem.name" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Price (FCFA)</label>
                    <input type="number" name="price" x-model="selectedItem.price" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Description</label>
                    <textarea name="description" rows="3" x-model="selectedItem.description" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none"></textarea>
                </div>
                <div class="flex justify-end pt-4 space-x-3">
                    <button type="button" @click="isEditMenuItemModalOpen = false" class="px-6 py-2.5 text-gray-500 font-bold hover:bg-gray-50 rounded-xl transition-all">Cancel</button>
                    <button type="submit" class="px-6 py-2.5 bg-[#8B1C3A] text-white font-bold rounded-xl hover:bg-[#a01c3a] transition-all shadow-lg shadow-[#8B1C3A]/20">Update Item</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
