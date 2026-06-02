@extends('layouts.dashboard')

@section('title', 'System Communications Hub')
@section('header_title', 'Secure Terminal // Messaging')
@section('header_subtitle', 'Real-time Cryptographic Connection // Active Sync')

@section('content')
<div x-data="chatSystem()" class="h-[calc(100vh-220px)] flex bg-white border border-zinc-200 overflow-hidden shadow-[4px_4px_0px_0px_rgba(0,0,0,0.05)]" x-cloak>
    
    <!-- ── LEFT SIDEBAR: CONTACT LIST ── -->
    <div class="w-80 border-r border-zinc-200 flex flex-col bg-zinc-50 flex-shrink-0">
        <!-- Search contacts -->
        <div class="p-4 border-b border-zinc-200 bg-white">
            <div class="relative">
                <input 
                    type="text" 
                    x-model="searchQuery" 
                    placeholder="SEARCH CONTACTS..." 
                    class="w-full px-3 py-2 text-[10px] font-mono border border-zinc-200 focus:border-cyan-600 focus:ring-0 focus:outline-none placeholder-zinc-400 bg-zinc-50 uppercase tracking-wider"
                />
                <div class="absolute right-3 top-2.5 text-zinc-400">
                    <i data-lucide="search" class="size-3.5"></i>
                </div>
            </div>
        </div>

        <!-- Contacts list -->
        <div class="flex-1 overflow-y-auto divide-y divide-zinc-100">
            <!-- Loading state -->
            <template x-if="loadingContacts && contacts.length === 0">
                <div class="p-8 text-center">
                    <div class="size-6 border-2 border-zinc-300 border-t-cyan-600 rounded-full animate-spin mx-auto mb-2"></div>
                    <p class="text-[9px] font-mono text-zinc-400 uppercase tracking-widest">Retrieving list...</p>
                </div>
            </template>

            <!-- No contacts -->
            <template x-if="!loadingContacts && filteredContacts().length === 0">
                <div class="p-8 text-center">
                    <i data-lucide="users-round" class="size-6 text-zinc-300 mx-auto mb-2"></i>
                    <p class="text-[9px] font-mono text-zinc-400 uppercase tracking-widest">No contacts found</p>
                </div>
            </template>

            <!-- Contact Row -->
            <template x-for="contact in filteredContacts()" :key="contact.id">
                <div 
                    @click="selectContact(contact)"
                    :class="activeContact && activeContact.id === contact.id ? 'bg-cyan-50/50 border-l-4 border-cyan-600' : 'bg-white hover:bg-zinc-50 border-l-4 border-transparent'"
                    class="p-4 flex items-center gap-x-3 cursor-pointer transition-all duration-150 relative"
                >
                    <!-- Avatar -->
                    <div class="h-10 w-10 flex-shrink-0 flex items-center justify-center font-mono text-xs font-bold text-white relative"
                         :class="contact.role === 'admin' ? 'bg-zinc-900 border border-zinc-800' : (contact.role === 'co-coach' ? 'bg-cyan-700' : 'bg-zinc-600')">
                        <span x-text="contact.name.substring(0, 2).toUpperCase()"></span>
                        <!-- Status indicator -->
                        <span class="absolute bottom-0 right-0 h-2.5 w-2.5 bg-green-500 border-2 border-white rounded-full"></span>
                    </div>

                    <!-- Details -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <h4 class="text-[10px] font-bold text-zinc-900 uppercase truncate" x-text="contact.name"></h4>
                            <span 
                                x-show="contact.last_message" 
                                class="text-[8px] font-mono text-zinc-400" 
                                x-text="formatTime(contact.last_message?.created_at)"
                            ></span>
                        </div>
                        <div class="flex items-center justify-between mt-1">
                            <p class="text-[9px] font-mono text-zinc-500 truncate pr-2 uppercase">
                                <template x-if="contact.last_message">
                                    <span>
                                        <template x-if="contact.last_message.is_sender"><span>YOU: </span></template>
                                        <span x-text="contact.last_message.file_type ? '[' + contact.last_message.file_type.toUpperCase() + ' ATTACHMENT]' : contact.last_message.message"></span>
                                    </span>
                                </template>
                                <template x-if="!contact.last_message">
                                    <span class="text-zinc-400 italic">No communication yet</span>
                                </template>
                            </p>

                            <!-- Badge -->
                            <span 
                                x-show="contact.unread_count > 0" 
                                class="h-4 min-w-4 px-1 flex items-center justify-center bg-cyan-600 text-white text-[8px] font-mono font-bold rounded-full"
                                x-text="contact.unread_count"
                            ></span>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- ── RIGHT MAIN WINDOW: ACTIVE CHAT ── -->
    <div class="flex-1 flex flex-col bg-zinc-50 relative">
        <template x-if="!activeContact">
            <div class="flex-1 flex flex-col items-center justify-center p-8 bg-zinc-50/50">
                <div class="p-6 bg-white border border-zinc-200 shadow-sm text-center max-w-sm">
                    <i data-lucide="messages-square" class="size-8 text-cyan-600 mx-auto mb-4 animate-bounce"></i>
                    <h3 class="text-[11px] font-mono font-bold uppercase tracking-wider text-zinc-800">Secure Communications</h3>
                    <p class="text-[10px] text-zinc-500 mt-2 leading-relaxed uppercase">Select an active contact from the sidebar to establish a secure, real-time cryptographic sync.</p>
                </div>
            </div>
        </template>

        <template x-if="activeContact">
            <div class="flex-1 flex flex-col h-full overflow-hidden">
                
                <!-- Chat Window Header -->
                <div class="px-6 py-4 bg-white border-b border-zinc-200 flex items-center justify-between z-10">
                    <div class="flex items-center gap-x-3">
                        <div class="h-10 w-10 flex items-center justify-center font-mono text-xs font-bold text-white"
                             :class="activeContact.role === 'admin' ? 'bg-zinc-900 border border-zinc-800' : (activeContact.role === 'co-coach' ? 'bg-cyan-700' : 'bg-zinc-600')">
                            <span x-text="activeContact.name.substring(0, 2).toUpperCase()"></span>
                        </div>
                        <div>
                            <div class="flex items-center gap-x-2">
                                <h3 class="text-xs font-bold text-zinc-900 uppercase" x-text="activeContact.name"></h3>
                                <span class="px-1.5 py-0.5 bg-zinc-100 text-zinc-600 text-[8px] font-mono font-semibold uppercase tracking-wider" x-text="activeContact.role"></span>
                            </div>
                            <div class="flex items-center gap-x-1.5 mt-0.5">
                                <span class="h-1.5 w-1.5 bg-green-500 rounded-full animate-pulse"></span>
                                <span class="text-[8px] font-mono text-zinc-400 uppercase tracking-widest">Active Connection</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Message Container (WhatsApp Theme Wallpaper background) -->
                <div 
                    x-ref="messageContainer"
                    class="flex-1 overflow-y-auto p-6 space-y-4"
                    style="background-color: #fafafa; background-image: radial-gradient(#e4e4e7 1px, transparent 1px); background-size: 16px 16px;"
                >
                    <template x-for="(msg, index) in messages" :key="msg.id">
                        <div class="flex flex-col" :class="msg.sender_id === currentUserId ? 'items-end' : 'items-start'">
                            
                            <!-- Date separator if first message or new day -->
                            <template x-if="index === 0 || isNewDay(messages[index-1].created_at, msg.created_at)">
                                <div class="w-full flex justify-center my-4">
                                    <span class="px-2.5 py-1 bg-white border border-zinc-200 text-[8px] font-mono font-bold text-zinc-500 uppercase tracking-widest shadow-sm" x-text="formatDate(msg.created_at)"></span>
                                </div>
                            </template>

                            <!-- Message Bubble Card -->
                            <div 
                                :class="msg.sender_id === currentUserId ? 'bg-[#d9fdd3] border-cyan-700/20 text-zinc-900 rounded-tl-xl rounded-tr-sm rounded-bl-xl shadow-sm' : 'bg-white border-zinc-200 text-zinc-900 rounded-tl-sm rounded-tr-xl rounded-br-xl shadow-sm'"
                                class="max-w-[70%] p-3 border"
                            >
                                <!-- Content details -->
                                <div class="space-y-2">
                                    <!-- Image Preview -->
                                    <template x-if="msg.file_path && msg.file_type === 'image'">
                                        <div class="overflow-hidden border border-zinc-200/50 bg-zinc-50 group">
                                            <a :href="msg.file_path" target="_blank">
                                                <img :src="msg.file_path" alt="Uploaded photo" class="max-h-64 object-cover w-full transition-transform duration-300 group-hover:scale-105" />
                                            </a>
                                        </div>
                                    </template>

                                    <!-- Non-Image Attachment Download -->
                                    <template x-if="msg.file_path && msg.file_type === 'file'">
                                        <a :href="msg.file_path" target="_blank" class="flex items-center gap-x-3 p-2 bg-zinc-50 border border-zinc-200 hover:bg-zinc-100 transition-colors duration-150">
                                            <div class="h-8 w-8 bg-cyan-50 border border-cyan-200 flex items-center justify-center text-cyan-700">
                                                <i data-lucide="file-text" class="size-4"></i>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-[9px] font-mono font-semibold truncate text-zinc-800" x-text="msg.file_name"></p>
                                                <p class="text-[7px] font-mono text-zinc-400 uppercase">Secure attachment</p>
                                            </div>
                                            <i data-lucide="download" class="size-3.5 text-zinc-400 hover:text-zinc-900 transition-colors"></i>
                                        </a>
                                    </template>

                                    <!-- Message Text -->
                                    <template x-if="msg.message">
                                        <p class="text-[11px] leading-relaxed break-words font-sans" x-text="msg.message"></p>
                                    </template>
                                </div>

                                <!-- Time & Tick indicators -->
                                <div class="flex items-center justify-end gap-x-1 mt-1">
                                    <span class="text-[7px] font-mono text-zinc-400" x-text="formatTime(msg.created_at)"></span>
                                    <template x-if="msg.sender_id === currentUserId">
                                        <span>
                                            <i x-show="!msg.is_read" data-lucide="check" class="size-3 text-zinc-400"></i>
                                            <i x-show="msg.is_read" data-lucide="check-check" class="size-3 text-cyan-600"></i>
                                        </span>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Active Upload File Strip -->
                <div x-show="selectedFile" class="px-6 py-2 bg-cyan-50 border-t border-cyan-200 flex items-center justify-between">
                    <div class="flex items-center gap-x-2 min-w-0">
                        <i data-lucide="paperclip" class="size-3.5 text-cyan-700 flex-shrink-0 animate-bounce"></i>
                        <span class="text-[9px] font-mono font-bold text-cyan-800 truncate uppercase" x-text="'ATTACHMENT: ' + fileName"></span>
                    </div>
                    <button @click="clearFile()" class="p-1 text-cyan-700 hover:text-red-600 transition-colors">
                        <i data-lucide="x" class="size-3.5"></i>
                    </button>
                </div>

                <!-- Message Input Bar (WhatsApp style bottom footer) -->
                <div class="p-4 bg-white border-t border-zinc-200">
                    <form @submit.prevent="sendMessage()" class="flex items-center gap-x-3">
                        
                        <!-- Upload attachment button -->
                        <button 
                            type="button"
                            @click="$refs.fileInput.click()"
                            class="h-9 w-9 border border-zinc-200 hover:border-cyan-500 hover:bg-zinc-50 flex items-center justify-center text-zinc-500 hover:text-cyan-600 transition-all flex-shrink-0"
                            title="Attach Image or File"
                        >
                            <i data-lucide="paperclip" class="size-4"></i>
                        </button>
                        
                        <input 
                            type="file" 
                            x-ref="fileInput" 
                            @change="handleFileChange($event)" 
                            class="hidden" 
                            accept="image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,text/plain"
                        />

                        <!-- Message Input Field -->
                        <input 
                            type="text" 
                            x-model="messageText"
                            placeholder="TYPE SECURE MESSAGE..." 
                            class="flex-1 h-9 px-4 text-[10px] font-mono border border-zinc-200 focus:border-cyan-600 focus:ring-0 focus:outline-none bg-zinc-50 placeholder-zinc-400 uppercase tracking-wider"
                            :disabled="isUploading"
                        />

                        <!-- Send Button -->
                        <button 
                            type="submit"
                            :disabled="isUploading || (!messageText.trim() && !selectedFile)"
                            class="h-9 px-4 bg-zinc-950 border border-zinc-950 hover:bg-cyan-700 hover:border-cyan-700 text-white font-mono text-[9px] font-bold uppercase tracking-widest transition-all duration-150 flex items-center justify-center gap-x-2 disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span x-show="!isUploading">TRANSMIT</span>
                            <span x-show="isUploading">SENDING...</span>
                            <i data-lucide="send" class="size-3.5"></i>
                        </button>
                    </form>
                </div>

            </div>
        </template>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('chatSystem', () => ({
            contacts: [],
            activeContact: null,
            messages: [],
            messageText: '',
            searchQuery: '',
            selectedFile: null,
            fileName: '',
            filePreview: null,
            isUploading: false,
            loadingContacts: true,
            loadingMessages: false,
            pollingInterval: null,
            currentUserId: {{ auth()->id() }},
            
            init() {
                this.fetchContacts();
                
                // Real-time loop polling every 3 seconds for updates
                this.pollingInterval = setInterval(() => {
                    this.fetchContacts(true);
                    if (this.activeContact) {
                        this.fetchMessages(this.activeContact.id, true);
                    }
                }, 3000);
            },
            
            destroy() {
                if (this.pollingInterval) {
                    clearInterval(this.pollingInterval);
                }
            },
            
            fetchContacts(silent = false) {
                if (!silent) this.loadingContacts = true;
                
                fetch('{{ route("coach.chat.contacts") }}')
                    .then(res => res.json())
                    .then(data => {
                        this.contacts = data.contacts;
                        
                        // Keep current active contact synced
                        if (this.activeContact) {
                            const updated = this.contacts.find(c => c.id === this.activeContact.id);
                            if (updated) {
                                this.activeContact.unread_count = updated.unread_count;
                            }
                        }
                    })
                    .finally(() => {
                        if (!silent) this.loadingContacts = false;
                        this.reinitLucide();
                    });
            },
            
            filteredContacts() {
                if (!this.searchQuery.trim()) return this.contacts;
                const query = this.searchQuery.toLowerCase();
                return this.contacts.filter(c => c.name.toLowerCase().includes(query));
            },
            
            selectContact(contact) {
                this.activeContact = contact;
                this.messages = [];
                this.fetchMessages(contact.id);
                contact.unread_count = 0;
            },
            
            fetchMessages(contactId, silent = false) {
                if (!silent) this.loadingMessages = true;
                
                let url = '{{ route("coach.chat.messages", ["contactId" => ":id"]) }}';
                url = url.replace(':id', contactId);
                
                fetch(url)
                    .then(res => res.json())
                    .then(data => {
                        // Prevent race condition - only update if still viewing same contact
                        if (!this.activeContact || this.activeContact.id !== contactId) return;
                        const prevCount = this.messages.length;
                        this.messages = data.messages;
                        
                        if (data.messages.length > prevCount) {
                            this.$nextTick(() => {
                                this.scrollToBottom();
                            });
                        }
                    })
                    .finally(() => {
                        if (!silent) this.loadingMessages = false;
                        this.reinitLucide();
                    });
            },
            
            handleFileChange(e) {
                const file = e.target.files[0];
                if (!file) return;
                
                // Max 5MB file size validation
                const maxSize = 5 * 1024 * 1024;
                if (file.size > maxSize) {
                    alert('File too large. Maximum size is 5MB.');
                    this.clearFile();
                    return;
                }
                
                this.selectedFile = file;
                this.fileName = file.name;
            },
            
            clearFile() {
                this.selectedFile = null;
                this.fileName = '';
                if (this.$refs.fileInput) {
                    this.$refs.fileInput.value = '';
                }
            },
            
            async compressImage(file) {
                return new Promise((resolve) => {
                    if (!file.type.startsWith('image/')) {
                        resolve(file);
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const img = new Image();
                        img.onload = () => {
                            const canvas = document.createElement('canvas');
                            let { width, height } = img;
                            // Max dimensions 1920px
                            const maxDim = 1920;
                            if (width > maxDim || height > maxDim) {
                                if (width > height) {
                                    height = (height / width) * maxDim;
                                    width = maxDim;
                                } else {
                                    width = (width / height) * maxDim;
                                    height = maxDim;
                                }
                            }
                            canvas.width = width;
                            canvas.height = height;
                            const ctx = canvas.getContext('2d');
                            ctx.drawImage(img, 0, 0, width, height);
                            canvas.toBlob((blob) => {
                                const compressed = new File([blob], file.name, {
                                    type: file.type,
                                    lastModified: Date.now()
                                });
                                resolve(compressed);
                            }, file.type, 0.8);
                        };
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                });
            },
            
            async sendMessage() {
                if (!this.activeContact) return;
                if (!this.messageText.trim() && !this.selectedFile) return;
                
                this.isUploading = true;
                
                const formData = new FormData();
                if (this.messageText.trim()) {
                    formData.append('message', this.messageText);
                }
                if (this.selectedFile) {
                    const compressed = await this.compressImage(this.selectedFile);
                    formData.append('file', compressed);
                }
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                let url = '{{ route("coach.chat.send", ["contactId" => ":id"]) }}';
                url = url.replace(':id', this.activeContact.id);
                
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.messages.push(data.message);
                        this.messageText = '';
                        this.clearFile();
                        this.$nextTick(() => {
                            this.scrollToBottom();
                        });
                        this.fetchContacts(true);
                    }
                })
                .finally(() => {
                    this.isUploading = false;
                    this.reinitLucide();
                });
            },
            
            scrollToBottom() {
                const container = this.$refs.messageContainer;
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            },
            
            formatTime(dateStr) {
                if (!dateStr) return '';
                const date = new Date(dateStr);
                return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: false });
            },
            
            formatDate(dateStr) {
                if (!dateStr) return '';
                const date = new Date(dateStr);
                return date.toLocaleDateString([], { month: 'short', day: 'numeric', year: 'numeric' });
            },
            
            isNewDay(prevDateStr, currDateStr) {
                const prev = new Date(prevDateStr).toDateString();
                const curr = new Date(currDateStr).toDateString();
                return prev !== curr;
            },
            
            reinitLucide() {
                this.$nextTick(() => {
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                });
            }
        }));
    });
</script>
@endsection
