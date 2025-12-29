<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SduiSetting;
use Illuminate\Http\Request;

class SduiSettingController extends Controller
{
    /**
     * Display SDUI settings
     */
    public function index()
    {
        $settings = SduiSetting::orderBy('group')->orderBy('key')->get()->groupBy('group');

        return view('admin.sdui.settings.index', compact('settings'));
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*.key' => 'required|string',
            'settings.*.value' => 'nullable',
            'settings.*.type' => 'required|in:string,json,boolean,integer,float',
        ]);

        foreach ($validated['settings'] as $settingData) {
            SduiSetting::set(
                $settingData['key'],
                $settingData['value'],
                $settingData['type'],
                $settingData['group'] ?? 'general'
            );
        }

        flash()->success('Settings updated successfully!');

        return redirect()->route('admin.sdui.settings.index');
    }

    /**
     * Create a new setting
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:255|unique:sdui_settings,key',
            'value' => 'nullable',
            'type' => 'required|in:string,json,boolean,integer,float',
            'description' => 'nullable|string',
            'group' => 'required|string|max:100',
        ]);

        $setting = new SduiSetting;
        $setting->key = $validated['key'];
        $setting->type = $validated['type'];
        $setting->description = $validated['description'] ?? null;
        $setting->group = $validated['group'];
        $setting->setTypedValue($validated['value'] ?? '');
        $setting->save();

        flash()->success('Setting created successfully!');

        return redirect()->route('admin.sdui.settings.index');
    }

    /**
     * Delete a setting
     */
    public function destroy($id)
    {
        $setting = SduiSetting::findOrFail($id);
        $setting->delete();

        flash()->success('Setting deleted successfully!');

        return redirect()->route('admin.sdui.settings.index');
    }

    /**
     * Get default settings structure
     */
    public function getDefaults()
    {
        return [
            'general' => [
                'app_name' => [
                    'value' => 'SDUI App',
                    'type' => 'string',
                    'description' => 'Application name',
                ],
                'api_version' => [
                    'value' => 'v1',
                    'type' => 'string',
                    'description' => 'API version',
                ],
                'enable_caching' => [
                    'value' => true,
                    'type' => 'boolean',
                    'description' => 'Enable SDUI response caching',
                ],
                'cache_ttl' => [
                    'value' => 3600,
                    'type' => 'integer',
                    'description' => 'Cache TTL in seconds',
                ],
            ],
            'validation' => [
                'strict_mode' => [
                    'value' => false,
                    'type' => 'boolean',
                    'description' => 'Enable strict validation for component props',
                ],
                'allow_unknown_types' => [
                    'value' => true,
                    'type' => 'boolean',
                    'description' => 'Allow unknown component types',
                ],
            ],
            'security' => [
                'require_authentication' => [
                    'value' => true,
                    'type' => 'boolean',
                    'description' => 'Require authentication for SDUI API',
                ],
                'rate_limit' => [
                    'value' => 60,
                    'type' => 'integer',
                    'description' => 'API rate limit per minute',
                ],
            ],
        ];
    }

    /**
     * Initialize default settings
     */
    public function initializeDefaults()
    {
        $defaults = $this->getDefaults();

        foreach ($defaults as $group => $settings) {
            foreach ($settings as $key => $config) {
                $existingSetting = SduiSetting::where('key', $key)->first();

                if (! $existingSetting) {
                    SduiSetting::set(
                        $key,
                        $config['value'],
                        $config['type'],
                        $group
                    );

                    // Update description
                    $setting = SduiSetting::where('key', $key)->first();
                    if ($setting) {
                        $setting->description = $config['description'];
                        $setting->save();
                    }
                }
            }
        }

        flash()->success('Default settings initialized successfully!');

        return redirect()->route('admin.sdui.settings.index');
    }
}
