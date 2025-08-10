@extends('backends.layouts.app')

@section('title', 'Subscription Plans')

@push('style')
<style>
    .plan-card {
        transition: transform 0.2s;
        height: 100%;
    }
    
    .plan-card:hover {
        transform: translateY(-5px);
    }
    
    .plan-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 10;
    }
    
    .plan-features {
        padding-left: 1.5rem;
    }
    
    .plan-features li {
        margin-bottom: 0.5rem;
    }
    
    .plan-actions {
        display: flex;
        gap: 0.5rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Subscription Plans</li>
                    </ol>
                </div>
                <h4 class="page-title">Subscription Plans</h4>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title">Manage Subscription Plans</h5>
                        <a href="{{ route('admin.subscription-plans.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus me-1"></i> Create New Plan
                        </a>
                    </div>
                    <p class="card-text">
                        Create and manage subscription plans for landlords. These plans determine how many properties and rooms a landlord can manage.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @forelse($plans as $plan)
        <div class="col-md-6 col-xl-4 mb-4">
            <div class="card plan-card">
                @if($plan->is_featured)
                <div class="plan-badge">
                    <span class="badge bg-warning">Featured</span>
                </div>
                @endif
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h4 class="card-title">{{ $plan->name }}</h4>
                        <span class="badge {{ $plan->is_active ? 'bg-success' : 'bg-danger' }}">
                            {{ $plan->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    
                    <h2 class="mb-3 text-primary">{{ $plan->formatted_price }}</h2>
                    <p class="text-muted mb-3">{{ $plan->formatted_duration }}</p>
                    
                    <p class="card-text mb-3">{{ $plan->description }}</p>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Properties:</span>
                            <span class="fw-bold">{{ $plan->properties_limit }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Rooms:</span>
                            <span class="fw-bold">{{ $plan->rooms_limit }}</span>
                        </div>
                    </div>
                    
                    @if($plan->features)
                    <div class="mb-4">
                        <h6 class="mb-2">Features:</h6>
                        <ul class="plan-features">
                            @foreach(json_decode($plan->features) as $feature)
                            <li>{{ $feature }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                    <div class="plan-actions">
                        <a href="{{ route('admin.subscription-plans.edit', $plan->id) }}" class="btn btn-sm btn-info">
                            <i class="ti ti-edit me-1"></i> Edit
                        </a>
                        <form action="{{ route('admin.subscription-plans.destroy', $plan->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this plan?')">
                                <i class="ti ti-trash me-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="ti ti-credit-card display-4 text-muted mb-3"></i>
                    <h4>No Subscription Plans Found</h4>
                    <p class="text-muted">You haven't created any subscription plans yet.</p>
                    <a href="{{ route('admin.subscription-plans.create') }}" class="btn btn-primary mt-2">
                        <i class="ti ti-plus me-1"></i> Create New Plan
                    </a>
                </div>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
