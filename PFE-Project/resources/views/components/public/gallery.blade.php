@props(['gallery' => []])

<section class="py-24 bg-neutral-100 dark:bg-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/10 text-brand-600 dark:text-brand-400 text-xs font-medium tracking-widest uppercase mb-4">Gallery</div>
            <h2 class="font-display text-4xl sm:text-5xl md:text-6xl lg:text-7xl tracking-wider leading-none text-neutral-900 dark:text-white mb-4">Client Transformations</h2>
            <p class="text-neutral-500 dark:text-neutral-400 font-light text-lg">Check out some of our amazing client transformations</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($gallery as $index => $item)
                <div class="rounded-[2rem] overflow-hidden border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 shadow-xl transition-all duration-300 hover:shadow-2xl">
                    <div
                        class="relative h-[500px]"
                        x-data="{ position: 50 }"
                    >
                        <!-- BEFORE -->
                        <img
                            src="{{ $item['before'] }}"
                            alt="{{ $item['alt'] }}"
                            class="absolute inset-0 w-full h-full object-cover"
                        >

                        <!-- AFTER -->
                        <div
                            class="absolute inset-0 overflow-hidden"
                            :style="`clip-path: inset(0 0 0 ${position}%)`"
                        >
                            <img
                                src="{{ $item['after'] }}"
                                alt="{{ $item['alt'] }}"
                                class="absolute inset-0 w-full h-full object-cover"
                            >
                        </div>

                        <!-- LINE -->
                        <div
                            class="absolute top-0 bottom-0 z-30"
                            :style="`left:${position}%`"
                        >
                            <div class="absolute top-0 bottom-0 w-[2px] bg-white"></div>
                            <div class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2">
                                <div class="w-14 h-14 rounded-full bg-white shadow-2xl flex items-center justify-center border-4 border-brand-500">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5 text-black"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2.5"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M8 9l-4 3m0 0l4 3m-4-3h16m-4-3l4 3m0 0l-4 3"
                                        />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- RANGE -->
                        <input
                            type="range"
                            min="0"
                            max="100"
                            x-model="position"
                            class="absolute inset-0 opacity-0 cursor-ew-resize z-40 w-full h-full"
                        >

                        <!-- LABELS -->
                        <div class="absolute top-5 left-5 z-40">
                            <div class="px-4 py-2 rounded-full bg-black/40 backdrop-blur-md text-white text-[10px] uppercase tracking-[0.25em]">
                                Before
                            </div>
                        </div>

                        <div class="absolute top-5 right-5 z-40">
                            <div class="px-4 py-2 rounded-full bg-brand-500 text-white text-[10px] uppercase tracking-[0.25em] shadow-lg">
                                After
                            </div>
                        </div>
                    </div>

                    <!-- CONTENT -->
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-display text-2xl tracking-wider text-neutral-900 dark:text-white">
                                {{ $item['alt'] }}
                            </h3>
                            <span class="text-brand-500 text-sm font-medium">
                                {{ $item['duration'] }}
                            </span>
                        </div>

                        <p class="text-sm text-neutral-500 dark:text-neutral-400 leading-relaxed mb-5">
                            {{ $item['details'] }}
                        </p>

                        <span class="inline-flex px-4 py-2 rounded-full bg-brand-500/10 text-brand-500 text-xs uppercase tracking-widest font-semibold">
                            {{ $item['goal'] }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>