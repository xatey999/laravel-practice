@extends('layouts.app')

@section('content')
    @switch(Auth::user()->role->value)
        @case('admin')
            @include('dashboards.admin-dashboard')
            @break
        @case('supplier')
            @include('dashboards.supplier-dashboard')
            @break
        @case('customer')
            @include('dashboards.customer-dashboard')
            @break
        @default
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <p>Unknown role. Please contact support.</p>
                        </div>
                    </div>
                </div>
            </div>
    @endswitch
@endsection