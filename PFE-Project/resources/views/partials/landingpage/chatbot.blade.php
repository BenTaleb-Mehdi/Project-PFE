<!-- CHATBOT BACKDROP (click outside to close) -->
<div
  x-show="chatOpen"
  @click="toggleChat()"
  class="fixed inset-0 z-[98]"
  style="display: none;"
></div>

<!-- CHATBOT BUTTON -->
<button
  x-show="!chatOpen"
  @click="toggleChat()"
  class="fixed bottom-6 left-6 z-[99] w-14 h-14 rounded-full bg-brand-700 text-white flex items-center justify-center shadow-xl hover:bg-brand-600 transition-all hover:scale-105"
  x-transition:enter="transition ease-out duration-300"
  x-transition:enter-start="opacity-0 scale-50"
  x-transition:enter-end="opacity-100 scale-100"
  style="display: none;"
  aria-label="Open chat"
>
  <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
</button>

<!-- CHATBOT WINDOW -->
<div
  x-show="chatOpen"
  x-transition:enter="transition ease-out duration-300"
  x-transition:enter-start="opacity-0 translate-y-8 scale-95"
  x-transition:enter-end="opacity-100 translate-y-0 scale-100"
  x-transition:leave="transition ease-in duration-200"
  x-transition:leave-start="opacity-100 translate-y-0 scale-100"
  x-transition:leave-end="opacity-0 translate-y-8 scale-95"
  class="fixed bottom-0 sm:bottom-6 left-0 sm:left-6 z-[99] w-full sm:w-[380px] h-[70vh] max-h-[560px] sm:h-[560px] bg-white dark:bg-neutral-900 rounded-none sm:rounded-2xl shadow-2xl border-t sm:border border-neutral-200 dark:border-neutral-700 flex flex-col overflow-hidden"
  style="display: none;"
>
  <!-- Header -->
  <div class="bg-brand-700 text-white px-5 py-4 flex items-center justify-between shrink-0">
    <div class="flex items-center gap-3">
      <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-lg font-bold">A</div>
      <div>
        <h3 class="font-semibold text-sm">Coach Achraf</h3>
        <p class="text-white/70 text-[11px] flex items-center gap-1.5">
          <span class="w-1.5 h-1.5 bg-green-400 rounded-full"></span>
          Online
        </p>
      </div>
    </div>
    <button @click="toggleChat()" class="text-white/70 hover:text-white transition-colors p-1">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
    </button>
  </div>

  <!-- Messages -->
  <div class="flex-1 overflow-y-auto p-5 space-y-4 bg-neutral-50 dark:bg-neutral-950/50" id="chat-scroll-container">
    <template x-for="(msg, i) in chatMessages" :key="i">
      <div class="flex" :class="msg.role === 'user' ? 'justify-end' : 'justify-start'">
        <div
          class="max-w-[85%] px-4 py-3 text-sm leading-relaxed rounded-2xl"
          :class="msg.role === 'user'
            ? 'bg-brand-700 text-white rounded-br-none'
            : 'bg-white dark:bg-neutral-800 text-neutral-800 dark:text-neutral-200 border border-neutral-200 dark:border-neutral-700 rounded-bl-none'"
        >
          <p x-text="msg.text"></p>
        </div>
      </div>
    </template>

    <!-- Suggested Questions (shown when chat is idle) -->
    <div x-show="chatMessages.length === 1 && !chatLoading" class="space-y-2 pb-2">
      <p class="text-xs text-neutral-400 font-medium uppercase tracking-wider">Suggested Questions</p>
      <div class="flex flex-wrap gap-2">
        <template x-for="(q, idx) in suggestedQuestions" :key="idx">
          <button
            @click="askSuggested(q)"
            class="text-xs px-3 py-2 rounded-xl bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-300 hover:border-brand-500 hover:text-brand-500 transition-colors text-left"
            x-text="q"
          ></button>
        </template>
      </div>
    </div>

    <!-- Loading -->
    <div x-show="chatLoading" class="flex justify-start">
      <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 px-4 py-3 rounded-2xl rounded-bl-none">
        <div class="flex gap-1">
          <div class="w-2 h-2 bg-neutral-300 dark:bg-neutral-600 rounded-full animate-bounce" style="animation-delay:0ms"></div>
          <div class="w-2 h-2 bg-neutral-300 dark:bg-neutral-600 rounded-full animate-bounce" style="animation-delay:150ms"></div>
          <div class="w-2 h-2 bg-neutral-300 dark:bg-neutral-600 rounded-full animate-bounce" style="animation-delay:300ms"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Input -->
  <div class="p-4 border-t border-neutral-200 dark:border-neutral-700 shrink-0 bg-white dark:bg-neutral-900">
    <form @submit.prevent="sendChatMessage()" class="flex items-center gap-2">
      <input
        type="text"
        x-model="chatInput"
        placeholder="Ask me anything..."
        class="flex-1 px-4 py-2.5 rounded-xl bg-neutral-100 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 text-sm focus:outline-none focus:border-brand-500 placeholder-neutral-400 text-neutral-900 dark:text-white"
        :disabled="chatLoading"
      >
      <button
        type="submit"
        class="w-10 h-10 rounded-xl bg-brand-700 text-white flex items-center justify-center disabled:opacity-50 hover:bg-brand-600 transition-colors shrink-0"
        :disabled="chatLoading || chatInput.trim() === ''"
      >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-7-7l7 7-7 7"/></svg>
      </button>
    </form>
  </div>
</div>
