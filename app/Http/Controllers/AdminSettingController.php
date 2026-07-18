<?php

namespace App\Http\Controllers;

use App\Support\AdminSettings;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function index()
    {
        $settings = AdminSettings::all();

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'laundry_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'whatsapp' => ['required', 'string', 'max:50'],
            'operational_hours' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'facebook' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $settings = AdminSettings::all();
        $settings = array_merge($settings, $validated);

        if ($request->hasFile('logo')) {
            $settings['logo'] = $request->file('logo')->store('settings', 'public');
        }

        AdminSettings::store($settings);

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan laundry berhasil disimpan.');
    }
}
