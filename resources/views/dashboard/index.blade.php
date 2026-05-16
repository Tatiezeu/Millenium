@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
<div class="space-y-6" x-data="{ isNewOrderModalOpen: false, isAddStaffModalOpen: false }">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-gray-500">Total Staff</h3>
                <div class="bg-blue-500 p-2 rounded-lg">
                    <i data-lucide="users" class="h-4 w-4 text-white"></i>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900 mb-1">{{ $totalStaff }}</div>
            <p class="text-xs text-gray-400">Manage all accounts</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-gray-500">Active Orders</h3>
                <div class="bg-[#8B1C3A] p-2 rounded-lg">
                    <i data-lucide="shopping-bag" class="h-4 w-4 text-white"></i>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900 mb-1">{{ $activeOrders }}</div>
            <p class="text-xs text-gray-400">Orders in progress</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-gray-500">Today's Revenue</h3>
                <div class="bg-green-500 p-2 rounded-lg">
                    <i data-lucide="dollar-sign" class="h-4 w-4 text-white"></i>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900 mb-1">{{ number_format($todayRevenue) }} FCFA</div>
            <p class="text-xs text-gray-400">Delivered orders today</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-gray-500">Available Tables</h3>
                <div class="bg-[#ffd700] p-2 rounded-lg">
                    <i data-lucide="trending-up" class="h-4 w-4 text-[#8B1C3A]"></i>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900 mb-1">{{ $availableTablesCount }}/{{ $totalTables }}</div>
            <p class="text-xs text-gray-400">Tables ready for guests</p>
        </div>
    </div>

    <!-- Orders & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Orders -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50">
                <h3 class="font-bold text-gray-900">Recent Orders</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($recentOrders as $order)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center space-x-2 mb-1">
                                    <span class="text-sm font-semibold text-gray-900">#{{ substr($order->id, -6) }}</span>
                                    <span class="text-xs text-gray-500">• {{ $order->table->name ?? 'N/A' }}</span>
                                </div>
                                <p class="text-sm text-gray-600 truncate">{{ $order->items_summary }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $order->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-medium 
                                {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : 
                                   ($order->status === 'preparing' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-4">No recent orders.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Upcoming Reservations -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50">
                <h3 class="font-bold text-gray-900">Upcoming Reservations</h3>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    @forelse($upcomingReservations as $res)
                        <div class="flex items-center justify-between p-3 border border-gray-100 rounded-lg">
                            <div class="flex items-center space-x-4">
                                <div class="text-center min-w-[60px]">
                                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">{{ date('M d', strtotime($res->reservation_date)) }}</p>
                                    <p class="text-sm font-semibold text-gray-700">{{ $res->reservation_time }}</p>
                                </div>
                                <div class="h-8 w-px bg-gray-100"></div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $res->user->name ?? $res->guest_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $res->guest_count }} guests • {{ $res->table->name ?? 'TBD' }}</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ ucfirst($res->status) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-4">No upcoming reservations.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <!-- New Order Modal -->
    <div x-show="isNewOrderModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
        <div @click="isNewOrderModalOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>
        <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">Place New Order</h2>
                <button @click="isNewOrderModalOpen = false"><i data-lucide="x" class="w-6 h-6 text-gray-400"></i></button>
            </div>
            <form class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Table Number</label>
                        <select class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                            <option>Table 1</option>
                            <option>Table 2</option>
                            <option>Table 3</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Customer Name (Optional)</label>
                        <input type="text" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Select Items</label>
                    <div class="h-48 overflow-y-auto border border-gray-100 rounded-xl p-2 space-y-2">
                        <label class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-lg cursor-pointer">
                            <span class="text-sm">Grilled Salmon - 18,000 FCFA</span>
                            <input type="checkbox" class="rounded text-[#8B1C3A] focus:ring-[#8B1C3A]">
                        </label>
                        <label class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-lg cursor-pointer">
                            <span class="text-sm">Beef Steak - 22,000 FCFA</span>
                            <input type="checkbox" class="rounded text-[#8B1C3A] focus:ring-[#8B1C3A]">
                        </label>
                    </div>
                </div>
                <div class="flex justify-end pt-4">
                    <button type="submit" class="px-6 py-2.5 bg-[#8B1C3A] text-white font-bold rounded-xl hover:bg-[#a01c3a] transition-all">Submit Order</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Staff Modal -->
    <div x-show="isAddStaffModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
        <div @click="isAddStaffModalOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>
        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">Add Staff Account</h2>
                <button @click="isAddStaffModalOpen = false"><i data-lucide="x" class="w-6 h-6 text-gray-400"></i></button>
            </div>
            <form class="p-6 space-y-4">
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Full Name</label>
                    <input type="text" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Role</label>
                        <select class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                            <option>Cook</option>
                            <option>Waiter</option>
                            <option>Cashier</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Phone</label>
                        <input type="text" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Email Address</label>
                    <input type="email" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                </div>
                <div class="flex justify-end pt-4">
                    <button type="submit" class="px-6 py-2.5 bg-[#8B1C3A] text-white font-bold rounded-xl hover:bg-[#a01c3a] transition-all">Create Account</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Reservations -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50">
            <h3 class="font-bold text-gray-900">Today's Reservations</h3>
        </div>
        <div class="p-6">
            <div class="space-y-3">
                @forelse($todayReservations as $res)
                    <div class="flex items-center justify-between p-3 border border-gray-100 rounded-lg">
                        <div class="flex items-center space-x-4">
                            <div class="text-center min-w-[50px]">
                                <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">Time</p>
                                <p class="text-sm font-semibold text-gray-700">{{ $res->reservation_time }}</p>
                            </div>
                            <div class="h-8 w-px bg-gray-100"></div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $res->user->name ?? $res->guest_name }}</p>
                                <p class="text-xs text-gray-500">{{ $res->guest_count }} guests • {{ $res->table->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $res->status == 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($res->status) }}
                        </span>
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-4">No reservations for today.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
