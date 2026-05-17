{-- Cashier View --}
{-- This view handles the display and user interaction for Cashier. --}
@extends('layouts.dashboard')

@section('title', 'Cashier')
@section('page_title', 'Cashier')

@section('content')
<div class="space-y-6" x-data="{ 
    isRegisterDialogOpen: false, 
    completedOrders: {{ json_encode($completedOrders) }},
    selectedOrderId: '',
    selectedSale: { order_id: '', amount: '', method: '' },
    
    init() {
        this.$watch('selectedOrderId', value => {
            const order = this.completedOrders.find(o => o._id === value);
            if (order) {
                this.selectedSale.order_id = order._id;
                this.selectedSale.amount = order.total_price;
            }
        });
    },
    
    openAddModal() {
        this.selectedOrderId = '';
        this.selectedSale = { order_id: '', amount: '', method: '' };
        this.isRegisterDialogOpen = true;
    }
}">
    <!-- Top Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Sales Today</h3>
                <i data-lucide="dollar-sign" class="h-5 w-5 text-green-600"></i>
            </div>
            <div class="text-2xl font-bold text-gray-900">{{ number_format($todaySalesTotal) }} FCFA</div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Transactions</h3>
                <i data-lucide="receipt" class="h-5 w-5 text-blue-600"></i>
            </div>
            <div class="text-2xl font-bold text-gray-900">{{ $todayTransactions }}</div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Cash</h3>
                <i data-lucide="wallet" class="h-5 w-5 text-orange-600"></i>
            </div>
            <div class="text-2xl font-bold text-gray-900">{{ $cashPayments }}</div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Card</h3>
                <i data-lucide="credit-card" class="h-5 w-5 text-purple-600"></i>
            </div>
            <div class="text-2xl font-bold text-gray-900">{{ $cardPayments }}</div>
        </div>
    </div>

    <!-- Sales Register Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 border-b border-gray-50 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Sales Register</h3>
                <p class="text-xs text-gray-500 mt-1">Review and process completed order payments</p>
            </div>
            <button @click="openAddModal()" class="w-full sm:w-auto bg-[#8B1C3A] text-white px-6 py-3 rounded-xl hover:bg-[#a01c3a] transition-all flex items-center justify-center text-sm font-bold shadow-lg shadow-[#8B1C3A]/20 active:scale-95">
                <i data-lucide="plus-circle" class="h-5 w-5 mr-2"></i>
                Register New Sale
            </button>
        </div>
        <div class="p-8">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50">
                            <th class="pb-4">Order ID</th>
                            <th class="pb-4">Description</th>
                            <th class="pb-4 text-center">Amount</th>
                            <th class="pb-4 text-center">Method</th>
                            <th class="pb-4 text-center">Time</th>
                            <th class="pb-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($sales as $sale)
                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                <td class="py-5">
                                    <span class="text-sm font-bold text-gray-900">#{{ substr($sale->order_id, -6) }}</span>
                                </td>
                                <td class="py-5">
                                    <p class="text-sm text-gray-600">{{ $sale->items }}</p>
                                </td>
                                <td class="py-5 text-center">
                                    <span class="text-sm font-bold text-[#8B1C3A]">{{ number_format($sale->amount) }} FCFA</span>
                                </td>
                                <td class="py-5 text-center">
                                    <span class="text-[10px] px-3 py-1.5 bg-gray-100 text-gray-600 rounded-full font-bold uppercase tracking-wider">
                                        {{ $sale->payment_method }}
                                    </span>
                                </td>
                                <td class="py-5 text-center">
                                    <span class="text-xs text-gray-500 font-medium">{{ $sale->created_at->format('H:i') }}</span>
                                </td>
                                <td class="py-5 text-right">
                                    <button class="p-2 text-gray-300 hover:text-[#8B1C3A] transition-colors">
                                        <i data-lucide="printer" class="h-5 w-5"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-20 text-center">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i data-lucide="receipt" class="h-8 w-8 text-gray-200"></i>
                                    </div>
                                    <h3 class="text-sm font-bold text-gray-900">No sales registered yet</h3>
                                    <p class="text-xs text-gray-500">Sales will appear here as they are processed.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-8 pt-8 border-t border-gray-100 flex items-center justify-between">
                <div class="flex items-center space-x-3 text-gray-600">
                    <i data-lucide="line-chart" class="h-6 w-6 text-green-500"></i>
                    <span class="text-sm font-bold uppercase tracking-widest">Cumulative Revenue:</span>
                </div>
                <span class="text-3xl font-extrabold text-[#8B1C3A] tracking-tighter">{{ number_format($todaySalesTotal) }} <span class="text-sm font-normal text-gray-400">FCFA</span></span>
            </div>
        </div>
    </div>

    <!-- Register Sale Dialog -->
    <div x-show="isRegisterDialogOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
        <div @click="isRegisterDialogOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-md animate-fade-in"></div>
        <div class="relative w-full max-w-xl bg-white rounded-3xl shadow-2xl overflow-hidden animate-zoom-in">
            <div class="p-8 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Register Transaction</h2>
                    <p class="text-xs text-gray-500 mt-1">Finalize the payment process for a completed order</p>
                </div>
                <button @click="isRegisterDialogOpen = false" class="p-2 hover:bg-gray-100 rounded-full transition-colors text-gray-400"><i data-lucide="x" class="w-6 h-6"></i></button>
            </div>

            <form action="{{ route('sales.store') }}" method="POST" class="p-8 space-y-6">
                @csrf
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Select Completed Order</label>
                    <div class="relative">
                        <select name="order_id" x-model="selectedOrderId" required class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-[#8B1C3A]/10 outline-none transition-all appearance-none font-bold text-gray-800">
                            <option value="">-- Choose an Order --</option>
                            <template x-for="order in completedOrders" :key="order._id">
                                <option :value="order._id" x-text="'Order #' + order._id.substring(order._id.length - 6) + ' (' + Number(order.total_price).toLocaleString() + ' FCFA)'"></option>
                            </template>
                        </select>
                        <i data-lucide="chevron-down" class="absolute right-5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none"></i>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Settlement Amount</label>
                        <div class="relative">
                            <input type="number" name="amount" x-model="selectedSale.amount" required class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-[#8B1C3A]/10 outline-none transition-all font-bold text-gray-800">
                            <span class="absolute right-5 top-1/2 -translate-y-1/2 text-[10px] font-bold text-gray-400">FCFA</span>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Payment Method</label>
                        <div class="relative">
                            <select name="payment_method" required class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-[#8B1C3A]/10 outline-none transition-all appearance-none font-bold text-gray-800">
                                <option value="Cash">Cash Settlement</option>
                                <option value="Card">Credit/Debit Card</option>
                                <option value="Mobile Money">Mobile Money (OM/MoMo)</option>
                                <option value="Transfer">Bank Transfer</option>
                            </select>
                            <i data-lucide="chevron-down" class="absolute right-5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none"></i>
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full py-5 bg-[#8B1C3A] text-white font-extrabold rounded-2xl hover:bg-[#a01c3a] shadow-2xl shadow-[#8B1C3A]/30 transition-all active:scale-[0.98] flex items-center justify-center space-x-3 text-lg">
                        <i data-lucide="check-circle-2" class="w-6 h-6"></i>
                        <span>Register & Close Transaction</span>
                    </button>
                    <p class="text-center text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-4">This action will finalize the order and log the revenue</p>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
@keyframes fade-in { from { opacity: 0; } to { opacity: 1; } }
@keyframes zoom-in { from { opacity: 0; transform: scale(0.98) translateY(10px); } to { opacity: 1; transform: scale(1) translateY(0); } }
.animate-fade-in { animation: fade-in 0.3s ease-out; }
.animate-zoom-in { animation: zoom-in 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
</style>
@endsection
