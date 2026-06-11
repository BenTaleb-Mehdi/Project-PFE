<!-- ▌▌▌ GALLERY PAGE ▌▌▌ -->
<section
    class="pt-36 pb-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"
    x-show="currentPage === 'gallery' && gallery && gallery.length > 0"
    x-transition:enter="transition ease-out duration-400"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
>
    <!-- heading -->
    <div class="text-center max-w-3xl mx-auto mb-16">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/10 text-brand-600 dark:text-brand-400 text-xs font-medium tracking-widest uppercase mb-4">Transformations</div>
        <h1 class="font-display text-5xl sm:text-6xl tracking-wider text-neutral-900 dark:text-white">OUR <span class="text-brand-500">GALLERY</span></h1>
        <p class="text-neutral-500 dark:text-neutral-400 font-light text-lg">Here are some examples of transformations our clients have achieved with our program.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <template x-for="(img, i) in (galleryItems || gallery || [])" :key="i">
            <div
                class="reveal overflow-hidden rounded-[2rem] border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 shadow-xl transition-all duration-300 hover:shadow-2xl"
                :class="'delay-' + (i * 100 + 100)"
            >
                <!-- BEFORE / AFTER -->
                <div
                    class="relative h-[500px]"
                    x-data="{ position: 50 }"
                >
                    <!-- BEFORE IMAGE -->
                    <img
                        :src="img.before"
                        :alt="img.alt"
                        class="absolute inset-0 w-full h-full object-cover"
                        loading="lazy"
                    >

                    <!-- AFTER IMAGE -->
                    <div
                        class="absolute inset-0 overflow-hidden"
                        :style="`clip-path: inset(0 0 0 ${position}%)`"
                    >
                        <img
                            :src="img.after"
                            :alt="img.alt"
                            class="absolute inset-0 w-full h-full object-cover"
                            loading="lazy"
                        >
                    </div>

                    <!-- CENTER LINE -->
                    <div
                        class="absolute top-0 bottom-0 z-30"
                        :style="`left:${position}%`"
                    >
                        <!-- LINE -->
                        <div class="absolute top-0 bottom-0 w-[2px] bg-white"></div>

                        <!-- SLIDER BUTTON -->
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
                        class="absolute inset-0 z-40 opacity-0 cursor-ew-resize w-full h-full"
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
                        <h3
                            class="font-display text-2xl tracking-wider text-neutral-900 dark:text-white"
                            x-text="img.alt"
                        ></h3>
                        <span
                            class="text-brand-500 text-sm font-medium"
                            x-text="img.duration"
                        ></span>
                    </div>

                    <p
                        class="text-sm text-neutral-500 dark:text-neutral-400 leading-relaxed mb-5"
                        x-text="img.details"
                    ></p>

                    <span
                        class="inline-flex px-4 py-2 rounded-full bg-brand-500/10 text-brand-500 text-xs uppercase tracking-widest font-semibold"
                        x-text="img.goal"
                    ></span>
                </div>
            </div>
        </template>
    </div>
</section>
