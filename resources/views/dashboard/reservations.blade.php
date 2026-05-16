@extends('layouts.dashboard')

@section('title', 'Reservations')
@section('page_title', 'Reservations')

@section('content')
<div class="space-y-6" x-data="{ 
    isAddReservationModalOpen: false, 
    isViewModalOpen: false, 
    selectedReservation: null,
    confirmReservation(id) {
        $dispatch('toast', { message: 'Reservation #' + id + ' confirmed!', type: 'success' });
    },
    declineReservation(id) {
        if(confirm('Are you sure you want to decline this reservation?')) {
            $dispatch('toast', { message: 'Reservation declined', type: 'error' });
        }
    },
    viewReservation(res) {
        this.selectedReservation = res;
        this.isViewModalOpen = true;
    }
}">
    <!-- Top Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 animate-fade-in">
            <h3 class="text-sm font-medium text-gray-500 mb-2">Total Reservations</h3>
            <div class="text-3xl font-bold text-gray-900">{{ $totalRes }}</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 animate-fade-in">
            <h3 class="text-sm font-medium text-gray-500 mb-2">Confirmed</h3>
            <div class="text-3xl font-bold text-green-600">{{ $confirmedRes }}</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 animate-fade-in">
            <h3 class="text-sm font-medium text-gray-500 mb-2">Pending</h3>
            <div class="text-3xl font-bold text-yellow-600">{{ $pendingRes }}</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 animate-fade-in">
            <h3 class="text-sm font-medium text-gray-500 mb-2">Today's Guests</h3>
            <div class="text-3xl font-bold text-[#8B1C3A]">{{ $todayGuests }}</div>
        </div>
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
            @forelse($reservations as $res)
                <div class="border border-gray-100 rounded-xl p-6 hover:shadow-md transition-all duration-200 bg-white group">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-[#8B1C3A] transition-colors">
                                {{ $res->user ? $res->user->name : $res->guest_name }}
                            </h3>
                            <div class="flex items-center space-x-4 mt-1 text-sm text-gray-500">
                                @if($res->user)
                                    <span class="flex items-center"><i data-lucide="mail" class="h-3.5 w-3.5 mr-1.5"></i> {{ $res->user->email }}</span>
                                    <span class="px-2 py-0.5 bg-blue-50 text-blue-600 text-[10px] font-bold rounded uppercase tracking-wider">Registered Client</span>
                                @else
                                    <span class="flex items-center text-orange-600 font-medium">Quick Guest</span>
                                @endif
                            </div>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                            {{ $res->status == 'confirmed' ? 'bg-green-100 text-green-800' : 
                               ($res->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ $res->status }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-5 gap-6 mb-4">
                        <div class="flex items-center space-x-3">
                            <i data-lucide="calendar" class="h-5 w-5 text-gray-400"></i>
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase font-bold">Date</p>
                                <p class="text-sm font-semibold text-gray-700">{{ $res->reservation_date }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i data-lucide="clock" class="h-5 w-5 text-gray-400"></i>
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase font-bold">Time</p>
                                <p class="text-sm font-semibold text-gray-700">{{ $res->reservation_time }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i data-lucide="users" class="h-5 w-5 text-gray-400"></i>
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase font-bold">Guests</p>
                                <p class="text-sm font-semibold text-gray-700">{{ $res->guest_count }} people</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase font-bold">Table</p>
                            <p class="text-sm font-semibold text-gray-700">{{ $res->table ? $res->table->title : 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase font-bold">Category</p>
                            <p class="text-sm font-semibold text-[#8B1C3A]">{{ $res->table ? $res->table->category : 'N/A' }}</p>
                        </div>
                    </div>

                    @if($res->notes)
                        <div class="bg-gray-50 border-l-4 border-gray-200 p-3 mb-4 rounded-r-lg">
                            <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Notes</p>
                            <p class="text-sm text-gray-600 italic">"{{ $res->notes }}"</p>
                        </div>
                    @endif

                    <div class="flex space-x-3">
                        @if($res->status == 'pending')
                            <form action="{{ route('reservations.update', $res->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="confirmed">
                                <button type="submit" class="flex items-center px-4 py-2 bg-green-600 text-white text-sm font-bold rounded-lg hover:bg-green-700 transition-colors shadow-sm">
                                    <i data-lucide="check-circle" class="h-4 w-4 mr-2"></i> Confirm
                                </button>
                            </form>
                            <form action="{{ route('reservations.update', $res->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="flex items-center px-4 py-2 border-2 border-red-100 text-red-600 text-sm font-bold rounded-lg hover:bg-red-50 transition-colors">
                                    <i data-lucide="x-circle" class="h-4 w-4 mr-2"></i> Cancel
                                </button>
                            </form>
                        @endif
                        <button @click="viewReservation({{ json_encode($res->load(['table', 'user'])) }})" class="px-4 py-2 border-2 border-gray-100 text-gray-500 text-sm font-bold rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors">
                            View Details
                        </button>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <p class="text-gray-400">No reservations found.</p>
                </div>
            @endforelse
        </div>
    <!-- View Reservation Modal -->
    <template x-if="selectedReservation">
        <div x-show="isViewModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
            <div @click="isViewModalOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm animate-fade-in"></div>
            <div class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl overflow-hidden animate-zoom-in">
                <div class="p-8 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Reservation Details</h2>
                        <p class="text-sm text-gray-500 mt-1" x-text="'Ref: #RES-' + selectedReservation._id.substring(0,8).toUpperCase()"></p>
                    </div>
                    <button @click="isViewModalOpen = false" class="p-2 bg-white hover:bg-gray-100 rounded-full shadow-sm transition-all border border-gray-100">
                        <i data-lucide="x" class="w-6 h-6 text-gray-400"></i>
                    </button>
                </div>
                
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div class="space-y-1">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Customer</p>
                            <p class="text-lg font-bold text-gray-900" x-text="selectedReservation.user ? selectedReservation.user.name : selectedReservation.guest_name"></p>
                            <div class="flex flex-col space-y-1 mt-2">
                                <span class="text-sm text-gray-600 flex items-center" x-show="selectedReservation.user"><i data-lucide="mail" class="w-4 h-4 mr-2 text-gray-400"></i> <span x-text="selectedReservation.user ? selectedReservation.user.email : ''"></span></span>
                                <span class="text-sm text-gray-600 flex items-center" x-show="selectedReservation.guest_phone"><i data-lucide="phone" class="w-4 h-4 mr-2 text-gray-400"></i> <span x-text="selectedReservation.guest_phone"></span></span>
                            </div>
                        </div>

                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <p class="text-[10px] font-bold text-[#8B1C3A] uppercase tracking-widest mb-3">Status Tracking</p>
                            <div class="flex items-center space-x-3">
                                <div class="w-2.5 h-2.5 rounded-full" :class="selectedReservation.status === 'confirmed' ? 'bg-green-500' : (selectedReservation.status === 'pending' ? 'bg-yellow-500' : 'bg-red-500')"></div>
                                <p class="text-sm font-bold text-gray-900 uppercase tracking-wider" x-text="selectedReservation.status"></p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6 bg-gray-50 p-6 rounded-3xl border border-gray-100">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Date</p>
                                <p class="text-sm font-bold text-gray-900" x-text="selectedReservation.reservation_date"></p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Time</p>
                                <p class="text-sm font-bold text-gray-900" x-text="selectedReservation.reservation_time"></p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Guests</p>
                                <p class="text-sm font-bold text-gray-900" x-text="selectedReservation.guest_count + ' People'"></p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Table</p>
                                <p class="text-sm font-bold text-gray-900" x-text="selectedReservation.table ? selectedReservation.table.title : 'N/A'"></p>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-gray-200">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Service Category</p>
                            <p class="text-sm font-bold text-[#8B1C3A]" x-text="selectedReservation.table ? selectedReservation.table.category : 'N/A'"></p>
                        </div>
                    </div>

                    <div class="md:col-span-2" x-show="selectedReservation.notes">
                        <div class="p-6 bg-blue-50/50 border-2 border-dashed border-blue-100 rounded-3xl">
                            <p class="text-[10px] font-bold text-[#8B1C3A] uppercase tracking-widest mb-2">Special Request / Notes</p>
                            <p class="text-sm text-gray-700 italic font-medium" x-text="'&quot;' + selectedReservation.notes + '&quot;'"></p>
                        </div>
                    </div>
                </div>

                <div class="p-8 border-t border-gray-100 flex justify-end space-x-3 bg-gray-50/50">
                    <template x-if="selectedReservation.status === 'pending'">
                        <div class="flex space-x-3">
                            <form :action="'{{ url('/dashboard/reservations') }}/' + selectedReservation._id" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="confirmed">
                                <button type="submit" class="px-6 py-2.5 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 transition-all shadow-lg shadow-green-600/20">Confirm</button>
                            </form>
                            <form :action="'{{ url('/dashboard/reservations') }}/' + selectedReservation._id" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="px-6 py-2.5 border-2 border-red-100 text-red-600 font-bold rounded-xl hover:bg-red-50 transition-all">Decline</button>
                            </form>
                        </div>
                    </template>
                    <button @click="isViewModalOpen = false" class="px-8 py-2.5 bg-[#8B1C3A] text-white font-bold rounded-xl hover:bg-[#a01c3a] transition-all shadow-lg shadow-[#8B1C3A]/20">Close</button>
                </div>
            </div>
        </div>
    </template>

    <!-- Add Reservation Modal -->
    <div x-show="isAddReservationModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
        <div @click="isAddReservationModalOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm animate-fade-in"></div>
        <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl overflow-hidden animate-zoom-in"
             x-data="{ 
                resType: 'Standard', 
                guestCount: 1, 
                isNewClient: false,
                allTables: {{ json_encode($tables) }},
                get filteredTables() {
                    return this.allTables.filter(t => t.category === this.resType && t.status === 'available');
                },
                get recommendation() {
                    if (this.guestCount > 2 && this.resType === 'Standard') return 'Standard tables only have 2 seats. We recommend Medium or VIP for ' + this.guestCount + ' guests.';
                    if (this.guestCount > 4 && this.resType === 'Medium') return 'Medium tables only have 4 seats. We recommend VIP for ' + this.guestCount + ' guests.';
                    return '';
                }
             }">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">Add New Reservation</h2>
                <button @click="isAddReservationModalOpen = false"><i data-lucide="x" class="w-6 h-6 text-gray-400"></i></button>
            </div>
            <form action="{{ route('reservations.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Category Filter</label>
                        <select x-model="resType" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                            <option value="Standard">Standard</option>
                            <option value="Medium">Medium</option>
                            <option value="First Class">First Class (VIP)</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Select Table</label>
                        <select name="table_id" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                            <option value="">Select an available table...</option>
                            <template x-for="table in filteredTables" :key="table.id || table._id">
                                <option :value="table.id || table._id" x-text="table.title + ' (' + table.seats + ' seats)'"></option>
                            </template>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Guests</label>
                        <input type="number" name="guest_count" x-model="guestCount" min="1" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Date</label>
                        <input type="date" name="reservation_date" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Time</label>
                        <input type="time" name="reservation_time" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                    </div>
                </div>

                <!-- Recommendation Alert -->
                <template x-if="recommendation">
                    <div class="bg-[#8B1C3A]/5 border-l-4 border-[#8B1C3A] p-3 text-xs font-bold text-[#8B1C3A] animate-fade-in">
                        <i data-lucide="info" class="inline-block w-3 h-3 mr-1"></i> <span x-text="recommendation"></span>
                    </div>
                </template>

                <div class="pt-2">
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-sm font-semibold text-gray-700">Customer Selection</label>
                        <button type="button" @click="isNewClient = !isNewClient" class="text-xs font-bold text-[#8B1C3A] hover:underline" x-text="isNewClient ? 'Select Existing Client' : 'Add New Client'"></button>
                    </div>
                    
                    <div x-show="!isNewClient" class="animate-fade-in">
                        <select name="user_id" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                            <option value="">Choose a registered client...</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }} ({{ $client->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div x-show="isNewClient" class="space-y-3 animate-fade-in">
                        <input type="text" name="guest_name" placeholder="Full Name" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                        <div class="grid grid-cols-2 gap-4">
                            <input type="email" name="guest_email" placeholder="Email (Optional)" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                            <input type="text" name="guest_phone" placeholder="Phone Number" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                        </div>
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Special Requests / Notes</label>
                    <textarea name="notes" rows="2" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none"></textarea>
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
