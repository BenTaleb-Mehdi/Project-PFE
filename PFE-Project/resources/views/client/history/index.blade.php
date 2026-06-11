@extends('layouts.client')

@section('title', 'Program History')

@section('content')
<div x-data="{ 
    searchQuery: '',
    filterStatus: 'ALL_STATUSES',
    expandedIds: [],
    toggleExpand(id) {
        if (this.expandedIds.includes(id)) {
            this.expandedIds = this.expandedIds.filter(i => i !== id);
        } else {
            this.expandedIds.push(id);
        }
    }
}">
    @include('client.history.partials.header')
    @include('client.history.partials.discovery-bar')
    @include('client.history.partials.history-table')
    @include('client.history.partials.history-cards')
    @include('client.history.partials.pagination')
</div>
</div>
@endsection
