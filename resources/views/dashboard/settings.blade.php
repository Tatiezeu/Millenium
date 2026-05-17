{-- Settings View --}
{-- This view handles the display and user interaction for Settings. --}
@extends('layouts.dashboard')

@section('title', 'Settings')
@section('page_title', 'Settings')

@section('content')
<div class="space-y-6">
    <!-- System Settings -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex items-center space-x-2">
            <i data-lucide="shield" class="h-5 w-5 text-[#8B1C3A]"></i>
            <h3 class="font-bold text-gray-900">System Settings</h3>
        </div>
        <form action="{{ route('settings.update') }}" method="POST" class="p-6 space-y-8">
            @csrf
            @method('PATCH')
            <!-- Security -->
            <div>
                <h4 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-6 border-b border-gray-50 pb-2">Security Configuration</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Max Login Attempts</label>
                        <input type="number" name="max_login_attempts" value="{{ $settings['max_login_attempts'] }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                        <p class="text-[10px] text-gray-400 font-medium">Number of failed attempts before lock</p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Session Timeout (min)</label>
                        <input type="number" name="session_timeout" value="{{ $settings['session_timeout'] }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                        <p class="text-[10px] text-gray-400 font-medium">Inactive session duration</p>
                    </div>
                </div>
            </div>

            <!-- Verification -->
            <div>
                <div class="flex items-center space-x-2 mb-6">
                    <i data-lucide="mail" class="h-5 w-5 text-[#8B1C3A]"></i>
                    <h4 class="text-sm font-bold text-gray-900">Email Verification Configuration</h4>
                </div>
                <div class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">SMTP Server</label>
                        <input type="text" name="smtp_server" value="{{ $settings['smtp_server'] }}" placeholder="smtp.gmail.com" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="text-sm font-semibold text-gray-700">SMTP Port</label>
                            <input type="number" name="smtp_port" value="{{ $settings['smtp_port'] }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                        </div>
                        <div class="space-y-1">
                            <label class="text-sm font-semibold text-gray-700">Email Address</label>
                            <input type="email" name="email_address" value="{{ $settings['email_address'] }}" placeholder="millenium23726@gmail.com" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-white rounded-lg shadow-sm text-[#8B1C3A]"><i data-lucide="bell" class="h-5 w-5"></i></div>
                    <div>
                        <p class="text-sm font-bold text-gray-900">Email Notifications</p>
                        <p class="text-xs text-gray-500 font-medium">Critical events alerts</p>
                    </div>
                </div>
                <div class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="email_notifications" value="1" {{ $settings['email_notifications'] ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#8B1C3A]"></div>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="px-6 py-2.5 bg-[#8B1C3A] text-white text-sm font-bold rounded-xl hover:bg-[#a01c3a] transition-all active:scale-95 shadow-lg shadow-[#8B1C3A]/20">
                    Save Settings
                </button>
            </div>
        </form>
    </div>
    </div>
</div>
@endsection
