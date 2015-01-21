<?php namespace Ngungut\Nccms\Controller;

use BaseController;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Ngungut\Nccms\Libraries\Format;
use Ngungut\Nccms\Model\Categories;
use Ngungut\Nccms\Model\PostCategory;
use Ngungut\Nccms\Model\Posts;

/**
 * Class CategoryController
 * Contain Categories Handler
 */
class CategoryController extends BaseController {
    /**
     * set default layout
     * @var string
     */
    protected $layout = 'nccms::layouts.admin';

    /**
     * Caegory Post Page
     *
     */
	public function index()
	{
        $this->layout->title = 'Categories Post - NCCMS';
        $this->layout->with('script', 'nccms::admin.posts.scripts.categories')
            ->with('style', 'nccms::admin.posts.styles.categories');
        $this->layout->content = View::make('nccms::admin.posts.categories')
            ->with('categories', Categories::orderBy('updated_at', 'desc')->get())
            ->with('title', 'Categories Post');
	}

    /**
     * Category Save action handler
     * @return \Illuminate\Http\RedirectResponse
     */
    public function doCategories(){
        if(Input::has('delete')){
            $id = Input::get('theID');
            Categories::destroy($id);
            return Redirect::nccms('post/categories');
        }
        $rules = array(
            'cName' => 'required|max:128',
        );
        $display = array(
            'cName' => 'Category Name',
        );

        $validator = Validator::make(Input::all(), $rules, array(), $display);
        if($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(Input::all());
        }else{
            if(Input::has('cID')){
                $category = Categories::find(Input::get('cID'));
                $category->name = Input::get('cName');
                $category->slug = \Format::textToSlug(Input::get('cName'));
                $category->icon = (Input::has('cIcon')) ? Input::get('cIcon'):null;
                $category->description = (Input::has('cDescription')) ? Input::get('cDescription'):null;
                $category->save();
            }else{
                Categories::create([
                    'name' => \Input::get('cName'),
                    'slug' => \Format::textToSlug(\Input::get('cName')),
                    'icon' => (Input::has('cIcon')) ? \Input::get('cIcon'):null,
                    'description' => (\Input::has('cDescription')) ? \Input::get('cDescription'):null,
                    'creator' => (\Session::has('logedin')) ? \Session::get('logedin'):null
                ]);
            }
            return Redirect::nccms('post/categories');
        }
    }

}
