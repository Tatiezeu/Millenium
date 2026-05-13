@extends('layouts.dashboard')

@section('title', 'Notifications')
@section('page_title', 'Notifications')

@section('content')
<div class="space-y-6" x-data="{ 
    isWriteModalOpen: false, 
    isReplyModalOpen: false,
    replyTo: null,
    markAsRead(id) {
        alert('Notification ' + id + ' marked as read.');
    },
    deleteNotif(id) {
        if(confirm('Delete this notification?')) {
            alert('Notification ' + id + ' deleted.');
        }
    },
    openReply(notif) {
        this.replyTo = notif;
        this.isReplyModalOpen = true;
    }
}">
    <div class="flex justify-between items-center">
        <h2 class="text-sm font-medium text-gray-500">Manage your system alerts and team communications</h2>
        <button @click="isWriteModalOpen = true" class="bg-[#8B1C3A] text-white px-4 py-2 rounded-lg hover:bg-[#a01c3a] transition-colors flex items-center text-sm font-medium">
            <i data-lucide="plus" class="h-4 w-4 mr-2"></i>
            Write Notification
        </button>
    </div>

    <!-- Top Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @php
            $notifStats = [
                ['title' => 'Total Notifications', 'value' => '5', 'color' => 'text-gray-900'],
                ['title' => 'Unread', 'value' => '2', 'color' => 'text-[#8B1C3A]'],
                ['title' => 'Read', 'value' => '3', 'color' => 'text-gray-400'],
            ];
        @endphp

        @foreach($notifStats as $stat)
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-sm font-medium text-gray-500 mb-2">{{ $stat['title'] }}</h3>
                <div class="text-3xl font-bold {{ $stat['color'] }}">{{ $stat['value'] }}</div>
            </div>
        @endforeach
    </div>

    <!-- Notifications List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50">
            <h3 class="font-bold text-gray-900">All Notifications</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @php
                    $notifications = [
                        ['id' => 1, 'from' => 'Sarah Chen', 'role' => 'Head Chef', 'message' => 'Low stock alert: Fresh salmon running low for tonight\'s service. Please check inventory.', 'time' => '5 min ago', 'unread' => true, 'canReply' => true, 'attachments' => [['name' => 'inventory.pdf', 'type' => 'pdf']]],
                        ['id' => 2, 'from' => 'Mike Johnson', 'role' => 'Waiter', 'message' => 'Table 12 requesting manager presence for special request regarding wine pairing.', 'time' => '15 min ago', 'unread' => true, 'canReply' => true, 'attachments' => []],
                        ['id' => 3, 'from' => 'System', 'role' => 'Automated', 'message' => 'New reservation: Party of 6 for tomorrow at 7:00 PM. Confirmation pending.', 'time' => '1 hour ago', 'unread' => false, 'canReply' => false, 'attachments' => []],
                        ['id' => 4, 'from' => 'Emma Wilson', 'role' => 'Cashier', 'message' => 'Daily sales report ready for review. Total sales: 245,000 FCFA.', 'time' => '2 hours ago', 'unread' => false, 'canReply' => true, 'attachments' => [['name' => 'sales_report.jpg', 'type' => 'image']]],
                        ['id' => 5, 'from' => 'Admin', 'role' => 'System Administrator', 'message' => 'Scheduled maintenance tonight at 11 PM. System will be offline for 30 minutes.', 'time' => '3 hours ago', 'unread' => false, 'canReply' => false, 'attachments' => []],
                    ];
                @endphp

                @foreach($notifications as $notif)
                    <div class="border rounded-xl p-6 transition-all {{ $notif['unread'] ? 'bg-blue-50/30 border-blue-100 shadow-sm' : 'border-gray-100 hover:bg-gray-50/50' }}">
                        <div class="flex items-start space-x-4">
                            <div class="h-12 w-12 rounded-full bg-[#8B1C3A] text-white flex items-center justify-center text-sm font-bold shadow-md">
                                @foreach(explode(' ', $notif['from']) as $n) {{ substr($n, 0, 1) }} @endforeach
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-2">
                                    <div>
                                        <p class="text-sm font-bold text-gray-900">{{ $notif['from'] }}</p>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $notif['role'] }}</p>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        @if($notif['unread'])
                                            <span class="w-2.5 h-2.5 bg-[#8B1C3A] rounded-full animate-pulse"></span>
                                        @endif
                                        <span class="text-xs font-medium text-gray-400">{{ $notif['time'] }}</span>
                                    </div>
                                </div>

                                <p class="text-sm text-gray-700 leading-relaxed my-3">{{ $notif['message'] }}</p>

                                @if(!empty($notif['attachments']))
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        @foreach($notif['attachments'] as $att)
                                            <div class="flex items-center space-x-2 px-3 py-1.5 bg-white border border-gray-100 rounded-lg shadow-sm text-xs text-gray-600">
                                                <i data-lucide="{{ $att['type'] === 'pdf' ? 'file-text' : 'image' }}" class="w-3.5 h-3.5 text-[#8B1C3A]"></i>
                                                <span class="font-medium">{{ $att['name'] }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="flex items-center space-x-3 pt-2">
                                    @if($notif['canReply'])
                                        <button @click="openReply({{ json_encode($notif) }})" class="flex items-center px-4 py-1.5 text-xs font-bold text-gray-600 hover:text-gray-900 bg-white border border-gray-100 rounded-lg shadow-sm transition-all">
                                            <i data-lucide="reply" class="h-3.5 w-3.5 mr-1.5"></i> Reply
                                        </button>
                                    @endif
                                    @if($notif['unread'])
                                        <button @click="markAsRead({{ $notif['id'] }})" class="px-4 py-1.5 text-xs font-bold text-[#8B1C3A] hover:bg-white border border-transparent rounded-lg transition-all">
                                            Mark as Read
                                        </button>
                                    @endif
                                    <button @click="deleteNotif({{ $notif['id'] }})" class="flex items-center px-4 py-1.5 text-xs font-bold text-red-500 hover:text-red-700 transition-all">
                                        <i data-lucide="trash-2" class="h-3.5 w-3.5 mr-1.5"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Write Notification Modal -->
    <div x-show="isWriteModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
        <div @click="isWriteModalOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm animate-fade-in"></div>
        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden animate-zoom-in">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">Compose Notification</h2>
                <button @click="isWriteModalOpen = false" class="text-gray-400 hover:text-gray-600"><i data-lucide="x" class="w-6 h-6"></i></button>
            </div>
            <form class="p-6 space-y-4">
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Recipient</label>
                    <select class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none transition-all appearance-none">
                        <option value="all">All Staff</option>
                        <option value="waiters">Waiters Only</option>
                        <option value="cooks">Kitchen Team</option>
                        <option value="managers">Managers</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Priority</label>
                    <div class="flex space-x-4">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="radio" name="priority" value="normal" checked class="text-[#8B1C3A] focus:ring-[#8B1C3A]">
                            <span class="text-sm">Normal</span>
                        </label>
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="radio" name="priority" value="high" class="text-[#8B1C3A] focus:ring-[#8B1C3A]">
                            <span class="text-sm text-red-600 font-bold">Urgent</span>
                        </label>
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Message</label>
                    <textarea rows="4" placeholder="Write your message here..." class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none transition-all"></textarea>
                </div>
                <!-- Attachment Upload -->
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Attachments (Max 3)</label>
                    <div class="flex items-center justify-center w-full">
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-200 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors cursor-pointer group">
                            <i data-lucide="paperclip" class="w-8 h-8 text-gray-300 group-hover:text-[#8B1C3A] transition-colors"></i>
                            <p class="text-[10px] font-bold text-gray-400 mt-2">CLICK TO UPLOAD IMAGES OR PDF</p>
                            <input type="file" class="hidden" multiple>
                        </label>
                    </div>
                </div>
                <div class="flex justify-end pt-4">
                    <button type="submit" class="px-6 py-2.5 bg-[#8B1C3A] text-white font-bold rounded-xl hover:bg-[#a01c3a] transition-all shadow-lg shadow-[#8B1C3A]/20">Send Notification</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Reply Modal -->
    <template x-if="replyTo">
        <div x-show="isReplyModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
            <div @click="isReplyModalOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm animate-fade-in"></div>
            <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden animate-zoom-in">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-900" x-text="'Reply to ' + replyTo.from"></h2>
                    <button @click="isReplyModalOpen = false"><i data-lucide="x" class="w-6 h-6 text-gray-400"></i></button>
                </div>
                <form class="p-6 space-y-4">
                    <div class="bg-gray-50 p-4 rounded-xl mb-2 text-sm text-gray-600 border border-gray-100 italic">
                        <span class="font-bold block mb-1">Replying to:</span>
                        <span x-text="replyTo.message"></span>
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Your Message</label>
                        <textarea rows="4" placeholder="Write your reply..." class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none transition-all"></textarea>
                    </div>
                    <!-- Attachment Upload -->
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Attachments (Optional)</label>
                        <div class="flex items-center space-x-2">
                            <label class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-xs font-bold text-gray-500 cursor-pointer hover:bg-gray-50">
                                <i data-lucide="plus" class="w-3.5 h-3.5 inline mr-1"></i> Add File
                                <input type="file" class="hidden">
                            </label>
                        </div>
                    </div>
                    <div class="flex justify-end pt-4 space-x-3">
                        <button type="button" @click="isReplyModalOpen = false" class="px-6 py-2.5 text-gray-500 font-bold hover:bg-gray-50 rounded-xl transition-all">Cancel</button>
                        <button type="submit" class="px-6 py-2.5 bg-[#8B1C3A] text-white font-bold rounded-xl hover:bg-[#a01c3a] transition-all shadow-lg shadow-[#8B1C3A]/20">Send Reply</button>
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
