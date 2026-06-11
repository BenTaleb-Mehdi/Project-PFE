@extends('layouts.client')

@section('title', 'Active Protocol')

@section('content')
<div x-data="{ 
    detailModalOpen: false, 
    selectedMeal: null,
    dailyMacros: { 
        kcal: {{ $programData['dailyMacros']['kcal'] ?? 0 }}, 
        p: {{ $programData['dailyMacros']['p'] ?? 0 }}, 
        c: {{ $programData['dailyMacros']['c'] ?? 0 }}, 
        f: {{ $programData['dailyMacros']['f'] ?? 0 }} 
    } 
}" class="max-w-7xl mx-auto relative">
    
    @include('client.programs.partials.background-accents')

    @if($programData['program_title'] !== 'NO_ACTIVE_PROTOCOL')
        @include('client.programs.partials.header')
        @include('client.programs.partials.macros-overview')
        @include('client.programs.partials.daily-sequence')
    @else
        @include('client.programs.partials.no-protocol')
    @endif

    @include('client.programs.partials.detail-modal')
</div>
@endsection
