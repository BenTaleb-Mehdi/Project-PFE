@extends('layouts.dashboard')

@section('title', 'Finance Control')
@section('header_title', 'Financial Flows')
@section('header_subtitle', 'Revenue Control // Transaction Log V3.0')

@section('content')
<div x-data='financeTracker({ 
    searchQuery: "{{ request("search") }}",
    filterStatus: "{{ request("status", "ALL_TRANSACTIONS") }}",
    pupils: {{ $clients->map(fn($c) => ["id" => $c->id, "name" => $c->user->name])->toJson() }},
    isAddPaymentModalOpen: false
})'>

    @include('coach.finance.partials.kpi-grid')
    @include('coach.finance.partials.transaction-log')
    @include('coach.finance.partials.modals')
</div>




@endsection
