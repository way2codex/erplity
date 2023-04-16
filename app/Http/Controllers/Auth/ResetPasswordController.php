<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    // use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->common_data = [
            'title' => 'Change Password',
            'view' => 'passwordChange',
            'route' => 'passwordChange',
            'module' => 'Change Password',
        ];
    }

    public function index() {
        $data = $this->common_data;
        return view('auth.changePass',compact('data'));
    }

    public function update(Request $request) {
        auth()->user()->update(['password' => bcrypt($request->new_confirm_password)]);

        Helper::message_popup($this->common_data['module'] . ' Successfully', 'success');
        return redirect('/' . $this->common_data['route']);
    }
}
