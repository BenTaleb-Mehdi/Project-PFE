<!-- resources/views/components/logo.blade.php -->
<div {{ $attributes->merge(['class' => 'flex items-center']) }}>
    <img src="{{ asset('images/logo.png') }}" 
         alt="Coach Portal Logo" 
         class="h-12 w-auto object-contain transition-transform hover:scale-[1.02]">
</div>
