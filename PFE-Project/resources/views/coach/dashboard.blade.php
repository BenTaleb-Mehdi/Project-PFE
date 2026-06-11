@extends('layouts.dashboard')

@section('title', 'Dashboard Overview')
@section('header_title', 'Dashboard')
@section('header_subtitle', 'Operational Intel // System Sync Active')

@section('content')
    @include('coach.dashboard.partials.navbar')
    @include('coach.dashboard.partials.kpi-grid')
    @include('coach.dashboard.partials.bottom-grid')
@endsection
