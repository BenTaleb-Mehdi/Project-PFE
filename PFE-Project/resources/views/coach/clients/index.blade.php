@extends('layouts.dashboard')

@section('title', 'Client Registry')
@section('header_title', 'Client Registry')
@section('header_subtitle', 'Pupil Database // Assignment Protocol')

@section('content')
<div x-data='clientRegistry({ 
    protocols: {{ $protocols->map(fn($p) => ["id" => $p->id, "title" => $p->title])->toJson() }},
    searchQuery: "{{ request("search") }}",
    filterStatus: "{{ request("status", "ALL_STATUSES") }}"
})'>

    @include('coach.clients.partials.discovery-bar')
    @include('coach.clients.partials.client-list')
    @include('coach.clients.partials.modals')
</div>




@endsection
