{-- My Orders View --}
{-- This view handles the display and user interaction for My Orders. --}
@extends('layouts.dashboard')

@section('title', 'My Orders')
@section('page_title', 'My Orders')

@section('content')
@php
    $statusFlow = [
        'pending' => ['color' => 'bg-gray-100 text-gray-800', 'next' => 'confirmed', 'label' => 'Pending', 'action' => 'Confirm Order', 'icon' => 'clock', 'percent' => 10],
        'confirmed' => ['color' => 'bg-blue-100 text-blue-800', 'next' => 'preparing', 'label' => 'Confirmed', 'action' => 'Start Preparation', 'icon' => 'check-circle', 'percent' => 25],
        'preparing' => ['color' => 'bg-yellow-100 text-yellow-800', 'next' => 'ready', 'label' => 'Preparing', 'action' => 'Mark as Ready', 'icon' => 'utensils', 'percent' => 45],
        'ready' => ['color' => 'bg-indigo-100 text-indigo-800', 'next' => 'collected', 'label' => 'Ready for Collection', 'action' => 'Collect Order', 'icon' => 'bell', 'percent' => 60],
        'collected' => ['color' => 'bg-orange-100 text-orange-800', 'next' => 'out for delivery', 'label' => 'Collected', 'action' => 'Start Delivery', 'icon' => 'hand-holding', 'percent' => 75],
        'out for delivery' => ['color' => 'bg-purple-100 text-purple-800', 'next' => 'delivered', 'label' => 'Out for Delivery', 'action' => 'Mark Delivered', 'icon' => 'truck', 'percent' => 90],
        'served' => ['color' => 'bg-green-100 text-green-800', 'next' => 'completed', 'label' => 'Served', 'action' => 'Finalize Order', 'icon' => 'user-check', 'percent' => 100],
        'delivered' => ['color' => 'bg-green-100 text-green-800', 'next' => 'completed', 'label' => 'Delivered', 'action' => 'Finalize Order', 'icon' => 'home', 'percent' => 100],
        'completed' => ['color' => 'bg-emerald-100 text-emerald-800', 'next' => null, 'label' => 'Completed', 'action' => null, 'icon' => 'check-double', 'percent' => 100],
    ];

    $userRole = Auth::user()->role;
@endphp

