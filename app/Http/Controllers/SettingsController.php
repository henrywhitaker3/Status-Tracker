<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Rules\SettingsArrayRule;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::get();

        return Inertia::render(
            'Settings/Index',
            [
                'settings' => [
                    'general' => $settings->where('category', 'general'),
                    'notifications' => $settings->where('category', 'notifications'),
                ],
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'settings' => ['required', new SettingsArrayRule],
        ]);

        foreach ($request->get('settings') as $setting) {
            Setting::where('id', $setting['id'])
                ->update(['value' => $setting['value']]);
        }

        return redirect()->back()->with('success', __('messages.settings.updated'));
    }
}
