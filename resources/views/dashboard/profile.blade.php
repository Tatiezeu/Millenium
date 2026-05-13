@extends('layouts.dashboard')

@section('title', 'Profile')
@section('page_title', 'Profile')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center text-center">
            <div class="h-24 w-24 rounded-full bg-[#8B1C3A] text-white flex items-center justify-center text-3xl font-bold mb-4 shadow-xl shadow-[#8B1C3A]/20 border-4 border-white">
                JD
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-1">John Doe</h3>
            <p class="text-sm text-gray-500 font-medium mb-6">Restaurant Manager</p>
            <button class="w-full py-2.5 border-2 border-gray-100 text-gray-600 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all">
                Change Profile Picture
            </button>
        </div>

        <!-- Contact Details -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50">
                <h3 class="font-bold text-gray-900">Contact Details</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @php
                        $contacts = [
                            ['icon' => 'mail', 'label' => 'Email', 'value' => 'john.doe@restaurant.com'],
                            ['icon' => 'phone', 'label' => 'Phone', 'value' => '+1 234 567 8900'],
                            ['icon' => 'map-pin', 'label' => 'Address', 'value' => '123 Main Street, Downtown'],
                            ['icon' => 'briefcase', 'label' => 'Role', 'value' => 'Restaurant Manager'],
                        ];
                    @endphp
                    @foreach($contacts as $contact)
                        <div class="flex items-center space-x-3 p-4 bg-gray-50 rounded-xl border border-gray-100/50">
                            <div class="p-2 bg-white rounded-lg shadow-sm">
                                <i data-lucide="{{ $contact['icon'] }}" class="h-5 w-5 text-[#8B1C3A]"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $contact['label'] }}</p>
                                <p class="text-sm font-bold text-gray-700">{{ $contact['value'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Update Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50">
            <h3 class="font-bold text-gray-900">Update Profile Information</h3>
        </div>
        <div class="p-6">
            <form class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">First Name</label>
                        <input type="text" value="John" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Last Name</label>
                        <input type="text" value="Doe" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                    </div>
                </div>
                <div class="flex justify-end">
                    <button class="px-6 py-2.5 bg-[#8B1C3A] text-white text-sm font-bold rounded-xl hover:bg-[#a01c3a] transition-all active:scale-95">
                        Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
