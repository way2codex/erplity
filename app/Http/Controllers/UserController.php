<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->common_data = [
            'title' => 'Profile',
            'view' => 'setting.profile',
            'route' => 'profile',
            'module' => 'Profile',
        ];
    }

    public function index() {
        $data = $this->common_data;
        $user = User::find(auth()->user()->id);
        return view($this->common_data['view'] . '.index', compact('data','user'));
    }

    public function update(Request $request) {

        if($request->has('image')) {
            $fileName = 'profile_'.time().'.'.$request->image->extension();
            $request->image->move(storage_path('app/profile'), $fileName);
            Helper::unlinkFile($request->old_photo);
        } else {
            $fileName = array_reverse(explode('/',$request->old_photo))[0] == 'admin.png' ? null : array_reverse(explode('/',$request->old_photo))[0];
        }

        $request['photo'] = $fileName;
        auth()->user()->update(['name' => $request->name,'mobile' => $request->mobile,'alt_mobile' => $request->alt_mobile,'photo' => $request->photo]);

        Helper::message_popup($this->common_data['module'] . ' Update Successfully', 'success');
        return redirect('/' . $this->common_data['route']);
    }


}
