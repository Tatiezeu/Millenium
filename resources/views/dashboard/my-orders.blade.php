@extends('layouts.dashboard')

@section('title', 'My Orders')
@section('page_title', 'My Orders')

@section('content')
<div class="space-y-6" x-data="{ 
    selectedOrder: null,
    updateStatus(orderId, currentStatus) {
        let nextStatus = '';
        if(currentStatus.includes('Ready')) nextStatus = 'Picked Up';
        else nextStatus = 'Ready';
        
        alert('Order ' + orderId + ' status updated to ' + nextStatus);
    },
    printTicket(orderId) {
        alert('Generating PDF Ticket for ' + orderId + '...');
        // Simulation of PDF print redirect
    }
}">
    <div class="bg-blue-50 border border-blue-100 p-6 rounded-xl">
        <p class="text-sm text-blue-800 font-medium leading-relaxed">
            This view shows orders assigned to you based on your role. Waiters see orders ready for pickup, 
            Cooks see orders to prepare, and Delivery staff see orders to deliver.
        </p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @php
            $myStats = [
                ['title' => 'My Active Orders', 'value' => '3', 'color' => 'text-gray-900'],
                ['title' => 'In Progress', 'value' => '2', 'color' => 'text-yellow-600'],
                ['title' => 'Ready', 'value' => '1', 'color' => 'text-green-600'],
            ];
        @endphp
        @foreach($myStats as $stat)
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-sm font-medium text-gray-500 mb-2">{{ $stat['title'] }}</h3>
                <div class="text-3xl font-bold {{ $stat['color'] }}">{{ $stat['value'] }}</div>
            </div>
        @endforeach
    </div>

    <!-- Orders -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50">
            <h3 class="font-bold text-gray-900">My Orders</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @php
                    $myOrders = [
                        ['id' => '#ORD-001', 'assigned' => 'Waiter - Mike Johnson', 'loc' => 'Table 5', 'items' => ['Grilled Salmon', 'Red Wine'], 'status' => 'Ready for Pickup', 'time' => '2 min ago'],
                        ['id' => '#ORD-003', 'assigned' => 'Cook - Sarah Chen', 'loc' => 'Table 3', 'items' => ['Pasta Carbonara x2'], 'status' => 'In Preparation', 'time' => '8 min ago'],
                    ];
                @endphp
                @foreach($myOrders as $order)
                    <div class="border border-gray-100 rounded-xl p-6 hover:bg-gray-50/30 transition-all">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 mb-1">{{ $order['id'] }}</h3>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $order['assigned'] }}</p>
                                <p class="text-[10px] font-medium text-gray-400 mt-1">{{ $order['time'] }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ str_contains($order['status'], 'Ready') ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $order['status'] }}
                            </span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl mb-4 text-sm">
                            <p class="mb-2"><span class="font-bold text-gray-400 uppercase text-[10px] tracking-widest mr-2">Location:</span> <span class="font-bold text-gray-700">{{ $order['loc'] }}</span></p>
                            <p><span class="font-bold text-gray-400 uppercase text-[10px] tracking-widest mr-2">Items:</span> <span class="font-semibold text-gray-600">{{ implode(', ', $order['items']) }}</span></p>
                        </div>
                        <div class="flex space-x-3">
                            @if(str_contains($order['status'], 'Ready'))
                                <button @click="updateStatus('{{ $order['id'] }}', '{{ $order['status'] }}')" class="px-5 py-2 bg-[#8B1C3A] text-white text-xs font-bold rounded-lg hover:bg-[#a01c3a] transition-all">Mark as Picked Up</button>
                            @else
                                <button @click="updateStatus('{{ $order['id'] }}', '{{ $order['status'] }}')" class="px-5 py-2 bg-green-600 text-white text-xs font-bold rounded-lg hover:bg-green-700 transition-all">Mark as Ready</button>
                            @endif
                            <button @click="selectedOrder = {{ json_encode($order) }}" class="px-5 py-2 border-2 border-gray-100 text-gray-500 text-xs font-bold rounded-lg hover:bg-white transition-all">View Details</button>
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
                        <p class="text-xs text-gray-500 mt-1" x-text="selectedOrder.assigned + ' • ' + selectedOrder.loc"></p>
                    </div>
                    <button @click="selectedOrder = null"><i data-lucide="x" class="w-6 h-6 text-gray-400"></i></button>
                </div>
                <div class="p-6 space-y-6">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-gray-400 uppercase tracking-widest">Status</span>
                        <span class="px-3 py-1 rounded-full text-xs font-bold" :class="selectedOrder.status.includes('Ready') ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'" x-text="selectedOrder.status"></span>
                    </div>

                    <div>
                        <h3 class="text-sm font-bold text-gray-900 mb-3">Items to Handle</h3>
                        <div class="space-y-3">
                            <template x-for="item in selectedOrder.items" :key="item">
                                <div class="flex items-center space-x-3 text-sm">
                                    <span class="w-2 h-2 bg-[#8B1C3A] rounded-full"></span>
                                    <span class="text-gray-700 font-medium" x-text="item"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-gray-50 border-t border-gray-100 flex space-x-3">
                    <button @click="selectedOrder = null" class="flex-1 py-2.5 bg-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-300 transition-all">Close</button>
                    <button @click="printTicket(selectedOrder.id)" class="flex-1 py-2.5 bg-[#8B1C3A] text-white font-bold rounded-xl hover:bg-[#a01c3a] transition-all">Print Ticket</button>
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
