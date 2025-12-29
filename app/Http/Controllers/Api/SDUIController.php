<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SduiPage;
use App\Models\SduiSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Role;

class SDUIController extends Controller
{
    /**
     * Get SDUI configuration for Flutter app
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * Query Parameters:
     * - role: Role slug (e.g., 'field-executive', 'engineer', 'delivery-man')
     * - screen: Screen slug (e.g., 'login', 'dashboard', 'otp')
     * - page_id: Direct page ID (optional, alternative to screen slug)
     */
    public function getConfig(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'role' => 'nullable|string',
                'screen' => 'nullable|string',
                'page_id' => 'nullable|integer|exists:sdui_pages,id',
            ]);

            $roleSlug = $request->query('role');
            $screenSlug = $request->query('screen');
            $pageId = $request->query('page_id');

            // Check if caching is enabled
            $enableCaching = SduiSetting::get('enable_caching', true);
            $cacheTtl = SduiSetting::get('cache_ttl', 3600);

            // Generate cache key
            $cacheKey = "sdui_config_{$roleSlug}_{$screenSlug}_{$pageId}";

            // Try to get from cache if enabled
            if ($enableCaching) {
                $cachedData = Cache::get($cacheKey);
                if ($cachedData) {
                    return response()->json([
                        'success' => true,
                        'data' => $cachedData,
                        'cached' => true,
                    ]);
                }
            }

            // Find the page
            $page = null;

            if ($pageId) {
                // Direct page ID lookup
                $page = SduiPage::where('is_active', true)->find($pageId);
            } elseif ($screenSlug) {
                // Find by screen type
                $query = SduiPage::where('screen_type', $screenSlug)
                    ->where('is_active', true);

                // Filter by role if provided
                if ($roleSlug) {
                    $role = Role::where('name', $roleSlug)->first();
                    if ($role) {
                        $query->forRole($role->id);
                    }
                }

                $page = $query->first();
            }

            // Check if page exists
            if (! $page) {
                return response()->json([
                    'success' => false,
                    'message' => 'Page not found for the specified criteria.',
                    'data' => null,
                ], 404);
            }

            // Build response data with complete JSON schema
            $responseData = [
                'page' => [
                    'id' => $page->id,
                    'title' => $page->title,
                    'slug' => $page->slug,
                    'description' => $page->description,
                    'screen_type' => $page->screen_type,
                ],
                'schema' => $page->json_schema ?? [],
            ];

            // If role-based filtering is needed, filter components within the schema
            if ($roleSlug && isset($responseData['schema']['components'])) {
                $role = Role::where('name', $roleSlug)->first();
                if ($role) {
                    $filteredComponents = [];
                    foreach ($responseData['schema']['components'] as $component) {
                        // Check if component has role restrictions
                        if (isset($component['roles']) && ! empty($component['roles'])) {
                            // If role is specified, check if user's role has access
                            if (in_array($roleSlug, $component['roles']) || in_array($role->name, $component['roles'])) {
                                $filteredComponents[] = $component;
                            }
                        } else {
                            // No role restrictions, include component
                            $filteredComponents[] = $component;
                        }
                    }
                    $responseData['schema']['components'] = $filteredComponents;
                }
            }

            // Cache the response if caching is enabled
            if ($enableCaching) {
                Cache::put($cacheKey, $responseData, $cacheTtl);
            }

            return response()->json([
                'success' => true,
                'data' => $responseData,
                'cached' => false,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching SDUI configuration.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Get all available screens for a role
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getScreens(Request $request)
    {
        try {
            $request->validate([
                'role' => 'nullable|string',
            ]);

            $roleSlug = $request->query('role');

            $query = SduiPage::select('id', 'title', 'slug', 'screen_type', 'description')
                ->where('is_active', true);

            // Filter by role if provided
            if ($roleSlug) {
                $role = Role::where('name', $roleSlug)->first();
                if ($role) {
                    $query->forRole($role->id);
                }
            }

            $pages = $query->get();

            return response()->json([
                'success' => true,
                'data' => $pages,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching screens.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Clear SDUI cache
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function clearCache()
    {
        try {
            // Clear all SDUI page-level cache
            // Note: Cache::flush() clears all cache. For production, consider using cache tags
            Cache::flush();

            return response()->json([
                'success' => true,
                'message' => 'SDUI page cache cleared successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while clearing cache.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Get component types and their schemas
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getComponentTypes()
    {
        $componentTypes = [
            'header' => [
                'name' => 'Header',
                'description' => 'Display a header with title and optional subtitle',
                'schema' => [
                    'title' => 'string (required)',
                    'subtitle' => 'string (optional)',
                    'alignment' => 'string (left|center|right)',
                    'style' => 'object (optional)',
                ],
            ],
            'text' => [
                'name' => 'Text',
                'description' => 'Display text content',
                'schema' => [
                    'content' => 'string (required)',
                    'alignment' => 'string (left|center|right)',
                    'style' => 'object (optional)',
                ],
            ],
            'button' => [
                'name' => 'Button',
                'description' => 'Interactive button',
                'schema' => [
                    'label' => 'string (required)',
                    'action' => 'string (navigate|api_call|submit)',
                    'endpoint' => 'string (optional)',
                    'style' => 'object (optional)',
                ],
            ],
            'input' => [
                'name' => 'Input Field',
                'description' => 'Form input field',
                'schema' => [
                    'type' => 'string (text|email|password|number)',
                    'name' => 'string (required)',
                    'label' => 'string (required)',
                    'placeholder' => 'string (optional)',
                    'required' => 'boolean',
                    'validation' => 'array (optional)',
                ],
            ],
            'image' => [
                'name' => 'Image',
                'description' => 'Display an image',
                'schema' => [
                    'url' => 'string (required)',
                    'alt' => 'string (optional)',
                    'width' => 'string|number',
                    'height' => 'string|number',
                ],
            ],
        ];

        return response()->json([
            'success' => true,
            'data' => $componentTypes,
        ]);
    }

    public function handleRoleSelectionSchema()
    {
        try {
            $roleSelectionPage = SduiPage::where('screen_type', 'role_selection')->first();

            if (! $roleSelectionPage) {
                return response()->json([
                    'success' => false,
                    'message' => 'Role selection page not found.',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $roleSelectionPage->json_schema ?? [],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching role selection schema.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    public function handleLoginSchema(Request $request)
    {
        try {
            $request->validate([
                'role_id' => 'required|exists:roles,id',
            ]);

            if ($request->role_id == 1) {
                $screen_type = 'field_login';
            } elseif ($request->role_id == 2) {
                $screen_type = 'delivery_login';
            } elseif ($request->role_id == 3) {
                $screen_type = 'sales_login';
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid role id.',
                ], 404);
            }

            $loginPage = SduiPage::where('screen_type', $screen_type)->forRole($request->role_id)->first();
            if (! $loginPage) {
                return response()->json([
                    'success' => false,
                    'message' => 'Login page not found.',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $loginPage->json_schema ?? [],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching login schema.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
}
