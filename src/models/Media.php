<?php namespace Ngungut\Nccms\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Media extends Eloquent {

	/**
	 * The database table menus by the model.
	 *
	 * @var string
	 */
	protected $table = 'media';

    /**
     * Fillable of menus data
     *
     * @var array
     */
    protected $fillable = [
        'thumbnail', 'medium', 'large', 'description', 'realname', 'type', 'creator'
    ];

    /**
     * Relation to User model
     * @return object
     */
    public function creators(){
        return $this->belongsTo('Ngungut\Nccms\Model\User', 'creator');
    }

    /**
     * Relation from SliderDetail model
     * @return object
     */
    public function sliderDetail(){
        return $this->hasMany('Ngungut\Nccms\Model\SliderDetail', 'media_id');
    }

    /**
     * Relation From Posts Model
     * @return object
     */
    public function feature(){
        return $this->hasMany('Posts', 'feature_image');
    }

    /**
     * Get all media files list
     * @return object
     */
    public static function getAll(){
        return static::orderBy('created_at', 'desc')->get();
    }

    /**
     * Get image media files list
     * @return object
     */
    public static function getImage(){
        return static::where('type', 'LIKE', '%image%')->orderBy('created_at', 'desc')->get();
    }

    /**
     * Get multimedia files list
     * @return object
     */
    public static function getMultimedia(){
        return static::where('type', 'LIKE', '%audio%')->orWhere('type', 'LIKE', '%video%')->orderBy('created_at', 'desc')->get();
    }

}
