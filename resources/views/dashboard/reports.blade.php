{-- Reports View --}
{-- This view handles the display and user interaction for Reports. --}
@extends('layouts.dashboard')

@section('title', 'Reports & Analytics')
@section('page_title', 'Reports & Analytics')

@section('content')
<div class="space-y-6" x-data="{ 
    reportRange: 'today',
    isViewModalOpen: false,
    selectedReport: null,
    generateReport() {
        alert('New report generated successfully! It will appear in your list shortly.');
    },
    downloadPDF(title) {
        alert('Downloading ' + title + ' as PDF...');
    },
    viewReport(report) {
        this.selectedReport = report;
        this.isViewModalOpen = true;
    }
}">
    <!-- Header Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center space-x-2">
            <button @click="reportRange = 'today'" :class="reportRange === 'today' ? 'bg-[#8B1C3A] text-white' : 'bg-white text-gray-600'" class="px-4 py-2 rounded-lg text-sm font-medium transition-all shadow-sm">Today</button>
            <button @click="reportRange = 'week'" :class="reportRange === 'week' ? 'bg-[#8B1C3A] text-white' : 'bg-white text-gray-600'" class="px-4 py-2 rounded-lg text-sm font-medium transition-all shadow-sm">This Week</button>
            <button @click="reportRange = 'month'" :class="reportRange === 'month' ? 'bg-[#8B1C3A] text-white' : 'bg-white text-gray-600'" class="px-4 py-2 rounded-lg text-sm font-medium transition-all shadow-sm">This Month</button>
        </div>
        <div class="flex items-center space-x-3">
            <button class="flex items-center px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium shadow-sm">
                <i data-lucide="calendar" class="h-4 w-4 mr-2 text-gray-400"></i>
                Custom Range
            </button>
            <a href="{{ route('reports.print') }}" target="_blank" class="bg-[#8B1C3A] text-white px-6 py-2.5 rounded-xl hover:bg-[#a01c3a] transition-all flex items-center text-sm font-bold shadow-lg shadow-[#8B1C3A]/20">
                <i data-lucide="printer" class="h-4 w-4 mr-2"></i>
                PRINT REPORT (PDF)
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $reportStats = [
                ['title' => 'Gross Revenue', 'value' => number_format($totalSales) . ' FCFA', 'trend' => '+12.5%', 'trend_up' => true, 'icon' => 'dollar-sign', 'color' => 'text-green-600', 'bg' => 'bg-green-50'],
                ['title' => 'Total Orders', 'value' => $totalOrders, 'trend' => '+15.3%', 'trend_up' => true, 'icon' => 'shopping-bag', 'color' => 'text-blue-600', 'bg' => 'bg-blue-50'],
                ['title' => 'Registered Clients', 'value' => $totalCustomers, 'trend' => '+8.2%', 'trend_up' => true, 'icon' => 'users', 'color' => 'text-[#8B1C3A]', 'bg' => 'bg-red-50'],
                ['title' => 'Reservations', 'value' => $totalReservations, 'trend' => '+5.1%', 'trend_up' => true, 'icon' => 'calendar', 'color' => 'text-purple-600', 'bg' => 'bg-purple-50'],
            ];
        @endphp

        @foreach($reportStats as $stat)
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 group hover:shadow-md transition-all">
                <div class="flex items-center justify-between mb-4">
                    <div class="{{ $stat['bg'] }} p-3 rounded-xl group-hover:scale-110 transition-transform">
                        <i data-lucide="{{ $stat['icon'] }}" class="h-6 w-6 {{ $stat['color'] }}"></i>
                    </div>
                    <div class="flex items-center space-x-1 {{ $stat['trend_up'] ? 'text-green-600' : 'text-red-600' }}">
                        <span class="text-xs font-bold">{{ $stat['trend'] }}</span>
                        <i data-lucide="{{ $stat['trend_up'] ? 'trending-up' : 'trending-down' }}" class="h-3 w-3"></i>
                    </div>
                </div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">{{ $stat['title'] }}</h3>
                <div class="text-2xl font-bold text-gray-900">{{ $stat['value'] }}</div>
            </div>
        @endforeach
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Revenue Chart -->
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-bold text-gray-900">Revenue Overview</h3>
                    <p class="text-xs text-gray-500">Daily revenue trends for the current period</p>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="flex items-center space-x-1">
                        <span class="w-3 h-3 bg-[#8B1C3A] rounded-full"></span>
                        <span class="text-xs text-gray-500">Sales</span>
                    </div>
                    <div class="flex items-center space-x-1">
                        <span class="w-3 h-3 bg-[#ffd700] rounded-full"></span>
                        <span class="text-xs text-gray-500">Profit</span>
                    </div>
                </div>
            </div>
            <div class="h-80 w-full">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Distribution Chart -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="mb-6">
                <h3 class="font-bold text-gray-900">Sales by Category</h3>
                <p class="text-xs text-gray-500">Revenue distribution across menu items</p>
            </div>
            <div class="h-64 w-full flex items-center justify-center">
                <canvas id="categoryChart"></canvas>
            </div>
            <div class="mt-6 space-y-3">
                @php
                    $categories = [
                        ['label' => 'Main Plates', 'value' => '45%', 'color' => 'bg-[#8B1C3A]'],
                        ['label' => 'Drinks & Bar', 'value' => '30%', 'color' => 'bg-[#ffd700]'],
                        ['label' => 'Desserts', 'value' => '15%', 'color' => 'bg-gray-900'],
                        ['label' => 'Side Dishes', 'value' => '10%', 'color' => 'bg-gray-400'],
                    ];
                @endphp
                @foreach($categories as $cat)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="w-2 h-2 {{ $cat['color'] }} rounded-full"></span>
                            <span class="text-xs font-medium text-gray-600">{{ $cat['label'] }}</span>
                        </div>
                        <span class="text-xs font-bold text-gray-900">{{ $cat['value'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Reports & Top Sellers -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Available Reports -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                <h3 class="font-bold text-gray-900">Generated Reports</h3>
                <a href="#" class="text-xs font-bold text-[#8B1C3A] hover:underline">View History</a>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($reports as $report)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors cursor-pointer group">
                            <div @click="viewReport({{ json_encode($report) }})" class="flex items-center space-x-4 flex-1">
                                <div class="bg-white p-2 rounded-lg border border-gray-100 group-hover:border-[#8B1C3A]/20 transition-colors">
                                    <i data-lucide="file-text" class="h-5 w-5 text-[#8B1C3A]"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900">{{ $report->title }}</h4>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $report->created_at->format('M d, Y') }} • {{ $report->type }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button @click="downloadPDF('{{ $report->title }}')" class="p-2 text-gray-400 hover:text-[#8B1C3A] transition-colors">
                                    <i data-lucide="download" class="h-4 w-4"></i>
                                </button>
                                <button @click="viewReport({{ json_encode($report) }})" class="p-2 text-gray-400 hover:text-gray-900 transition-colors">
                                    <i data-lucide="eye" class="h-4 w-4"></i>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <p class="text-xs text-gray-400">No generated reports yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Top Selling Items -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                <h3 class="font-bold text-gray-900">Top Selling Items</h3>
                <span class="text-[10px] px-2 py-0.5 bg-[#ffd700] text-[#8B1C3A] rounded font-bold uppercase tracking-widest">Live Updates</span>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @php
                        $topSellers = [
                            ['name' => 'Grilled Salmon', 'cat' => 'Main Plates', 'orders' => 24, 'revenue' => '432,000 FCFA', 'image' => 'https://images.unsplash.com/photo-1467003909585-2f8a72700288?w=100&h=100&fit=crop'],
                            ['name' => 'Beef Steak', 'cat' => 'Main Plates', 'orders' => 18, 'revenue' => '396,000 FCFA', 'image' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=100&h=100&fit=crop'],
                            ['name' => 'Red Wine', 'cat' => 'Drinks', 'orders' => 32, 'revenue' => '480,000 FCFA', 'image' => 'https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?w=100&h=100&fit=crop'],
                        ];
                    @endphp

                    @foreach($topSellers as $item)
                        <div class="flex items-center justify-between p-3 rounded-xl border border-transparent hover:border-gray-100 hover:bg-gray-50 transition-all">
                            <div class="flex items-center space-x-3">
                                <img src="{{ $item['image'] }}" class="w-12 h-12 rounded-lg object-cover shadow-sm">
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900">{{ $item['name'] }}</h4>
                                    <p class="text-[10px] font-medium text-gray-500 uppercase">{{ $item['cat'] }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-[#8B1C3A]">{{ $item['revenue'] }}</p>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $item['orders'] }} Orders</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- View Report Detail Modal -->
    <template x-if="selectedReport">
        <div x-show="isViewModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
            <div @click="isViewModalOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm animate-fade-in"></div>
            <div class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl overflow-hidden animate-zoom-in">
                <div class="p-8 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900" x-text="selectedReport.title"></h2>
                        <p class="text-sm text-gray-500 mt-1" x-text="'Generated on ' + selectedReport.date"></p>
                    </div>
                    <button @click="isViewModalOpen = false" class="p-2 bg-white hover:bg-gray-100 rounded-full shadow-sm transition-all border border-gray-100">
                        <i data-lucide="x" class="w-6 h-6 text-gray-400"></i>
                    </button>
                </div>
                <div class="p-8 space-y-6">
                    <div class="p-6 bg-[#8B1C3A]/5 rounded-2xl border border-[#8B1C3A]/10">
                        <h3 class="text-[10px] font-bold text-[#8B1C3A] uppercase tracking-widest mb-2">Executive Summary</h3>
                        <p class="text-sm text-gray-700 leading-relaxed font-medium" x-text="selectedReport.summary"></p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <h4 class="text-[10px] font-bold text-gray-400 uppercase mb-1">Status</h4>
                            <p class="text-sm font-bold text-green-600 flex items-center">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                Finalized
                            </p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <h4 class="text-[10px] font-bold text-gray-400 uppercase mb-1">Type</h4>
                            <p class="text-sm font-bold text-gray-900" x-text="selectedReport.type"></p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest">Key Findings</h3>
                        <div class="space-y-2">
                            <template x-for="i in [1, 2, 3]">
                                <div class="flex items-center space-x-3 text-sm text-gray-600">
                                    <div class="w-1.5 h-1.5 bg-[#ffd700] rounded-full"></div>
                                    <span x-text="'Data point ' + i + ' shows significant improvement compared to last period.'"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
                <div class="p-8 border-t border-gray-100 flex justify-end space-x-3">
                    <button @click="downloadPDF(selectedReport.title)" class="px-6 py-2.5 border-2 border-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-50 transition-all flex items-center">
                        <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                        Export as PDF
                    </button>
                    <button @click="isViewModalOpen = false" class="px-8 py-2.5 bg-[#8B1C3A] text-white font-bold rounded-xl hover:bg-[#a01c3a] transition-all shadow-lg shadow-[#8B1C3A]/20">
                        Close View
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [
                    {
                        label: 'Sales',
                        data: [65000, 59000, 80000, 81000, 56000, 95000, 120000],
                        borderColor: '#8B1C3A',
                        backgroundColor: 'rgba(139, 28, 58, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointBackgroundColor: '#8B1C3A',
                        pointBorderColor: '#fff',
                        pointRadius: 4,
                        pointHoverRadius: 6
                    },
                    {
                        label: 'Profit',
                        data: [45000, 39000, 60000, 61000, 36000, 75000, 100000],
                        borderColor: '#ffd700',
                        backgroundColor: 'transparent',
                        fill: false,
                        tension: 0.4,
                        borderWidth: 2,
                        borderDash: [5, 5],
                        pointRadius: 0
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [5, 5], drawBorder: false },
                        ticks: {
                            callback: function(value) { return value.toLocaleString() + ' FCFA'; },
                            font: { size: 10 }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 10 } }
                    }
                }
            }
        });

        // Category Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: ['Main Plates', 'Drinks', 'Desserts', 'Side Dishes'],
                datasets: [{
                    data: [45, 30, 15, 10],
                    backgroundColor: ['#8B1C3A', '#ffd700', '#111827', '#9ca3af'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: { display: false }
                }
            }
        });
    });
</script>
@endsection
