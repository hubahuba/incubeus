<?php namespace Ngungut\Nccms\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Posts extends Eloquent {

	/**
	 * The database table categories by the model.
	 *
	 * @var string
	 */
	protected $table = 'posts';

    /**
     * Fillable of categories data
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'post', 'excerpt', 'status', 'feature_image', 'template', 'type', 'creator', 'publish_date'
    ];

    /**
     * Relation from PostCategory model
     * @return object
     */
    public function ofCategory(){
        return $this->hasMany('Ngungut\Nccms\Model\PostCategory', 'post_id');
    }

    /**
     * Relation to Media model
     * @return object
     */
    public function media(){
        return $this->belongsTo('Ngungut\Nccms\Model\Media', 'feature_image');
    }

    /**
     * Relation to User model
     * @return object
     */
    public function creators(){
        return $this->belongsTo('Ngungut\Nccms\Model\User', 'creator');
    }

    /**
     * Relation to Template model
     * @return object
     */
    public function template(){
        return $this->belongsTo('Ngungut\Nccms\Model\Template', 'template_id');
    }

}
