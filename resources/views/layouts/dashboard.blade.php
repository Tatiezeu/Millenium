{-- Dashboard View --}
{-- This view handles the display and user interaction for Dashboard. --}
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
<body class="bg-gray-50" x-data="{ 
    showNotifications: false, 
    currentPage: '{{ Request::path() }}',
    toasts: [],
    
    /**
     * Display a toast notification
     * @param {string} message - The text to display
     * @param {string} type - success, error, or info
     */
    showToast(message, type = 'success') {
        const id = Date.now();
        this.toasts.push({ id, message, type });
        
        // Refresh icons after Alpine adds the toast to the DOM
        this.$nextTick(() => {
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });

        // Auto-remove toast after 4 seconds
        setTimeout(() => {
            this.toasts = this.toasts.filter(t => t.id !== id);
        }, 4000);
    },

    /**
     * Initialize dashboard and check for session flash messages
     */
    init() {
        @if(session('welcome'))
            this.showToast('{{ session('welcome') }}', 'success');
        @endif
        @if(session('success'))
            this.showToast('{{ session('success') }}', 'success');
        @endif
        @if(session('error'))
            this.showToast('{{ session('error') }}', 'error');
        @endif
    }
}" x-init="init()" @toast.window="showToast($event.detail.message, $event.detail.type)">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Navigation (Hidden for Clients) -->
        @if(Auth::user()->role !== 'client')
        <aside class="w-64 bg-[#8B1C3A] text-white flex flex-col flex-shrink-0 shadow-xl">
            <!-- Brand Logo -->
            <div class="p-6 border-b border-[#ffd700]/20">
                <a href="{{ url('/') }}" class="flex items-center space-x-3 hover:opacity-80 transition-opacity">
                    <div class="w-12 h-12 bg-[#ffd700] rounded-lg flex items-center justify-center shadow-lg">
                        <i data-lucide="utensils" class="w-7 h-7 text-[#8B1C3A]"></i>
                    </div>
                    <div>
                        <h2 class="text-xl text-[#ffd700] font-bold">Millenium</h2>
                        <p class="text-xs text-white/70">Luxury Hospitality</p>
                    </div>
                </a>
            </div>

            <!-- Navigation Links -->
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
                            ['icon' => 'user-plus', 'label' => 'User Accounts', 'path' => 'dashboard/user-accounts'],
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
                               class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all {{ $isActive ? 'bg-[#ffd700] text-[#8B1C3A] shadow-md' : 'text-white hover:bg-white/10' }}">
                                <i data-lucide="{{ $item['icon'] }}" class="w-5 h-5"></i>
                                <span class="text-sm font-medium">{{ $item['label'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            <!-- Secure Logout -->
            <div class="p-4 border-t border-[#ffd700]/20">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-white hover:bg-red-600/20 hover:text-red-400 transition-all group">
                    <i data-lucide="log-out" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                    <span class="text-sm font-medium">Logout</span>
                </a>
            </div>
        </aside>
        @endif

        <!-- Main Workspace -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            
            <!-- Global Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 z-10">
                <div class="flex items-center justify-between px-6 py-4">
                    <!-- Left: Status & Date -->
                    <div class="flex items-center space-x-4">
                        @if(Auth::user()->role === 'client')
                            <a href="{{ url('/') }}" class="flex items-center space-x-2 mr-6">
                                <div class="w-10 h-10 bg-[#8B1C3A] rounded-xl flex items-center justify-center shadow-lg">
                                    <i data-lucide="utensils" class="w-6 h-6 text-[#ffd700]"></i>
                                </div>
                                <div class="hidden sm:block">
                                    <h2 class="text-lg font-bold text-[#8B1C3A] leading-tight">Millenium</h2>
                                    <p class="text-[10px] text-gray-500 uppercase tracking-tighter">Luxury Hospitality</p>
                                </div>
                            </a>
                        @endif
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                            <span class="text-sm font-medium text-gray-700">System Online</span>
                        </div>
                        <span class="text-sm text-gray-500 hidden sm:block">{{ date('l, F j, Y') }}</span>
                    </div>

                    <!-- Right: Notifications & User Profile -->
                    <div class="flex items-center space-x-4">
                        <button @click="showNotifications = !showNotifications" 
                                class="relative p-2 text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                            <i data-lucide="bell" class="h-5 w-5"></i>
                            @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                                <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-600 text-white text-[10px] font-bold flex items-center justify-center rounded-full border-2 border-white shadow-sm">
                                    {{ $unreadNotificationsCount }}
                                </span>
                            @endif
                        </button>

                        <div class="flex items-center space-x-3 pl-4 border-l border-gray-200">
                            <!-- User Avatar (Image or Initials) -->
                            <div class="h-9 w-9 rounded-full bg-[#8B1C3A] flex items-center justify-center text-white font-bold text-sm shadow-inner overflow-hidden">
                                @if(Auth::user()->profile_picture)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Avatar" class="h-full w-full object-cover">
                                @else
                                    @php
                                        $names = explode(' ', Auth::user()->name);
                                        $initials = strtoupper(substr($names[0], 0, 1));
                                        if (count($names) > 1) {
                                            $initials .= strtoupper(substr($names[count($names)-1], 0, 1));
                                        }
                                    @endphp
                                    {{ $initials }}
                                @endif
                            </div>
                            <!-- User Details -->
                            <div class="hidden md:block">
                                <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Breadcrumbs & Dynamic Page Content -->
            <main class="flex-1 overflow-auto p-6">
                <div class="mb-6">
                    @if(Auth::user()->role !== 'client')
                    <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-2">
                        <a href="{{ url('/dashboard') }}" class="hover:text-gray-700">Dashboard</a>
                        @php
                            $segments = Request::segments();
                            array_shift($segments); // Skip 'dashboard'
                        @endphp
                        @foreach($segments as $segment)
                            <i data-lucide="chevron-right" class="h-4 w-4"></i>
                            <span class="{{ $loop->last ? 'text-[#800020] font-medium' : '' }}">
                                {{ ucfirst(str_replace('-', ' ', $segment)) }}
                            </span>
                        @endforeach
                    </nav>
                    @endif
                    <h1 class="text-3xl font-bold text-gray-900">
                        @yield('page_title', 'Dashboard')
                    </h1>
                </div>

                <!-- Page-specific content goes here -->
                @yield('content')
            </main>
        </div>

        <!-- Notifications Sidebar Overlay -->
        <div x-show="showNotifications" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="showNotifications = false"
             class="fixed inset-0 bg-black/20 z-40" x-cloak></div>

        <!-- Notifications Sidebar -->
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
                    @forelse($navbarNotifications as $notification)
                        <div class="p-4 hover:bg-gray-50 transition-colors {{ !$notification->is_read ? 'bg-blue-50/30' : '' }}">
                            <div class="flex items-start space-x-3">
                                <div class="h-10 w-10 rounded-full bg-[#8B1C3A] text-white flex items-center justify-center text-xs font-bold overflow-hidden">
                                    @if($notification->sender && $notification->sender->profile_picture)
                                        <img src="{{ asset('storage/' . $notification->sender->profile_picture) }}" class="h-full w-full object-cover">
                                    @else
                                        @php
                                            $senderName = $notification->sender->name ?? 'System';
                                            $sn = explode(' ', $senderName);
                                            $si = strtoupper(substr($sn[0], 0, 1));
                                            if (count($sn) > 1) $si .= strtoupper(substr($sn[count($sn)-1], 0, 1));
                                        @endphp
                                        {{ $si }}
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="text-sm font-semibold text-gray-900">{{ $notification->sender->name ?? 'System' }}</p>
                                        @if(!$notification->is_read)
                                            <span class="w-2 h-2 bg-[#8B1C3A] rounded-full"></span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-500 mb-1">{{ ucfirst($notification->sender->role ?? 'Admin') }}</p>
                                    <p class="text-sm text-gray-700 mb-2 line-clamp-2">{{ $notification->message }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                                        <div class="flex space-x-2">
                                            <a href="{{ url('dashboard/notifications') }}" class="flex items-center text-xs text-gray-600 hover:text-gray-900">
                                                <i data-lucide="eye" class="h-3 w-3 mr-1"></i> View
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <i data-lucide="bell-off" class="w-12 h-12 text-gray-200 mx-auto mb-3"></i>
                            <p class="text-gray-500 text-sm">No notifications found.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

    <!-- Toast Notifications Container (Floating) -->
    <div class="fixed bottom-6 right-6 z-[200] space-y-3">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-show="true" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="flex items-center space-x-3 px-6 py-4 rounded-2xl shadow-2xl border backdrop-blur-md"
                 :class="{
                     'bg-green-500/90 border-green-400 text-white': toast.type === 'success',
                     'bg-red-500/90 border-red-400 text-white': toast.type === 'error',
                     'bg-[#8B1C3A]/90 border-[#ffd700]/30 text-white': toast.type === 'info'
                 }">
                <div class="p-1 bg-white/20 rounded-lg">
                    <i :data-lucide="toast.type === 'success' ? 'check-circle' : (toast.type === 'error' ? 'alert-circle' : 'info')" class="w-5 h-5 text-white"></i>
                </div>
                <p class="text-sm font-bold" x-text="toast.message"></p>
            </div>
        </template>
    </div>

    <script>
        // Initialize Lucide icons on page load
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
    </script>
</body>
</html>
