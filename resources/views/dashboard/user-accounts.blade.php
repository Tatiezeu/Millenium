{{-- User Accounts View --}}
{{-- This view handles the display and user interaction for User Accounts. --}}
@extends('layouts.dashboard')

@section('title', 'Client Accounts')
@section('page_title', 'Client Accounts')

@section('content')
<div class="space-y-6" x-data="{ 
    isAddDialogOpen: false, 
    isViewDialogOpen: false,
    isEditDialogOpen: false,
    selectedUser: null,
    openView(user) {
        this.selectedUser = user;
        this.isViewDialogOpen = true;
    },
    openEdit(user) {
        this.selectedUser = { ...user };
        this.isEditDialogOpen = true;
    },
    saveUser() {
        // Form will handle the submission and redirect
    }
}">
    <!-- Top Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-sm font-medium text-gray-500 mb-2">Total Clients</h3>
            <div class="text-3xl font-bold text-gray-900">{{ $totalUsers }}</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-sm font-medium text-gray-500 mb-2">Active Clients</h3>
            <div class="text-3xl font-bold text-green-600">{{ $activeUsers }}</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-sm font-medium text-gray-500 mb-2">Inactive Clients</h3>
            <div class="text-3xl font-bold text-gray-400">{{ $inactiveUsers }}</div>
        </div>
    </div>

    <!-- User Members Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex flex-row items-center justify-between">
            <h3 class="font-bold text-gray-900">Registered Clients</h3>
            <button @click="isAddDialogOpen = true" class="bg-[#8B1C3A] text-white px-4 py-2 rounded-lg hover:bg-[#a01c3a] transition-colors flex items-center text-sm font-medium">
                <i data-lucide="plus" class="h-4 w-4 mr-2"></i>
                Add Client
            </button>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-gray-50">
                        <tr class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                            <th class="pb-3">Client Name</th>
                            <th class="pb-3">Contact Info</th>
                            <th class="pb-3">Role</th>
                            <th class="pb-3">Account Status</th>
                            <th class="pb-3">2FA Security</th>
                            <th class="pb-3 text-right pr-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($userMembers as $user)
                            <tr class="hover:bg-gray-50/50 transition-colors" x-data="{ 
                                accountStatus: '{{ $user->status }}',
                                tfaStatus: {{ $user->is_2fa_enabled ? 'true' : 'false' }},
                                async toggleStatus() {
                                    try {
                                        const response = await fetch('{{ route('accounts.toggle-status', $user->id) }}', {
                                            method: 'PATCH',
                                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                                        });
                                        const data = await response.json();
                                        this.accountStatus = data.status;
                                        $dispatch('toast', { message: 'Status updated for ' + '{{ $user->name }}', type: 'info' });
                                    } catch (e) { console.error(e); }
                                },
                                async toggle2FA() {
                                    try {
                                        const response = await fetch('{{ route('accounts.toggle-2fa', $user->id) }}', {
                                            method: 'PATCH',
                                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                                        });
                                        const data = await response.json();
                                        this.tfaStatus = data.is_2fa_enabled;
                                        $dispatch('toast', { message: '2FA status updated', type: 'info' });
                                    } catch (e) { console.error(e); }
                                }
                            }">
                                <td class="py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="h-10 w-10 rounded-full overflow-hidden bg-gray-900 text-white flex items-center justify-center font-bold text-xs">
                                            @if($user->profile_picture)
                                                <img src="{{ asset('storage/' . $user->profile_picture) }}" class="h-full w-full object-cover">
                                            @else
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            @endif
                                        </div>
                                        <span class="text-sm font-semibold text-gray-900">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="py-4">
                                    <div class="text-sm">
                                        <div class="font-medium text-gray-900">{{ $user->email }}</div>
                                        <div class="text-gray-500 text-xs">{{ $user->phone }}</div>
                                    </div>
                                </td>
                                <td class="py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-[#8B1C3A]/10 text-[#8B1C3A] capitalize">
                                        {{ $user->role ?? 'client' }}
                                    </span>
                                </td>
                                <td class="py-4">
                                    <div class="flex items-center space-x-3">
                                        <button @click="toggleStatus()" 
                                                class="relative inline-flex h-5 w-10 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
                                                :class="accountStatus === 'Active' ? 'bg-green-500' : 'bg-gray-200'">
                                            <span class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                                  :class="accountStatus === 'Active' ? 'translate-x-5' : 'translate-x-0'"></span>
                                        </button>
                                        <span class="text-xs font-bold uppercase tracking-widest" :class="accountStatus === 'Active' ? 'text-green-600' : 'text-gray-400'" x-text="accountStatus"></span>
                                    </div>
                                </td>
                                <td class="py-4">
                                    <div class="flex items-center space-x-3">
                                        <button @click="toggle2FA()" 
                                                class="relative inline-flex h-5 w-10 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
                                                :class="tfaStatus ? 'bg-[#8B1C3A]' : 'bg-gray-200'">
                                            <span class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                                  :class="tfaStatus ? 'translate-x-5' : 'translate-x-0'"></span>
                                        </button>
                                        <span class="text-[10px] font-bold uppercase tracking-widest" :class="tfaStatus ? 'text-[#8B1C3A]' : 'text-gray-400'" x-text="tfaStatus ? 'Enabled' : 'Disabled'"></span>
                                    </div>
                                </td>
                                <td class="py-4 text-right pr-4">
                                    <div class="flex items-center justify-end space-x-2">
                                        <button @click="openView({{ json_encode($user) }})" class="p-2 text-gray-400 hover:text-[#8B1C3A] hover:bg-[#8B1C3A]/5 rounded-lg transition-all">
                                            <i data-lucide="eye" class="h-4 w-4"></i>
                                        </button>
                                        <button @click="openEdit({{ json_encode($user) }})" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                                            <i data-lucide="pencil" class="h-4 w-4"></i>
                                        </button>
                                        <form action="{{ route('accounts.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Delete this client account?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                                <i data-lucide="trash-2" class="h-4 w-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div x-show="isAddDialogOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
        <div @click="isAddDialogOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm animate-fade-in"></div>
        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden animate-zoom-in">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">Add Client Account</h2>
                <button @click="isAddDialogOpen = false"><i data-lucide="x" class="w-6 h-6 text-gray-400"></i></button>
            </div>
            <form action="{{ route('accounts.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="role" value="client">
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Full Name</label>
                    <input type="text" name="name" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Phone</label>
                    <input type="text" name="phone" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Email Address</label>
                    <input type="email" name="email" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4" x-data="{ 
                    password: '', 
                    confirmation: '',
                    showPass: false, 
                    showConfirm: false,
                    get strength() {
                        if (!this.password) return { label: 'Empty', color: 'bg-gray-200', width: '0%' };
                        let score = 0;
                        if (this.password.length > 8) score++;
                        if (/[A-Z]/.test(this.password)) score++;
                        if (/[0-9]/.test(this.password)) score++;
                        if (/[^A-Za-z0-9]/.test(this.password)) score++;
                        
                        if (score < 2) return { label: 'Weak', color: 'bg-red-500', width: '25%' };
                        if (score < 3) return { label: 'Fair', color: 'bg-yellow-500', width: '50%' };
                        if (score < 4) return { label: 'Good', color: 'bg-blue-500', width: '75%' };
                        return { label: 'Strong', color: 'bg-green-500', width: '100%' };
                    }
                }">
                    <div class="space-y-1">
                        <div class="flex items-center justify-between">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Password</label>
                            <span class="text-[10px] font-bold" :class="strength.color.replace('bg-', 'text-')" x-text="strength.label"></span>
                        </div>
                        <div class="relative">
                            <input :type="showPass ? 'text' : 'password'" name="password" x-model="password" required class="w-full pl-4 pr-10 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none font-medium transition-all" :class="password && strength.label === 'Weak' ? 'border-red-300' : ''">
                            <button type="button" @click="showPass = !showPass" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#8B1C3A]">
                                <i :data-lucide="showPass ? 'eye-off' : 'eye'" class="w-4 h-4"></i>
                            </button>
                        </div>
                        <div class="h-1 w-full bg-gray-100 rounded-full overflow-hidden mt-1">
                            <div class="h-full transition-all duration-500" :class="strength.color" :style="'width: ' + strength.width"></div>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <div class="flex items-center justify-between">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Confirm Password</label>
                            <span x-show="confirmation && password !== confirmation" class="text-[10px] font-bold text-red-500">Mismatched</span>
                            <span x-show="confirmation && password === confirmation" class="text-[10px] font-bold text-green-500">Matched</span>
                        </div>
                        <div class="relative">
                            <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation" x-model="confirmation" required class="w-full pl-4 pr-10 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none font-medium transition-all" :class="confirmation && password !== confirmation ? 'border-red-300' : ''">
                            <button type="button" @click="showConfirm = !showConfirm" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#8B1C3A]">
                                <i :data-lucide="showConfirm ? 'eye-off' : 'eye'" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Profile Picture</label>
                    <input type="file" name="profile_picture" class="w-full text-xs file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-[#8B1C3A]/10 file:text-[#8B1C3A] hover:file:bg-[#8B1C3A]/20 transition-all">
                </div>
                <div class="flex justify-end pt-4">
                    <button type="submit" class="px-6 py-2.5 bg-[#8B1C3A] text-white font-bold rounded-xl hover:bg-[#a01c3a] transition-all shadow-lg shadow-[#8B1C3A]/20">Create Client</button>
                </div>
            </form>
        </div>
    </div>

    <!-- View User Modal -->
    <template x-if="selectedUser">
        <div x-show="isViewDialogOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
            <div @click="isViewDialogOpen = false" class="fixed inset-0 bg-black/40 backdrop-blur-md animate-fade-in"></div>
            <div class="relative w-full max-w-sm bg-white rounded-3xl shadow-2xl overflow-hidden animate-zoom-in border border-gray-100">
                <div class="h-28 bg-gradient-to-br from-gray-800 to-black relative">
                    <button @click="isViewDialogOpen = false" class="absolute top-4 right-4 p-2 bg-white/10 hover:bg-white/20 rounded-full transition-colors backdrop-blur-sm">
                        <i data-lucide="x" class="w-5 h-5 text-white"></i>
                    </button>
                    <div class="absolute -bottom-12 left-1/2 -translate-x-1/2">
                        <div class="w-24 h-24 rounded-2xl bg-gray-900 border-4 border-white shadow-xl flex items-center justify-center text-white text-2xl font-bold overflow-hidden">
                            <template x-if="selectedUser.profile_picture">
                                <img :src="'/storage/' + selectedUser.profile_picture" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!selectedUser.profile_picture">
                                <span x-text="selectedUser.name.charAt(0).toUpperCase()"></span>
                            </template>
                        </div>
                    </div>
                </div>
                <div class="px-8 pb-8 mt-14 text-center">
                    <h3 class="text-xl font-bold text-gray-900 leading-tight" x-text="selectedUser.name"></h3>
                    <div class="inline-flex items-center px-3 py-1 bg-gray-100 rounded-full mt-2">
                        <span class="text-[10px] font-bold text-gray-600 uppercase tracking-widest">Le Gourmet Member</span>
                    </div>
                    
                    <div class="mt-8 space-y-3 text-left">
                        <div class="flex items-center space-x-3 p-3 bg-gray-50/80 rounded-2xl border border-gray-100/50">
                            <div class="bg-white p-2.5 rounded-xl shadow-sm border border-gray-100"><i data-lucide="mail" class="w-4 h-4 text-gray-900"></i></div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Email Address</p>
                                <p class="text-sm font-semibold text-gray-700" x-text="selectedUser.email"></p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 p-3 bg-gray-50/80 rounded-2xl border border-gray-100/50">
                            <div class="bg-white p-2.5 rounded-xl shadow-sm border border-gray-100"><i data-lucide="phone" class="w-4 h-4 text-gray-900"></i></div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Phone Number</p>
                                <p class="text-sm font-semibold text-gray-700" x-text="selectedUser.phone"></p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 p-3 bg-gray-50/80 rounded-2xl border border-gray-100/50">
                            <div class="bg-white p-2.5 rounded-xl shadow-sm border border-gray-100"><i data-lucide="shield-check" class="w-4 h-4 text-gray-900"></i></div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Security Status</p>
                                <div class="flex items-center">
                                    <div class="w-1.5 h-1.5 rounded-full bg-green-500 mr-2"></div>
                                    <p class="text-sm font-bold text-green-600" x-text="selectedUser.status"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button @click="isViewDialogOpen = false" class="w-full mt-8 py-3 bg-gray-900 text-white font-bold rounded-2xl hover:bg-gray-800 transition-all shadow-lg">
                        Close Profile
                    </button>
                </div>
            </div>
        </div>
    </template>

    <!-- Edit User Modal -->
    <template x-if="selectedUser">
        <div x-show="isEditDialogOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
            <div @click="isEditDialogOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm animate-fade-in"></div>
            <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden animate-zoom-in">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-900">Edit Client Account</h2>
                    <button @click="isEditDialogOpen = false"><i data-lucide="x" class="w-6 h-6 text-gray-400"></i></button>
                </div>
                <form :action="'{{ url('dashboard/accounts') }}/' + selectedUser.id" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="role" value="client">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Full Name</label>
                        <input type="text" name="name" x-model="selectedUser.name" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Phone</label>
                        <input type="text" name="phone" x-model="selectedUser.phone" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Email Address</label>
                        <input type="email" name="email" x-model="selectedUser.email" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Profile Picture</label>
                        <input type="file" name="profile_picture" class="w-full text-xs">
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
