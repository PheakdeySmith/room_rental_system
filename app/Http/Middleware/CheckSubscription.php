<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        // If not a landlord, continue (this middleware only applies to landlords)
        if (!$user || !$user->hasRole('landlord')) {
            return $next($request);
        }
        
        // Allow access to subscription-related routes even without a subscription
        if ($request->routeIs('landlord.subscription.*')) {
            return $next($request);
        }
        
        // Get the active subscription
        $subscription = $user->activeSubscription();
        
        // Check if user has an active subscription
        if (!$subscription) {
            Log::info("User {$user->id} ({$user->email}) has no active subscription - redirecting to subscription plans");
            return redirect()->route('landlord.subscription.plans')
                ->with('warning', 'You need an active subscription to access this feature. Please subscribe to a plan.');
        }
        
        // Check if subscription is expired (this handles database inconsistencies where status is 'active' but end_date has passed)
        if ($subscription->isExpired()) {
            Log::info("User {$user->id} ({$user->email}) has expired subscription - redirecting to subscription plans");
            return redirect()->route('landlord.subscription.plans')
                ->with('warning', 'Your subscription has expired. Please renew your subscription to continue using all features.');
        }
        
        // Check resource limits based on the request
        if ($this->shouldCheckResourceLimits($request)) {
            $planLimits = $this->checkPlanLimits($user, $subscription, $request);
            
            if (!$planLimits['allowed']) {
                Log::info("User {$user->id} ({$user->email}) exceeded subscription limits: " . $planLimits['message']);
                return redirect()->back()
                    ->with('error', $planLimits['message']);
            }
        }
        
        return $next($request);
    }
    
    /**
     * Determine if we should check resource limits for this request
     */
    private function shouldCheckResourceLimits(Request $request): bool
    {
        // Check limits when creating new properties or rooms
        if ($request->routeIs('landlord.properties.store')) {
            return true;
        }
        
        if ($request->routeIs('landlord.rooms.store') || $request->routeIs('landlord.properties.rooms.store')) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Check if the user's subscription plan limits are exceeded
     */
    private function checkPlanLimits($user, $subscription, $request): array
    {
        $plan = $subscription->subscriptionPlan;
        
        // Check property limits when creating a new property
        if ($request->routeIs('landlord.properties.store')) {
            $currentPropertyCount = $user->properties()->count();
            
            if ($currentPropertyCount >= $plan->properties_limit) {
                return [
                    'allowed' => false,
                    'message' => "You have reached the maximum number of properties ({$plan->properties_limit}) allowed in your subscription plan. Please upgrade your plan to add more properties."
                ];
            }
        }
        
        // Check room limits when creating a new room
        if ($request->routeIs('landlord.rooms.store') || $request->routeIs('landlord.properties.rooms.store')) {
            $currentRoomCount = $user->rooms()->count();
            
            if ($currentRoomCount >= $plan->rooms_limit) {
                return [
                    'allowed' => false,
                    'message' => "You have reached the maximum number of rooms ({$plan->rooms_limit}) allowed in your subscription plan. Please upgrade your plan to add more rooms."
                ];
            }
        }
        
        return ['allowed' => true, 'message' => ''];
    }
}
