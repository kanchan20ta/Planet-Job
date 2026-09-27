<?php

/*
 * ASSUMPTIONS — please adjust to match your app:
 * - Site settings are stored as simple key/value rows in a `settings` table, via a
 *   `Setting` model with `key` and `value` columns (a common lightweight pattern —
 *   swap this for your own config store/model if you already have one, e.g. a
 *   single-row `SiteSetting` model or a `.env`/config-file based approach).
 * - The fields below (site_name, contact_email, support_phone, maintenance_mode) are
 *   placeholders illustrating the pattern — replace with your actual settings fields.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key');

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'contact_email' => ['required', 'email', 'max:255'],
            'support_phone' => ['nullable', 'string', 'max:50'],
            'maintenance_mode' => ['nullable', 'boolean'],
        ]);

        $validated['maintenance_mode'] = $request->boolean('maintenance_mode');

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('status', 'Settings updated.');
    }
}
