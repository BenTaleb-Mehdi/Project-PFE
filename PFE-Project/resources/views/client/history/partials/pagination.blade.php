<!-- Pagination -->
@if(isset($programData['all_programs']) && method_exists($programData['all_programs'], 'links'))
<div class="px-6 py-4 border-t border-zinc-100 bg-zinc-50 flex flex-col sm:flex-row items-center justify-between gap-4">
    <span class="text-[10px] text-zinc-500 font-mono uppercase tracking-widest">
        Showing {{ $programData['all_programs']->firstItem() }} to {{ $programData['all_programs']->lastItem() }} of {{ $programData['all_programs']->total() }}
    </span>
    {{ $programData['all_programs']->links() }}
</div>
@endif
