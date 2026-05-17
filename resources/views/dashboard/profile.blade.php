{-- Profile View --}
{-- This view handles the display and user interaction for Profile. --}
@extends('layouts.dashboard')

@section('title', 'My Profile')
@section('page_title', 'Account Settings')

@section('content')
<!-- 
    Profile Management Container
    Adjusted to w-[80vw] to provide a wider, more spacious layout as requested.
-->
<div class="w-[80vw] mx-auto space-y-8">
    <!-- 
        Profile Header & Account Settings Card
        Covers the primary user information including avatar, bio, and contact details.
    -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="h-32 bg-gradient-to-r from-[#8B1C3A] to-[#a01c3a]"></div>
        <div class="px-8 pb-8">
            <div class="relative -mt-16 mb-6 flex items-end justify-between">
                <div class="flex items-end space-x-6">
                    <div class="relative group">
                        <div class="h-32 w-32 rounded-3xl border-4 border-white overflow-hidden bg-gray-100 shadow-lg">
                            @if(Auth::user()->profile_picture)
                                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile" class="h-full w-full object-cover">
                            @else
                                <div class="h-full w-full flex items-center justify-center bg-[#8B1C3A] text-white text-4xl font-bold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="pb-2">
                        <h2 class="text-2xl font-bold text-gray-900">{{ Auth::user()->name }}</h2>
                        <p class="text-gray-500 font-medium">{{ ucfirst(Auth::user()->role) }} • Member since {{ Auth::user()->created_at->format('M Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Profile Form: Handles updates for personal info and contact details -->
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Personal Info Section -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center">
                            <i data-lucide="user" class="w-5 h-5 mr-2 text-[#8B1C3A]"></i>
                            Personal Information
                        </h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">First Name</label>
                                <input type="text" name="first_name" value="{{ Auth::user()->profile->first_name ?? explode(' ', Auth::user()->name)[0] }}" 
                                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none transition-all">
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Last Name</label>
                                <input type="text" name="last_name" value="{{ Auth::user()->profile->last_name ?? (explode(' ', Auth::user()->name)[1] ?? '') }}" 
                                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none transition-all">
                            </div>
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Bio</label>
                            <textarea name="bio" rows="3" placeholder="Tell us a bit about yourself..." 
                                      class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none transition-all">{{ Auth::user()->profile->bio ?? '' }}</textarea>
                        </div>
                    </div>

                    <!-- Contact Details Section -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center">
                            <i data-lucide="mail" class="w-5 h-5 mr-2 text-[#8B1C3A]"></i>
                            Contact Details
                        </h3>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Email Address</label>
                            <input type="email" name="email" value="{{ Auth::user()->email }}" 
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none transition-all">
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Phone Number</label>
                            <input type="text" name="phone" value="{{ Auth::user()->phone }}" 
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none transition-all">
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Profile Picture</label>
                            <input type="file" name="profile_picture" 
                                   class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none transition-all text-sm">
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="px-8 py-3 bg-[#8B1C3A] text-white font-bold rounded-xl hover:bg-[#a01c3a] transition-all shadow-lg shadow-[#8B1C3A]/20 flex items-center">
                        <i data-lucide="save" class="w-5 h-5 mr-2"></i>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- 
        Security & Password Management Card
        Allows users to update their account password for better security.
    -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
            <i data-lucide="shield-check" class="w-6 h-6 mr-3 text-[#8B1C3A]"></i>
            Security Settings
        </h3>
        <form action="{{ route('profile.password') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Current Password</label>
                    <input type="password" name="current_password" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none transition-all">
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">New Password</label>
                    <input type="password" name="password" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none transition-all">
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Confirm Password</label>
                    <input type="password" name="password_confirmation" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none transition-all">
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-8 py-3 bg-gray-900 text-white font-bold rounded-xl hover:bg-black transition-all shadow-lg flex items-center">
                    <i data-lucide="key" class="w-5 h-5 mr-2"></i>
                    Update Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
