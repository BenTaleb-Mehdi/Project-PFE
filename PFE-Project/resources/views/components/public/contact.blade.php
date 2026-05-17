@props(['contactInfo' => [], 'socials' => [], 'whatsappNumber'])

<div x-show="currentPage === 'contact'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
  <section class="pt-36 pb-24 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid lg:grid-cols-2 gap-16">
      <!-- Left info -->
      <div class="space-y-8">
        <div>
          <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/10 text-brand-600 dark:text-brand-400 text-xs font-medium tracking-widest uppercase mb-4">Contact</div>
          <h1 class="font-display text-6xl tracking-wider leading-none text-neutral-900 dark:text-white">LET'S<br/><span class="text-brand-500">TALK</span></h1>
        </div>
        <p class="text-neutral-500 dark:text-neutral-400 leading-relaxed">Your first consultation is free and zero-pressure. Tell me your goals and I'll put together a game plan tailored just for you.</p>

        <!-- Dynamic contact details list -->
        <div class="space-y-4">
          @foreach($contactInfo as $c)
            <div class="flex items-center gap-4">
              <div class="w-10 h-10 rounded-xl bg-brand-500/10 flex items-center justify-center text-brand-500 shrink-0">{!! $c['icon'] !!}</div>
              <div>
                <div class="text-xs text-neutral-400 uppercase tracking-widest">{{ $c['label'] }}</div>
                <div class="font-medium text-sm text-neutral-900 dark:text-white">{{ $c['value'] }}</div>
              </div>
            </div>
          @endforeach

          <!-- Fallback/Database WhatsApp details inside contactInfo list -->
          <div class="flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-brand-500/10 flex items-center justify-center text-brand-500 shrink-0">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
            </div>
            <div>
              <div class="text-xs text-neutral-400 uppercase tracking-widest">WhatsApp</div>
              <div class="font-medium text-sm text-neutral-900 dark:text-white">+{{ $whatsappNumber }}</div>
            </div>
          </div>
        </div>

        <!-- Social Icons Row -->
        <div class="flex gap-3 pt-2">
          @foreach($socials as $s)
            <a href="{{ $s['url'] ?? '#' }}" target="_blank" class="w-10 h-10 rounded-xl bg-neutral-100 dark:bg-neutral-800 flex items-center justify-center text-neutral-600 dark:text-neutral-400 hover:bg-brand-500 hover:text-neutral-950 transition-colors">{!! $s['icon'] !!}</a>
          @endforeach
        </div>
      </div>

      <!-- Form -->
      <div class="bg-neutral-50 dark:bg-neutral-900 rounded-3xl p-8 border border-neutral-200 dark:border-neutral-800" x-data="contactForm()">
        <template x-if="!submitted">
          <div class="space-y-5">
            <div class="grid sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-medium text-neutral-500 dark:text-neutral-400 mb-2 uppercase tracking-widest">First Name</label>
                <input x-model="form.firstName" type="text" class="w-full px-4 py-3 rounded-xl bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 focus:outline-none focus:border-brand-500 text-sm transition-colors text-neutral-900 dark:text-white" placeholder="Alex"/>
              </div>
              <div>
                <label class="block text-xs font-medium text-neutral-500 dark:text-neutral-400 mb-2 uppercase tracking-widest">Last Name</label>
                <input x-model="form.lastName" type="text" class="w-full px-4 py-3 rounded-xl bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 focus:outline-none focus:border-brand-500 text-sm transition-colors text-neutral-900 dark:text-white" placeholder="Rivera"/>
              </div>
            </div>
            <div>
              <label class="block text-xs font-medium text-neutral-500 dark:text-neutral-400 mb-2 uppercase tracking-widest">Email</label>
              <input x-model="form.email" type="email" class="w-full px-4 py-3 rounded-xl bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 focus:outline-none focus:border-brand-500 text-sm transition-colors text-neutral-900 dark:text-white" placeholder="you@email.com"/>
            </div>
            <div>
              <label class="block text-xs font-medium text-neutral-500 dark:text-neutral-400 mb-2 uppercase tracking-widest">Goal</label>
              <select x-model="form.goal" class="w-full px-4 py-3 rounded-xl bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 focus:outline-none focus:border-brand-500 text-sm transition-colors text-neutral-900 dark:text-neutral-400">
                <option value="">Select your primary goal</option>
                <option>Fat Loss</option>
                <option>Muscle Building</option>
                <option>Athletic Performance</option>
                <option>General Health</option>
                <option>Online Coaching</option>
              </select>
            </div>
            <div>
              <label class="block text-xs font-medium text-neutral-500 dark:text-neutral-400 mb-2 uppercase tracking-widest">Message</label>
              <textarea x-model="form.message" rows="4" class="w-full px-4 py-3 rounded-xl bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 focus:outline-none focus:border-brand-500 text-sm transition-colors resize-none text-neutral-900 dark:text-white" placeholder="Tell me a bit about your situation…"></textarea>
            </div>
            <button
              @click="submit()"
              :disabled="loading"
              class="w-full py-4 rounded-full bg-brand-500 hover:bg-brand-600 disabled:opacity-60 text-neutral-950 font-medium transition-all"
            >
              <span x-show="!loading">Send Message 🚀</span>
              <span x-show="loading" class="flex items-center justify-center gap-2" style="display: none;">
                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg>
                Sending…
              </span>
            </button>
          </div>
        </template>
        <template x-if="submitted">
          <div class="flex flex-col items-center justify-center gap-4 py-16 text-center">
            <div class="w-16 h-16 rounded-full bg-brand-500 flex items-center justify-center">
              <svg class="w-8 h-8 text-neutral-950" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h3 class="font-display text-3xl tracking-wider text-neutral-900 dark:text-white">MESSAGE SENT!</h3>
            <p class="text-neutral-500 dark:text-neutral-400 text-sm max-w-xs">I'll get back to you within 24 hours. Check your inbox!</p>
            <button @click="submitted = false; form = {}" class="mt-4 text-sm text-brand-500 hover:underline">Send another</button>
          </div>
        </template>
      </div>
    </div>
  </section>
</div>
