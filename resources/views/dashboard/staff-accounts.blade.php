@extends('layouts.dashboard')

@section('title', 'Staff Accounts')
@section('page_title', 'Staff Accounts')

@section('content')
<div class="space-y-6" x-data="{ 
    isAddDialogOpen: false, 
    isViewDialogOpen: false,
    isEditDialogOpen: false,
    selectedStaff: null,
    deleteStaff(id) {
        if(confirm('Are you sure you want to delete this staff member?')) {
            alert('Staff member with ID ' + id + ' deleted.');
        }
    },
    openView(staff) {
        this.selectedStaff = staff;
        this.isViewDialogOpen = true;
    },
    openEdit(staff) {
        this.selectedStaff = { ...staff };
        this.isEditDialogOpen = true;
    }
}">
    <!-- Top Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @php
            $staffStats = [
                ['title' => 'Total Staff', 'value' => '4', 'color' => 'text-gray-900'],
                ['title' => 'Active Staff', 'value' => '3', 'color' => 'text-green-600'],
                ['title' => 'Inactive Staff', 'value' => '1', 'color' => 'text-gray-400'],
            ];
        @endphp

        @foreach($staffStats as $stat)
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-sm font-medium text-gray-500 mb-2">{{ $stat['title'] }}</h3>
                <div class="text-3xl font-bold {{ $stat['color'] }}">{{ $stat['value'] }}</div>
            </div>
        @endforeach
    </div>

    <!-- Staff Members Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex flex-row items-center justify-between">
            <h3 class="font-bold text-gray-900">Staff Members</h3>
            <button @click="isAddDialogOpen = true" class="bg-[#8B1C3A] text-white px-4 py-2 rounded-lg hover:bg-[#a01c3a] transition-colors flex items-center text-sm font-medium">
                <i data-lucide="plus" class="h-4 w-4 mr-2"></i>
                Add Staff
            </button>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-gray-50">
                        <tr class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                            <th class="pb-3">Name</th>
                            <th class="pb-3">Role</th>
                            <th class="pb-3">Contact</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @php
                            $staffMembers = [
                                ['id' => 1, 'name' => 'Sarah Chen', 'role' => 'Cook', 'status' => 'Active', 'email' => 'sarah@restaurant.com', 'phone' => '+1 234 567 8901', 'photo' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100&h=100&fit=crop'],
                                ['id' => 2, 'name' => 'Mike Johnson', 'role' => 'Waiter', 'status' => 'Active', 'email' => 'mike@restaurant.com', 'phone' => '+1 234 567 8902', 'photo' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop'],
                                ['id' => 3, 'name' => 'Emma Wilson', 'role' => 'Cashier', 'status' => 'Active', 'email' => 'emma@restaurant.com', 'phone' => '+1 234 567 8903', 'photo' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=100&h=100&fit=crop'],
                                ['id' => 4, 'name' => 'James Brown', 'role' => 'Delivery', 'status' => 'Inactive', 'email' => 'james@restaurant.com', 'phone' => '+1 234 567 8904', 'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&h=100&fit=crop'],
                            ];
                        @endphp

                        @foreach($staffMembers as $staff)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-4">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ $staff['photo'] }}" class="h-10 w-10 rounded-full object-cover shadow-sm">
                                        <span class="text-sm font-semibold text-gray-900">{{ $staff['name'] }}</span>
                                    </div>
                                </td>
                                <td class="py-4 text-sm text-gray-600">{{ $staff['role'] }}</td>
                                <td class="py-4">
                                    <div class="text-sm">
                                        <div class="font-medium text-gray-900">{{ $staff['email'] }}</div>
                                        <div class="text-gray-500">{{ $staff['phone'] }}</div>
                                    </div>
                                </td>
                                <td class="py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $staff['status'] === 'Active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $staff['status'] }}
                                    </span>
                                </td>
                                <td class="py-4">
                                    <div class="flex items-center space-x-2">
                                        <button @click="openView({{ json_encode($staff) }})" class="p-2 text-gray-400 hover:text-[#8B1C3A] transition-colors">
                                            <i data-lucide="eye" class="h-4 w-4"></i>
                                        </button>
                                        <button @click="openEdit({{ json_encode($staff) }})" class="p-2 text-gray-400 hover:text-blue-600 transition-colors">
                                            <i data-lucide="pencil" class="h-4 w-4"></i>
                                        </button>
                                        <button @click="deleteStaff({{ $staff['id'] }})" class="p-2 text-gray-400 hover:text-red-600 transition-colors">
                                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Staff Modal -->
    <div x-show="isAddDialogOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
        <div @click="isAddDialogOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm animate-fade-in"></div>
        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden animate-zoom-in">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">Add Staff Account</h2>
                <button @click="isAddDialogOpen = false"><i data-lucide="x" class="w-6 h-6 text-gray-400"></i></button>
            </div>
            <form class="p-6 space-y-4">
                <!-- Profile Picture Upload -->
                <div class="flex flex-col items-center justify-center space-y-3 pb-4">
                    <div class="w-24 h-24 rounded-full bg-gray-100 border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden relative group">
                        <i data-lucide="camera" class="w-8 h-8 text-gray-400 group-hover:scale-110 transition-transform"></i>
                        <input type="file" class="absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Upload Profile Picture</p>
                </div>

                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Full Name</label>
                    <input type="text" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Role</label>
                        <select class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                            <option>Cook</option>
                            <option>Waiter</option>
                            <option>Cashier</option>
                            <option>Delivery</option>
                            <option>Restaurant Manager</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Phone</label>
                        <input type="text" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Email Address</label>
                    <input type="email" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                </div>
                <div class="flex justify-end pt-4">
                    <button type="submit" class="px-6 py-2.5 bg-[#8B1C3A] text-white font-bold rounded-xl hover:bg-[#a01c3a] transition-all shadow-lg shadow-[#8B1C3A]/20">Create Account</button>
                </div>
            </form>
        </div>
    </div>

    <!-- View Staff Modal -->
    <template x-if="selectedStaff">
        <div x-show="isViewDialogOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
            <div @click="isViewDialogOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm animate-fade-in"></div>
            <div class="relative w-full max-w-sm bg-white rounded-3xl shadow-2xl overflow-hidden animate-zoom-in">
                <div class="h-32 bg-[#8B1C3A] relative">
                    <button @click="isViewDialogOpen = false" class="absolute top-4 right-4 p-2 bg-white/20 hover:bg-white/30 rounded-full transition-colors">
                        <i data-lucide="x" class="w-5 h-5 text-white"></i>
                    </button>
                </div>
                <div class="px-6 pb-8 -mt-16 text-center">
                    <img :src="selectedStaff.photo" class="w-32 h-32 rounded-3xl object-cover mx-auto border-4 border-white shadow-xl">
                    <h3 class="mt-4 text-xl font-bold text-gray-900" x-text="selectedStaff.name"></h3>
                    <p class="text-xs font-bold text-[#8B1C3A] uppercase tracking-widest mt-1" x-text="selectedStaff.role"></p>
                    
                    <div class="mt-8 space-y-4 text-left">
                        <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-2xl">
                            <div class="bg-white p-2 rounded-lg shadow-sm"><i data-lucide="mail" class="w-4 h-4 text-gray-400"></i></div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase">Email</p>
                                <p class="text-sm font-medium text-gray-700" x-text="selectedStaff.email"></p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-2xl">
                            <div class="bg-white p-2 rounded-lg shadow-sm"><i data-lucide="phone" class="w-4 h-4 text-gray-400"></i></div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase">Phone</p>
                                <p class="text-sm font-medium text-gray-700" x-text="selectedStaff.phone"></p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-2xl">
                            <div class="bg-white p-2 rounded-lg shadow-sm"><i data-lucide="shield-check" class="w-4 h-4 text-gray-400"></i></div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase">Status</p>
                                <p class="text-sm font-medium text-green-600" x-text="selectedStaff.status"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <!-- Edit Staff Modal -->
    <template x-if="selectedStaff">
        <div x-show="isEditDialogOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
            <div @click="isEditDialogOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm animate-fade-in"></div>
            <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden animate-zoom-in">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-900">Edit Staff Member</h2>
                    <button @click="isEditDialogOpen = false"><i data-lucide="x" class="w-6 h-6 text-gray-400"></i></button>
                </div>
                <form class="p-6 space-y-4">
                    <div class="flex flex-col items-center justify-center space-y-3 pb-4">
                        <div class="w-24 h-24 rounded-full border-2 border-[#8B1C3A] overflow-hidden relative group">
                            <img :src="selectedStaff.photo" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer">
                                <i data-lucide="camera" class="w-6 h-6 text-white"></i>
                            </div>
                            <input type="file" class="absolute inset-0 opacity-0 cursor-pointer">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Full Name</label>
                        <input type="text" x-model="selectedStaff.name" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-sm font-semibold text-gray-700">Role</label>
                            <select x-model="selectedStaff.role" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                                <option>Cook</option>
                                <option>Waiter</option>
                                <option>Cashier</option>
                                <option>Delivery</option>
                                <option>Restaurant Manager</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="text-sm font-semibold text-gray-700">Phone</label>
                            <input type="text" x-model="selectedStaff.phone" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                        </div>
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Email Address</label>
                        <input type="email" x-model="selectedStaff.email" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
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
