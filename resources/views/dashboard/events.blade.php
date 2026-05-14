@extends('layouts.dashboard')

@section('title', 'Events')
@section('page_title', 'Events')

@section('content')
<div class="space-y-6" x-data="{ 
    isAddDialogOpen: false,
    isViewDialogOpen: false,
    isEditDialogOpen: false,
    selectedEvent: null,
    viewEvent(event) {
        this.selectedEvent = event;
        this.isViewDialogOpen = true;
    },
    editEvent(event) {
        this.selectedEvent = { ...event };
        this.isEditDialogOpen = true;
    },
    saveEvent() {
        this.isEditDialogOpen = false;
        $dispatch('toast', { message: 'Event updated successfully!', type: 'success' });
    },
    createEvent() {
        this.isAddDialogOpen = false;
        $dispatch('toast', { message: 'New event created successfully!', type: 'success' });
    }
}">
    <div class="flex justify-between items-center">
        <p class="text-sm text-gray-600">Manage and track restaurant events</p>
        <button @click="isAddDialogOpen = true" class="bg-[#8B1C3A] text-white px-4 py-2 rounded-lg hover:bg-[#a01c3a] transition-colors flex items-center text-sm font-medium shadow-lg shadow-[#8B1C3A]/20">
            <i data-lucide="plus" class="h-4 w-4 mr-2"></i>
            Add Event
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @php
            $events = [
                ['id' => 1, 'title' => 'Wine Tasting Evening', 'date' => '2026-05-20', 'time' => '19:00', 'location' => 'Main Hall', 'attendees' => 45, 'max' => 50, 'status' => 'Upcoming', 'desc' => 'An exclusive wine tasting event featuring premium wines from the Bordeaux region, paired with artisan cheeses.'],
                ['id' => 2, 'title' => 'Corporate Dinner', 'date' => '2026-05-18', 'time' => '18:30', 'location' => 'Private Room', 'attendees' => 30, 'max' => 30, 'status' => 'Confirmed', 'desc' => 'Private corporate event for TechCorp Inc. includes a 5-course tasting menu and presentation equipment setup.'],
                ['id' => 3, 'title' => 'Live Jazz Night', 'date' => '2026-05-25', 'time' => '20:00', 'location' => 'Restaurant Floor', 'attendees' => 62, 'max' => 80, 'status' => 'Upcoming', 'desc' => 'Monthly jazz performance featuring the Midnight Quartet. Standard dinner service with live musical background.'],
            ];
        @endphp

        @foreach($events as $event)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-6 hover:shadow-md transition-all animate-fade-in group">
                <div class="flex items-start justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-[#8B1C3A] transition-colors">{{ $event['title'] }}</h3>
                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $event['status'] == 'Confirmed' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                        {{ $event['status'] }}
                    </span>
                </div>
                <p class="text-sm text-gray-500 mb-6 leading-relaxed line-clamp-2">{{ $event['desc'] }}</p>

                <div class="space-y-3 mb-6">
                    <div class="flex items-center space-x-3 text-sm font-medium text-gray-600">
                        <i data-lucide="calendar" class="h-4 w-4 text-[#8B1C3A]"></i>
                        <span>{{ $event['date'] }} at {{ $event['time'] }}</span>
                    </div>
                    <div class="flex items-center space-x-3 text-sm font-medium text-gray-600">
                        <i data-lucide="map-pin" class="h-4 w-4 text-[#8B1C3A]"></i>
                        <span>{{ $event['location'] }}</span>
                    </div>
                    <div class="flex items-center space-x-3 text-sm font-medium text-gray-600">
                        <i data-lucide="users" class="h-4 w-4 text-[#8B1C3A]"></i>
                        <span>{{ $event['attendees'] }}/{{ $event['max'] }} attendees</span>
                    </div>
                </div>

                <div class="pt-2">
                    <div class="flex items-center justify-between mb-2 text-xs font-bold text-gray-400 uppercase tracking-widest">
                        <span>Capacity</span>
                        <span>{{ round(($event['attendees'] / $event['max']) * 100) }}%</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                        <div class="bg-[#8B1C3A] h-full rounded-full transition-all duration-1000" style="width: {{ ($event['attendees'] / $event['max']) * 100 }}%"></div>
                    </div>
                </div>

                <div class="flex space-x-3 mt-6 pt-6 border-t border-gray-50">
                    <button @click="editEvent({{ json_encode($event) }})" class="flex-1 py-2.5 border-2 border-gray-100 text-gray-500 text-sm font-bold rounded-xl hover:bg-gray-50 transition-colors">
                        Edit Event
                    </button>
                    <button @click="viewEvent({{ json_encode($event) }})" class="flex-1 py-2.5 bg-[#8B1C3A] text-white text-sm font-bold rounded-xl hover:bg-[#a01c3a] transition-all active:scale-95 shadow-lg shadow-[#8B1C3A]/10">
                        View Details
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <!-- View Event Modal -->
    <template x-if="selectedEvent">
        <div x-show="isViewDialogOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
            <div @click="isViewDialogOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm animate-fade-in"></div>
            <div class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl overflow-hidden animate-zoom-in">
                <div class="relative h-48 bg-[#8B1C3A]">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <button @click="isViewDialogOpen = false" class="absolute top-4 right-4 p-2 bg-white/20 hover:bg-white/40 rounded-full transition-all text-white">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                    <div class="absolute bottom-6 left-8">
                        <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-[10px] font-bold text-white uppercase tracking-widest mb-2 inline-block" x-text="selectedEvent.status"></span>
                        <h2 class="text-3xl font-bold text-white" x-text="selectedEvent.title"></h2>
                    </div>
                </div>

                <div class="p-8 space-y-8">
                    <div class="grid grid-cols-3 gap-6">
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 flex flex-col items-center text-center">
                            <i data-lucide="calendar" class="w-6 h-6 text-[#8B1C3A] mb-2"></i>
                            <p class="text-[10px] font-bold text-gray-400 uppercase">Date</p>
                            <p class="text-sm font-bold text-gray-900" x-text="selectedEvent.date"></p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 flex flex-col items-center text-center">
                            <i data-lucide="clock" class="w-6 h-6 text-[#8B1C3A] mb-2"></i>
                            <p class="text-[10px] font-bold text-gray-400 uppercase">Time</p>
                            <p class="text-sm font-bold text-gray-900" x-text="selectedEvent.time"></p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 flex flex-col items-center text-center">
                            <i data-lucide="map-pin" class="w-6 h-6 text-[#8B1C3A] mb-2"></i>
                            <p class="text-[10px] font-bold text-gray-400 uppercase">Location</p>
                            <p class="text-sm font-bold text-gray-900" x-text="selectedEvent.location"></p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest border-b border-gray-100 pb-2">About the Event</h3>
                        <p class="text-sm text-gray-600 leading-relaxed font-medium" x-text="selectedEvent.desc"></p>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-3xl border border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-white rounded-lg shadow-sm">
                                    <i data-lucide="users" class="w-5 h-5 text-[#8B1C3A]"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase">Attendance</p>
                                    <p class="text-sm font-bold text-gray-900" x-text="selectedEvent.attendees + ' / ' + selectedEvent.max + ' Registered'"></p>
                                </div>
                            </div>
                            <span class="text-sm font-bold text-[#8B1C3A]" x-text="Math.round((selectedEvent.attendees / selectedEvent.max) * 100) + '% Capacity'"></span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                            <div class="bg-[#8B1C3A] h-full rounded-full transition-all duration-1000 shadow-lg shadow-[#8B1C3A]/20" :style="'width: ' + (selectedEvent.attendees / selectedEvent.max) * 100 + '%'"></div>
                        </div>
                    </div>
                </div>

                <div class="p-8 border-t border-gray-100 bg-gray-50/50 flex justify-end space-x-3">
                    <button @click="isViewDialogOpen = false" class="px-8 py-3 border-2 border-gray-200 text-gray-500 font-bold rounded-xl hover:bg-gray-100 transition-all">Close</button>
                    <button @click="isViewDialogOpen = false; editEvent(selectedEvent)" class="px-8 py-3 bg-[#8B1C3A] text-white font-bold rounded-xl hover:bg-[#a01c3a] transition-all shadow-lg shadow-[#8B1C3A]/20">Edit Event</button>
                </div>
            </div>
        </div>
    </template>

    <!-- Add Event Modal -->
    <div x-show="isAddDialogOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
        <div @click="isAddDialogOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm animate-fade-in"></div>
        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden animate-zoom-in">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">Add New Event</h2>
                <button @click="isAddDialogOpen = false"><i data-lucide="x" class="w-6 h-6 text-gray-400"></i></button>
            </div>
            <form @submit.prevent="createEvent()" class="p-6 space-y-4">
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Event Title</label>
                    <input type="text" placeholder="e.g. Wine Tasting" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                </div>
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
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Location</label>
                    <input type="text" placeholder="e.g. Private Room B" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Max Capacity</label>
                        <input type="number" placeholder="50" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Status</label>
                        <select class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none appearance-none">
                            <option>Upcoming</option>
                            <option>Confirmed</option>
                        </select>
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Description</label>
                    <textarea rows="3" placeholder="Event details..." class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none"></textarea>
                </div>
                <div class="flex justify-end pt-4">
                    <button type="submit" class="px-6 py-2.5 bg-[#8B1C3A] text-white font-bold rounded-xl hover:bg-[#a01c3a] transition-all shadow-lg shadow-[#8B1C3A]/20">Create Event</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Event Modal -->
    <template x-if="selectedEvent">
        <div x-show="isEditDialogOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
            <div @click="isEditDialogOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm animate-fade-in"></div>
            <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden animate-zoom-in">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-900">Edit Event</h2>
                    <button @click="isEditDialogOpen = false"><i data-lucide="x" class="w-6 h-6 text-gray-400"></i></button>
                </div>
                <form @submit.prevent="saveEvent()" class="p-6 space-y-4">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Event Title</label>
                        <input type="text" x-model="selectedEvent.title" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-sm font-semibold text-gray-700">Date</label>
                            <input type="date" x-model="selectedEvent.date" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                        </div>
                        <div class="space-y-1">
                            <label class="text-sm font-semibold text-gray-700">Time</label>
                            <input type="time" x-model="selectedEvent.time" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                        </div>
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Location</label>
                        <input type="text" x-model="selectedEvent.location" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-sm font-semibold text-gray-700">Max Capacity</label>
                            <input type="number" x-model="selectedEvent.max" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                        </div>
                        <div class="space-y-1">
                            <label class="text-sm font-semibold text-gray-700">Status</label>
                            <select x-model="selectedEvent.status" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none appearance-none">
                                <option>Upcoming</option>
                                <option>Confirmed</option>
                            </select>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Description</label>
                        <textarea rows="3" x-model="selectedEvent.desc" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none"></textarea>
                    </div>
                    <div class="flex justify-end pt-4 space-x-3">
                        <button type="button" @click="isEditDialogOpen = false" class="px-6 py-2.5 text-gray-500 font-bold hover:bg-gray-50 rounded-xl transition-all">Cancel</button>
                        <button type="submit" class="px-6 py-2.5 bg-[#8B1C3A] text-white font-bold rounded-xl hover:bg-[#a01c3a] transition-all shadow-lg shadow-[#8B1C3A]/20">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </template>
</div>

<style>
@keyframes fade-in { from { opacity: 0; } to { opacity: 1; } }
@keyframes zoom-in { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
.animate-fade-in { animation: fade-in 0.2s ease-out; }
.animate-zoom-in { animation: zoom-in 0.2s ease-out; }
</style>
@endsection