<div class="space-y-6" x-data="{ 
    selectedOrder: null,
    isUpdating: false,
    async updateStatus(orderId, nextStatus, preparationTime = null) {
        if (!confirm('Confirm status update to ' + nextStatus + '?')) return;
        this.isUpdating = true;
        try {
            const body = { status: nextStatus };
            if (preparationTime) body.preparation_time = preparationTime;

            const response = await fetch(`/dashboard/orders/${orderId}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(body)
            });
            const data = await response.json();
            if (data.success) {
                window.location.reload();
            }
        } catch (error) {
            alert('Error updating status');
        } finally {
            this.isUpdating = false;
        }
    },
    isMessageOpen: false,
    messageRecipient: null,
    messageText: '',
    openMessageModal(user) {
        this.messageRecipient = user;
        this.isMessageOpen = true;
    },
    async sendMessage() {
        if (!this.messageText) return;
        try {
            const response = await fetch('{{ route('notifications.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    receiver_id: this.messageRecipient.id || this.messageRecipient._id,
                    message: this.messageText
                })
            });
            if (response.ok) {
                alert('Message sent to ' + this.messageRecipient.name);
                this.isMessageOpen = false;
                this.messageText = '';
            }
        } catch (e) {
            console.error(e);
        }
    }
}">
    @if($userRole !== 'client')
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-[#8B1C3A]/10 rounded-xl flex items-center justify-center">
                <i data-lucide="clipboard-list" class="w-6 h-6 text-[#8B1C3A]"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-900">Order Management</h3>
                <p class="text-xs text-gray-500">Handle orders according to your role: <span class="font-bold text-[#8B1C3A]">{{ ucfirst($userRole) }}</span></p>
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <span class="flex h-3 w-3 relative">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
            </span>
            <span class="text-xs font-bold text-gray-600">Live Updates</span>
        </div>
    </div>
    @endif

    <!-- Orders Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @forelse($orders as $order)
            @php
                $status = $order->status ?? 'pending';
                $config = $statusFlow[$status] ?? $statusFlow['pending'];
                
                // Determine if the current user can perform the next action
                $canAction = false;
                $nextStatus = $config['next'];
                $actionLabel = $config['action'];

                // Check if receiver_id is a role or "all_staff"
                $roles = ['waiter', 'client', 'cook', 'manager', 'restaurant manager'];
                if ($userRole === 'restaurant manager' || $userRole === 'manager') {
                    $canAction = in_array($status, ['pending', 'served', 'delivered']);
                } elseif ($userRole === 'cook') {
                    $canAction = in_array($status, ['confirmed', 'preparing']);
                } elseif ($userRole === 'waiter') {
                    if ($status === 'ready') {
                        $canAction = true;
                    } elseif ($status === 'collected') {
                        $canAction = true;
                        $nextStatus = 'served';
                        $actionLabel = 'Mark as Served';
                    }
                } elseif ($userRole === 'delivery') {
                    $canAction = in_array($status, ['ready', 'collected', 'out for delivery']);
                }
            @endphp

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-[#8B1C3A]">
                                <i data-lucide="hash" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">{{ substr($order->id, -6) }}</h3>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{ $order->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <span class="px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $config['color'] }}">
                            {{ $config['label'] }}
                        </span>
                    </div>

                    <div class="space-y-4 mb-6">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Customer</span>
                            <span class="font-bold text-gray-900">{{ $order->user->name ?? 'Guest' }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Location</span>
                            <span class="font-bold text-[#8B1C3A]">
                                @if($order->service_type === 'delivered')
                                    <i data-lucide="truck" class="w-3 h-3 inline mr-1"></i> Livraison ({{ $order->location ?? 'N/A' }})
                                @else
                                    <i data-lucide="utensils" class="w-3 h-3 inline mr-1"></i> Table {{ $order->table->title ?? 'À Table' }}
                                @endif
                            </span>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Order Items</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($order->items as $item)
                                    <span class="px-2 py-1 bg-white border border-gray-100 rounded-lg text-xs font-medium text-gray-600">
                                        {{ $item['qty'] }}x {{ $item['name'] }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        @if($order->notes && $order->notes !== 'Order from website')
                            <div class="p-4 bg-amber-50 border border-amber-100 rounded-xl">
                                <p class="text-[10px] font-bold text-amber-600 uppercase tracking-widest mb-1">Note de commande</p>
                                <p class="text-sm text-amber-800 italic">"{{ $order->notes }}"</p>
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                        <div class="text-lg font-bold text-gray-900">
                            {{ number_format($order->total_price) }} <span class="text-xs text-gray-400 font-normal">FCFA</span>
                        </div>
                        <div class="flex space-x-2">
                            @if($canAction && $nextStatus)
                                @if($userRole === 'cook' && $status === 'confirmed')
                                    <div class="flex items-center space-x-2" x-data="{ estTime: 20 }">
                                        <div class="relative w-24">
                                            <input type="number" x-model="estTime" class="w-full pl-3 pr-8 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold outline-none">
                                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] text-gray-400 font-bold">MIN</span>
                                        </div>
                                        <button @click="updateStatus('{{ $order->id }}', 'preparing', estTime)" 
                                                :disabled="isUpdating"
                                                class="px-4 py-2.5 bg-[#8B1C3A] text-white text-[10px] font-extrabold rounded-xl hover:bg-[#a01c3a] shadow-lg shadow-[#8B1C3A]/20">
                                            START COOKING
                                        </button>
                                    </div>
                                @else
                                    <button @click="updateStatus('{{ $order->id }}', '{{ $nextStatus }}')" 
                                            :disabled="isUpdating"
                                            class="px-6 py-2.5 bg-[#8B1C3A] text-white text-xs font-bold rounded-xl hover:bg-[#a01c3a] transition-all shadow-lg shadow-[#8B1C3A]/20 disabled:opacity-50">
                                        {{ $actionLabel }}
                                    </button>
                                @endif
                            @endif

                            @if($status !== 'completed' && $status !== 'cancelled' && (str_contains($userRole, 'manager')))
                                <button @click="updateStatus('{{ $order->id }}', 'cancelled')" 
                                        :disabled="isUpdating"
                                        class="px-4 py-2.5 bg-white border border-red-100 text-red-600 text-[10px] font-extrabold rounded-xl hover:bg-red-50 transition-all">
                                    CANCEL
                                </button>
                            @endif

                            @if($status !== 'completed' && $status !== 'cancelled' && ($userRole === 'restaurant manager' || $userRole === 'manager'))
                                <button @click="updateStatus('{{ $order->id }}', 'cancelled')" 
                                        :disabled="isUpdating"
                                        class="px-4 py-2.5 bg-white border border-red-100 text-red-600 text-xs font-bold rounded-xl hover:bg-red-50 transition-all">
                                    CANCEL
                                </button>
                            @endif

                            @if($order->user_id && $userRole !== 'client')
                                <button @click="openMessageModal({{ json_encode($order->user) }})" class="p-2.5 bg-[#8B1C3A]/5 border border-[#8B1C3A]/10 rounded-xl hover:bg-[#8B1C3A]/10 text-[#8B1C3A] transition-all" title="Message Client">
                                    <i data-lucide="message-square" class="w-5 h-5"></i>
                                </button>
                            @endif

                            <button @click="selectedOrder = {{ json_encode($order) }}" class="p-2.5 border border-gray-100 rounded-xl hover:bg-gray-50 text-gray-400 transition-all">
                                <i data-lucide="maximize-2" class="w-5 h-5"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="h-1.5 w-full bg-gray-100 relative">
                    <div class="h-full bg-[#8B1C3A] transition-all duration-1000" style="width: {{ $config['percent'] }}%"></div>
                    <div class="absolute right-4 -top-8 text-[10px] font-extrabold text-[#8B1C3A] bg-[#8B1C3A]/5 px-2 py-1 rounded-md border border-[#8B1C3A]/10">
                        {{ $config['percent'] }}% TRACKING
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="shopping-bag" class="w-10 h-10 text-gray-200"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900">No active orders</h3>
                <p class="text-gray-500 text-sm max-w-xs mx-auto">Orders will appear here once they are placed or assigned to you.</p>
            </div>
        @endforelse
    </div>

    <!-- Details Modal -->
    <template x-if="selectedOrder">
        <div class="fixed inset-0 z-[200] flex items-center justify-center p-6" x-cloak>
            <div @click="selectedOrder = null" class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>
            <div class="relative w-full max-w-xl bg-white rounded-3xl shadow-2xl overflow-hidden">
                <div class="p-8 border-b border-gray-100 flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-[#8B1C3A] rounded-2xl flex items-center justify-center text-white">
                            <i data-lucide="shopping-cart" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900" x-text="'Order ' + selectedOrder._id.substring(selectedOrder._id.length - 6)"></h2>
                            <p class="text-xs text-gray-500 mt-1" x-text="selectedOrder.created_at"></p>
                        </div>
                    </div>
                    <button @click="selectedOrder = null" class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                        <i data-lucide="x" class="w-6 h-6 text-gray-400"></i>
                    </button>
                </div>
                
                <div class="p-8 space-y-8">
                    <!-- Status Timeline -->
                    <div class="flex items-center justify-between">
                        <template x-for="(step, index) in ['pending', 'preparing', 'ready', 'delivered', 'completed']" :key="step">
                            <div class="flex flex-col items-center space-y-2">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-[10px] font-bold transition-all"
                                     :class="selectedOrder.status === step ? 'bg-[#8B1C3A] text-white shadow-lg ring-4 ring-[#8B1C3A]/10' : 'bg-gray-100 text-gray-400'">
                                    <span x-text="index + 1"></span>
                                </div>
                                <span class="text-[9px] font-bold uppercase tracking-tighter" :class="selectedOrder.status === step ? 'text-[#8B1C3A]' : 'text-gray-400'" x-text="step"></span>
                            </div>
                        </template>
                    </div>

                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Items Details</h4>
                        <div class="space-y-3">
                            <template x-for="item in selectedOrder.items" :key="item.name">
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl">
                                    <div class="flex items-center space-x-3">
                                        <span class="w-8 h-8 bg-white rounded-lg flex items-center justify-center font-bold text-[#8B1C3A] text-xs shadow-sm" x-text="item.qty + 'x'"></span>
                                        <span class="font-bold text-gray-800 text-sm" x-text="item.name"></span>
                                    </div>
                                    <span class="font-bold text-gray-500 text-sm" x-text="(item.price * item.qty).toLocaleString() + ' FCFA'"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="p-6 bg-gray-900 rounded-2xl flex items-center justify-between text-white">
                        <div>
                            <p class="text-xs text-gray-400 font-medium">Total Amount</p>
                            <p class="text-2xl font-bold" x-text="Number(selectedOrder.total_price).toLocaleString() + ' FCFA'"></p>
                        </div>
                        <i data-lucide="receipt" class="w-8 h-8 text-gray-700"></i>
                    </div>
                </div>
                
                <div class="p-8 bg-gray-50 border-t border-gray-100">
                    <div class="flex pt-6 border-t border-gray-100 space-x-4">
                        <a :href="'/dashboard/orders/' + selectedOrder.id + '/receipt'" target="_blank" class="flex-1 py-4 bg-gray-900 text-white font-bold rounded-2xl hover:bg-black transition-all flex items-center justify-center shadow-lg">
                            <i data-lucide="printer" class="w-5 h-5 mr-2"></i>
                            PRINT RECEIPT (PDF)
                        </a>
                        <button @click="selectedOrder = null" class="flex-1 py-4 bg-gray-50 text-gray-500 font-bold rounded-2xl hover:bg-gray-100 transition-all">
                            Close Details
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>
    <!-- Quick Message Modal -->
    <template x-if="messageRecipient">
        <div x-show="isMessageOpen" class="fixed inset-0 z-[300] flex items-center justify-center p-6" x-cloak>
            <div @click="isMessageOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>
            <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden animate-zoom-in">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-gray-900">Message to <span x-text="messageRecipient.name"></span></h3>
                    <button @click="isMessageOpen = false"><i data-lucide="x" class="w-6 h-6 text-gray-400"></i></button>
                </div>
                <div class="p-6 space-y-4">
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Your Message</label>
                        <textarea x-model="messageText" rows="4" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none resize-none" placeholder="Type instructions or updates for the client..."></textarea>
                    </div>
                    <button @click="sendMessage()" class="w-full py-4 bg-[#8B1C3A] text-white font-bold rounded-2xl hover:bg-[#a01c3a] transition-all shadow-lg flex items-center justify-center">
                        <i data-lucide="send" class="w-5 h-5 mr-2"></i>
                        Send Message
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>
@endsection
