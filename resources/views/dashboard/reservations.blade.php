@extends('layouts.dashboard')

@section('title', 'Reservations')
@section('page_title', 'Reservations')

@section('content')
<div class="space-y-6" x-data="{ 
    isAddReservationModalOpen: false, 
    isViewModalOpen: false, 
    selectedReservation: null,
    confirmReservation(id) {
        alert('Reservation ' + id + ' confirmed successfully!');
    },
    declineReservation(id) {
        if(confirm('Are you sure you want to decline this reservation?')) {
            alert('Reservation ' + id + ' declined.');
        }
    },
    viewReservation(res) {
        this.selectedReservation = res;
        this.isViewModalOpen = true;
    }
}">
    <!-- Top Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @php
            $resStats = [
                ['title' => 'Total Reservations', 'value' => '4', 'color' => 'text-gray-900'],
                ['title' => 'Confirmed', 'value' => '3', 'color' => 'text-green-600'],
                ['title' => 'Pending', 'value' => '1', 'color' => 'text-yellow-600'],
                ['title' => 'Today\'s Guests', 'value' => '15', 'color' => 'text-[#8B1C3A]'],
            ];
        @endphp

        @foreach($resStats as $stat)
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 animate-fade-in">
                <h3 class="text-sm font-medium text-gray-500 mb-2">{{ $stat['title'] }}</h3>
                <div class="text-3xl font-bold {{ $stat['color'] }}">{{ $stat['value'] }}</div>
            </div>
        @endforeach
    </div>

    <!-- Reservations List Header -->
    <div class="flex justify-between items-center mb-4">
        <h3 class="font-bold text-gray-900">All Reservations</h3>
        <button @click="isAddReservationModalOpen = true" class="bg-[#8B1C3A] text-white px-4 py-2 rounded-lg hover:bg-[#a01c3a] transition-colors flex items-center text-sm font-medium shadow-lg shadow-[#8B1C3A]/20">
            <i data-lucide="plus" class="h-4 w-4 mr-2"></i>
            Add New Reservation
        </button>
    </div>

    <!-- Reservations List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-6">
        <div class="space-y-4">
            @php
                $reservations = [
                    ['id' => 1, 'name' => 'Alice Johnson', 'email' => 'alice@email.com', 'phone' => '+1 234 567 8900', 'date' => '2026-05-14', 'time' => '18:00', 'guests' => 4, 'table' => 'Table 7', 'category' => 'Medium', 'status' => 'Confirmed', 'request' => 'Window seating preferred'],
                    ['id' => 2, 'name' => 'Robert Smith', 'email' => 'robert@email.com', 'phone' => '+1 234 567 8901', 'date' => '2026-05-14', 'time' => '19:00', 'guests' => 2, 'table' => 'Table 3', 'category' => 'First Class', 'status' => 'Pending', 'request' => 'Anniversary celebration'],
                    ['id' => 3, 'name' => 'Emma Davis', 'email' => 'emma@email.com', 'phone' => '+1 234 567 8902', 'date' => '2026-05-15', 'time' => '19:30', 'guests' => 6, 'table' => 'Table 15', 'category' => 'Medium', 'status' => 'Confirmed', 'request' => ''],
                    ['id' => 4, 'name' => 'Michael Brown', 'email' => 'michael@email.com', 'phone' => '+1 234 567 8903', 'date' => '2026-05-15', 'time' => '20:00', 'guests' => 3, 'table' => 'Table 10', 'category' => 'Standard', 'status' => 'Confirmed', 'request' => 'Child seat needed'],
                ];
            @endphp

            @foreach($reservations as $res)
                <div class="border border-gray-100 rounded-xl p-6 hover:shadow-md transition-all duration-200 bg-white group">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-[#8B1C3A] transition-colors">{{ $res['name'] }}</h3>
                            <div class="flex items-center space-x-4 mt-1 text-sm text-gray-500">
                                <span class="flex items-center"><i data-lucide="mail" class="h-3.5 w-3.5 mr-1.5"></i> {{ $res['email'] }}</span>
                                <span class="flex items-center"><i data-lucide="phone" class="h-3.5 w-3.5 mr-1.5"></i> {{ $res['phone'] }}</span>
                            </div>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $res['status'] == 'Confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $res['status'] }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-5 gap-6 mb-4">
                        <div class="flex items-center space-x-3">
                            <i data-lucide="calendar" class="h-5 w-5 text-gray-400"></i>
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase font-bold">Date</p>
                                <p class="text-sm font-semibold text-gray-700">{{ $res['date'] }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i data-lucide="clock" class="h-5 w-5 text-gray-400"></i>
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase font-bold">Time</p>
                                <p class="text-sm font-semibold text-gray-700">{{ $res['time'] }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i data-lucide="users" class="h-5 w-5 text-gray-400"></i>
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase font-bold">Guests</p>
                                <p class="text-sm font-semibold text-gray-700">{{ $res['guests'] }} people</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase font-bold">Table</p>
                            <p class="text-sm font-semibold text-gray-700">{{ $res['table'] }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase font-bold">Category</p>
                            <p class="text-sm font-semibold text-gray-700">{{ $res['category'] }}</p>
                        </div>
                    </div>

                    @if($res['request'])
                        <div class="bg-blue-50 border-l-4 border-[#8B1C3A] p-4 mb-4 rounded-r-lg">
                            <p class="text-xs font-bold text-[#8B1C3A] uppercase mb-1">Special Request</p>
                            <p class="text-sm text-gray-700 italic">"{{ $res['request'] }}"</p>
                        </div>
                    @endif

                    <div class="flex space-x-3">
                        @if($res['status'] == 'Pending')
                            <button @click="confirmReservation({{ $res['id'] }})" class="flex items-center px-4 py-2 bg-green-600 text-white text-sm font-bold rounded-lg hover:bg-green-700 transition-colors shadow-sm">
                                <i data-lucide="check-circle" class="h-4 w-4 mr-2"></i> Confirm
                            </button>
                            <button @click="declineReservation({{ $res['id'] }})" class="flex items-center px-4 py-2 border-2 border-red-100 text-red-600 text-sm font-bold rounded-lg hover:bg-red-50 transition-colors">
                                <i data-lucide="x-circle" class="h-4 w-4 mr-2"></i> Decline
                            </button>
                        @endif
                        <button @click="viewReservation({{ json_encode($res) }})" class="px-4 py-2 border-2 border-gray-100 text-gray-500 text-sm font-bold rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors">
                            View Details
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- View Reservation Modal -->
    <template x-if="selectedReservation">
        <div x-show="isViewModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
            <div @click="isViewModalOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm animate-fade-in"></div>
            <div class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl overflow-hidden animate-zoom-in">
                <div class="p-8 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Reservation Details</h2>
                        <p class="text-sm text-gray-500 mt-1" x-text="'Ref: #RES-00' + selectedReservation.id"></p>
                    </div>
                    <button @click="isViewModalOpen = false" class="p-2 bg-white hover:bg-gray-100 rounded-full shadow-sm transition-all border border-gray-100">
                        <i data-lucide="x" class="w-6 h-6 text-gray-400"></i>
                    </button>
                </div>
                
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div class="space-y-1">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Customer</p>
                            <p class="text-lg font-bold text-gray-900" x-text="selectedReservation.name"></p>
                            <div class="flex flex-col space-y-1 mt-2">
                                <span class="text-sm text-gray-600 flex items-center"><i data-lucide="mail" class="w-4 h-4 mr-2 text-gray-400"></i> <span x-text="selectedReservation.email"></span></span>
                                <span class="text-sm text-gray-600 flex items-center"><i data-lucide="phone" class="w-4 h-4 mr-2 text-gray-400"></i> <span x-text="selectedReservation.phone"></span></span>
                            </div>
                        </div>

                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <p class="text-[10px] font-bold text-[#8B1C3A] uppercase tracking-widest mb-3">Status Tracking</p>
                            <div class="flex items-center space-x-3">
                                <div class="w-2.5 h-2.5 rounded-full" :class="selectedReservation.status === 'Confirmed' ? 'bg-green-500' : 'bg-yellow-500'"></div>
                                <p class="text-sm font-bold text-gray-900" x-text="selectedReservation.status"></p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6 bg-gray-50 p-6 rounded-3xl border border-gray-100">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Date</p>
                                <p class="text-sm font-bold text-gray-900" x-text="selectedReservation.date"></p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Time</p>
                                <p class="text-sm font-bold text-gray-900" x-text="selectedReservation.time"></p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Guests</p>
                                <p class="text-sm font-bold text-gray-900" x-text="selectedReservation.guests + ' People'"></p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Table</p>
                                <p class="text-sm font-bold text-gray-900" x-text="selectedReservation.table"></p>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-gray-200">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Service Category</p>
                            <p class="text-sm font-bold text-[#8B1C3A]" x-text="selectedReservation.category"></p>
                        </div>
                    </div>

                    <div class="md:col-span-2" x-show="selectedReservation.request">
                        <div class="p-6 bg-blue-50/50 border-2 border-dashed border-blue-100 rounded-3xl">
                            <p class="text-[10px] font-bold text-[#8B1C3A] uppercase tracking-widest mb-2">Special Request</p>
                            <p class="text-sm text-gray-700 italic font-medium" x-text="'&quot;' + selectedReservation.request + '&quot;'"></p>
                        </div>
                    </div>
                </div>

                <div class="p-8 border-t border-gray-100 flex justify-end space-x-3 bg-gray-50/50">
                    <template x-if="selectedReservation.status === 'Pending'">
                        <div class="flex space-x-3">
                            <button @click="confirmReservation(selectedReservation.id); isViewModalOpen = false" class="px-6 py-2.5 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 transition-all shadow-lg shadow-green-600/20">Confirm Reservation</button>
                            <button @click="declineReservation(selectedReservation.id); isViewModalOpen = false" class="px-6 py-2.5 border-2 border-red-100 text-red-600 font-bold rounded-xl hover:bg-red-50 transition-all">Decline</button>
                        </div>
                    </template>
                    <button @click="isViewModalOpen = false" class="px-8 py-2.5 bg-[#8B1C3A] text-white font-bold rounded-xl hover:bg-[#a01c3a] transition-all shadow-lg shadow-[#8B1C3A]/20">Close Window</button>
                </div>
            </div>
        </div>
    </template>

    <!-- Add Reservation Modal -->
    <div x-show="isAddReservationModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
        <div @click="isAddReservationModalOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm animate-fade-in"></div>
        <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl overflow-hidden animate-zoom-in">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">Add New Reservation</h2>
                <button @click="isAddReservationModalOpen = false"><i data-lucide="x" class="w-6 h-6 text-gray-400"></i></button>
            </div>
            <form class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Date</label>
                        <input type="date" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Time</label>
                        <input type="time" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Guests</label>
                        <input type="number" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Table</label>
                        <input type="text" placeholder="e.g. Table 5" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Category</label>
                        <select class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none appearance-none">
                            <option>Standard</option>
                            <option>Medium</option>
                            <option>First Class</option>
                        </select>
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Customer Name</label>
                    <input type="text" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Email</label>
                        <input type="email" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Phone</label>
                        <input type="text" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Special Requests</label>
                    <textarea rows="3" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none"></textarea>
                </div>
                <div class="flex justify-end pt-4">
                    <button type="submit" class="px-8 py-2.5 bg-[#8B1C3A] text-white font-bold rounded-xl hover:bg-[#a01c3a] transition-all shadow-lg shadow-[#8B1C3A]/20">Create Reservation</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
@keyframes fade-in { from { opacity: 0; } to { opacity: 1; } }
@keyframes zoom-in { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
.animate-fade-in { animation: fade-in 0.2s ease-out; }
.animate-zoom-in { animation: zoom-in 0.2s ease-out; }
</style>
@endsection
