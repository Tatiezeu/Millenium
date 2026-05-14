@extends('layouts.dashboard')

@section('title', 'Services')
@section('page_title', 'Services')

@section('content')
<div class="space-y-6" x-data="{ 
    isAddMenuItemModalOpen: false, 
    isEditMenuItemModalOpen: false, 
    activeTab: 'meals',
    newItem: { name: '', price: '', desc: '', type: 'meal', category: 'Main Course' },
    selectedItem: { name: '', price: '', desc: '', type: 'meal', category: 'Main Course' },
    editItem(item, type) {
        this.selectedItem = { ...item, type: type };
        this.isEditMenuItemModalOpen = true;
    },
    deleteItem(id) {
        if(confirm('Are you sure you want to delete this item?')) {
            $dispatch('toast', { message: 'Item deleted successfully', type: 'error' });
        }
    },
    saveNewItem() {
        this.isAddMenuItemModalOpen = false;
        $dispatch('toast', { message: 'New menu item added!', type: 'success' });
    },
    updateItem() {
        this.isEditMenuItemModalOpen = false;
        $dispatch('toast', { message: 'Menu item updated successfully!', type: 'success' });
    },
    get categories() {
        if (this.activeTab === 'meals') {
            return ['Breakfast', 'Lunch', 'Dinner', 'Appetizer', 'Dessert', 'Main Course', 'Side Dish'];
        }
        return ['Spirits', 'Alcoholic', 'Non-Alcoholic', 'Malt', 'Wine', 'Champagne', 'Hot Beverage', 'Cold Beverage'];
    }
}">
    <div class="flex justify-between items-center">
        <p class="text-sm text-gray-600">Manage menu items displayed on the landing page</p>
        <button @click="isAddMenuItemModalOpen = true" class="bg-[#8B1C3A] text-white px-4 py-2 rounded-lg hover:bg-[#a01c3a] transition-colors flex items-center text-sm font-medium shadow-lg shadow-[#8B1C3A]/20">
            <i data-lucide="plus" class="h-4 w-4 mr-2"></i>
            Add Menu Item
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50">
            <h3 class="font-bold text-gray-900">Menu Management</h3>
        </div>
        <div class="p-6">
            <!-- Tabs -->
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

            <!-- Meals List -->
            <div x-show="activeTab === 'meals'" class="space-y-3" x-cloak>
                @php
                    $meals = [
                        ['id' => 1, 'name' => 'Grilled Salmon', 'category' => 'Main Course', 'price' => '18,000', 'desc' => 'Fresh Atlantic salmon with herbs'],
                        ['id' => 2, 'name' => 'English Breakfast', 'category' => 'Breakfast', 'price' => '12,000', 'desc' => 'Eggs, bacon, sausage, and toast'],
                        ['id' => 3, 'name' => 'Club Sandwich', 'category' => 'Lunch', 'price' => '9,000', 'desc' => 'Classic triple-decker with fries'],
                        ['id' => 4, 'name' => 'Beef Fillet', 'category' => 'Dinner', 'price' => '25,000', 'desc' => 'Premium tenderloin with red wine reduction'],
                        ['id' => 5, 'name' => 'Caesar Salad', 'category' => 'Appetizer', 'price' => '8,000', 'desc' => 'Crispy romaine with parmesan'],
                    ];
                @endphp
                @foreach($meals as $item)
                    <div class="flex items-center justify-between p-4 border border-gray-100 rounded-xl hover:bg-gray-50 transition-colors animate-fade-in group">
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-gray-900 mb-1 group-hover:text-[#8B1C3A] transition-colors">{{ $item['name'] }}</h4>
                            <p class="text-xs text-gray-500 mb-2 leading-relaxed">{{ $item['desc'] }}</p>
                            <div class="flex items-center space-x-3 text-xs">
                                <span class="px-2 py-0.5 bg-[#8B1C3A]/5 text-[#8B1C3A] rounded font-bold uppercase tracking-wider text-[10px]">{{ $item['category'] }}</span>
                                <span class="text-gray-900 font-bold">{{ $item['price'] }} FCFA</span>
                            </div>
                        </div>
                        <div class="flex space-x-1">
                            <button @click="editItem({{ json_encode($item) }}, 'meal')" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all"><i data-lucide="pencil" class="h-4 w-4"></i></button>
                            <button @click="deleteItem({{ $item['id'] }})" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"><i data-lucide="trash-2" class="h-4 w-4"></i></button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Drinks List -->
            <div x-show="activeTab === 'drinks'" class="space-y-3" x-cloak>
                @php
                    $drinks = [
                        ['id' => 6, 'name' => 'Glenfiddich 12yr', 'category' => 'Spirits', 'price' => '85,000', 'desc' => 'Single malt Scotch whisky'],
                        ['id' => 7, 'name' => 'Heineken', 'category' => 'Alcoholic', 'price' => '3,500', 'desc' => 'Premium lager beer'],
                        ['id' => 8, 'name' => 'Malta Guinness', 'category' => 'Malt', 'price' => '2,500', 'desc' => 'Classic non-alcoholic malt'],
                        ['id' => 9, 'name' => 'Bordeaux Red', 'category' => 'Wine', 'price' => '25,000', 'desc' => 'Vintage red wine'],
                        ['id' => 10, 'name' => 'Fresh Orange Juice', 'category' => 'Non-Alcoholic', 'price' => '4,000', 'desc' => '100% natural squeeze'],
                    ];
                @endphp
                @foreach($drinks as $item)
                    <div class="flex items-center justify-between p-4 border border-gray-100 rounded-xl hover:bg-gray-50 transition-colors animate-fade-in group">
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-gray-900 mb-1 group-hover:text-[#8B1C3A] transition-colors">{{ $item['name'] }}</h4>
                            <p class="text-xs text-gray-500 mb-2 leading-relaxed">{{ $item['desc'] }}</p>
                            <div class="flex items-center space-x-3 text-xs">
                                <span class="px-2 py-0.5 bg-[#ffd700]/10 text-[#8B1C3A] rounded font-bold uppercase tracking-wider text-[10px]">{{ $item['category'] }}</span>
                                <span class="text-gray-900 font-bold">{{ $item['price'] }} FCFA</span>
                            </div>
                        </div>
                        <div class="flex space-x-1">
                            <button @click="editItem({{ json_encode($item) }}, 'drink')" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all"><i data-lucide="pencil" class="h-4 w-4"></i></button>
                            <button @click="deleteItem({{ $item['id'] }})" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"><i data-lucide="trash-2" class="h-4 w-4"></i></button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Add Menu Item Modal -->
    <div x-show="isAddMenuItemModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
        <div @click="isAddMenuItemModalOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm animate-fade-in"></div>
        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden animate-zoom-in">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">Add Menu Item</h2>
                <button @click="isAddMenuItemModalOpen = false"><i data-lucide="x" class="w-6 h-6 text-gray-400"></i></button>
            </div>
            <form @submit.prevent="saveNewItem()" class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Type</label>
                        <select x-model="newItem.type" @change="newItem.category = newItem.type === 'meal' ? 'Main Course' : 'Spirits'" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none appearance-none">
                            <option value="meal">Meal</option>
                            <option value="drink">Drink</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Category</label>
                        <select x-model="newItem.category" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none appearance-none">
                            <template x-if="newItem.type === 'meal'">
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
                            <template x-if="newItem.type === 'drink'">
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
                    <input type="text" x-model="newItem.name" placeholder="e.g. Grilled Salmon" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Price (FCFA)</label>
                    <input type="number" x-model="newItem.price" placeholder="e.g. 18000" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Description</label>
                    <textarea rows="3" x-model="newItem.desc" placeholder="Describe the item..." class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none"></textarea>
                </div>
                <div class="flex justify-end pt-4">
                    <button type="submit" class="px-8 py-2.5 bg-[#8B1C3A] text-white font-bold rounded-xl hover:bg-[#a01c3a] transition-all shadow-lg shadow-[#8B1C3A]/20">Add Item</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Menu Item Modal -->
    <template x-if="selectedItem">
        <div x-show="isEditMenuItemModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
            <div @click="isEditMenuItemModalOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm animate-fade-in"></div>
            <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden animate-zoom-in">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-900">Edit Menu Item</h2>
                    <button @click="isEditMenuItemModalOpen = false"><i data-lucide="x" class="w-6 h-6 text-gray-400"></i></button>
                </div>
                <form @submit.prevent="updateItem()" class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-sm font-semibold text-gray-700">Type</label>
                            <select x-model="selectedItem.type" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none appearance-none">
                                <option value="meal">Meal</option>
                                <option value="drink">Drink</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="text-sm font-semibold text-gray-700">Category</label>
                            <select x-model="selectedItem.category" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none appearance-none">
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
                        <input type="text" x-model="selectedItem.name" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Price (FCFA)</label>
                        <input type="text" x-model="selectedItem.price" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Description</label>
                        <textarea rows="3" x-model="selectedItem.desc" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none"></textarea>
                    </div>
                    <div class="flex justify-end pt-4 space-x-3">
                        <button type="button" @click="isEditMenuItemModalOpen = false" class="px-6 py-2.5 text-gray-500 font-bold hover:bg-gray-50 rounded-xl transition-all">Cancel</button>
                        <button type="submit" class="px-6 py-2.5 bg-[#8B1C3A] text-white font-bold rounded-xl hover:bg-[#a01c3a] transition-all shadow-lg shadow-[#8B1C3A]/20">Update Item</button>
                    </div>
                </form>
            </div>
        </div>
    </template>
</div>
@endsection
