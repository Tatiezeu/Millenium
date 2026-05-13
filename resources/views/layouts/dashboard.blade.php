<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le Gourmet Dashboard | @yield('title', 'Dashboard')</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        /* Custom scrollbar for sidebar */
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: rgba(255,255,255,0.05); }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
    </style>
</head>
<body class="bg-gray-50" x-data="{ showNotifications: false, currentPage: '{{ Request::path() }}' }">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-[#8B1C3A] text-white flex flex-col flex-shrink-0">
            <div class="p-6 border-b border-[#ffd700]/20">
                <a href="{{ url('/') }}" class="flex items-center space-x-3 hover:opacity-80 transition-opacity">
                    <div class="w-12 h-12 bg-[#ffd700] rounded-lg flex items-center justify-center">
                        <i data-lucide="utensils" class="w-7 h-7 text-[#8B1C3A]"></i>
                    </div>
                    <div>
                        <h2 class="text-xl text-[#ffd700] font-bold">Millenium</h2>
                        <p class="text-xs text-white/70">Luxury Hospitality</p>
                    </div>
                </a>
            </div>

            <nav class="flex-1 overflow-y-auto py-4 sidebar-scroll">
                <ul class="space-y-1 px-3">
                    @php
                        $menuItems = [
                            ['icon' => 'layout-dashboard', 'label' => 'Dashboard', 'path' => 'dashboard'],
                            ['icon' => 'calendar', 'label' => 'Reservations', 'path' => 'dashboard/reservations'],
                            ['icon' => 'utensils', 'label' => 'Tables', 'path' => 'dashboard/tables'],
                            ['icon' => 'concierge-bell', 'label' => 'Services', 'path' => 'dashboard/services'],
                            ['icon' => 'party-popper', 'label' => 'Events', 'path' => 'dashboard/events'],
                            ['icon' => 'image', 'label' => 'Gallery', 'path' => 'dashboard/gallery'],
                            ['icon' => 'shopping-bag', 'label' => 'Orders', 'path' => 'dashboard/orders'],
                            ['icon' => 'clipboard-list', 'label' => 'My Orders', 'path' => 'dashboard/my-orders'],
                            ['icon' => 'wallet', 'label' => 'Cashier', 'path' => 'dashboard/cashier'],
                            ['icon' => 'users', 'label' => 'Staff Accounts', 'path' => 'dashboard/staff-accounts'],
                            ['icon' => 'bell', 'label' => 'Notifications', 'path' => 'dashboard/notifications'],
                            ['icon' => 'file-text', 'label' => 'Reports', 'path' => 'dashboard/reports'],
                            ['icon' => 'user', 'label' => 'Profile', 'path' => 'dashboard/profile'],
                            ['icon' => 'settings', 'label' => 'Settings', 'path' => 'dashboard/settings'],
                        ];
                    @endphp

                    @foreach($menuItems as $item)
                        @php $isActive = Request::is($item['path']) || (Request::is('dashboard') && $item['path'] == 'dashboard'); @endphp
                        <li>
                            <a href="{{ url($item['path']) }}" 
                               class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ $isActive ? 'bg-[#ffd700] text-[#8B1C3A]' : 'text-white hover:bg-white/10' }}">
                                <i data-lucide="{{ $item['icon'] }}" class="w-5 h-5"></i>
                                <span class="text-sm font-medium">{{ $item['label'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            <!-- Logout Button -->
            <div class="p-4 border-t border-[#ffd700]/20">
                <a href="{{ url('/login') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-white hover:bg-red-600/20 hover:text-red-400 transition-all group">
                    <i data-lucide="log-out" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                    <span class="text-sm font-medium">Logout</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 z-10">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                            <span class="text-sm font-medium text-gray-700">System Online</span>
                        </div>
                        <span class="text-sm text-gray-500">{{ date('l, F j, Y') }}</span>
                    </div>

                    <div class="flex items-center space-x-4">
                        <button @click="showNotifications = !showNotifications" 
                                class="relative p-2 text-gray-400 hover:text-gray-600 focus:outline-none">
                            <i data-lucide="bell" class="h-5 w-5"></i>
                            <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                        </button>

                        <div class="flex items-center space-x-3 pl-4 border-l border-gray-200">
                            <div class="h-9 w-9 rounded-full bg-[#8B1C3A] flex items-center justify-center text-white font-bold text-sm">
                                JD
                            </div>
                            <div class="hidden md:block">
                                <p class="text-sm font-semibold text-gray-800">John Doe</p>
                                <p class="text-xs text-gray-500">Restaurant Manager</p>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Breadcrumbs & Title -->
            <main class="flex-1 overflow-auto p-6">
                <div class="mb-6">
                    <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-2">
                        <a href="{{ url('/dashboard') }}" class="hover:text-gray-700">Dashboard</a>
                        @php
                            $segments = Request::segments();
                            array_shift($segments); // Remove 'dashboard'
                        @endphp
                        @foreach($segments as $segment)
                            <i data-lucide="chevron-right" class="h-4 w-4"></i>
                            <span class="{{ $loop->last ? 'text-[#800020] font-medium' : '' }}">
                                {{ ucfirst($segment) }}
                            </span>
                        @endforeach
                    </nav>
                    <h1 class="text-3xl font-bold text-gray-900">
                        @yield('page_title', 'Dashboard')
                    </h1>
                </div>

                @yield('content')
            </main>
        </div>

        <!-- Notifications Panel Overlay -->
        <div x-show="showNotifications" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="showNotifications = false"
             class="fixed inset-0 bg-black/20 z-40" x-cloak></div>

        <!-- Notifications Panel -->
        <div x-show="showNotifications"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full"
             class="fixed right-0 top-0 w-96 h-screen bg-white shadow-2xl border-l border-gray-200 z-50 flex flex-col" x-cloak>
            
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-800">Notifications</h3>
                <button @click="showNotifications = false" class="p-2 text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="h-5 w-5"></i>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto">
                <div class="divide-y divide-gray-100">
                    @php
                        $notifications = [
                            ['from' => 'Sarah Chen', 'role' => 'Head Chef', 'message' => 'Low stock alert: Fresh salmon running low for tonight\'s service', 'time' => '5 min ago', 'unread' => true],
                            ['from' => 'Mike Johnson', 'role' => 'Waiter', 'message' => 'Table 12 requesting manager presence for special request', 'time' => '15 min ago', 'unread' => true],
                            ['from' => 'System', 'role' => 'Automated', 'message' => 'New reservation: Party of 6 for tomorrow at 7:00 PM', 'time' => '1 hour ago', 'unread' => false],
                            ['from' => 'Emma Wilson', 'role' => 'Cashier', 'message' => 'Daily sales report ready for review', 'time' => '2 hours ago', 'unread' => false],
                        ];
                    @endphp

                    @foreach($notifications as $notification)
                        <div class="p-4 hover:bg-gray-50 transition-colors {{ $notification['unread'] ? 'bg-blue-50/30' : '' }}">
                            <div class="flex items-start space-x-3">
                                <div class="h-10 w-10 rounded-full bg-[#800020] text-white flex items-center justify-center text-xs font-bold">
                                    @foreach(explode(' ', $notification['from']) as $n) {{ substr($n, 0, 1) }} @endforeach
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="text-sm font-semibold text-gray-900">{{ $notification['from'] }}</p>
                                        @if($notification['unread'])
                                            <span class="w-2 h-2 bg-[#800020] rounded-full"></span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-500 mb-1">{{ $notification['role'] }}</p>
                                    <p class="text-sm text-gray-700 mb-2">{{ $notification['message'] }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-gray-400">{{ $notification['time'] }}</span>
                                        <div class="flex space-x-2">
                                            <button class="flex items-center text-xs text-gray-600 hover:text-gray-900">
                                                <i data-lucide="reply" class="h-3 w-3 mr-1"></i> Reply
                                            </button>
                                            <button class="text-xs text-red-600 hover:text-red-700">
                                                <i data-lucide="trash-2" class="h-3 w-3"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();
    </script>
</body>
</html>
