{-- Notifications View --}
{-- This view handles the display and user interaction for Notifications. --}
@extends('layouts.dashboard')

@section('title', 'Notifications')
@section('page_title', 'Notifications Center')

@section('content')
<div class="space-y-6" x-data="{ 
    tab: 'inbox', 
    isComposeOpen: false,
    attachments: [],
    replyTo: null,
    receiverId: '',
    message: '',
    parentId: null,
    
    openCompose(recipient = null, parentId = null) {
        if (recipient) {
            this.receiverId = recipient.id || recipient._id;
            this.replyTo = recipient;
            this.parentId = parentId;
        } else {
            this.receiverId = '{{ Auth::user()->role === 'client' ? 'restaurant manager' : '' }}';
            this.replyTo = null;
            this.parentId = null;
        }
        this.isComposeOpen = true;
    },
    addAttachments(event) {
        const files = Array.from(event.target.files);
        if (this.attachments.length + files.length > 3) {
            alert('Maximum 3 attachments allowed');
            return;
        }
        
        const dt = new DataTransfer();
        // Keep existing files
        this.attachments.forEach(att => dt.items.add(att.file));
        // Add new files
        files.forEach(file => {
            dt.items.add(file);
            this.attachments.push({
                file: file,
                name: file.name,
                size: (file.size / 1024).toFixed(1) + ' KB'
            });
        });
        this.$refs.mainFileInput.files = dt.files;
    },
    removeAttachment(index) {
        this.attachments.splice(index, 1);
        const dt = new DataTransfer();
        this.attachments.forEach(att => dt.items.add(att.file));
        this.$refs.mainFileInput.files = dt.files;
    }
}">
    <!-- Action Bar -->
    <div class="flex justify-between items-center bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex space-x-2">
            <button @click="tab = 'inbox'" 
                    :class="tab === 'inbox' ? 'bg-[#8B1C3A] text-white' : 'text-gray-500 hover:bg-gray-100'"
                    class="px-6 py-2 rounded-xl font-bold transition-all flex items-center">
                <i data-lucide="inbox" class="w-4 h-4 mr-2"></i>
                Inbox (Primary)
            </button>
            <button @click="tab = 'sent'" 
                    :class="tab === 'sent' ? 'bg-[#8B1C3A] text-white' : 'text-gray-500 hover:bg-gray-100'"
                    class="px-6 py-2 rounded-xl font-bold transition-all flex items-center">
                <i data-lucide="send" class="w-4 h-4 mr-2"></i>
                Sent
            </button>
        </div>
        <button @click="openCompose()" class="bg-gray-900 text-white px-6 py-2 rounded-xl font-bold hover:bg-black transition-all flex items-center shadow-lg">
            <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
            Send New Notification
        </button>
    </div>

    <!-- Inbox Tab -->
    <div x-show="tab === 'inbox'" class="space-y-4 animate-fade-in">
        @forelse($inbox as $msg)
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden">
                @if(!$msg->is_read)
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-[#8B1C3A]"></div>
                @endif
                <div class="flex items-start space-x-4">
                    <div class="h-12 w-12 rounded-full bg-[#8B1C3A] text-white flex items-center justify-center font-bold overflow-hidden shadow-inner">
                        @if($msg->sender && $msg->sender->profile_picture)
                            <img src="{{ asset('storage/' . $msg->sender->profile_picture) }}" class="h-full w-full object-cover">
                        @else
                            {{ strtoupper(substr($msg->sender->name ?? 'S', 0, 1)) }}
                        @endif
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start mb-1">
                            <h4 class="font-bold text-gray-900">{{ $msg->sender->name ?? 'System' }}</h4>
                            <span class="text-xs text-gray-400">{{ $msg->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-600 leading-relaxed">{{ $msg->message }}</p>
                        
                        @if($msg->attachments && count($msg->attachments) > 0)
                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach($msg->attachments as $file)
                                    <a href="{{ asset('storage/' . $file['path']) }}" target="_blank" class="flex items-center space-x-2 px-3 py-2 bg-gray-50 border border-gray-100 rounded-lg hover:bg-gray-100 transition-colors group">
                                        <i data-lucide="file" class="w-4 h-4 text-[#8B1C3A]"></i>
                                        <span class="text-xs font-semibold text-gray-600 truncate max-w-[150px]">{{ $file['name'] }}</span>
                                        <i data-lucide="download" class="w-3 h-3 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        <div class="mt-4 flex space-x-4">
                            <button @click="openCompose({{ json_encode($msg->sender) }}, '{{ $msg->id }}')" class="text-xs font-bold text-[#8B1C3A] hover:underline flex items-center">
                                <i data-lucide="reply" class="w-3 h-3 mr-1"></i> Reply
                            </button>
                            <button class="text-xs font-bold text-gray-400 hover:text-red-600 flex items-center transition-colors">
                                <i data-lucide="trash-2" class="w-3 h-3 mr-1"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-100">
                <i data-lucide="mail-warning" class="w-12 h-12 text-gray-200 mx-auto mb-4"></i>
                <p class="text-gray-500 font-medium">Your inbox is empty.</p>
            </div>
        @endforelse
    </div>

    <!-- Sent Tab -->
    <div x-show="tab === 'sent'" class="space-y-4 animate-fade-in" x-cloak>
        @forelse($sent as $msg)
            <div class="bg-gray-50/50 p-6 rounded-2xl border border-gray-200 hover:bg-white transition-colors">
                <div class="flex items-start space-x-4">
                    <div class="h-12 w-12 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-bold">
                        {{ strtoupper(substr($msg->receiver->name ?? 'R', 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start mb-1">
                            <h4 class="font-bold text-gray-900">To: {{ $msg->receiver->name ?? 'Recipient' }}</h4>
                            <span class="text-xs text-gray-400">{{ $msg->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-500 leading-relaxed">{{ $msg->message }}</p>

                        @if($msg->attachments && count($msg->attachments) > 0)
                            <div class="mt-3 flex flex-wrap gap-2">
                                @foreach($msg->attachments as $file)
                                    <div class="flex items-center space-x-2 px-2 py-1 bg-white border border-gray-100 rounded-md">
                                        <i data-lucide="paperclip" class="w-3 h-3 text-gray-400"></i>
                                        <span class="text-[10px] font-medium text-gray-500">{{ $file['name'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="mt-2 text-xs text-gray-400 flex items-center">
                            <i data-lucide="{{ $msg->is_read ? 'check-check' : 'check' }}" class="w-3 h-3 mr-1 {{ $msg->is_read ? 'text-blue-500' : '' }}"></i>
                            {{ $msg->is_read ? 'Read by recipient' : 'Delivered' }}
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-100">
                <i data-lucide="send" class="w-12 h-12 text-gray-200 mx-auto mb-4"></i>
                <p class="text-gray-500 font-medium">No sent notifications yet.</p>
            </div>
        @endforelse
    </div>

    <!-- Compose Modal -->
    <div x-show="isComposeOpen" class="fixed inset-0 z-50 flex items-center justify-center p-6" x-cloak>
        <div @click="isComposeOpen = false; attachments = []" class="fixed inset-0 bg-black/60 backdrop-blur-sm animate-fade-in"></div>
        <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl overflow-hidden animate-zoom-in">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="text-xl font-bold text-gray-900" x-text="replyTo ? 'Reply to ' + replyTo.name : 'New Notification'"></h3>
                <button @click="isComposeOpen = false; attachments = []" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            <form action="{{ route('notifications.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                <input type="hidden" name="parent_id" x-model="parentId">
                
                @if(Auth::user()->role !== 'client')
                <div class="space-y-1" x-show="!replyTo">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Select Recipient</label>
                    <select name="receiver_id" x-model="receiverId" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none">
                        <option value="">Choose recipient...</option>
                        <optgroup label="Broadcast to Roles">
                            <option value="waiter">All Waiters</option>
                            <option value="cook">All Cooks</option>
                            <option value="manager">All Managers</option>
                            <option value="restaurant manager">Restaurant Manager</option>
                            <option value="client">All Clients</option>
                            <option value="all_staff">All Staff Accounts</option>
                        </optgroup>
                        <optgroup label="Individual Users">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ ucfirst($user->role) }})</option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>
                <div class="space-y-1" x-show="replyTo">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Recipient</label>
                    <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-900 flex items-center">
                        <div class="w-6 h-6 rounded-full bg-[#8B1C3A] text-white flex items-center justify-center text-[10px] mr-2 overflow-hidden">
                            <template x-if="replyTo && replyTo.profile_picture">
                                <img :src="'/storage/' + replyTo.profile_picture" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!replyTo || !replyTo.profile_picture">
                                <span x-text="replyTo ? replyTo.name.charAt(0) : ''"></span>
                            </template>
                        </div>
                        <span x-text="replyTo ? replyTo.name : ''"></span>
                        <input type="hidden" name="receiver_id" x-model="receiverId">
                    </div>
                </div>
                @else
                <input type="hidden" name="receiver_id" value="restaurant manager">
                <div class="p-4 bg-[#8B1C3A]/5 border border-[#8B1C3A]/10 rounded-xl">
                    <p class="text-xs font-bold text-[#8B1C3A]">Note: Your message will be sent to the Restaurant Manager.</p>
                </div>
                @endif
                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Message</label>
                    <textarea name="message" rows="4" required placeholder="Type your message here..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#8B1C3A]/20 outline-none resize-none"></textarea>
                </div>

                <!-- Attachment System -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest flex justify-between">
                        Attachments (Max 3)
                        <span x-text="attachments.length + '/3'"></span>
                    </label>
                    
                    <!-- File Row List -->
                    <div class="space-y-2">
                        <template x-for="(att, index) in attachments" :key="index">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 bg-white rounded-lg shadow-sm">
                                        <i data-lucide="file-text" class="w-4 h-4 text-[#8B1C3A]"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-700" x-text="att.name"></p>
                                        <p class="text-[10px] text-gray-400" x-text="att.size"></p>
                                    </div>
                                </div>
                                <button type="button" @click="removeAttachment(index)" class="p-2 text-gray-400 hover:text-red-600 transition-colors">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </template>
                    </div>

                    <!-- Add Attachment Button -->
                    <div x-show="attachments.length < 3">
                        <label class="flex items-center justify-center p-3 border-2 border-dashed border-gray-200 rounded-xl cursor-pointer hover:border-[#8B1C3A]/50 hover:bg-[#8B1C3A]/5 transition-all group">
                            <i data-lucide="paperclip" class="w-4 h-4 mr-2 text-gray-400 group-hover:text-[#8B1C3A]"></i>
                            <span class="text-xs font-bold text-gray-500 group-hover:text-[#8B1C3A]">Add Attachment</span>
                            <input type="file" @change="addAttachments" class="hidden" multiple accept="image/*,.pdf,.doc,.docx">
                        </label>
                    </div>

                    <!-- Hidden input that actually submits the files -->
                    <input type="file" name="attachments[]" class="hidden" multiple x-ref="mainFileInput">
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-[#8B1C3A] text-white px-8 py-3 rounded-xl font-bold hover:bg-[#a01c3a] transition-all shadow-lg shadow-[#8B1C3A]/20 flex items-center">
                        <i data-lucide="send" class="w-4 h-4 mr-2"></i>
                        Send Now
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
