@extends('layouts.dashboard')

@section('title', 'Blog Manager')
@section('header_title', 'Blog Articles')
@section('header_subtitle', 'Manage landing page blog posts // data.json')

@section('content')

{{-- ── Action Bar ── --}}
<div class="flex items-center justify-between mb-6">
    <p class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest">
        {{ count($posts) }} article{{ count($posts) !== 1 ? 's' : '' }} published
    </p>
    <button onclick="document.getElementById('add-modal').classList.remove('hidden')"
            class="flex items-center gap-x-2 px-4 py-2 bg-zinc-900 text-white text-[10px] font-mono uppercase tracking-widest hover:bg-cyan-700 transition-colors">
        <i data-lucide="plus" class="size-3.5"></i> New Article
    </button>
</div>

{{-- ── Articles Grid ── --}}
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 mb-10">
    @forelse($posts as $post)
        <div class="ag-card p-0 overflow-hidden">
            {{-- Color bar --}}
            <div class="h-1.5 w-full" style="{{ $post['color'] ?? 'background:linear-gradient(90deg,#0891b2,#6366f1)' }}"></div>
            <div class="p-5">
                <div class="flex items-start justify-between gap-x-3 mb-3">
                    <div class="flex items-center gap-x-2">
                        <span class="text-xl">{{ $post['emoji'] ?? '📝' }}</span>
                        <span class="text-[9px] font-mono uppercase tracking-widest px-2 py-0.5 bg-zinc-100 text-zinc-600">{{ $post['category'] }}</span>
                    </div>
                    <span class="text-[9px] font-mono text-zinc-400">{{ $post['date'] }}</span>
                </div>
                <h3 class="text-[13px] font-bold text-zinc-900 leading-snug mb-2 line-clamp-2">{{ $post['title'] }}</h3>
                <p class="text-[11px] text-zinc-500 line-clamp-2 mb-4">{{ $post['excerpt'] }}</p>
                <div class="flex items-center gap-x-1 flex-wrap mb-4">
                    @foreach(($post['tags'] ?? []) as $tag)
                        <span class="text-[9px] font-mono px-1.5 py-0.5 bg-cyan-50 text-cyan-700 border border-cyan-100">#{{ $tag }}</span>
                    @endforeach
                </div>
                <div class="flex items-center gap-x-2 pt-3 border-t border-zinc-100">
                    <a href="{{ route('coach.blog.edit', $post['id']) }}"
                       class="flex items-center gap-x-1.5 px-3 py-1.5 text-[9px] font-mono uppercase tracking-wider border border-zinc-200 text-zinc-600 hover:border-cyan-500 hover:text-cyan-700 transition-colors">
                        <i data-lucide="pencil" class="size-3"></i> Edit
                    </a>
                    <form action="{{ route('coach.blog.destroy', $post['id']) }}" method="POST"
                          onsubmit="return confirm('Delete this article?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="flex items-center gap-x-1.5 px-3 py-1.5 text-[9px] font-mono uppercase tracking-wider border border-zinc-200 text-red-500 hover:border-red-300 hover:bg-red-50 transition-colors">
                            <i data-lucide="trash-2" class="size-3"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full py-16 flex flex-col items-center text-center">
            <i data-lucide="file-text" class="size-10 text-zinc-200 mb-4"></i>
            <p class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest">No articles yet. Publish your first one!</p>
        </div>
    @endforelse
</div>

