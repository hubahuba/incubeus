<?php namespace Ngungut\Components\Controller;

use BaseController;
use Illuminate\Support\Facades\Request;
use Ngungut\Nccms\Format;
use Ngungut\Nccms\Model\Categories;
use Ngungut\Nccms\Model\PostCategory;
use Ngungut\Nccms\Model\Posts;

/**
 * Class Widgets
 * Contain Widgets Plugin handler
 */
class Components extends BaseController {

    public function showTitle(){
        $slug = Request::segment(1);
        $post = Posts::where('slug', '=', $slug)->first();
        if(isset($post['id'])) {
            return \View::make('component::showTitle')
                ->with('title', $post['title']);
        }
        return null;
    }

    public function showContent(){
        $slug = Request::segment(1);
        $post = Posts::where('slug', '=', $slug)->first();
        if(isset($post['id'])) {
            return \View::make('component::showContent')
                ->with('post', $post['post']);
        }
        return null;
    }

    public function showImage(){
        $slug = Request::segment(1);
        $post = Posts::where('slug', '=', $slug)->first();
        if(isset($post['id'])) {
            return '<img src="' . $post['feature_image'] . '" />';
        }
        return null;
    }

    public function showDate(){
        $slug = Request::segment(1);
        $post = Posts::where('slug', '=', $slug)->first();
        if(isset($post['id'])) {
            return Format::formats_date($post['created_at']);
        }
        return null;
    }

    public function getList(){
        $categories = Categories::all();
        $data = ['' => ':slug'];
        foreach($categories as $category){
            $data[$category['id']] = $category['name'];
        }
        return \Form::select('options', $data, null, ['class' => 'form-control']);
    }

    public function recentPost($param = false)
    {
        if($param){
            $postCat = PostCategory::where('category_id', '=', $param)->lists('post_id');
        }else{
            $postCat = [];
            $slug = Request::segment(2);
            if($slug) {
                $postCat = PostCategory::where('slug', '=', $slug)->lists('post_id');
            }
        }
        $newPosts = [];
        if(!empty($postCat)) {
            $newPosts = Posts::whereIn('id', $postCat)
                ->where('type', '=', 'post')
                ->orderBy('publish_date', 'desc')
                ->take(3)->get();
        }
        return \View::make('component::recentPost')
            ->with('newPosts', $newPosts);
    }

    public function categoryPost($param = false)
    {
        if($param){
            $postCat = PostCategory::where('category_id', '=', $param)->lists('post_id');
        }else{
            $postCat = [];
            $slug = Request::segment(2);
            if($slug) {
                $category = Categories::where('slug', '=', $slug)->first();
                $postCat = PostCategory::where('category_id', '=', $category['id'])->lists('post_id');
            }
        }
        $newPosts = [];
        if(!empty($postCat)) {
            $newPosts = Posts::whereIn('id', $postCat)
                ->orderBy('publish_date', 'desc')
                ->paginate(6);
        }
        return \View::make('component::categoryPost')
            ->with('newPosts', $newPosts)
            ->with('title', $category['name']);
    }

}
