    <!-- ── LEFT SIDEBAR: CONTACT LIST ── -->
    <div class="w-80 border-r border-zinc-200 flex flex-col bg-zinc-50 flex-shrink-0 lg:relative fixed inset-y-0 left-0 z-40 transition-transform duration-300 lg:translate-x-0"
         :class="showContacts ? 'translate-x-0' : '-translate-x-full'">
        <!-- Search contacts -->
        <div class="p-4 border-b border-zinc-200 bg-white">
            <div class="relative">
                <input 
                    type="text" 
                    x-model="searchQuery" 
                    placeholder="SEARCH STAFF..." 
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
                    <p class="text-[9px] font-mono text-zinc-400 uppercase tracking-widest">Searching channels...</p>
                </div>
            </template>

            <!-- No contacts -->
            <template x-if="!loadingContacts && filteredContacts().length === 0">
                <div class="p-8 text-center">
                    <i data-lucide="user-x" class="size-6 text-zinc-300 mx-auto mb-2"></i>
                    <p class="text-[9px] font-mono text-zinc-400 uppercase tracking-widest">No staff available</p>
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
                         :class="contact.role === 'admin' ? 'bg-zinc-900 border border-zinc-800' : 'bg-cyan-700'">
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
