@extends('backends.layouts.app')

@section('title', 'Subscription Details')

@push('style')
<style>
    .subscription-info {
        margin-bottom: 2rem;
    }
    
    .subscription-info .title {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .subscription-badge {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 0.25rem;
    }
    
    .landlord-info {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .landlord-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin-right: 1rem;
    }
    
    .landlord-details h5 {
        margin-bottom: 0.25rem;
    }
    
    .plan-details {
        background-color: #f8f9fa;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .subscription-dates {
        display: flex;
        margin-bottom: 1.5rem;
    }
    
    .date-box {
        flex: 1;
        padding: 1rem;
        border-radius: 0.5rem;
        text-align: center;
    }
    
    .date-box:first-child {
        margin-right: 1rem;
        background-color: #e8f3ff;
    }
    
    .date-box:last-child {
        background-color: #fff8e8;
    }
    
    .date-box .title {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }
    
    .date-box .value {
        font-size: 1.25rem;
        font-weight: 600;
    }
    
    .payment-info {
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
        padding: 1.5rem;
    }
    
    .info-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .info-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    
    .info-label {
        color: #6c757d;
    }
    
    .info-value {
        font-weight: 500;
    }
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        margin-top: 2rem;
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
                        <li class="breadcrumb-item"><a href="{{ route('admin.subscriptions.index') }}">User Subscriptions</a></li>
                        <li class="breadcrumb-item active">Details</li>
                    </ol>
                </div>
                <h4 class="page-title">Subscription Details</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title">Subscription #{{ $subscription->id }}</h5>
                        <div>
                            @if($subscription->status == 'active')
                                <span class="subscription-badge bg-success-subtle text-success">Active</span>
                            @elseif($subscription->status == 'canceled')
                                <span class="subscription-badge bg-danger-subtle text-danger">Canceled</span>
                            @else
                                <span class="subscription-badge bg-warning-subtle text-warning">Expired</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="landlord-info">
                        <img src="{{ $subscription->user->image ? asset('storage/'.$subscription->user->image) : asset('assets/images/users/avatar-1.jpg') }}" 
                            class="landlord-avatar" alt="Landlord Avatar">
                        <div class="landlord-details">
                            <h5>{{ $subscription->user->name }}</h5>
                            <p class="text-muted mb-1">{{ $subscription->user->email }}</p>
                            <p class="text-muted mb-0">{{ $subscription->user->phone }}</p>
                        </div>
                    </div>
                    
                    <div class="plan-details">
                        <h6 class="mb-3">Subscription Plan</h6>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="mb-0">{{ $subscription->subscriptionPlan->name }}</h5>
                            <h5 class="mb-0 text-primary">{{ $subscription->subscriptionPlan->formatted_price }}</h5>
                        </div>
                        <p class="mb-3">{{ $subscription->subscriptionPlan->description }}</p>
                        <div class="row">
                            <div class="col-6">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Duration:</span>
                                    <span class="fw-medium">{{ $subscription->subscriptionPlan->formatted_duration }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Properties:</span>
                                    <span class="fw-medium">{{ $subscription->subscriptionPlan->properties_limit }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Rooms:</span>
                                    <span class="fw-medium">{{ $subscription->subscriptionPlan->rooms_limit }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Days Remaining:</span>
                                    <span class="fw-medium">{{ $subscription->days_remaining }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="subscription-dates">
                        <div class="date-box">
                            <div class="title">Start Date</div>
                            <div class="value">{{ $subscription->start_date->format('M d, Y') }}</div>
                        </div>
                        <div class="date-box">
                            <div class="title">End Date</div>
                            <div class="value">{{ $subscription->end_date->format('M d, Y') }}</div>
                        </div>
                    </div>
                    
                    <div class="payment-info">
                        <h6 class="mb-3">Payment Information</h6>
                        <div class="info-item">
                            <div class="info-label">Payment Status</div>
                            <div class="info-value">
                                @if($subscription->payment_status == 'paid')
                                    <span class="subscription-badge bg-success-subtle text-success">Paid</span>
                                @elseif($subscription->payment_status == 'pending')
                                    <span class="subscription-badge bg-warning-subtle text-warning">Pending</span>
                                @elseif($subscription->payment_status == 'trial')
                                    <span class="subscription-badge bg-info-subtle text-info">Trial</span>
                                @else
                                    <span class="subscription-badge bg-danger-subtle text-danger">Failed</span>
                                @endif
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Amount Paid</div>
                            <div class="info-value">{{ $subscription->formatted_amount_paid }}</div>
                        </div>
                        @if($subscription->payment_method)
                        <div class="info-item">
                            <div class="info-label">Payment Method</div>
                            <div class="info-value">{{ ucfirst($subscription->payment_method) }}</div>
                        </div>
                        @endif
                        @if($subscription->transaction_id)
                        <div class="info-item">
                            <div class="info-label">Transaction ID</div>
                            <div class="info-value">{{ $subscription->transaction_id }}</div>
                        </div>
                        @endif
                    </div>
                    
                    @if($subscription->notes)
                    <div class="mt-4">
                        <h6 class="mb-2">Notes</h6>
                        <p class="mb-0">{{ $subscription->notes }}</p>
                    </div>
                    @endif
                    
                    <div class="action-buttons">
                        <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left me-1"></i> Back to Subscriptions
                        </a>
                        @if($subscription->status == 'active')
                        <form action="{{ route('admin.subscriptions.cancel', $subscription->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-warning" onclick="return confirm('Are you sure you want to cancel this subscription?')">
                                <i class="ti ti-x me-1"></i> Cancel Subscription
                            </button>
                        </form>
                        @endif
                        <form action="{{ route('admin.subscriptions.renew', $subscription->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to renew this subscription?')">
                                <i class="ti ti-refresh me-1"></i> Renew Subscription
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Subscription Timeline</h5>
                    
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-dot bg-primary">
                                <i class="ti ti-credit-card"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Subscription Created</h6>
                                <p class="text-muted mb-0">{{ $subscription->created_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                        
                        @if($subscription->payment_status == 'paid')
                        <div class="timeline-item">
                            <div class="timeline-dot bg-success">
                                <i class="ti ti-check"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Payment Completed</h6>
                                <p class="text-muted mb-0">{{ $subscription->updated_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                        @endif
                        
                        @if($subscription->status == 'canceled')
                        <div class="timeline-item">
                            <div class="timeline-dot bg-danger">
                                <i class="ti ti-x"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Subscription Canceled</h6>
                                <p class="text-muted mb-0">{{ $subscription->updated_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                        @endif
                        
                        @if($subscription->isExpired())
                        <div class="timeline-item">
                            <div class="timeline-dot bg-warning">
                                <i class="ti ti-alert-triangle"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Subscription Expired</h6>
                                <p class="text-muted mb-0">{{ $subscription->end_date->format('M d, Y') }}</p>
                            </div>
                        </div>
                        @elseif($subscription->status == 'active')
                        <div class="timeline-item">
                            <div class="timeline-dot bg-info">
                                <i class="ti ti-calendar-event"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Expires On</h6>
                                <p class="text-muted mb-0">{{ $subscription->end_date->format('M d, Y') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Quick Actions</h5>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.users.edit', $subscription->user_id) }}" class="btn btn-outline-primary">
                            <i class="ti ti-user me-1"></i> Edit Landlord
                        </a>
                        <a href="{{ route('admin.subscriptions.create') }}" class="btn btn-outline-info">
                            <i class="ti ti-plus me-1"></i> Create New Subscription
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
