<?php namespace Ngungut\Nccms\Model;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

    /**
     * Fillable data from user table
     *
     */
    protected $fillable = [
        'username', 'password', 'firstname',
        'lastname', 'nickname', 'level',
        'creator',
    ];

    /**
     * Get User firstname
     * @return string
     */
    public static function firstname($id){
        $user = static::where('id', '=', $id)->select('firstname')->first();
        return $user['firstname'];
    }

    /**
     * Get User lastname
     * @return string
     */
    public static function lastname($id){
        $user = static::where('id', '=', $id)->select('lastname')->first();
        return $user['lastname'];
    }

    /**
     * Relation from Categories model
     * @return object
     */
    public function categories(){
        return $this->hasMany('Ngungut\Nccms\Model\Categories', 'creator');
    }


    /**
     * Relation from Tags model
     * @return object
     */
    public function media(){
        return $this->hasMany('Ngungut\Nccms\Model\Media', 'creator');
    }

    /**
     * Self relation to User model
     * @return object
     */
    public function parent(){
        return $this->hasMany('Ngungut\Nccms\Model\User', 'creator');
    }

    /**
     * Selft relation from User model
     * @return object
     */
    public function child(){
        return $this->belongsTo('Ngungut\Nccms\Model\User', 'creator');
    }

    /**
     * Relation from Posts model
     * @return mixed
     */
    public function posts(){
        return $this->hasMany('Ngungut\Nccms\Model\Posts', 'creator');
    }

    /**
     * Relation from Menus model
     * @return mixed
     */
    public function menus(){
        return $this->hasMany('Ngungut\Nccms\Model\Menus', 'creator');
    }

    /**
     * Relation from Address model
     * @return mixed
     */
    public function templates(){
        return $this->hasMany('Ngungut\Nccms\Model\Template', 'creator');
    }

}
