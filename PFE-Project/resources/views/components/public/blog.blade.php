@props(['posts' => []])

<div>
  <!-- 1. LATEST ARTICLES PREVIEW (Shown on Home Page) -->
  <div x-show="currentPage === 'home'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
    <section class="py-24 lg:py-32">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12">
          <div class="space-y-3">
            <div class="reveal inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/10 text-brand-600 dark:text-brand-400 text-xs font-medium tracking-widest uppercase">Blog</div>
            <h2 class="reveal delay-100 font-display text-5xl tracking-wider text-neutral-900 dark:text-white">LATEST<br/><span class="text-brand-500">ARTICLES</span></h2>
          </div>
          <button @click="goTo('blog')" class="reveal self-start sm:self-auto inline-flex items-center gap-2 text-brand-500 font-medium hover:underline">
            All Posts
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
          </button>
        </div>

        <!-- Alpine Dynamic Preview -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6" x-show="posts && posts.length > 0">
          <template x-for="(post, i) in posts.slice(0, 3)" :key="post.id">
            <div class="reveal card-hover cursor-pointer rounded-2xl bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 overflow-hidden group" :class="'delay-' + (i * 100 + 100)" @click="openPost(post)">
              <div class="h-48 overflow-hidden" :style="'background: ' + post.color">
                <div class="w-full h-full flex items-center justify-center">
                  <span class="font-display text-7xl text-white/30" x-text="post.emoji"></span>
                </div>
              </div>
              <div class="p-6 space-y-3">
                <div class="flex items-center gap-2">
                  <span class="text-xs px-2 py-0.5 rounded-full bg-brand-500/10 text-brand-600 dark:text-brand-400 font-medium" x-text="post.category"></span>
                  <span class="text-xs text-neutral-400" x-text="post.date"></span>
                </div>
                <h3 class="font-semibold text-base leading-snug group-hover:text-brand-500 transition-colors text-neutral-900 dark:text-white" x-text="post.title"></h3>
                <p class="text-xs text-neutral-500 dark:text-neutral-400 leading-relaxed line-clamp-2" x-text="post.excerpt"></p>
              </div>
            </div>
          </template>
        </div>

        <!-- Blade Fallback Preview -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6" x-show="!posts || posts.length === 0">
          @foreach(array_slice($posts, 0, 3) as $index => $post)
            <div class="reveal card-hover cursor-pointer rounded-2xl bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 overflow-hidden group delay-{{ ($index * 100 + 100) }}" @click="openPost({ id: {{ $post['id'] }}, category: '{{ $post['category'] }}', date: '{{ $post['date'] }}', readTime: '{{ $post['readTime'] }}', emoji: '{{ $post['emoji'] }}', color: '{{ $post['color'] }}', title: '{{ addslashes($post['title']) }}', excerpt: '{{ addslashes($post['excerpt']) }}', tags: @json($post['tags'] ?? []), body: '{{ addslashes($post['body']) }}' })">
              <div class="h-48 overflow-hidden" style="background: {{ $post['color'] }}">
                <div class="w-full h-full flex items-center justify-center">
                  <span class="font-display text-7xl text-white/30">{{ $post['emoji'] }}</span>
                </div>
              </div>
              <div class="p-6 space-y-3">
                <div class="flex items-center gap-2">
                  <span class="text-xs px-2 py-0.5 rounded-full bg-brand-500/10 text-brand-600 dark:text-brand-400 font-medium">{{ $post['category'] }}</span>
                  <span class="text-xs text-neutral-400">{{ $post['date'] }}</span>
                </div>
                <h3 class="font-semibold text-base leading-snug group-hover:text-brand-500 transition-colors text-neutral-900 dark:text-white">{{ $post['title'] }}</h3>
                <p class="text-xs text-neutral-500 dark:text-neutral-400 leading-relaxed line-clamp-2">{{ $post['excerpt'] }}</p>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>
  </div>

  <!-- 2. FULL BLOG LISTING & DETAIL VIEWS (Shown on Blog Page) -->
  <div x-show="currentPage === 'blog'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
    
    <!-- Blog List Grid -->
    <div x-show="!selectedPost">
      <section class="pt-36 pb-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 space-y-4">
          <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/10 text-brand-600 dark:text-brand-400 text-xs font-medium tracking-widest uppercase">Blog</div>
          <h1 class="font-display text-6xl sm:text-7xl tracking-wider text-neutral-900 dark:text-white">FITNESS<br/><span class="text-brand-500">INSIGHTS</span></h1>
          <p class="text-neutral-500 dark:text-neutral-400 max-w-md mx-auto">Science-backed articles on training, nutrition, mindset, and recovery.</p>
        </div>

        <!-- Category filter -->
        <div class="flex flex-wrap justify-center gap-2 mb-10" x-show="posts && posts.length > 0">
          <template x-for="cat in ['All', ...new Set(posts.map(p => p.category))]" :key="cat">
            <button
              @click="activeCategory = cat"
              class="px-4 py-1.5 rounded-full text-sm font-medium border transition-all"
              :class="activeCategory === cat ? 'bg-brand-500 border-brand-500 text-neutral-950' : 'border-neutral-300 dark:border-neutral-700 text-neutral-500 dark:text-neutral-400 hover:border-brand-500 hover:text-brand-500'"
              x-text="cat"
            ></button>
          </template>
        </div>

        <!-- Fallback Category filter -->
        <div class="flex flex-wrap justify-center gap-2 mb-10" x-show="!posts || posts.length === 0">
          @foreach(['All', 'Training', 'Nutrition', 'Recovery', 'Mindset'] as $cat)
            <button
              @click="activeCategory = '{{ $cat }}'"
              class="px-4 py-1.5 rounded-full text-sm font-medium border transition-all"
              :class="activeCategory === '{{ $cat }}' ? 'bg-brand-500 border-brand-500 text-neutral-950' : 'border-neutral-300 dark:border-neutral-700 text-neutral-500 dark:text-neutral-400 hover:border-brand-500 hover:text-brand-500'"
            >{{ $cat }}</button>
          @endforeach
        </div>

        <!-- Alpine Dynamic Grid -->
        <div x-show="posts && posts.length > 0">
          <!-- Featured post -->
          <div class="mb-10 cursor-pointer" @click="openPost(filteredPosts[0])" x-show="filteredPosts.length > 0">
            <div class="rounded-3xl overflow-hidden grid lg:grid-cols-2 border border-neutral-200 dark:border-neutral-800 bg-neutral-50 dark:bg-neutral-900 group card-hover">
              <div class="h-64 lg:h-auto" :style="'background: ' + filteredPosts[0]?.color">
                <div class="w-full h-full flex items-center justify-center">
                  <span class="font-display text-9xl text-white/30" x-text="filteredPosts[0]?.emoji"></span>
                </div>
              </div>
              <div class="p-8 lg:p-12 flex flex-col justify-center space-y-4">
                <div class="flex items-center gap-2">
                  <span class="text-xs px-2 py-0.5 rounded-full bg-brand-500/10 text-brand-600 dark:text-brand-400 font-medium" x-text="filteredPosts[0]?.category"></span>
                  <span class="text-xs text-neutral-400" x-text="filteredPosts[0]?.date"></span>
                  <span class="text-xs text-neutral-400" x-text="filteredPosts[0]?.readTime"></span>
                </div>
                <h2 class="font-display text-3xl sm:text-4xl tracking-wider group-hover:text-brand-500 transition-colors text-neutral-900 dark:text-white" x-text="filteredPosts[0]?.title"></h2>
                <p class="text-neutral-500 dark:text-neutral-400 text-sm leading-relaxed" x-text="filteredPosts[0]?.excerpt"></p>
                <div class="flex items-center gap-1 text-brand-500 text-sm font-medium">
                  Read Article
                  <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </div>
              </div>
            </div>
          </div>

          <!-- Listing Grid -->
          <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <template x-for="(post, i) in filteredPosts.slice(1)" :key="post.id">
              <div
                class="reveal card-hover cursor-pointer rounded-2xl bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 overflow-hidden group"
                :class="'delay-' + (i * 100 + 100)"
                @click="openPost(post)"
              >
                <div class="h-44 overflow-hidden" :style="'background: ' + post.color">
                  <div class="w-full h-full flex items-center justify-center">
                    <span class="font-display text-7xl text-white/30" x-text="post.emoji"></span>
                  </div>
                </div>
                <div class="p-6 space-y-3">
                  <div class="flex items-center gap-2 flex-wrap">
                    <span class="text-xs px-2 py-0.5 rounded-full bg-brand-500/10 text-brand-600 dark:text-brand-400 font-medium" x-text="post.category"></span>
                    <span class="text-xs text-neutral-400" x-text="post.date"></span>
                    <span class="text-xs text-neutral-400" x-text="post.readTime"></span>
                  </div>
                  <h3 class="font-semibold text-base leading-snug group-hover:text-brand-500 transition-colors text-neutral-900 dark:text-white" x-text="post.title"></h3>
                  <p class="text-xs text-neutral-500 dark:text-neutral-400 leading-relaxed line-clamp-2" x-text="post.excerpt"></p>
                </div>
              </div>
            </template>
          </div>
        </div>

        <!-- Blade Fallback Grid -->
        <div x-show="!posts || posts.length === 0">
          @if(count($posts) > 0)
            <!-- Featured post -->
            <div class="mb-10 cursor-pointer" @click="openPost({ id: {{ $posts[0]['id'] }}, category: '{{ $posts[0]['category'] }}', date: '{{ $posts[0]['date'] }}', readTime: '{{ $posts[0]['readTime'] }}', emoji: '{{ $posts[0]['emoji'] }}', color: '{{ $posts[0]['color'] }}', title: '{{ addslashes($posts[0]['title']) }}', excerpt: '{{ addslashes($posts[0]['excerpt']) }}', tags: @json($posts[0]['tags'] ?? []), body: '{{ addslashes($posts[0]['body']) }}' })">
              <div class="rounded-3xl overflow-hidden grid lg:grid-cols-2 border border-neutral-200 dark:border-neutral-800 bg-neutral-50 dark:bg-neutral-900 group card-hover">
                <div class="h-64 lg:h-auto" style="background: {{ $posts[0]['color'] }}">
                  <div class="w-full h-full flex items-center justify-center">
                    <span class="font-display text-9xl text-white/30">{{ $posts[0]['emoji'] }}</span>
                  </div>
                </div>
                <div class="p-8 lg:p-12 flex flex-col justify-center space-y-4">
                  <div class="flex items-center gap-2">
                    <span class="text-xs px-2 py-0.5 rounded-full bg-brand-500/10 text-brand-600 dark:text-brand-400 font-medium">{{ $posts[0]['category'] }}</span>
                    <span class="text-xs text-neutral-400">{{ $posts[0]['date'] }}</span>
                    <span class="text-xs text-neutral-400">{{ $posts[0]['readTime'] }}</span>
                  </div>
                  <h2 class="font-display text-3xl sm:text-4xl tracking-wider group-hover:text-brand-500 transition-colors text-neutral-900 dark:text-white">{{ $posts[0]['title'] }}</h2>
                  <p class="text-neutral-500 dark:text-neutral-400 text-sm leading-relaxed">{{ $posts[0]['excerpt'] }}</p>
                  <div class="flex items-center gap-1 text-brand-500 text-sm font-medium">
                    Read Article
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                  </div>
                </div>
              </div>
            </div>

            <!-- Listing Grid -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
              @foreach(array_slice($posts, 1) as $index => $post)
                <div
                  class="reveal card-hover cursor-pointer rounded-2xl bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 overflow-hidden group delay-{{ ($index * 100 + 100) }}"
                  @click="openPost({ id: {{ $post['id'] }}, category: '{{ $post['category'] }}', date: '{{ $post['date'] }}', readTime: '{{ $post['readTime'] }}', emoji: '{{ $post['emoji'] }}', color: '{{ $post['color'] }}', title: '{{ addslashes($post['title']) }}', excerpt: '{{ addslashes($post['excerpt']) }}', tags: @json($post['tags'] ?? []), body: '{{ addslashes($post['body']) }}' })"
                >
                  <div class="h-44 overflow-hidden" style="background: {{ $post['color'] }}">
                    <div class="w-full h-full flex items-center justify-center">
                      <span class="font-display text-7xl text-white/30">{{ $post['emoji'] }}</span>
                    </div>
                  </div>
                  <div class="p-6 space-y-3">
                    <div class="flex items-center gap-2 flex-wrap">
                      <span class="text-xs px-2 py-0.5 rounded-full bg-brand-500/10 text-brand-600 dark:text-brand-400 font-medium">{{ $post['category'] }}</span>
                      <span class="text-xs text-neutral-400">{{ $post['date'] }}</span>
                      <span class="text-xs text-neutral-400">{{ $post['readTime'] }}</span>
                    </div>
                    <h3 class="font-semibold text-base leading-snug group-hover:text-brand-500 transition-colors text-neutral-900 dark:text-white">{{ $post['title'] }}</h3>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 leading-relaxed line-clamp-2">{{ $post['excerpt'] }}</p>
                  </div>
                </div>
              @endforeach
            </div>
          @endif
        </div>
      </section>
    </div>

    <!-- Blog Detail Page -->
    <div x-show="selectedPost" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
      <article class="pt-36 pb-24 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back -->
        <button @click="selectedPost = null" class="flex items-center gap-2 text-sm text-neutral-500 hover:text-brand-500 transition-colors mb-8">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
          Back to Blog
        </button>

        <!-- Cover -->
        <div class="h-64 sm:h-80 rounded-3xl mb-10 flex items-center justify-center overflow-hidden" :style="'background: ' + selectedPost?.color">
          <span class="font-display text-[8rem] text-white/30" x-text="selectedPost?.emoji"></span>
        </div>

        <!-- Meta -->
        <div class="flex flex-wrap items-center gap-3 mb-6">
          <span class="text-xs px-2 py-0.5 rounded-full bg-brand-500/10 text-brand-600 dark:text-brand-400 font-medium" x-text="selectedPost?.category"></span>
          <span class="text-xs text-neutral-400" x-text="selectedPost?.date"></span>
          <span class="text-xs text-neutral-400" x-text="selectedPost?.readTime"></span>
        </div>

        <!-- Title -->
        <h1 class="font-display text-4xl sm:text-5xl tracking-wider mb-6 leading-tight text-neutral-900 dark:text-white" x-text="selectedPost?.title"></h1>
        <p class="text-lg text-neutral-600 dark:text-neutral-400 mb-10 leading-relaxed font-light" x-text="selectedPost?.excerpt"></p>

        <!-- Article body -->
        <div class="prose prose-neutral dark:prose-invert max-w-none space-y-6 text-base leading-relaxed text-neutral-700 dark:text-neutral-300" x-html="selectedPost?.body"></div>

        <!-- Tags -->
        <div class="flex flex-wrap gap-2 mt-12 pt-8 border-t border-neutral-200 dark:border-neutral-800">
          <template x-for="tag in (selectedPost?.tags || [])">
            <span class="px-3 py-1 rounded-full bg-neutral-100 dark:bg-neutral-800 text-xs text-neutral-500 dark:text-neutral-400" x-text="'#' + tag"></span>
          </template>
        </div>

        <!-- Author info -->
        <div class="flex items-center gap-4 mt-8 p-6 rounded-2xl bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800">
          <div class="w-14 h-14 rounded-full bg-brand-500 flex items-center justify-center font-display text-neutral-950 text-2xl shrink-0">A</div>
          <div>
            <div class="font-semibold text-neutral-900 dark:text-white">Alex Rivera</div>
            <div class="text-sm text-neutral-500 dark:text-neutral-400">CSCS · NASM-CPT · Precision Nutrition Coach</div>
          </div>
        </div>

        <!-- Related Posts inside Alpine -->
        <div class="mt-16" x-show="posts && posts.length > 1">
          <h3 class="font-display text-2xl tracking-wider mb-6 text-neutral-900 dark:text-white">MORE <span class="text-brand-500">ARTICLES</span></h3>
          <div class="grid sm:grid-cols-2 gap-4">
            <template x-for="post in posts.filter(p => p.id !== selectedPost?.id).slice(0, 2)" :key="post.id">
              <div class="cursor-pointer rounded-xl bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 overflow-hidden group card-hover" @click="openPost(post)">
                <div class="h-28" :style="'background: ' + post.color + '; display:flex; align-items:center; justify-content:center'">
                  <span class="font-display text-4xl text-white/30" x-text="post.emoji"></span>
                </div>
                <div class="p-4">
                  <h4 class="font-semibold text-sm group-hover:text-brand-500 transition-colors text-neutral-900 dark:text-white" x-text="post.title"></h4>
                </div>
              </div>
            </template>
          </div>
        </div>
      </article>
    </div>

  </div>
</div>
