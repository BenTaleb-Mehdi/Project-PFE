@extends('layouts.dashboard')

@section('title', 'Nutrition Engine')
@section('header_title', 'Nutrition Engine')
@section('header_subtitle', 'Protocol Sync // Biomass Analysis')

@section('content')
<div x-data='coachHub({ 
    meals: @json($meals),
    programs: @json($programs),
    mealSearch: "{{ request("meal_search") }}", 
    programSearch: "{{ request("program_search") }}",
    firstCategoryName: "{{ $categories->first()->name ?? "" }}",
    firstCategoryId: "{{ $categories->first()->id ?? "" }}"
})'>
    @include('coach.nutrition.partials.tabs-header')

    <!-- TAB 01: MEAL CREATOR -->
    <div x-show="activeTab === 'meals'" x-transition class="grid grid-cols-1 lg:grid-cols-3 gap-8 font-mono">
        <div class="lg:col-span-2 space-y-6">
            @include('coach.nutrition.partials.meal-creator-config')
            @include('coach.nutrition.partials.meal-creator-registry')
        </div>
        @include('coach.nutrition.partials.matrix-analysis')
    </div>

    <!-- TAB 02: PROGRAM MANAGER -->
    <div x-show="activeTab === 'programs'" x-transition class="space-y-8 font-mono">
        @include('coach.nutrition.partials.program-list')
        @include('coach.nutrition.partials.program-builder')
    </div>

    @include('coach.nutrition.partials.pdf_styles')
    @include('coach.nutrition.partials.delete-program-modal')
    @include('coach.nutrition.partials.delete-meal-modal')
    @include('coach.nutrition.partials.delete-form')
</div>
@endsection
