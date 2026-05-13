@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
<div class="space-y-6" x-data="{ isNewOrderModalOpen: false, isAddStaffModalOpen: false }">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
             $stats = [
                ['title' => 'Total Staff', 'value' => '24', 'icon' => 'users', 'color' => 'bg-blue-500', 'trend' => '+2 this month'],
                ['title' => 'Active Orders', 'value' => '18', 'icon' => 'shopping-bag', 'color' => 'bg-[#8B1C3A]', 'trend' => '3 preparing'],
                ['title' => 'Today\'s Revenue', 'value' => ' 245,000 FCFA', 'icon' => 'dollar-sign', 'color' => 'bg-green-500', 'trend' => '+12% from yesterday'],
                ['title' => 'Active Tables', 'value' => '12/20', 'icon' => 'trending-up', 'color' => 'bg-[#ffd700]', 'text_color' => 'text-[#8B1C3A]', 'trend' => '60% occupied'],
            ];
        @endphp

        @foreach( $stats as  $stat)
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium text-gray-500">{{  $stat['title'] }}</h3>
                    <div class="{{  $stat['color'] }} p-2 rounded-lg">
                        <i data-lucide="{{  $stat['icon'] }}" class="h-4 w-4 {{  $stat['text_color'] ?? 'text-white' }}"></i>
                    </div>
                </div>
                <div class="text-2xl font-bold text-gray-900 mb-1">{{  $stat['value'] }}</div>
                <p class="text-xs text-gray-400">{{  $stat['trend'] }}</p>
            </div>
        @endforeach
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
                    @php
                         $recentOrders = [
                            ['id' => '#ORD-001', 'table' => 'Table 5', 'items' => 'Grilled Salmon, Wine', 'status' => 'Preparing', 'time' => '5 min ago', 'color' => 'bg-yellow-100 text-yellow-800'],
                            ['id' => '#ORD-002', 'table' => 'Table 12', 'items' => 'Steak Medium Rare, Salad', 'status' => 'Ready', 'time' => '8 min ago', 'color' => 'bg-green-100 text-green-800'],
                            ['id' => '#ORD-003', 'table' => 'Table 3', 'items' => 'Pasta Carbonara, Dessert', 'status' => 'Pending', 'time' => '12 min ago', 'color' => 'bg-gray-100 text-gray-800'],
                            ['id' => '#ORD-004', 'table' => 'Table 8', 'items' => 'Lobster Bisque, Champagne', 'status' => 'Delivered', 'time' => '20 min ago', 'color' => 'bg-blue-100 text-blue-800'],
                        ];
                    @endphp

                    @foreach( $recentOrders as  $order)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center space-x-2 mb-1">
                                    <span class="text-sm font-semibold text-gray-900">{{  $order['id'] }}</span>
                                    <span class="text-xs text-gray-500">• {{  $order['table'] }}</span>
                                </div>
                                <p class="text-sm text-gray-600 truncate">{{  $order['items'] }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{  $order['time'] }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-medium {{  $order['color'] }}">
                                {{  $order['status'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50">
                <h3 class="font-bold text-gray-900">Quick Actions</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4">
                    <button @click="isNewOrderModalOpen = true" class="flex flex-col items-center justify-center p-4 bg-[#8B1C3A] text-white rounded-lg hover:bg-[#a01c3a] transition-colors">
                        <i data-lucide="shopping-bag" class="h-6 w-6 mb-2"></i>
                        <span class="text-sm font-medium">New Order</span>
                    </button>
                    <button @click="isAddStaffModalOpen = true" class="flex flex-col items-center justify-center p-4 bg-[#ffd700] text-[#8B1C3A] rounded-lg hover:bg-[#ffed4e] transition-colors">
                        <i data-lucide="user-plus" class="h-6 w-6 mb-2"></i>
                        <span class="text-sm font-medium">Add Staff</span>
                    </button>
                    <a href="/dashboard/reservations" class="flex flex-col items-center justify-center p-4 border-2 border-[#8B1C3A] text-[#8B1C3A] rounded-lg hover:bg-[#8B1C3A] hover:text-white transition-colors group text-center">
                        <i data-lucide="calendar" class="h-6 w-6 mb-2 group-hover:text-white"></i>
                        <span class="text-sm font-medium">Reservations</span>
                    </a>
                    <a href="/dashboard/reports" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-center">
                        <i data-lucide="file-text" class="h-6 w-6 mb-2"></i>
                        <span class="text-sm font-medium">View Reports</span>
                    </a>
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
                @php
                     $reservations = [
                        ['time' => '18:00', 'name' => 'Alice Johnson', 'guests' => 4, 'table' => 'Table 7', 'status' => 'Confirmed'],
                        ['time' => '19:00', 'name' => 'Robert Smith', 'guests' => 2, 'table' => 'Table 3', 'status' => 'Confirmed'],
                        ['time' => '19:30', 'name' => 'Emma Davis', 'guests' => 6, 'table' => 'Table 15', 'status' => 'Pending'],
                        ['time' => '20:00', 'name' => 'Michael Brown', 'guests' => 3, 'table' => 'Table 10', 'status' => 'Confirmed'],
                    ];
                @endphp

                @foreach( $reservations as  $res)
                    <div class="flex items-center justify-between p-3 border border-gray-100 rounded-lg">
                        <div class="flex items-center space-x-4">
                            <div class="text-center min-w-[50px]">
                                <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">Time</p>
                                <p class="text-sm font-semibold text-gray-700">{{  $res['time'] }}</p>
                            </div>
                            <div class="h-8 w-px bg-gray-100"></div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{  $res['name'] }}</p>
                                <p class="text-xs text-gray-500">{{  $res['guests'] }} guests • {{  $res['table'] }}</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{  $res['status'] == 'Confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{  $res['status'] }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
