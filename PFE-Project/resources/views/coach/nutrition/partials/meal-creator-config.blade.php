            <form :action="isEditingMeal ? `/coach/nutrition/meals/${editingMealId}` : '{{ route('coach.nutrition.meals.store') }}'" 
                  method="POST" class="ag-card p-8 bg-white relative">
                @csrf
                <template x-if="isEditingMeal">
                    <input type="hidden" name="_method" value="PUT">
                </template>
                <div class="flex items-center justify-between mb-6 border-b border-zinc-100 pb-2">
                    <h3 class="text-xs font-bold uppercase tracking-widest" x-text="isEditingMeal ? 'Meal Modification' : 'Meal Configuration'"></h3>
                    <button type="button" x-show="isEditingMeal" @click="resetMeal()" class="text-[8px] text-red-500 uppercase font-bold tracking-widest hover:underline">Cancel Edit</button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Category Dropdown -->
                    <div class="relative" x-data='{ open: false }'>
                        <label class="block text-[8px] text-zinc-400 uppercase tracking-widest mb-2">Category Node</label>
                        <input type="hidden" name="category_id" :value="mealCategorySelectedId">
                        <button type="button" @click.stop="open = !open" 
                                class="w-full bg-zinc-50 px-4 py-3 text-[10px] uppercase border border-zinc-200 flex items-center justify-between outline-none focus:border-cyan-600 transition-colors font-mono text-cyan-700 rounded-none">
                            <span x-text="mealCategorySelected || 'Select Category'"></span>
                            <i data-lucide="chevron-down" class="size-4" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="open" @click.outside="open = false" 
                             class="absolute left-0 mt-1 w-full bg-white border border-zinc-200 z-[110] shadow-[4px_4px_0px_0px_rgba(0,0,0,0.05)]">
                            @foreach($categories as $cat)
                                <div @click="mealCategorySelected = '{{ $cat->name }}'; mealCategorySelectedId = '{{ $cat->id }}'; open = false" 
                                     class="px-4 py-3 text-[10px] uppercase font-bold tracking-widest text-zinc-500 hover:bg-zinc-50 hover:text-cyan-600 cursor-pointer transition-all border-l-2 border-transparent hover:border-cyan-600 flex items-center justify-between">
                                    <span>{{ $cat->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Meal Name -->
                    <div>
                        <label class="block text-[8px] text-zinc-400 uppercase tracking-widest mb-2">Identity Label</label>
                        <input type="text" name="name" x-model="mealName" placeholder="E.G. SHRED OATS V4" required
                               class="w-full bg-zinc-50 px-4 py-3 text-[10px] uppercase border border-zinc-200 outline-none focus:border-cyan-600 transition-colors font-mono text-zinc-900 placeholder:opacity-30 rounded-none">
                    </div>
                </div>

                <!-- Hidden Macro Inputs (Synced with Matrix) -->
                <input type="hidden" name="protein" :value="p">
                <input type="hidden" name="carbs" :value="c">
                <input type="hidden" name="fats" :value="f">

                <div class="bg-white border border-zinc-200 shadow-[4px_4px_0_0_rgba(0,0,0,0.04)] relative" x-data="{ }">
                    <!-- Matrix Rich Toolbar -->
                    <div class="flex flex-wrap items-center bg-white border-b border-zinc-200 sticky top-0 z-10">
                        <!-- Text Style Group -->
                        <div class="flex border-r border-zinc-200">
                            <button type="button" @mousedown.prevent="document.execCommand('bold')"
                                    class="h-10 w-10 flex items-center justify-center text-zinc-500 hover:bg-zinc-50 hover:text-cyan-600 transition-colors"
                                    title="Bold Sync (Ctrl+B)">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path d="M6 4h8a4 4 0 014 4 4 4 0 01-4 4H6z"/><path d="M6 12h9a4 4 0 014 4 4 4 0 01-4 4H6z"/>
                                </svg>
                            </button>
                            <button type="button" @mousedown.prevent="document.execCommand('italic')"
                                    class="h-10 w-10 flex items-center justify-center text-zinc-500 hover:bg-zinc-50 hover:text-cyan-600 transition-colors"
                                    title="Italic Sync (Ctrl+I)">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path d="M19 4h-9m0 0l-4 16m4-16h9m-9 16h9" stroke-linecap="square"/>
                                </svg>
                            </button>
                            <button type="button" @mousedown.prevent="document.execCommand('underline')"
                                    class="h-10 w-10 flex items-center justify-center text-zinc-500 hover:bg-zinc-50 hover:text-cyan-600 transition-colors"
                                    title="Underline Sync (Ctrl+U)">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path d="M6 3v7a6 6 0 006 6 6 6 0 006-6V3M4 21h16"/>
                                </svg>
                            </button>
                        </div>
                        <!-- Lists Group -->
                        <div class="flex border-r border-zinc-200">
                            <button type="button" @mousedown.prevent="document.execCommand('insertUnorderedList')"
                                    class="h-10 w-10 flex items-center justify-center text-zinc-500 hover:bg-zinc-50 hover:text-cyan-600 transition-colors"
                                    title="Bullet Matrix">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>
                                </svg>
                            </button>
                            <button type="button" @mousedown.prevent="document.execCommand('insertOrderedList')"
                                    class="h-10 w-10 flex items-center justify-center text-zinc-500 hover:bg-zinc-50 hover:text-cyan-600 transition-colors"
                                    title="Ordered Sequence">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M10 6h11M10 12h11M10 18h11M4 6h1v4M4 10h2M4 18h3"/>
                                </svg>
                            </button>
                        </div>
                        <!-- Headings Group -->
                        <div class="flex border-r border-zinc-200">
                            <button type="button" @mousedown.prevent="document.execCommand('formatBlock', false, 'H1')"
                                    class="h-10 px-3 flex items-center text-[10px] font-bold text-zinc-500 hover:bg-zinc-50 hover:text-cyan-600 transition-colors font-mono">
                                H1
                            </button>
                            <button type="button" @mousedown.prevent="document.execCommand('formatBlock', false, 'H2')"
                                    class="h-10 px-3 flex items-center text-[10px] font-bold text-zinc-500 hover:bg-zinc-50 hover:text-cyan-600 transition-colors font-mono">
                                H2
                            </button>
                            <button type="button" @mousedown.prevent="document.execCommand('formatBlock', false, 'blockquote')"
                                    class="h-10 w-10 flex items-center justify-center text-zinc-500 hover:bg-zinc-50 hover:text-cyan-600 transition-colors">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1zm12 0c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z"/>
                                </svg>
                            </button>
                        </div>
                        <!-- Hypermedia Group -->
                        <div class="flex border-r border-zinc-200">
                            <button type="button" @mousedown.prevent="saveSelection(); showLinkModal = true"
                                    class="h-10 w-10 flex items-center justify-center text-zinc-500 hover:bg-zinc-50 hover:text-cyan-600 transition-colors"
                                    title="Link Nexus">
                                <i data-lucide="link" class="size-3.5"></i>
                            </button>
                            <button type="button" @mousedown.prevent="saveSelection(); showImageModal = true"
                                    class="h-10 w-10 flex items-center justify-center text-zinc-500 hover:bg-zinc-50 hover:text-cyan-600 transition-colors"
                                    title="Image Buffer">
                                <i data-lucide="image" class="size-3.5"></i>
                            </button>
                        </div>
                        <!-- Style Sanitizer -->
                        <div class="flex border-r border-zinc-200">
                            <button type="button" @mousedown.prevent="document.execCommand('removeFormat')" 
                                    class="h-10 w-10 flex items-center justify-center text-zinc-400 hover:bg-cyan-50 hover:text-cyan-600 transition-all" title="Remove Styles // Format Purge">
                                <i data-lucide="eraser" class="size-3.5"></i>
                            </button>
                        </div>
                        <!-- Clear -->
                        <div class="flex ml-auto group">
                            <button type="button" @mousedown.prevent="detailsHTML = ''; $refs.editor.innerHTML = ''" 
                                    class="h-10 w-10 flex items-center justify-center text-red-300 hover:bg-red-50 hover:text-red-500 transition-all" title="Purge Buffer">
                                <i data-lucide="trash-2" class="size-3.5"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Hidden Input for Form Sync -->
                    <input type="hidden" name="details" :value="detailsHTML">

                    <!-- Content Engine -->
                    <div contenteditable="true" 
                         x-ref="editor"
                         @input="detailsHTML = $el.innerHTML"
                         @blur="detailsHTML = $el.innerHTML"
                         class="v3-editor-matrix p-8 min-h-[400px] text-sm font-sans text-zinc-900 leading-relaxed focus:outline-none bg-white font-sans normal-case"
                         data-placeholder="Start writing your protocol intelligence here...">
                    </div>

                    <!-- Link Nexus Modal -->
                    <div x-show="showLinkModal" x-transition 
                         class="absolute inset-x-0 top-10 bg-white border-b border-zinc-200 z-[120] p-6 shadow-2xl animate-in slide-in-from-top duration-200">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-[8px] font-bold text-zinc-400 uppercase tracking-widest">Connect Link Nexus</span>
                            <button @click="showLinkModal = false" class="text-zinc-400 hover:text-red-500 transition-colors">
                                <i data-lucide="x" class="size-3.5"></i>
                            </button>
                        </div>
                        <div class="flex gap-x-3">
                            <div class="flex-1 relative">
                                <i data-lucide="link" class="absolute left-3 top-2.5 size-3.5 text-zinc-300"></i>
                                <input type="url" x-model="linkUrl" placeholder="https://..." 
                                       class="w-full bg-zinc-50 border border-zinc-100 px-10 py-2.5 text-[10px] font-mono focus:outline-none focus:border-cyan-600 transition-all rounded-none">
                            </div>
                            <button type="button" @click="insertLink()" 
                                    class="bg-zinc-950 text-white px-6 text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-all">
                                Sync Link
                            </button>
                        </div>
                    </div>

                    <!-- Media Matrix Modal -->
                    <div x-show="showImageModal" x-transition 
                         class="absolute inset-x-0 top-10 bg-white border-b border-zinc-200 z-[120] p-6 shadow-2xl animate-in slide-in-from-top duration-200">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-[8px] font-bold text-zinc-400 uppercase tracking-widest">Inject Media Node</span>
                            <button @click="showImageModal = false" class="text-zinc-400 hover:text-red-500 transition-colors">
                                <i data-lucide="x" class="size-3.5"></i>
                            </button>
                        </div>
                        <div class="flex flex-col gap-y-4">
                            <div class="flex gap-x-3">
                                <div class="flex-1 relative">
                                    <i data-lucide="globe" class="absolute left-3 top-2.5 size-3.5 text-zinc-300"></i>
                                    <input type="url" x-model="imageUrl" placeholder="Remote Image URL..." 
                                           class="w-full bg-zinc-50 border border-zinc-100 px-10 py-2.5 text-[10px] font-mono focus:outline-none focus:border-cyan-600 transition-all rounded-none">
                                </div>
                                <button type="button" @click="insertImage(imageUrl)" 
                                        class="bg-zinc-950 text-white px-6 text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-all">
                                    Embed Remote
                                </button>
                            </div>
                            <div class="relative group">
                                <input type="file" @change="handleImageUpload($event)" accept="image/*"
                                       class="absolute inset-0 opacity-0 cursor-pointer z-10">
                                <div class="border-2 border-dashed border-zinc-100 p-6 flex flex-col items-center justify-center group-hover:bg-zinc-50 transition-all group-hover:border-cyan-100">
                                    <i data-lucide="upload-cloud" class="size-6 text-zinc-300 mb-2 group-hover:text-cyan-400 transition-all"></i>
                                    <p class="text-[8px] font-bold text-zinc-400 uppercase tracking-widest group-hover:text-cyan-600 transition-all">Local Upload Node</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="px-8 py-4 bg-zinc-950 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)]">
                        <span x-text="isEditingMeal ? 'Update Meal Node' : 'Register Meal to Registry'"></span>
                    </button>
                </div>
            </form>
