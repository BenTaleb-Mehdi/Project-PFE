@extends('layouts.dashboard')

@section('title', 'Team Management')
@section('header_title', 'Team Registry')
@section('header_subtitle', 'Hierarchy Control // Staff Manifest V3.0')

@section('content')
<div x-data='teamManagement({ 
    searchQuery: "{{ request("search") }}",
    filterSpec: "{{ request("specialty", "ALL_SPECIALIZATIONS") }}"
})'>

    @include('coach.team.partials.kpi-grid')
    @include('coach.team.partials.team-table')
    @include('coach.team.partials.modals')
</div>




@endsection
