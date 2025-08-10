<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserSubscription;
use App\Models\User;
use App\Models\SubscriptionPlan;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UserSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Don't truncate due to potential foreign key constraints
        // Instead, we'll only add subscriptions for users that don't have one yet

        // Get all landlord users
        $landlords = User::role('landlord')->get();
        
        // Get all subscription plans
        $subscriptionPlans = SubscriptionPlan::all();
        
        if ($landlords->isEmpty() || $subscriptionPlans->isEmpty()) {
            $this->command->info('No landlords or subscription plans found. Please run the UserSeeder and SubscriptionPlanSeeder first.');
            return;
        }

        // Current date for reference
        $currentDate = Carbon::now();

        // Sample payment methods
        $paymentMethods = ['credit_card', 'paypal', 'bank_transfer', 'cash'];
        
        // Create subscriptions with various statuses and dates
        $subscriptions = [
            // Active subscriptions
            [
                'user_id' => $landlords[0]->id,
                'subscription_plan_id' => $subscriptionPlans->where('name', 'Standard Plan')->first()->id,
                'start_date' => $currentDate->copy()->subDays(15),
                'end_date' => $currentDate->copy()->addDays(15),
                'status' => 'active',
                'payment_status' => 'paid',
                'amount_paid' => 59.99,
                'payment_method' => 'credit_card',
                'transaction_id' => 'txn_' . Str::random(10),
                'notes' => 'Monthly subscription',
                'meta_data' => json_encode(['promotion_applied' => false]),
                'created_at' => $currentDate->copy()->subDays(15),
                'updated_at' => $currentDate->copy()->subDays(15),
            ],
            [
                'user_id' => $landlords[1]->id,
                'subscription_plan_id' => $subscriptionPlans->where('name', 'Premium Plan')->first()->id,
                'start_date' => $currentDate->copy()->subDays(20),
                'end_date' => $currentDate->copy()->addDays(10),
                'status' => 'active',
                'payment_status' => 'paid',
                'amount_paid' => 99.99,
                'payment_method' => 'paypal',
                'transaction_id' => 'txn_' . Str::random(10),
                'notes' => 'Customer requested premium features',
                'meta_data' => json_encode(['payment_id' => 'PAY-' . Str::random(10), 'paypal_email' => $landlords[1]->email]),
                'created_at' => $currentDate->copy()->subDays(20),
                'updated_at' => $currentDate->copy()->subDays(20),
            ],
            [
                'user_id' => $landlords[2]->id,
                'subscription_plan_id' => $subscriptionPlans->where('name', 'Enterprise Plan')->first()->id,
                'start_date' => $currentDate->copy()->subDays(25),
                'end_date' => $currentDate->copy()->addDays(5),
                'status' => 'active',
                'payment_status' => 'paid',
                'amount_paid' => 199.99,
                'payment_method' => 'bank_transfer',
                'transaction_id' => 'txn_' . Str::random(10),
                'notes' => 'Large property management company',
                'meta_data' => json_encode(['bank_reference' => 'BT-' . Str::random(8), 'confirmed_by' => 'admin']),
                'created_at' => $currentDate->copy()->subDays(25),
                'updated_at' => $currentDate->copy()->subDays(25),
            ],
            
            // Active annual subscriptions
            [
                'user_id' => $landlords[3]->id,
                'subscription_plan_id' => $subscriptionPlans->where('name', 'Standard Annual')->first()->id,
                'start_date' => $currentDate->copy()->subDays(60),
                'end_date' => $currentDate->copy()->addDays(305),
                'status' => 'active',
                'payment_status' => 'paid',
                'amount_paid' => 599.99,
                'payment_method' => 'credit_card',
                'transaction_id' => 'txn_' . Str::random(10),
                'notes' => 'Annual subscription with discount',
                'created_at' => $currentDate->copy()->subDays(60),
                'updated_at' => $currentDate->copy()->subDays(60),
            ],
            
            // Expiring soon (within 7 days)
            [
                'user_id' => $landlords[4]->id,
                'subscription_plan_id' => $subscriptionPlans->where('name', 'Basic Plan')->first()->id,
                'start_date' => $currentDate->copy()->subDays(25),
                'end_date' => $currentDate->copy()->addDays(5),
                'status' => 'active',
                'payment_status' => 'paid',
                'amount_paid' => 29.99,
                'payment_method' => 'paypal',
                'transaction_id' => 'txn_' . Str::random(10),
                'notes' => 'First-time customer',
                'created_at' => $currentDate->copy()->subDays(25),
                'updated_at' => $currentDate->copy()->subDays(25),
            ],
            [
                'user_id' => $landlords[5]->id,
                'subscription_plan_id' => $subscriptionPlans->where('name', 'Premium Plan')->first()->id,
                'start_date' => $currentDate->copy()->subDays(27),
                'end_date' => $currentDate->copy()->addDays(3),
                'status' => 'active',
                'payment_status' => 'paid',
                'amount_paid' => 99.99,
                'payment_method' => 'credit_card',
                'transaction_id' => 'txn_' . Str::random(10),
                'notes' => 'Needs renewal reminder',
                'created_at' => $currentDate->copy()->subDays(27),
                'updated_at' => $currentDate->copy()->subDays(27),
            ],
            
            // Expired subscriptions
            [
                'user_id' => $landlords[6]->id,
                'subscription_plan_id' => $subscriptionPlans->where('name', 'Basic Plan')->first()->id,
                'start_date' => $currentDate->copy()->subDays(45),
                'end_date' => $currentDate->copy()->subDays(15),
                'status' => 'expired',
                'payment_status' => 'paid',
                'amount_paid' => 29.99,
                'payment_method' => 'cash',
                'transaction_id' => 'txn_' . Str::random(10),
                'notes' => 'Did not renew after expiration',
                'created_at' => $currentDate->copy()->subDays(45),
                'updated_at' => $currentDate->copy()->subDays(15),
            ],
            [
                'user_id' => $landlords[7]->id,
                'subscription_plan_id' => $subscriptionPlans->where('name', 'Standard Plan')->first()->id,
                'start_date' => $currentDate->copy()->subDays(40),
                'end_date' => $currentDate->copy()->subDays(10),
                'status' => 'expired',
                'payment_status' => 'paid',
                'amount_paid' => 59.99,
                'payment_method' => 'paypal',
                'transaction_id' => 'txn_' . Str::random(10),
                'notes' => 'Needs follow-up for renewal',
                'created_at' => $currentDate->copy()->subDays(40),
                'updated_at' => $currentDate->copy()->subDays(10),
            ],
            
            // Canceled subscriptions
            [
                'user_id' => $landlords[8]->id,
                'subscription_plan_id' => $subscriptionPlans->where('name', 'Premium Plan')->first()->id,
                'start_date' => $currentDate->copy()->subDays(20),
                'end_date' => $currentDate->copy()->addDays(10),
                'status' => 'canceled',
                'payment_status' => 'paid',
                'amount_paid' => 99.99,
                'payment_method' => 'credit_card',
                'transaction_id' => 'txn_' . Str::random(10),
                'notes' => 'Customer requested cancellation due to financial reasons',
                'created_at' => $currentDate->copy()->subDays(20),
                'updated_at' => $currentDate->copy()->subDays(5),
            ],
            
            // Trial subscriptions
            [
                'user_id' => $landlords[9]->id,
                'subscription_plan_id' => $subscriptionPlans->where('name', 'Basic Plan')->first()->id,
                'start_date' => $currentDate->copy()->subDays(10),
                'end_date' => $currentDate->copy()->addDays(4),
                'status' => 'active',
                'payment_status' => 'trial',
                'amount_paid' => 0.00,
                'payment_method' => null,
                'transaction_id' => null,
                'notes' => '14-day free trial',
                'created_at' => $currentDate->copy()->subDays(10),
                'updated_at' => $currentDate->copy()->subDays(10),
            ],
            
            // Pending payment
            [
                'user_id' => $landlords[10]->id,
                'subscription_plan_id' => $subscriptionPlans->where('name', 'Premium Plan')->first()->id,
                'start_date' => $currentDate->copy()->subDays(2),
                'end_date' => $currentDate->copy()->addDays(28),
                'status' => 'active',
                'payment_status' => 'pending',
                'amount_paid' => 0.00,
                'payment_method' => 'bank_transfer',
                'transaction_id' => null,
                'notes' => 'Waiting for bank transfer confirmation',
                'created_at' => $currentDate->copy()->subDays(2),
                'updated_at' => $currentDate->copy()->subDays(2),
            ],
            
            // Recently renewed
            [
                'user_id' => $landlords[11]->id,
                'subscription_plan_id' => $subscriptionPlans->where('name', 'Enterprise Plan')->first()->id,
                'start_date' => $currentDate->copy()->subDays(2),
                'end_date' => $currentDate->copy()->addDays(28),
                'status' => 'active',
                'payment_status' => 'paid',
                'amount_paid' => 199.99,
                'payment_method' => 'credit_card',
                'transaction_id' => 'txn_' . Str::random(10),
                'notes' => 'Renewal after previous plan expired',
                'created_at' => $currentDate->copy()->subDays(2),
                'updated_at' => $currentDate->copy()->subDays(2),
            ],
            
            // Recent upgrade from basic to premium
            [
                'user_id' => $landlords[12]->id,
                'subscription_plan_id' => $subscriptionPlans->where('name', 'Premium Plan')->first()->id,
                'start_date' => $currentDate->copy()->subDays(5),
                'end_date' => $currentDate->copy()->addDays(25),
                'status' => 'active',
                'payment_status' => 'paid',
                'amount_paid' => 99.99,
                'payment_method' => 'credit_card',
                'transaction_id' => 'txn_' . Str::random(10),
                'notes' => 'Upgraded from Basic Plan',
                'created_at' => $currentDate->copy()->subDays(5),
                'updated_at' => $currentDate->copy()->subDays(5),
            ],
        ];

        // Add additional random subscriptions to fill the database
        for ($i = 0; $i < min(count($landlords) - 13, 20); $i++) {
            // Skip landlords that already have subscriptions
            if (in_array($landlords[13 + $i]->id, array_column($subscriptions, 'user_id'))) {
                continue;
            }
            
            $plan = $subscriptionPlans->random();
            $startDate = $currentDate->copy()->subDays(rand(1, 60));
            $endDate = $startDate->copy()->addDays($plan->duration_days);
            $status = $endDate->isPast() ? 'expired' : 'active';
            
            $subscriptions[] = [
                'user_id' => $landlords[13 + $i]->id,
                'subscription_plan_id' => $plan->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => $status,
                'payment_status' => 'paid',
                'amount_paid' => $plan->price,
                'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                'transaction_id' => 'txn_' . Str::random(10),
                'notes' => null,
                'meta_data' => json_encode(['auto_generated' => true, 'seed_timestamp' => now()->timestamp]),
                'created_at' => $startDate,
                'updated_at' => $startDate,
            ];
        }

        // Create the subscriptions
        foreach ($subscriptions as $subscription) {
            // Check if the user already has a subscription
            $existingSubscription = UserSubscription::where('user_id', $subscription['user_id'])->first();
            
            if (!$existingSubscription) {
                UserSubscription::create($subscription);
            }
        }
    }
}
