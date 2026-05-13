@extends('layouts.dashboard')

@section('title', 'Orders')
@section('page_title', 'Orders')

@section('content')
<div class="space-y-6" x-data="{ 
    selectedOrder: null,
    updateStatus(orderId, currentStatus) {
        let nextStatus = '';
        if(currentStatus === 'Preparing') nextStatus = 'Ready';
        else if(currentStatus === 'Ready') nextStatus = 'Delivered';
        else if(currentStatus === 'Pending') nextStatus = 'Preparing';
        
        alert('Order ' + orderId + ' status updated to ' + nextStatus);
    },
    printOrder(orderId) {
        alert('Generating PDF Receipt for ' + orderId + '...');
        // Simulation of PDF print redirect
    }
}">
    <!-- Top Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @php
            $orderStats = [
                ['title' => 'Total Orders', 'value' => '4', 'color' => 'text-gray-900'],
                ['title' => 'Pending', 'value' => '1', 'color' => 'text-gray-500'],
                ['title' => 'Preparing', 'value' => '1', 'color' => 'text-yellow-600'],
                ['title' => 'Ready', 'value' => '1', 'color' => 'text-green-600'],
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
                @php
                    $orders = [
                        [
                            'id' => '#ORD-001', 'table' => 'Table 5', 'customer' => 'John Doe', 'status' => 'Preparing', 'time' => '5 min ago', 'notes' => 'No onions please',
                            'items' => [['name' => 'Grilled Salmon', 'qty' => 1, 'price' => '18,000'], ['name' => 'Red Wine', 'qty' => 1, 'price' => '15,000']],
                            'total' => '33,000', 'color' => 'bg-yellow-100 text-yellow-800'
                        ],
                        [
                            'id' => '#ORD-002', 'table' => 'Table 12', 'customer' => 'Jane Smith', 'status' => 'Ready', 'time' => '8 min ago', 'notes' => '',
                            'items' => [['name' => 'Beef Steak', 'qty' => 1, 'price' => '22,000'], ['name' => 'Caesar Salad', 'qty' => 1, 'price' => '8,000']],
                            'total' => '30,000', 'color' => 'bg-green-100 text-green-800'
                        ],
                    ];
                @endphp

                @foreach($orders as $order)
                    <div class="border border-gray-100 rounded-xl p-6 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <div class="flex items-center space-x-3">
                                    <h3 class="text-sm font-bold text-gray-900">{{ $order['id'] }}</h3>
                                    <span class="text-sm text-gray-500 font-medium">• {{ $order['table'] }}</span>
                                    <span class="text-sm text-gray-500 font-medium">• {{ $order['customer'] }}</span>
                                </div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase mt-1 tracking-wider">{{ $order['time'] }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $order['color'] }}">
                                {{ $order['status'] }}
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
                                    @foreach($order['items'] as $item)
                                        <tr>
                                            <td class="py-2 text-gray-700 font-medium">{{ $item['name'] }}</td>
                                            <td class="py-2 text-center text-gray-600">{{ $item['qty'] }}</td>
                                            <td class="py-2 text-right font-semibold text-gray-900">{{ $item['price'] }} FCFA</td>
                                        </tr>
                                    @endforeach
                                    <tr class="border-t-2 border-gray-300">
                                        <td class="pt-3 font-bold text-gray-900" colspan="2">Total</td>
                                        <td class="pt-3 text-right font-bold text-[#8B1C3A] text-lg">{{ $order['total'] }} FCFA</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="flex space-x-3">
                            @if($order['status'] === 'Preparing')
                                <button @click="updateStatus('{{ $order['id'] }}', 'Preparing')" class="px-4 py-2 bg-blue-600 text-white text-sm font-bold rounded-lg hover:bg-blue-700 transition-all">
                                    Mark as Ready
                                </button>
                            @elseif($order['status'] === 'Ready')
                                <button @click="updateStatus('{{ $order['id'] }}', 'Ready')" class="px-4 py-2 bg-green-600 text-white text-sm font-bold rounded-lg hover:bg-green-700 transition-all">
                                    Mark as Delivered
                                </button>
                            @endif
                            <button @click="selectedOrder = {{ json_encode($order) }}" class="px-4 py-2 border-2 border-gray-100 text-gray-500 text-sm font-bold rounded-lg hover:bg-gray-50 transition-all">
                                View Details
                            </button>
                        </div>
                    </div>
                @endforeach
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
                        <h2 class="text-xl font-bold text-gray-900" x-text="'Order ' + selectedOrder.id"></h2>
                        <p class="text-xs text-gray-500 mt-1" x-text="selectedOrder.customer + ' • ' + selectedOrder.table"></p>
                    </div>
                    <button @click="selectedOrder = null"><i data-lucide="x" class="w-6 h-6 text-gray-400"></i></button>
                </div>
                <div class="p-6 space-y-6">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-gray-400 uppercase tracking-widest">Status</span>
                        <span class="px-3 py-1 rounded-full text-xs font-bold" :class="selectedOrder.color" x-text="selectedOrder.status"></span>
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
                                    <span class="font-semibold text-gray-900" x-text="item.price + ' FCFA'"></span>
                                </div>
                            </template>
                        </div>
                        <div class="mt-4 pt-4 border-t-2 border-gray-50 flex justify-between items-center">
                            <span class="font-bold text-gray-900">Total Amount</span>
                            <span class="text-lg font-bold text-[#8B1C3A]" x-text="selectedOrder.total + ' FCFA'"></span>
                        </div>
                    </div>

                    <template x-if="selectedOrder.notes">
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg">
                            <p class="text-[10px] text-blue-700 font-bold mb-1 uppercase tracking-wider">Kitchen Notes</p>
                            <p class="text-sm text-gray-600" x-text="selectedOrder.notes"></p>
                        </div>
                    </template>
                </div>
                <div class="p-6 bg-gray-50 border-t border-gray-100 flex space-x-3">
                    <button @click="selectedOrder = null" class="flex-1 py-2.5 bg-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-300 transition-all">Close</button>
                    <button @click="printOrder(selectedOrder.id)" class="flex-1 py-2.5 bg-[#8B1C3A] text-white font-bold rounded-xl hover:bg-[#a01c3a] transition-all">Print Receipt</button>
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
