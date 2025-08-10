<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscriptionStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        // Only apply to landlord users
        if ($user && $user->isLandlord()) {
            // Get the active subscription
            $subscription = $user->activeSubscription();
            
            // Check if there's an active subscription
            if (!$subscription) {
                // No active subscription - store alert in session
                session()->flash('subscription_alert', [
                    'type' => 'danger',
                    'message' => 'You don\'t have an active subscription. Please subscribe to continue using all features.'
                ]);
                
                // If they're trying to access a restricted route, redirect to dashboard
                if (!$this->isAllowedWithoutSubscription($request)) {
                    return redirect()->route('dashboard')->with('subscription_expired', true);
                }
            }
            // Check if subscription is about to expire (within 7 days)
            elseif ($subscription->days_remaining <= 7) {
                session()->flash('subscription_alert', [
                    'type' => 'warning',
                    'message' => "Your subscription will expire in {$subscription->days_remaining} days. Please renew to avoid service interruption."
                ]);
            }
            // Check payment status
            elseif ($subscription->payment_status !== 'paid' && !$subscription->isInTrial()) {
                session()->flash('subscription_alert', [
                    'type' => 'warning',
                    'message' => 'Your payment is pending. Some features may be restricted until payment is confirmed.'
                ]);
            }
            
            // Store subscription status in session for views to access
            session(['subscription_status' => [
                'active' => $subscription ? true : false,
                'plan' => $subscription ? $subscription->subscriptionPlan->name : null,
                'days_remaining' => $subscription ? $subscription->days_remaining : 0,
                'payment_status' => $subscription ? $subscription->payment_status : null,
                'is_trial' => $subscription ? $subscription->isInTrial() : false,
            ]]);
        }
        
        return $next($request);
    }
    
    /**
     * Check if the route is allowed without a subscription
     */
    protected function isAllowedWithoutSubscription(Request $request): bool
    {
        // Allow access to dashboard, subscription routes, and profile
        $allowedRoutes = [
            'dashboard',
            'profile.edit',
            'profile.update',
            // Add subscription-related routes
            'landlord.subscription.plans',
            'landlord.subscription.checkout',
            'landlord.subscription.success',
        ];
        
        // Allow access to these route prefixes
        $allowedPrefixes = [
            'subscription',
            'profile',
            'payment',
        ];
        
        // Check if the route name is in allowed routes
        $routeName = $request->route()->getName();
        if ($routeName && in_array($routeName, $allowedRoutes)) {
            return true;
        }
        
        // Check if the route name starts with any allowed prefix
        if ($routeName) {
            foreach ($allowedPrefixes as $prefix) {
                if (str_starts_with($routeName, $prefix)) {
                    return true;
                }
            }
        }
        
        return false;
    }
}
