@extends('backends.layouts.app')

@section('title', 'User Subscriptions')

@push('style')
<style>
    .subscription-badge {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 0.25rem;
    }
    
    .subscription-actions {
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
                        <li class="breadcrumb-item active">User Subscriptions</li>
                    </ol>
                </div>
                <h4 class="page-title">User Subscriptions</h4>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title">Manage User Subscriptions</h5>
                        <a href="{{ route('admin.subscriptions.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus me-1"></i> Create New Subscription
                        </a>
                    </div>
                    <p class="card-text">
                        View and manage subscription records for landlords. You can create, view details, cancel, or renew subscriptions.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-centered table-hover table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Landlord</th>
                                    <th>Plan</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th>Amount</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subscriptions as $subscription)
                                <tr>
                                    <td>#{{ $subscription->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="{{ $subscription->user->image ? asset('storage/'.$subscription->user->image) : asset('assets/images/users/avatar-1.jpg') }}" 
                                                    class="rounded-circle avatar-xs" alt="User Image">
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <h5 class="mb-0 font-size-14">{{ $subscription->user->name }}</h5>
                                                <p class="mb-0 text-muted font-size-12">{{ $subscription->user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $subscription->subscriptionPlan->name }}</td>
                                    <td>{{ $subscription->start_date->format('M d, Y') }}</td>
                                    <td>{{ $subscription->end_date->format('M d, Y') }}</td>
                                    <td>
                                        @if($subscription->status == 'active')
                                            <span class="subscription-badge bg-success-subtle text-success">Active</span>
                                        @elseif($subscription->status == 'canceled')
                                            <span class="subscription-badge bg-danger-subtle text-danger">Canceled</span>
                                        @else
                                            <span class="subscription-badge bg-warning-subtle text-warning">Expired</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($subscription->payment_status == 'paid')
                                            <span class="subscription-badge bg-success-subtle text-success">Paid</span>
                                        @elseif($subscription->payment_status == 'pending')
                                            <span class="subscription-badge bg-warning-subtle text-warning">Pending</span>
                                        @elseif($subscription->payment_status == 'trial')
                                            <span class="subscription-badge bg-info-subtle text-info">Trial</span>
                                        @else
                                            <span class="subscription-badge bg-danger-subtle text-danger">Failed</span>
                                        @endif
                                    </td>
                                    <td>{{ $subscription->formatted_amount_paid }}</td>
                                    <td>
                                        <div class="subscription-actions">
                                            <a href="{{ route('admin.subscriptions.show', $subscription->id) }}" class="btn btn-sm btn-info">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            @if($subscription->status == 'active')
                                            <form action="{{ route('admin.subscriptions.cancel', $subscription->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Are you sure you want to cancel this subscription?')">
                                                    <i class="ti ti-x"></i>
                                                </button>
                                            </form>
                                            @endif
                                            <form action="{{ route('admin.subscriptions.renew', $subscription->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Are you sure you want to renew this subscription?')">
                                                    <i class="ti ti-refresh"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <i class="ti ti-credit-card display-4 text-muted mb-3 d-block"></i>
                                        <h5>No subscriptions found</h5>
                                        <p class="text-muted">There are no subscription records yet.</p>
                                        <a href="{{ route('admin.subscriptions.create') }}" class="btn btn-sm btn-primary mt-2">
                                            <i class="ti ti-plus me-1"></i> Create New Subscription
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-4">
                        {{ $subscriptions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
