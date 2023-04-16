<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->common_data = [
            'title' => 'Setting',
            'view' => 'setting',
            'route' => 'setting',
            'module' => 'Setting',
        ];
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = $this->common_data;
        $setting = Setting::first();
        return view($this->common_data['view'] . '.index', compact('data','setting'));
    }

    public function update(Request $request) {

        if($request->has('image')) {
            $fileName = 'logo_'.time().'.'.$request->image->extension();
            $request->image->move(storage_path('app/setting'), $fileName);
            Helper::unlinkFile($request->old_logo);
        } else {
            $fileName = array_reverse(explode('/',$request->old_logo))[0] == 'logo-icon.png' ? null : array_reverse(explode('/',$request->old_logo))[0];
        }

        $request['logo'] = $fileName;
        Setting::find(1)->update(['company_name' => $request->company_name,'gst_no' => $request->gst_no,'pan_no' => $request->pan_no,'mobile' => $request->mobile,'email' => $request->email,'city' => $request->city,'pincode' => $request->pincode,'address' => $request->address,'logo' => $request->logo]);

        Helper::message_popup($this->common_data['module'] . ' Update Successfully', 'success');
        return redirect('/' . $this->common_data['route']);
    }
}
