<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use DB;

class SettingController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:setting-list|setting-create|setting-edit|setting-delete', ['only' => ['index','store']]);
        $this->middleware('permission:setting-create', ['only' => ['create','store']]);
        $this->middleware('permission:setting-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:setting-delete', ['only' => ['destroy']]);
    }


    public function edit($id)
    {
        $settings = Setting::where('id' , $id)->first();
        return view('admin.settings.edit' , compact('settings'));
    }

    public function update(Request $request, $id)
    {
//        DB::table('settings')->where('id' , $id)->update([
//            // 'address' => request('address'),
//            'notification_settings_text' => request('notification_settings_text'),
//            'about_app' => request('about_app'),
//            'phone' => request('phone'),
//            'email' => request('email'),
//            'fb_link' => request('fb_link'),
//            'tw_link' => request('tw_link'),
//            'insta_link' => request('insta_link'),
//            'tube_link' => request('tube_link'),
//            'whats_link' => request('whats_link'),
//
//        ]);
        $settings = Setting::findOrfail($id);
        $settings->update($request->all());
        flash()->success('Updated');
        return redirect()->back();
    }

}
