@extends('backends.layouts.app')

@section('title', 'Subscription Checkout')

@push('style')
<style>
    .checkout-card {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .payment-method-card {
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    
    .payment-method-card.selected {
        border-color: var(--bs-primary);
        background-color: rgba(13, 110, 253, 0.05);
    }
    
    .payment-method-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .payment-logo {
        width: 80px;
        height: 50px;
        object-fit: contain;
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
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('landlord.subscription.plans') }}">Subscription Plans</a></li>
                        <li class="breadcrumb-item active">Checkout</li>
                    </ol>
                </div>
                <h4 class="page-title">Subscription Checkout</h4>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card checkout-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7 border-end">
                            <h5 class="card-title">Payment Details</h5>
                            
                            <form action="{{ route('landlord.subscription.purchase', $plan->id) }}" method="POST" id="payment-form">
                                @csrf
                                
                                <div class="mb-4">
                                    <label class="form-label">Select Payment Method</label>
                                    
                                    <div class="payment-methods">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="card payment-method-card" data-method="credit_card">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="https://cdn-icons-png.flaticon.com/512/179/179457.png" class="payment-logo" alt="Credit Card">
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                <h6 class="mb-0">Credit Card</h6>
                                                                <small class="text-muted">Visa, Mastercard, Amex</small>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input payment-method-radio" type="radio" name="payment_method" value="credit_card" id="payment-credit-card" checked>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="card payment-method-card" data-method="paypal">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="https://cdn-icons-png.flaticon.com/512/196/196566.png" class="payment-logo" alt="PayPal">
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                <h6 class="mb-0">PayPal</h6>
                                                                <small class="text-muted">Pay with your PayPal account</small>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input payment-method-radio" type="radio" name="payment_method" value="paypal" id="payment-paypal">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="card payment-method-card" data-method="bank_transfer">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="https://cdn-icons-png.flaticon.com/512/2830/2830289.png" class="payment-logo" alt="Bank Transfer">
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                <h6 class="mb-0">Bank Transfer</h6>
                                                                <small class="text-muted">Direct bank transfer</small>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input payment-method-radio" type="radio" name="payment_method" value="bank_transfer" id="payment-bank-transfer">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="billing-name" class="form-label">Name on Card</label>
                                    <input type="text" class="form-control" id="billing-name" name="billing_name" value="{{ $user->name }}" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="billing-email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="billing-email" name="billing_email" value="{{ $user->email }}" required>
                                </div>
                                
                                <div id="credit-card-fields">
                                    <div class="mb-3">
                                        <label for="card-number" class="form-label">Card Number</label>
                                        <input type="text" class="form-control" id="card-number" name="card_number" placeholder="4242 4242 4242 4242">
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="card-expiry" class="form-label">Expiry Date</label>
                                                <input type="text" class="form-control" id="card-expiry" name="card_expiry" placeholder="MM/YY">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="card-cvc" class="form-label">CVC</label>
                                                <input type="text" class="form-control" id="card-cvc" name="card_cvc" placeholder="123">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-primary">Complete Payment</button>
                                </div>
                            </form>
                        </div>
                        
                        <div class="col-md-5">
                            <h5 class="card-title">Order Summary</h5>
                            
                            <div class="card bg-light mb-3">
                                <div class="card-body">
                                    <h5 class="mb-3">{{ $plan->name }}</h5>
                                    
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Subscription Fee</span>
                                        <span>${{ number_format($plan->price, 2) }}</span>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between">
                                        <span>Duration</span>
                                        <span>{{ $plan->duration_days }} days</span>
                                    </div>
                                    
                                    <hr>
                                    
                                    <div class="d-flex justify-content-between fw-bold">
                                        <span>Total</span>
                                        <span>${{ number_format($plan->price, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Plan Features</h6>
                                    
                                    <ul class="list-group list-group-flush">
                                        @php 
                                            $features = json_decode($plan->features, true) ?? [];
                                        @endphp
                                        
                                        @foreach($features as $feature => $enabled)
                                            @if($enabled)
                                                <li class="list-group-item bg-transparent px-0">
                                                    <i class="ti ti-check text-success me-2"></i>
                                                    {{ ucwords(str_replace('_', ' ', $feature)) }}
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        // Handle payment method selection
        $('.payment-method-card').on('click', function() {
            const method = $(this).data('method');
            
            // Update UI
            $('.payment-method-card').removeClass('selected');
            $(this).addClass('selected');
            
            // Check the radio button
            $(`#payment-${method}`).prop('checked', true);
            
            // Show/hide credit card fields
            if (method === 'credit_card') {
                $('#credit-card-fields').show();
            } else {
                $('#credit-card-fields').hide();
            }
        });
        
        // Trigger click on the initially selected payment method
        $('.payment-method-card[data-method="credit_card"]').click();
    });
</script>
@endpush
