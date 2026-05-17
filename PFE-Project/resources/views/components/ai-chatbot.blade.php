<div 
    x-data="aiChatbot()"
    class="fixed bottom-6 right-6 z-50 font-sans"
>
    <!-- Chat Toggle Button -->
    <button 
        @click="toggleChat()"
        class="bg-[#0891B2] text-white p-4 rounded-full shadow-lg hover:scale-105 transition-transform flex items-center justify-center"
        :class="{ 'hidden': isOpen }"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
        </svg>
    </button>

    <!-- Chat Window -->
    <div 
        x-show="isOpen" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-8"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-8"
        class="w-[400px] bg-white rounded-2xl shadow-2xl flex flex-col overflow-hidden border border-zinc-200"
        style="height: 600px; display: none;"
    >
        <!-- Header -->
        <div class="bg-[#0891B2] text-white px-5 py-6 flex justify-between items-start shrink-0">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center border-2 border-white/30 overflow-hidden">
                        <img src="/images/logo-head.png" alt="Bot Avatar" class="w-8 h-8 object-contain">
                    </div>
                    <div class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-green-400 border-2 border-[#0891B2] rounded-full"></div>
                </div>
                <div>
                    <h3 class="font-bold text-lg leading-tight">CoachBot AI</h3>
                    <p class="text-white/80 text-sm flex items-center gap-1.5">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        Online Now
                    </p>
                </div>
            </div>
            <div class="flex gap-2">
                <button @click="toggleChat()" class="text-white/70 hover:text-white transition-colors p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
        </div>

        <!-- Messages Area -->
        <div class="flex-1 p-5 overflow-y-auto flex flex-col gap-6 bg-[#F8F9FB]" id="chatbot-messages">
            <template x-for="(msg, index) in messages" :key="index">
                <div class="flex flex-col" :class="msg.role === 'user' ? 'items-end' : 'items-start'">
                    <div class="flex items-start gap-2.5 max-w-[85%]" :class="msg.role === 'user' ? 'flex-row-reverse' : ''">
                        <!-- Bot Avatar in Messages -->
                        <template x-if="msg.role === 'ai'">
                            <div class="w-8 h-8 shrink-0 bg-white border border-zinc-200 rounded-full flex items-center justify-center overflow-hidden">
                                <img src="/images/logo-head.png" alt="Bot" class="w-5 h-5 object-contain">
                            </div>
                        </template>

                        <div class="flex flex-col" :class="msg.role === 'user' ? 'items-end' : 'items-start'">
                            <span class="text-[11px] text-zinc-400 font-medium mb-1 px-1" x-text="msg.role === 'user' ? 'You' : 'CoachBot AI'"></span>
                            <div 
                                class="p-4 text-[15px] leading-relaxed shadow-sm" 
                                :class="msg.role === 'user' 
                                    ? 'bg-[#0891B2] text-white rounded-2xl rounded-tr-none' 
                                    : 'bg-white text-zinc-800 rounded-2xl rounded-tl-none border border-zinc-100'"
                            >
                                <p x-html="msg.content.replace(/\n/g, '<br>')" class="break-words"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions (Only for AI and only if relevant) -->
                    <template x-if="msg.role === 'ai' && index === messages.length - 1 && !isLoading">
                        <div class="flex flex-wrap gap-2 mt-3 ml-10">
                            <button @click="input = 'Generate Breakfast'; sendMessage()" class="px-4 py-2 border border-[#0891B2] text-[#0891B2] rounded-full text-sm font-medium hover:bg-[#0891B2]/5 transition-colors">Breakfast</button>
                            <button @click="input = 'Generate Lunch'; sendMessage()" class="px-4 py-2 border border-[#0891B2] text-[#0891B2] rounded-full text-sm font-medium hover:bg-[#0891B2]/5 transition-colors">Lunch</button>
                            <button @click="input = 'Generate Snack'; sendMessage()" class="px-4 py-2 border border-[#0891B2] text-[#0891B2] rounded-full text-sm font-medium hover:bg-[#0891B2]/5 transition-colors">Snack</button>
                        </div>
                    </template>
                </div>
            </template>
            
            <!-- Loading Indicator -->
            <div x-show="isLoading" class="flex items-start gap-2.5">
                <div class="w-8 h-8 shrink-0 bg-white border border-zinc-200 rounded-full flex items-center justify-center">
                    <img src="/images/logo-head.png" alt="Bot" class="w-5 h-5 object-contain">
                </div>
                <div class="bg-white border border-zinc-100 p-4 rounded-2xl rounded-tl-none shadow-sm">
                    <div class="flex gap-1">
                        <div class="w-2 h-2 bg-zinc-300 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                        <div class="w-2 h-2 bg-zinc-300 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                        <div class="w-2 h-2 bg-zinc-300 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="p-4 bg-white border-t border-zinc-100 shrink-0">
            <form @submit.prevent.stop="sendMessage" class="flex items-center gap-2 bg-zinc-50 rounded-xl px-4 py-1 border border-zinc-200 focus-within:border-[#0891B2] transition-colors">
                <input 
                    type="text" 
                    x-model="input" 
                    placeholder="Reply to CoachBot..." 
                    class="flex-1 bg-transparent py-3 text-[15px] focus:outline-none placeholder-zinc-400"
                    :disabled="isLoading"
                >
                <button 
                    type="submit" 
                    class="text-[#0891B2] disabled:text-zinc-300 transition-colors"
                    :disabled="isLoading || input.trim() === ''"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="m21.426 11.097-17.356-8.73c-.93-.468-1.92.518-1.463 1.442l3.492 7.042c.11.222.11.48 0 .702l-3.492 7.042c-.457.924.533 1.91 1.463 1.442l17.356-8.73c.765-.384.765-1.472 0-1.856Z"/></svg>
                </button>
            </form>
            <div class="mt-3 flex justify-between items-center px-1">
                <span class="text-[11px] text-zinc-400">Coach Flow AI Protocol</span>
                <div class="flex items-center gap-1">
                    <span class="text-[11px] text-zinc-400">Powered by</span>
                    <span class="text-[11px] font-bold text-[#0891B2]">MT Engine</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('aiChatbot', () => ({
            isOpen: false,
            isLoading: false,
            input: '',
            messages: [
                { role: 'ai', content: 'Hello! I can help you generate nutrition categories. What would you like to create today?' }
            ],
            
            toggleChat() {
                this.isOpen = !this.isOpen;
                if (this.isOpen) {
                    setTimeout(() => this.scrollToBottom(), 100);
                }
            },
            
            scrollToBottom() {
                const container = document.getElementById('chatbot-messages');
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            },
            
            async sendMessage() {
                if (this.input.trim() === '' || this.isLoading) return;
                
                const userText = this.input.trim();
                this.messages.push({ role: 'user', content: userText });
                this.input = '';
                this.isLoading = true;
                this.scrollToBottom();
                
                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    
                    const response = await fetch('/api/chatbot/send', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ 
                            chatInput: userText
                        })
                    });
                    
                    const data = await response.json();
                    
                    if (response.ok) {
                        const aiResponse = data.output || 'Success! The category has been created and synced.';
                        
                        this.messages.push({ 
                            role: 'ai', 
                            content: aiResponse 
                        });
                        
                        if (aiResponse.toLowerCase().includes('success') || aiResponse.toLowerCase().includes('created')) {
                             setTimeout(() => {
                                window.location.reload();
                            }, 2500);
                        }
                    } else {
                        let errorMsg = data.details || data.output || data.message || 'Workflow Failure.';
                        
                        if (errorMsg.includes('Error in workflow')) {
                            errorMsg = "⚠️ **N8N Workflow Error detected.**\n\n**The Problem:** Your n8n workflow is likely trying to call an old ngrok link.\n\n**The Fix:**\n1. Open your n8n workflow.\n2. Find the **HTTP Request** node.\n3. Update the URL to:\n`https://dripping-hangup-detonator.ngrok-free.dev/api/nutrition/categories/ai-create`";
                        }

                        this.messages.push({ 
                            role: 'ai', 
                            content: errorMsg 
                        });
                    }
                } catch (error) {
                    this.messages.push({ 
                        role: 'ai', 
                        content: `**System Error:** Connection to n8n failed. Check your ngrok tunnel.` 
                    });
                } finally {
                    this.isLoading = false;
                    this.scrollToBottom();
                }
            }
        }));
    });
</script>
