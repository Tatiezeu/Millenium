@extends('layouts.dashboard')

@section('title', 'Cashier')
@section('page_title', 'Cashier')

@section('content')
<div class="space-y-6" x-data="{ 
    isRegisterDialogOpen: false, 
    editMode: false,
    selectedDate: new Date().toISOString().split('T')[0],
    selectedSale: { id: '', items: '', amount: '', method: '' },
    openAddModal() {
        this.editMode = false;
        this.selectedSale = { id: '', items: '', amount: '', method: '' };
        this.isRegisterDialogOpen = true;
    },
    openEditModal(sale) {
        this.editMode = true;
        this.selectedSale = { ...sale };
        this.isRegisterDialogOpen = true;
    },
    printReceipt(saleId) {
        alert('Generating PDF Receipt for ' + saleId + '...');
        // In a real app, this would redirect to a PDF generation route
    }
}">
    <!-- Top Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @php
            $salesData = [
                ['title' => 'Total Sales Today', 'value' => '132,000 FCFA', 'icon' => 'dollar-sign', 'color' => 'text-green-600'],
                ['title' => 'Transactions', 'value' => '4', 'icon' => 'receipt', 'color' => 'text-blue-600'],
                ['title' => 'Cash Payments', 'value' => '2', 'icon' => 'wallet', 'color' => 'text-orange-600'],
                ['title' => 'Card Payments', 'value' => '1', 'icon' => 'credit-card', 'color' => 'text-purple-600'],
            ];
        @endphp

        @foreach($salesData as $stat)
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium text-gray-500">{{ $stat['title'] }}</h3>
                    <i data-lucide="{{ $stat['icon'] }}" class="h-4 w-4 {{ $stat['color'] }}"></i>
                </div>
                <div class="text-2xl font-bold {{ $stat['color'] }}">{{ $stat['value'] }}</div>
            </div>
        @endforeach
    </div>

    <!-- Sales Register Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex flex-col sm:flex-row items-center gap-4 w-full sm:w-auto">
                <h3 class="font-bold text-gray-900 whitespace-nowrap">Sales Register</h3>
                <div class="relative w-full sm:w-48">
                    <input type="date" x-model="selectedDate" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                </div>
            </div>
            <button @click="openAddModal()" class="w-full sm:w-auto bg-[#8B1C3A] text-white px-4 py-2 rounded-lg hover:bg-[#a01c3a] transition-colors flex items-center justify-center text-sm font-medium">
                <i data-lucide="plus" class="h-4 w-4 mr-2"></i>
                Register Sale
            </button>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-gray-50">
                        <tr class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                            <th class="pb-3">Order ID</th>
                            <th class="pb-3">Items</th>
                            <th class="pb-3">Amount</th>
                            <th class="pb-3">Payment</th>
                            <th class="pb-3">Time</th>
                            <th class="pb-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @php
                            $todaySales = [
                                ['id' => '#ORD-001', 'items' => 'Grilled Salmon, Wine', 'amount' => '33,000', 'method' => 'Cash', 'time' => '14:30'],
                                ['id' => '#ORD-002', 'items' => 'Beef Steak, Salad', 'amount' => '30,000', 'method' => 'Card', 'time' => '15:15'],
                                ['id' => '#ORD-004', 'items' => 'Lobster Bisque, Champagne', 'amount' => '45,000', 'method' => 'Mobile Money', 'time' => '16:00'],
                                ['id' => '#ORD-006', 'items' => 'Pasta Carbonara x2', 'amount' => '24,000', 'method' => 'Cash', 'time' => '16:45'],
                            ];
                        @endphp

                        @foreach($todaySales as $sale)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-4 text-sm font-medium text-gray-900">{{ $sale['id'] }}</td>
                                <td class="py-4 text-sm text-gray-600">{{ $sale['items'] }}</td>
                                <td class="py-4 text-sm font-bold text-[#8B1C3A]">{{ $sale['amount'] }} FCFA</td>
                                <td class="py-4">
                                    <span class="text-xs px-2.5 py-1 bg-gray-100 text-gray-600 rounded-md font-medium">
                                        {{ $sale['method'] }}
                                    </span>
                                </td>
                                <td class="py-4 text-sm text-gray-500">{{ $sale['time'] }}</td>
                                <td class="py-4">
                                    <div class="flex items-center justify-end space-x-3">
                                        <button @click="openEditModal({{ json_encode($sale) }})" class="text-gray-400 hover:text-blue-600 transition-colors">
                                            <i data-lucide="pencil" class="h-4 w-4"></i>
                                        </button>
                                        <button @click="printReceipt('{{ $sale['id'] }}')" class="flex items-center text-xs font-bold text-gray-400 hover:text-[#8B1C3A] transition-colors">
                                            <i data-lucide="receipt" class="h-4 w-4 mr-1"></i>
                                            PDF
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <i data-lucide="trending-up" class="h-5 w-5 text-green-600"></i>
                        <span class="text-sm font-medium text-gray-600">Total for <span x-text="selectedDate"></span>:</span>
                    </div>
                    <span class="text-2xl font-bold text-[#8B1C3A]">132,000 FCFA</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Register/Edit Sale Dialog -->
    <div x-show="isRegisterDialogOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6" x-cloak>
        <div @click="isRegisterDialogOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm animate-fade-in"></div>
        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden animate-zoom-in">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900" x-text="editMode ? 'Edit Sale Entry' : 'Register New Sale'"></h2>
                <button @click="isRegisterDialogOpen = false" class="text-gray-400 hover:text-gray-600"><i data-lucide="x" class="w-6 h-6"></i></button>
            </div>

            <form class="p-6 space-y-4">
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Order ID</label>
                    <input type="text" x-model="selectedSale.id" placeholder="e.g., #ORD-001" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none transition-all">
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Items Sold</label>
                    <input type="text" x-model="selectedSale.items" placeholder="e.g., Grilled Salmon, Wine" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none transition-all">
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Amount (FCFA)</label>
                    <input type="text" x-model="selectedSale.amount" placeholder="e.g., 33000" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none transition-all">
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Payment Method</label>
                    <select x-model="selectedSale.method" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none transition-all appearance-none">
                        <option value="">Select payment method</option>
                        <option value="Cash">Cash</option>
                        <option value="Card">Card</option>
                        <option value="Mobile Money">Mobile Money</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" @click="isRegisterDialogOpen = false" class="px-5 py-2.5 text-sm font-bold text-gray-500 hover:bg-gray-50 rounded-xl transition-colors">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 bg-[#8B1C3A] text-white text-sm font-bold rounded-xl hover:bg-[#a01c3a] shadow-lg shadow-[#8B1C3A]/20 transition-all active:scale-95" x-text="editMode ? 'Update Sale' : 'Register Sale'"></button>
                </div>
            </form>
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
