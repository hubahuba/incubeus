<?php namespace Ngungut\Nccms\Controller;

use BaseController;
use Ngungut\Nccms\Model\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Ngungut\Nccms\Libraries\Format;
//use Ngungut\Nccms\Libraries\UploadHandler;
use Illuminate\Support\Facades\Validator;

/**
 * Class MediaController
 * Contain Media Libraries, Upload, and Image Slider Handler
 */
class UsersController extends BaseController {
    /**
     * set default layout
     * @var string
     */
    protected $layout = 'nccms::layouts.admin';

    /**
     * Media Upload
     */
	public function index()
	{
        $title = 'Users';
        $this->layout->title = $title . ' - NCCMS';
        $this->layout->with('script', 'nccms::admin.users.scripts.users')
            ->with('style', 'nccms::admin.users.styles.users');
        $this->layout->content = \View::make('nccms::admin.users.users')
            ->with('title', $title)
            ->with('users', User::all());
	}

    public function doUsers(){

        if(Input::has('delete')){
            $id = Input::get('theID');
            User::destroy($id);
            return \Redirect::nccms('users');
        }

        $rules = array(
            'cUserName' => 'required|max:30',
            'cFirstName' => 'required|max:30',
            'cNickname' => 'required|max:30',
            'cLastName' => 'required|max:30',
            'password' => 'required|same:password_confirmation',
            'password_confirmation' => 'required' 
        );
        $display = array(
            'cUserName' => 'UserName',
            'cFirstName' => 'FirstName',
            'cNickname' => 'Nickname',
            'cLastName' => 'LastName',
            'password' => 'Password',
            'password_confirmation' => 're-Password'
        );

        $title = 'Users';
        //$this->layout->title = $title . ' - NCCMS';
        $validator = Validator::make(Input::all(), $rules, array(), $display);
        if($validator->fails()) {
            
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(Input::all());
        }else{
            if(Input::has('cID')){
                    //username,password,first name,last name,nickname,level,status
                    $category = User::find(Input::get('cID'));
                    $category->username = Input::get('cUserName');
                    $category->password = \Hash::make(Input::get('password'));
                    $category->firstname = Input::get('cFirstName');
                    $category->nickname = Input::get('cNickname');
                    $category->level = Input::get('user_level');
                    $category->status = '1';
                    $category->save();
            }else{
                $repass = Input::get('password_confirmation');
                User::create([
                    'username' => Input::get('cUserName'),
                    'firstname' => Input::get('cFirstName'),
                    'lastname' => Input::get('cLastName'),
                    'nickname' => Input::get('cNickname'),
                    'password' => \Hash::make(Input::get('password')),
                    'level' => Input::get('user_level'),
                    'status' => '1'
                ]);
            }
        }

        return \Redirect::nccms('users');
         
    }

}
