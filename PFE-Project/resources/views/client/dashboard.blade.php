@extends('layouts.client')

@section('title', 'Dashboard Overview')

@section('content')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div x-data='clientDashboard({ 
    history: @json($history), 
    programMeals: @json($programData["meals"] ?? []) 
})'>
    
    <!-- DASHBOARD VIEW -->
    <div class="space-y-8 sm:space-y-12">
        @include('client.dashboard.partials.header')
        @include('client.dashboard.partials.kpi-grid')
        @include('client.dashboard.partials.dashboard-content')
    </div>
</div>
@endsection
