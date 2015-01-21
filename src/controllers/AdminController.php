<?php namespace Ngungut\Nccms\Controller;

use BaseController;
use Ngungut\Nccms\Model\User as User;

/**
 * Class AdminController
 * Contain Dashboard, Login, Logout handler
 */
class AdminController extends BaseController {

    /**
     * set default layout
     * @var string
     */
    protected $layout = 'nccms::layouts.admin';

    /**
     * Dashboard page
     *
     */
	public function dashboard()
	{
        $this->layout->title = 'Dashboard';
        $this->layout->with('script', 'nccms::admin.scripts.global')
            ->with('style', 'nccms::admin.styles.global');
        $this->layout->content = \View::make('nccms::admin.dashboard')
            ->with('title', 'Website');
	}

    /**
     * Login Page
     * @return \Illuminate\View\View
     */
    public function login(){
        return \View::make('nccms::admin.login');
    }

    /**
     * Login action handler
     * put login session
     * @return \Illuminate\Http\RedirectResponse
     */
    public function doLogin(){
        $rules = array(
            'userid' => 'required|max:30',
            'password' => 'required',
        );
        $display = array(
            'userid' => 'User ID',
            'password' => 'Password'
        );

        $validator = \Validator::make(\Input::all(), $rules, array(), $display);
        if($validator->fails()) {
            return \Redirect::back()
                ->withErrors($validator)
                ->withInput(\Input::all());
        }else{
            $user = User::where('username', '=', \Input::get('userid'))
                ->first();
            if(isset($user->id)){
                if($user->level < 3) {
                    if (\Hash::check(\Input::get('password'), $user->password)) {
                        \Session::put('logedin', $user->id);
                        \Session::put('loginLevel', $user->level);
                        \Session::put('nickname', $user->nickname);
                    }
                    return \Redirect::nccms('/');
                }else{
                    \Session::flash('error', 'Permission Error.');
                    return \Redirect::nccms('login');
                }
            }else{
                \Session::flash('error', 'Email/Password Error.');
                return \Redirect::nccms('login');
            }
        }
    }

    /**
     * Logout action handler
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(){
        \Session::forget('logedin');
        \Session::forget('loginLevel');
        \Session::forget('nickname');
        return \Redirect::nccms('login');
    }

}