{{-- ── Add Article Modal ── --}}
<div id="add-modal" class="hidden fixed inset-0 z-[400] bg-zinc-950/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white border border-zinc-200 w-full max-w-2xl max-h-[90vh] overflow-y-auto shadow-2xl">
        <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-100">
            <div class="flex items-center gap-x-2">
                <div class="h-4 w-0.5 bg-cyan-600"></div>
                <p class="text-[11px] font-mono font-bold uppercase tracking-widest text-zinc-900">New Blog Article</p>
            </div>
            <button onclick="document.getElementById('add-modal').classList.add('hidden')"
                    class="text-zinc-400 hover:text-zinc-900 transition-colors">
                <i data-lucide="x" class="size-4"></i>
            </button>
        </div>

        <form action="{{ route('coach.blog.store') }}" method="POST" class="px-6 py-5 space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[9px] font-mono uppercase tracking-widest text-zinc-500 mb-1">Title *</label>
                    <input name="title" type="text" required placeholder="Article title…"
                           class="w-full border border-zinc-200 px-3 py-2 text-[12px] text-zinc-900 focus:border-cyan-500 outline-none transition-colors">
                </div>
                <div>
                    <label class="block text-[9px] font-mono uppercase tracking-widest text-zinc-500 mb-1">Category *</label>
                    <select name="category" required
                            class="w-full border border-zinc-200 px-3 py-2 text-[12px] text-zinc-900 focus:border-cyan-500 outline-none bg-white">
                        <option value="Training">Training</option>
                        <option value="Nutrition">Nutrition</option>
                        <option value="Recovery">Recovery</option>
                        <option value="Mindset">Mindset</option>
                        <option value="Lifestyle">Lifestyle</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[9px] font-mono uppercase tracking-widest text-zinc-500 mb-1">Emoji</label>
                    <input name="emoji" type="text" placeholder="🏋️" maxlength="5"
                           class="w-full border border-zinc-200 px-3 py-2 text-[12px] text-zinc-900 focus:border-cyan-500 outline-none transition-colors">
                </div>
                <div>
                    <label class="block text-[9px] font-mono uppercase tracking-widest text-zinc-500 mb-1">Read Time</label>
                    <input name="readTime" type="text" placeholder="5 min read"
                           class="w-full border border-zinc-200 px-3 py-2 text-[12px] text-zinc-900 focus:border-cyan-500 outline-none transition-colors">
                </div>
            </div>

            <div>
                <label class="block text-[9px] font-mono uppercase tracking-widest text-zinc-500 mb-1">Excerpt * (shown in cards)</label>
                <textarea name="excerpt" required rows="2" placeholder="Short description shown in the blog card…"
                          class="w-full border border-zinc-200 px-3 py-2 text-[12px] text-zinc-900 focus:border-cyan-500 outline-none resize-none transition-colors"></textarea>
            </div>

            <div>
                <label class="block text-[9px] font-mono uppercase tracking-widest text-zinc-500 mb-1">Body * (supports HTML)</label>
                <textarea name="body" required rows="6" placeholder="<h2>Section Title</h2><p>Your content...</p>"
                          class="w-full border border-zinc-200 px-3 py-2 text-[12px] font-mono text-zinc-900 focus:border-cyan-500 outline-none resize-y transition-colors"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[9px] font-mono uppercase tracking-widest text-zinc-500 mb-1">Tags (comma-separated)</label>
                    <input name="tags" type="text" placeholder="training, strength, tips"
                           class="w-full border border-zinc-200 px-3 py-2 text-[12px] text-zinc-900 focus:border-cyan-500 outline-none transition-colors">
                </div>
                <div>
                    <label class="block text-[9px] font-mono uppercase tracking-widest text-zinc-500 mb-1">Card Color Gradient (CSS)</label>
                    <input name="color" type="text" placeholder="linear-gradient(135deg,#1a1a2e,#16213e)"
                           class="w-full border border-zinc-200 px-3 py-2 text-[12px] font-mono text-zinc-900 focus:border-cyan-500 outline-none transition-colors">
                </div>
            </div>

            <div class="flex items-center justify-end gap-x-3 pt-3 border-t border-zinc-100">
                <button type="button" onclick="document.getElementById('add-modal').classList.add('hidden')"
                        class="px-4 py-2 text-[10px] font-mono uppercase tracking-widest border border-zinc-200 text-zinc-600 hover:bg-zinc-50 transition-colors">
                    Cancel
                </button>
                <button type="submit"
                        class="px-5 py-2 text-[10px] font-mono uppercase tracking-widest bg-cyan-600 text-white hover:bg-cyan-700 transition-colors">
                    Publish Article
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
