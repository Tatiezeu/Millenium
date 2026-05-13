@extends('layouts.dashboard')

@section('title', 'Services')
@section('page_title', 'Services')

@section('content')
<div class="space-y-6" x-data="{ 
    isAddMenuItemModalOpen: false, 
    isEditMenuItemModalOpen: false, 
    activeTab: 'meals',
    selectedItem: { name: '', price: '', desc: '', type: 'meal' },
    editItem(item, type) {
        this.selectedItem = { ...item, type: type };
        this.isEditMenuItemModalOpen = true;
    },
    deleteItem(id) {
        if(confirm('Are you sure you want to delete this item?')) {
            // In a real app, this would be an API call
            alert('Item ' + id + ' deleted');
        }
    }
}">
    <div class="flex justify-between items-center">
        <p class="text-sm text-gray-600">Manage menu items displayed on the landing page</p>
        <button @click="isAddMenuItemModalOpen = true" class="bg-[#8B1C3A] text-white px-4 py-2 rounded-lg hover:bg-[#a01c3a] transition-colors flex items-center text-sm font-medium">
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
                        ['id' => 2, 'name' => 'Beef Steak', 'category' => 'Main Course', 'price' => '22,000', 'desc' => 'Premium aged beef, medium rare'],
                        ['id' => 3, 'name' => 'Pasta Carbonara', 'category' => 'Main Course', 'price' => '12,000', 'desc' => 'Classic Italian pasta'],
                        ['id' => 4, 'name' => 'Caesar Salad', 'category' => 'Appetizer', 'price' => '8,000', 'desc' => 'Crispy romaine with parmesan'],
                    ];
                @endphp
                @foreach($meals as $item)
                    <div class="flex items-center justify-between p-4 border border-gray-100 rounded-xl hover:bg-gray-50 transition-colors">
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-gray-900 mb-1">{{ $item['name'] }}</h4>
                            <p class="text-xs text-gray-500 mb-2 leading-relaxed">{{ $item['desc'] }}</p>
                            <div class="flex items-center space-x-3 text-xs">
                                <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded font-bold uppercase tracking-wider">{{ $item['category'] }}</span>
                                <span class="text-[#8B1C3A] font-bold">{{ $item['price'] }} FCFA</span>
                            </div>
                        </div>
                        <div class="flex space-x-1">
                            <button @click="editItem({{ json_encode($item) }}, 'meal')" class="p-2 text-gray-400 hover:text-gray-600 transition-colors"><i data-lucide="pencil" class="h-4 w-4"></i></button>
                            <button @click="deleteItem({{ $item['id'] }})" class="p-2 text-gray-400 hover:text-red-600 transition-colors"><i data-lucide="trash-2" class="h-4 w-4"></i></button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Drinks List -->
            <div x-show="activeTab === 'drinks'" class="space-y-3" x-cloak>
                @php
                    $drinks = [
                        ['id' => 5, 'name' => 'Red Wine', 'category' => 'Alcoholic', 'price' => '15,000', 'desc' => 'Bordeaux 2020'],
                        ['id' => 6, 'name' => 'Fresh Orange Juice', 'category' => 'Non-Alcoholic', 'price' => '3,000', 'desc' => 'Freshly squeezed'],
                        ['id' => 7, 'name' => 'Espresso', 'category' => 'Hot Beverage', 'price' => '2,500', 'desc' => 'Italian espresso'],
                    ];
                @endphp
                @foreach($drinks as $item)
                    <div class="flex items-center justify-between p-4 border border-gray-100 rounded-xl hover:bg-gray-50 transition-colors">
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-gray-900 mb-1">{{ $item['name'] }}</h4>
                            <p class="text-xs text-gray-500 mb-2 leading-relaxed">{{ $item['desc'] }}</p>
                            <div class="flex items-center space-x-3 text-xs">
                                <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded font-bold uppercase tracking-wider">{{ $item['category'] }}</span>
                                <span class="text-[#8B1C3A] font-bold">{{ $item['price'] }} FCFA</span>
                            </div>
                        </div>
                        <div class="flex space-x-1">
                            <button @click="editItem({{ json_encode($item) }}, 'drink')" class="p-2 text-gray-400 hover:text-gray-600 transition-colors"><i data-lucide="pencil" class="h-4 w-4"></i></button>
                            <button @click="deleteItem({{ $item['id'] }})" class="p-2 text-gray-400 hover:text-red-600 transition-colors"><i data-lucide="trash-2" class="h-4 w-4"></i></button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Add Menu Item Modal -->
    <div x-show="isAddMenuItemModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
        <div @click="isAddMenuItemModalOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>
        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">Add Menu Item</h2>
                <button @click="isAddMenuItemModalOpen = false"><i data-lucide="x" class="w-6 h-6 text-gray-400"></i></button>
            </div>
            <form class="p-6 space-y-4">
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Type</label>
                    <div class="flex space-x-4">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="radio" name="item_type" value="meal" checked class="text-[#8B1C3A] focus:ring-[#8B1C3A]">
                            <span class="text-sm">Meal</span>
                        </label>
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="radio" name="item_type" value="drink" class="text-[#8B1C3A] focus:ring-[#8B1C3A]">
                            <span class="text-sm">Drink</span>
                        </label>
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Title</label>
                    <input type="text" placeholder="e.g. Grilled Salmon" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Price (FCFA)</label>
                    <input type="number" placeholder="e.g. 18000" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Description</label>
                    <textarea rows="3" placeholder="Describe the item..." class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none"></textarea>
                </div>
                <div class="flex justify-end pt-4">
                    <button type="submit" class="px-6 py-2.5 bg-[#8B1C3A] text-white font-bold rounded-xl hover:bg-[#a01c3a] transition-all">Add Item</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Menu Item Modal -->
    <div x-show="isEditMenuItemModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
        <div @click="isEditMenuItemModalOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>
        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">Edit Menu Item</h2>
                <button @click="isEditMenuItemModalOpen = false"><i data-lucide="x" class="w-6 h-6 text-gray-400"></i></button>
            </div>
            <form class="p-6 space-y-4">
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Type</label>
                    <div class="flex space-x-4">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="radio" name="edit_item_type" value="meal" x-model="selectedItem.type" class="text-[#8B1C3A] focus:ring-[#8B1C3A]">
                            <span class="text-sm">Meal</span>
                        </label>
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="radio" name="edit_item_type" value="drink" x-model="selectedItem.type" class="text-[#8B1C3A] focus:ring-[#8B1C3A]">
                            <span class="text-sm">Drink</span>
                        </label>
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
                <div class="flex justify-end pt-4">
                    <button type="submit" class="px-6 py-2.5 bg-[#8B1C3A] text-white font-bold rounded-xl hover:bg-[#a01c3a] transition-all">Update Item</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
