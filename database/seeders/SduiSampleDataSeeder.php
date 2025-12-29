<?php

namespace Database\Seeders;

use App\Models\SduiPage;
use App\Models\SduiSetting;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class SduiSampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Creates sample SDUI pages with complete JSON schemas (Page-Level Architecture)
     */
    public function run(): void
    {
        // Get roles
        $fieldExecutiveRole = Role::where('name', 'Field Executive')->first();
        $engineerRole = Role::where('name', 'Engineer')->first();
        $deliveryManRole = Role::where('name', 'Delivery Man')->first();

        // Create sample login page with complete JSON schema
        $loginPage = SduiPage::create([
            'title' => 'Login Screen',
            'slug' => 'login',
            'description' => 'Universal login screen for all roles',
            'screen_type' => 'login',
            'json_schema' => [
                'version' => '1.0',
                'metadata' => [
                    'title' => 'Login',
                    'description' => 'User authentication screen',
                    'author' => 'System',
                ],
                'components' => [
                    [
                        'id' => 'header_1',
                        'type' => 'header',
                        'order' => 0,
                        'props' => [
                            'title' => 'Welcome Back',
                            'subtitle' => 'Sign in to continue',
                            'alignment' => 'center',
                            'style' => [
                                'fontSize' => 24,
                                'fontWeight' => 'bold',
                                'color' => '#000000',
                            ],
                        ],
                    ],
                    [
                        'id' => 'input_email',
                        'type' => 'input',
                        'order' => 1,
                        'props' => [
                            'type' => 'email',
                            'name' => 'email',
                            'label' => 'Email Address',
                            'placeholder' => 'Enter your email',
                            'required' => true,
                            'validation' => ['email'],
                        ],
                    ],
                    [
                        'id' => 'input_password',
                        'type' => 'input',
                        'order' => 2,
                        'props' => [
                            'type' => 'password',
                            'name' => 'password',
                            'label' => 'Password',
                            'placeholder' => 'Enter your password',
                            'required' => true,
                        ],
                    ],
                    [
                        'id' => 'button_login',
                        'type' => 'button',
                        'order' => 3,
                        'props' => [
                            'label' => 'Sign In',
                            'action' => 'api_call',
                            'endpoint' => '/api/auth/login',
                            'method' => 'POST',
                            'style' => [
                                'backgroundColor' => '#007bff',
                                'textColor' => '#ffffff',
                                'borderRadius' => 8,
                                'width' => '100%',
                            ],
                        ],
                    ],
                ],
                'layout' => [
                    'type' => 'vertical',
                    'spacing' => 16,
                    'padding' => 20,
                ],
            ],
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        // Create Field Executive Dashboard with JSON schema
        $feDashboard = SduiPage::create([
            'title' => 'Field Executive Dashboard',
            'slug' => 'field-executive-dashboard',
            'description' => 'Dashboard for field executives',
            'screen_type' => 'dashboard',
            'json_schema' => [
                'version' => '1.0',
                'metadata' => [
                    'title' => 'Field Executive Dashboard',
                    'description' => 'Main dashboard for field executives',
                ],
                'components' => [
                    [
                        'id' => 'header_1',
                        'type' => 'header',
                        'order' => 0,
                        'props' => [
                            'title' => 'Dashboard',
                            'subtitle' => 'Welcome to your workspace',
                            'alignment' => 'left',
                        ],
                        'roles' => ['Field Executive'], // Component-level role restriction
                    ],
                    [
                        'id' => 'card_tasks',
                        'type' => 'card',
                        'order' => 1,
                        'props' => [
                            'title' => 'Today\'s Tasks',
                            'content' => 'You have 5 pending tasks',
                            'action' => 'navigate',
                            'route' => '/tasks',
                            'style' => [
                                'backgroundColor' => '#f8f9fa',
                                'padding' => 16,
                                'borderRadius' => 8,
                            ],
                        ],
                    ],
                ],
                'layout' => [
                    'type' => 'vertical',
                    'spacing' => 16,
                ],
            ],
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        if ($fieldExecutiveRole) {
            $feDashboard->roles()->attach($fieldExecutiveRole->id);
        }

        // Create Engineer Dashboard with JSON schema
        $engineerDashboard = SduiPage::create([
            'title' => 'Engineer Dashboard',
            'slug' => 'engineer-dashboard',
            'description' => 'Dashboard for engineers',
            'screen_type' => 'dashboard',
            'json_schema' => [
                'version' => '1.0',
                'metadata' => [
                    'title' => 'Engineer Dashboard',
                    'description' => 'Work order management for engineers',
                ],
                'components' => [
                    [
                        'id' => 'header_1',
                        'type' => 'header',
                        'order' => 0,
                        'props' => [
                            'title' => 'Work Orders',
                            'subtitle' => 'Manage your assignments',
                            'alignment' => 'left',
                        ],
                        'roles' => ['Engineer'], // Component-level role restriction
                    ],
                    [
                        'id' => 'card_orders',
                        'type' => 'card',
                        'order' => 1,
                        'props' => [
                            'title' => 'Active Work Orders',
                            'content' => 'You have 3 active assignments',
                            'action' => 'navigate',
                            'route' => '/work-orders',
                            'style' => [
                                'backgroundColor' => '#e3f2fd',
                                'padding' => 16,
                                'borderRadius' => 8,
                            ],
                        ],
                    ],
                ],
                'layout' => [
                    'type' => 'vertical',
                    'spacing' => 16,
                ],
            ],
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        if ($engineerRole) {
            $engineerDashboard->roles()->attach($engineerRole->id);
        }

        // Initialize default settings
        $defaultSettings = [
            ['key' => 'app_name', 'value' => 'SDUI App', 'type' => 'string', 'group' => 'general', 'description' => 'Application name'],
            ['key' => 'api_version', 'value' => 'v1', 'type' => 'string', 'group' => 'general', 'description' => 'API version'],
            ['key' => 'enable_caching', 'value' => '1', 'type' => 'boolean', 'group' => 'general', 'description' => 'Enable SDUI response caching'],
            ['key' => 'cache_ttl', 'value' => '3600', 'type' => 'integer', 'group' => 'general', 'description' => 'Cache TTL in seconds'],
            ['key' => 'strict_mode', 'value' => '0', 'type' => 'boolean', 'group' => 'validation', 'description' => 'Enable strict validation for component props'],
            ['key' => 'allow_unknown_types', 'value' => '1', 'type' => 'boolean', 'group' => 'validation', 'description' => 'Allow unknown component types'],
            ['key' => 'require_authentication', 'value' => '1', 'type' => 'boolean', 'group' => 'security', 'description' => 'Require authentication for SDUI API'],
            ['key' => 'rate_limit', 'value' => '60', 'type' => 'integer', 'group' => 'security', 'description' => 'API rate limit per minute'],
        ];

        foreach ($defaultSettings as $setting) {
            SduiSetting::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('SDUI sample data created successfully!');
    }
}
