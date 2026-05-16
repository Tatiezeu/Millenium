@extends('layouts.dashboard')

@section('title', 'Events Management')
@section('page_title', 'Events & Occasions')

@section('content')
<div class="space-y-6" x-data="{ isAddModalOpen: false }">
    <!-- Header Actions -->
    <div class="flex justify-between items-center">
        <h3 class="font-bold text-gray-900">Upcoming Events</h3>
        <button @click="isAddModalOpen = true" class="bg-[#8B1C3A] text-white px-6 py-2.5 rounded-xl font-bold hover:bg-[#a01c3a] transition-all flex items-center shadow-lg shadow-[#8B1C3A]/20">
            <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
            Schedule New Event
        </button>
    </div>

    <!-- Events Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($events as $event)
            @php
                $eventDate = \Carbon\Carbon::parse($event->date . ' ' . $event->time);
                $now = \Carbon\Carbon::now();
                $isSoon = $event->status === 'confirmed' && $eventDate->isFuture() && $eventDate->diffInDays($now) <= 7;
                $statusColors = [
                    'pending' => 'bg-amber-100 text-amber-700',
                    'confirmed' => 'bg-green-100 text-green-700',
                    'upcoming' => 'bg-blue-100 text-blue-700',
                    'cancelled' => 'bg-red-100 text-red-700',
                ];
            @endphp
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-xl transition-all duration-500">
                <div class="relative h-48 overflow-hidden">
                    @if($event->image_path)
                        <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    @else
                        <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                            <i data-lucide="calendar" class="w-12 h-12 text-gray-300"></i>
                        </div>
                    @endif
                    <div class="absolute top-4 right-4 px-3 py-1 {{ $statusColors[$event->status] ?? 'bg-gray-100 text-gray-700' }} backdrop-blur-md rounded-full text-[10px] font-bold uppercase tracking-widest shadow-sm">
                        {{ $event->status }}
                    </div>
                    
                    @if($isSoon)
                        <div class="absolute bottom-4 left-4 right-4 px-4 py-2 bg-black/60 backdrop-blur-md rounded-xl text-white text-xs font-bold flex items-center justify-between">
                            <span class="flex items-center"><i data-lucide="clock" class="w-3 h-3 mr-2 text-amber-400"></i> Starting In:</span>
                            <span>{{ $eventDate->diffForHumans(['syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE]) }}</span>
                        </div>
                    @endif
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <h4 class="text-xl font-bold text-gray-900 mb-1">{{ $event->title }}</h4>
                        <div class="flex items-center text-xs font-medium text-gray-400">
                            <i data-lucide="map-pin" class="w-3 h-3 mr-1"></i>
                            {{ $event->location }}
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 line-clamp-2 leading-relaxed">{{ $event->description }}</p>
                    
                    <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                        <div class="flex items-center space-x-3 text-xs font-bold text-gray-700">
                            <div class="px-2 py-1 bg-gray-100 rounded-lg">
                                {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}
                            </div>
                            <div class="px-2 py-1 bg-gray-100 rounded-lg">
                                {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2 pt-2">
                        @if($event->status === 'pending')
                            <form action="{{ route('events.status', $event->id) }}" method="POST" class="flex-1">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="confirmed">
                                <button type="submit" class="w-full py-2 bg-green-600 text-white text-xs font-bold rounded-lg hover:bg-green-700 transition-colors flex items-center justify-center">
                                    <i data-lucide="check-circle" class="w-3 h-3 mr-1"></i> Confirm
                                </button>
                            </form>
                        @endif

                        @if($event->status !== 'cancelled')
                            <form action="{{ route('events.status', $event->id) }}" method="POST" class="{{ $event->status === 'pending' ? 'flex-1' : 'w-full' }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="w-full py-2 bg-gray-100 text-gray-600 text-xs font-bold rounded-lg hover:bg-red-50 hover:text-red-600 transition-all flex items-center justify-center">
                                    <i data-lucide="x-circle" class="w-3 h-3 mr-1"></i> Cancel
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event permanently?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-300 hover:text-red-600 transition-colors p-2 hover:bg-red-50 rounded-lg">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center bg-white rounded-3xl border-2 border-dashed border-gray-100">
                <i data-lucide="calendar-x" class="w-12 h-12 text-gray-200 mx-auto mb-4"></i>
                <p class="text-gray-500 font-medium">No events scheduled yet.</p>
            </div>
        @endforelse
    </div>

    <!-- Add Event Modal -->
    <div x-show="isAddModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-6" x-cloak>
        <div @click="isAddModalOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm animate-fade-in"></div>
        <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl overflow-hidden animate-zoom-in">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="text-xl font-bold text-gray-900">Schedule Event</h3>
                <button @click="isAddModalOpen = false" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Event Title</label>
                    <input type="text" name="title" required placeholder="e.g. Jazz Night" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Date</label>
                        <input type="date" name="date" required value="{{ date('Y-m-d') }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Time</label>
                        <input type="time" name="time" required value="{{ date('H:i') }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Location</label>
                    <select name="location" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                        <option value="Main Hall">Main Hall</option>
                        <option value="Secondary Hall">Secondary Hall</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Description</label>
                    <textarea name="description" rows="3" required placeholder="What's happening?" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none resize-none"></textarea>
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Cover Image</label>
                    <input type="file" name="image" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none text-sm">
                </div>
                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-[#8B1C3A] text-white px-8 py-3 rounded-xl font-bold hover:bg-[#a01c3a] transition-all shadow-lg shadow-[#8B1C3A]/20">
                        Create Event
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
@keyframes fade-in { from { opacity: 0; } to { opacity: 1; } }
@keyframes zoom-in { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
.animate-fade-in { animation: fade-in 0.3s ease-out; }
.animate-zoom-in { animation: zoom-in 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); }
</style>
@endsection
