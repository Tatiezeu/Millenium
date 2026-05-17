{-- Orders View --}
{-- This view handles the display and user interaction for Orders. --}
@extends('layouts.dashboard')

@section('title', 'Orders')
@section('page_title', 'Orders')

@section('content')
<div class="space-y-6" x-data="{ 
    selectedOrder: null,
    async updateStatus(orderId, nextStatus) {
        try {
            const response = await fetch(`/dashboard/orders/${orderId}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: nextStatus })
            });
            const data = await response.json();
            if (data.success) {
                $dispatch('toast', { message: 'Order status updated to ' + nextStatus, type: 'success' });
                location.reload();
            }
        } catch (error) {
            console.error('Error:', error);
        }
    },
    printOrder(orderId) {
        alert('Generating PDF Receipt for ' + orderId + '...');
    }
}">
    <!-- Top Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @php
            $total = $orders->count();
            $pending = $orders->where('status', 'pending')->count();
            $preparing = $orders->where('status', 'preparing')->count();
            $ready = $orders->where('status', 'ready')->count();
            
            $orderStats = [
                ['title' => 'Total Orders', 'value' => $total, 'color' => 'text-gray-900'],
                ['title' => 'Pending', 'value' => $pending, 'color' => 'text-gray-500'],
                ['title' => 'Preparing', 'value' => $preparing, 'color' => 'text-yellow-600'],
                ['title' => 'Ready', 'value' => $ready, 'color' => 'text-green-600'],
            ];
        @endphp

        @foreach($orderStats as $stat)
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-sm font-medium text-gray-500 mb-2">{{ $stat['title'] }}</h3>
                <div class="text-3xl font-bold {{ $stat['color'] }}">{{ $stat['value'] }}</div>
            </div>
        @endforeach
    </div>

    <!-- Orders List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50">
            <h3 class="font-bold text-gray-900">All Orders</h3>
        </div>
        <div class="p-6">
            <div class="space-y-6">
                @forelse($orders as $order)
                    <div class="border border-gray-100 rounded-xl p-6 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <div class="flex items-center space-x-3">
                                    <h3 class="text-sm font-bold text-gray-900">ORD-{{ substr($order->id, -5) }}</h3>
                                    <span class="text-sm text-gray-500 font-medium">• {{ $order->table->name ?? 'Takeaway' }}</span>
                                    <span class="text-sm text-gray-500 font-medium">• {{ $order->user->name ?? 'Guest Customer' }}</span>
                                </div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase mt-1 tracking-wider">{{ $order->created_at->diffForHumans() }}</p>
                            </div>
                            @php
                                $statusColors = [
                                    'pending' => 'bg-gray-100 text-gray-800',
                                    'preparing' => 'bg-yellow-100 text-yellow-800',
                                    'ready' => 'bg-green-100 text-green-800',
                                    'delivered' => 'bg-blue-100 text-blue-800',
                                ];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusColors[$order->status] ?? 'bg-gray-100' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4 mb-4">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                        <th class="pb-3">Item</th>
                                        <th class="pb-3 text-center">Qty</th>
                                        <th class="pb-3 text-right">Price</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td class="py-2 text-gray-700 font-medium">{{ $item['name'] }}</td>
                                            <td class="py-2 text-center text-gray-600">{{ $item['qty'] }}</td>
                                            <td class="py-2 text-right font-semibold text-gray-900">{{ number_format($item['price']) }} FCFA</td>
                                        </tr>
                                    @endforeach
                                    <tr class="border-t-2 border-gray-300">
                                        <td class="pt-3 font-bold text-gray-900" colspan="2">Total</td>
                                        <td class="pt-3 text-right font-bold text-[#8B1C3A] text-lg">{{ number_format($order->total_price) }} FCFA</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="flex space-x-3">
                            @if($order->status === 'pending')
                                <button @click="updateStatus('{{ $order->id }}', 'preparing')" class="px-4 py-2 bg-yellow-600 text-white text-sm font-bold rounded-lg hover:bg-yellow-700 transition-all">
                                    Start Preparing
                                </button>
                            @elseif($order->status === 'preparing')
                                <button @click="updateStatus('{{ $order->id }}', 'ready')" class="px-4 py-2 bg-green-600 text-white text-sm font-bold rounded-lg hover:bg-green-700 transition-all">
                                    Mark as Ready
                                </button>
                            @elseif($order->status === 'ready')
                                <button @click="updateStatus('{{ $order->id }}', 'delivered')" class="px-4 py-2 bg-blue-600 text-white text-sm font-bold rounded-lg hover:bg-blue-700 transition-all">
                                    Mark as Delivered
                                </button>
                            @endif
                            <button @click="selectedOrder = {{ json_encode($order) }}" class="px-4 py-2 border-2 border-gray-100 text-gray-500 text-sm font-bold rounded-lg hover:bg-gray-50 transition-all">
                                View Details
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <div class="p-4 bg-gray-50 rounded-full inline-block mb-4">
                            <i data-lucide="shopping-bag" class="h-8 w-8 text-gray-400"></i>
                        </div>
                        <h3 class="text-gray-900 font-bold">No orders yet</h3>
                        <p class="text-gray-500 text-sm">When clients place orders, they will appear here.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Order Details Modal -->
    <template x-if="selectedOrder">
        <div class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
            <div @click="selectedOrder = null" class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>
            <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden animate-zoomIn">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900" x-text="'Order ORD-' + selectedOrder._id.substring(selectedOrder._id.length - 5)"></h2>
                        <p class="text-xs text-gray-500 mt-1" x-text="(selectedOrder.user ? selectedOrder.user.name : 'Guest') + ' • ' + (selectedOrder.table ? selectedOrder.table.name : 'Takeaway')"></p>
                    </div>
                    <button @click="selectedOrder = null"><i data-lucide="x" class="w-6 h-6 text-gray-400"></i></button>
                </div>
                <div class="p-6 space-y-6">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-gray-400 uppercase tracking-widest">Status</span>
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800" x-text="selectedOrder.status.toUpperCase()"></span>
                    </div>

                    <div>
                        <h3 class="text-sm font-bold text-gray-900 mb-3">Order Items</h3>
                        <div class="space-y-3">
                            <template x-for="item in selectedOrder.items" :key="item.name">
                                <div class="flex justify-between items-center text-sm">
                                    <div class="flex items-center space-x-2">
                                        <span class="w-6 h-6 flex items-center justify-center bg-gray-100 rounded text-[10px] font-bold" x-text="item.qty"></span>
                                        <span class="text-gray-700 font-medium" x-text="item.name"></span>
                                    </div>
                                    <span class="font-semibold text-gray-900" x-text="item.price.toLocaleString() + ' FCFA'"></span>
                                </div>
                            </template>
                        </div>
                        <div class="mt-4 pt-4 border-t-2 border-gray-50 flex justify-between items-center">
                            <span class="font-bold text-gray-900">Total Amount</span>
                            <span class="text-lg font-bold text-[#8B1C3A]" x-text="selectedOrder.total_price.toLocaleString() + ' FCFA'"></span>
                        </div>
                    </div>

                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg" x-show="selectedOrder.notes">
                        <p class="text-[10px] text-blue-700 font-bold mb-1 uppercase tracking-wider">Kitchen Notes</p>
                        <p class="text-sm text-gray-600" x-text="selectedOrder.notes || 'No specific notes'"></p>
                    </div>
                </div>
                <div class="p-6 bg-gray-50 border-t border-gray-100 flex space-x-3">
                    <button @click="selectedOrder = null" class="flex-1 py-2.5 bg-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-300 transition-all">Close</button>
                    <button @click="printOrder(selectedOrder._id)" class="flex-1 py-2.5 bg-[#8B1C3A] text-white font-bold rounded-xl hover:bg-[#a01c3a] transition-all">Print Receipt</button>
                </div>
            </div>
        </div>
    </template>
</div>

<style>
@keyframes zoomIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
.animate-zoomIn { animation: zoomIn 0.3s ease-out; }
</style>
@endsection
