<!-- ▌▌▌ HOME PAGE ▌▌▌ -->
<div x-show="currentPage === 'home'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
    <x-public.hero />

    <x-public.gallery :gallery="$gallery" />
    <x-public.about :features="$features" :stats="$stats" :certs="$certs" :timeline="$timeline" />
    <x-public.digital-app :whatsappNumber="$whatsappNumber" />
    <x-public.testimonials :testimonials="$testimonials" />
    <x-public.cta />
</div>
