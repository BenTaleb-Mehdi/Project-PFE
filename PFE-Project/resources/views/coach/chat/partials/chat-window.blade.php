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
