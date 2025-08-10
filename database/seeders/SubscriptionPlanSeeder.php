<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;
use Carbon\Carbon;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Don't use truncate due to foreign key constraints
        // Instead, we'll check if plans exist and only add new ones

        $plans = [
            [
                'name' => 'Basic Plan',
                'code' => 'basic-monthly',
                'description' => 'Perfect for small landlords managing a single property with a few rooms.',
                'price' => 29.99,
                'duration_days' => 30,
                'properties_limit' => 1,
                'rooms_limit' => 5,
                'is_featured' => false,
                'is_active' => true,
                'features' => json_encode([
                    'has_analytics' => false,
                    'has_reports' => false,
                    'has_api_access' => false
                ]),
                'created_at' => Carbon::now()->subMonths(6),
                'updated_at' => Carbon::now()->subMonths(6),
            ],
            [
                'name' => 'Standard Plan',
                'code' => 'standard-monthly',
                'description' => 'Ideal for landlords with multiple properties and rooms who need basic analytics.',
                'price' => 59.99,
                'duration_days' => 30,
                'properties_limit' => 3,
                'rooms_limit' => 15,
                'is_featured' => true,
                'is_active' => true,
                'features' => json_encode([
                    'has_analytics' => true,
                    'has_reports' => false,
                    'has_api_access' => false
                ]),
                'created_at' => Carbon::now()->subMonths(5),
                'updated_at' => Carbon::now()->subMonths(5),
            ],
            [
                'name' => 'Premium Plan',
                'code' => 'premium-monthly',
                'description' => 'Perfect for established landlords who need comprehensive management tools.',
                'price' => 99.99,
                'duration_days' => 30,
                'properties_limit' => 5,
                'rooms_limit' => 30,
                'is_featured' => false,
                'is_active' => true,
                'features' => json_encode([
                    'has_analytics' => true,
                    'has_reports' => true,
                    'has_api_access' => false
                ]),
                'created_at' => Carbon::now()->subMonths(4),
                'updated_at' => Carbon::now()->subMonths(4),
            ],
            [
                'name' => 'Enterprise Plan',
                'code' => 'enterprise-monthly',
                'description' => 'For large-scale property management companies with advanced needs.',
                'price' => 199.99,
                'duration_days' => 30,
                'properties_limit' => 15,
                'rooms_limit' => 100,
                'is_featured' => false,
                'is_active' => true,
                'features' => json_encode([
                    'has_analytics' => true,
                    'has_reports' => true,
                    'has_api_access' => true
                ]),
                'created_at' => Carbon::now()->subMonths(3),
                'updated_at' => Carbon::now()->subMonths(3),
            ],
            [
                'name' => 'Basic Annual',
                'code' => 'basic-annual',
                'description' => 'Basic Plan with annual billing for greater savings.',
                'price' => 299.99,
                'duration_days' => 365,
                'properties_limit' => 1,
                'rooms_limit' => 5,
                'is_featured' => false,
                'is_active' => true,
                'features' => json_encode([
                    'has_analytics' => false,
                    'has_reports' => false,
                    'has_api_access' => false
                ]),
                'created_at' => Carbon::now()->subMonths(2),
                'updated_at' => Carbon::now()->subMonths(2),
            ],
            [
                'name' => 'Standard Annual',
                'code' => 'standard-annual',
                'description' => 'Standard Plan with annual billing for greater savings.',
                'price' => 599.99,
                'duration_days' => 365,
                'properties_limit' => 3,
                'rooms_limit' => 15,
                'is_featured' => false,
                'is_active' => true,
                'features' => json_encode([
                    'has_analytics' => true,
                    'has_reports' => false,
                    'has_api_access' => false
                ]),
                'created_at' => Carbon::now()->subMonths(2),
                'updated_at' => Carbon::now()->subMonths(2),
            ],
            [
                'name' => 'Premium Annual',
                'code' => 'premium-annual',
                'description' => 'Premium Plan with annual billing for greater savings.',
                'price' => 999.99,
                'duration_days' => 365,
                'properties_limit' => 5,
                'rooms_limit' => 30,
                'is_featured' => false,
                'is_active' => true,
                'features' => json_encode([
                    'has_analytics' => true,
                    'has_reports' => true,
                    'has_api_access' => false
                ]),
                'created_at' => Carbon::now()->subMonths(2),
                'updated_at' => Carbon::now()->subMonths(2),
            ],
            [
                'name' => 'Enterprise Annual',
                'code' => 'enterprise-annual',
                'description' => 'Enterprise Plan with annual billing for greater savings.',
                'price' => 1999.99,
                'duration_days' => 365,
                'properties_limit' => 15,
                'rooms_limit' => 100,
                'is_featured' => false,
                'is_active' => true,
                'features' => json_encode([
                    'has_analytics' => true,
                    'has_reports' => true,
                    'has_api_access' => true
                ]),
                'created_at' => Carbon::now()->subMonths(2),
                'updated_at' => Carbon::now()->subMonths(2),
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::firstOrCreate(
                ['name' => $plan['name']],
                $plan
            );
        }
    }
}
