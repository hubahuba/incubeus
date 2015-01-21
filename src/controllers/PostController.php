<?php namespace Ngungut\Nccms\Controller;

use BaseController;
use Ngungut\Nccms;
use Ngungut\Nccms\Model\Categories;
use Ngungut\Nccms\Model\PostCategory;
use Ngungut\Nccms\Model\Posts;
use Ngungut\Nccms\Model\Settings;
use Ngungut\Nccms\Model\Template;

/**
 * Class PostController
 * Contain Post Handler
 */
class PostController extends BaseController {
    /**
     * set default layout
     * @var string
     */
    protected $layout = 'nccms::layouts.admin';

    /**
     * List of Post Page
     * @var integer the id of post
     */
    public function index()
    {
        $posts = Posts::where('type', '=', 'post')->get();
        $this->layout->title = 'Post - NCCMS';
        $this->layout->with('script', 'nccms::admin.posts.scripts.index')
            ->with('style', 'nccms::admin.posts.styles.index');
        $this->layout->content = \View::make('nccms::admin.posts.index')
            ->with('posts', $posts)
            ->with('title', 'Post');
    }

    /**
     * New/Edit Post Page
     * @var integer the id of post
     */
	public function action($id = false)
	{
        if($id){
            $title = 'Edit';
            $post = Posts::where('type', '=', 'post')
                ->where('id', '=', $id)->first();
            if(empty($post)) return \Redirect::nccms('post');
            $postCategories = PostCategory::where('post_id', '=', $id)->lists('category_id');
        }else{
            $title = 'New';
            $post = false;
            $postCategories = false;
        }
        $templates = \Nccms::getTemplates();
        $this->layout->title = $title . ' Post - NCCMS';
        $this->layout->with('script', 'nccms::admin.posts.scripts.action')
            ->with('style', 'nccms::admin.posts.styles.action');
        $this->layout->content = \View::make('nccms::admin.posts.action')
            ->with('categories', Categories::orderBy('updated_at', 'desc')->get())
            ->with('post', $post)
            ->with('post_categories', $postCategories)
            ->with('templates', $templates)
            ->with('title', $title);
	}

    /**
     * Posts Save action handler
     * @return \Illuminate\Http\RedirectResponse
     */
    public function doAction($id = false){
        $rules = array(
            'p-title' => 'required|max:254|unique:posts,title,'.$id,
            'p-slug' => 'required|max:254|Slug|unique:posts,slug,'.$id,
            'template' => 'required',
            'categories' => 'required',
            'p-publish' => 'required_if:status,pub',
        );
        $display = array(
            'p-title' => 'Post Title',
            'p-slug' => 'Post Slug',
            'template' => 'Template',
            'categories' => 'Categories',
            'p-publish' => 'Publish Date',
        );

        $validator = \Validator::make(\Input::all(), $rules, array(), $display);
        if($validator->fails()) {
            return \Redirect::back()
                ->withErrors($validator)
                ->withInput(\Input::all());
        }else{
            if(\Input::has('p-id')){
                $post = Posts::find(\Input::get('p-id'));
                $post->title = \Input::get('p-title');
                $post->slug = \Input::get('p-slug');
                $post->post = (\Input::has('p-content')) ? \Input::get('p-content'):null;
                $post->excerpt = (\Input::has('p-excerpt')) ? \Input::get('p-excerpt'):null;
                $post->feature_image = (\Input::has('f-image')) ? \Input::get('f-image'):null;
                $post->template = \Input::get('template');
                $post->status = \Input::get('status');
                $post->publish_date = (\Input::has('p-publish')) ? \Format::prepare_date(\Input::get('p-publish')):null;
                $post->save();
                if($post->id) {
                    PostCategory::where('post_id', '=', $post->id)->delete();
                    $categories = \Input::get('categories');
                    if (!empty($categories)) {
                        foreach ($categories as $category) {
                            PostCategory::create([
                                'post_id' => $post->id,
                                'category_id' => $category
                            ]);
                        }
                    }
                }
            }else{
                $post = Posts::create([
                    'title' => \Input::get('p-title'),
                    'slug' => \Input::get('p-slug'),
                    'post' => (\Input::has('p-content')) ? \Input::get('p-content'):null,
                    'excerpt' => (\Input::has('p-excerpt')) ? \Input::get('p-excerpt'):null,
                    'feature_image' => (\Input::has('f-image')) ? \Input::get('f-image'):null,
                    'type' => 'post',
                    'template' => \Input::get('template'),
                    'status' => \Input::get('status'),
                    'publish_date' => (\Input::has('p-publish')) ? \Format::prepare_date(\Input::get('p-publish')):null,
                    'creator' => \Session::get('logedin')
                ]);
                if($post->id) {
                    $categories = \Input::get('categories');
                    if (!empty($categories)) {
                        foreach ($categories as $category) {
                            PostCategory::create([
                                'post_id' => $post->id,
                                'category_id' => $category
                            ]);
                        }
                    }
                }
            }
            return \Redirect::nccms('post');
        }
    }

    /**
     * Post Delete action handler
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id = false){
        if($id){
            Posts::where('type', '=', 'post')
                ->where('id', '=', $id)
                ->delete();
        }
        return \Redirect::nccms('post');
    }

}
