<!-- resources/views/components/admin/header.blade.php -->
<header class="lg:hidden sticky top-0 inset-x-0 flex flex-wrap md:justify-start md:flex-nowrap z-[48] w-full bg-white border-b border-zinc-200 text-sm py-2.5 font-sans">
    <nav class="max-w-[85rem] mx-auto w-full px-4 flex justify-between items-center" aria-label="Global">
        <div class="flex items-center space-x-2">
            <div class="h-5 w-5 bg-cyan-600"></div>
            <span class="font-bold text-sm tracking-tighter uppercase text-zinc-900">Coach</span>
        </div>
        
        <button type="button" 
                @click.stop="isSidebarOpen = true"
                class="h-11 w-11 inline-flex justify-center items-center gap-x-2 text-start bg-white border border-zinc-200 text-zinc-800 shadow-sm align-middle hover:bg-zinc-50 focus:outline-none focus:bg-zinc-50 transition-all font-mono uppercase">
            <span class="sr-only">Toggle Navigation</span>
            <i data-lucide="menu" class="size-4"></i>
        </button>
    </nav>
</header>
