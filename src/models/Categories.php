<?php namespace Ngungut\Nccms\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Categories extends Eloquent {

	/**
	 * The database table categories by the model.
	 *
	 * @var string
	 */
	protected $table = 'categories';

    /**
     * Fillable of categories data
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'icon', 'description', 'creator'
    ];

    /**
     * Relation from PostCategory model
     * @return object
     */
    public function ofPost(){
        return $this->hasMany('Ngungut\Nccms\Model\PostCategory', 'category_id');
    }

    /**
     * Relation to User model
     * @return object
     */
    public function creators(){
        return $this->belongsTo('Ngungut\Nccms\Model\User', 'creator');
    }

}
