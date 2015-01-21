<?php namespace Ngungut\Nccms\Controller;

use BaseController;
use Illuminate\Support\Facades\Redirect;
use Ngungut\Nccms;
use Ngungut\Nccms\Model\Posts;

/**
 * Class PageController
 * Contain Page Handler
 */
class PageController extends BaseController {
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
        $pages = Posts::where('type', '=', 'page')->get();
        $this->layout->title = 'Page - NCCMS';
        $this->layout->with('script', 'nccms::admin.pages.scripts.index')
            ->with('style', 'nccms::admin.pages.styles.index');
        $this->layout->content = \View::make('nccms::admin.pages.index')
            ->with('pages', $pages)
            ->with('title', 'Page');
    }

    /**
     * New/Edit Post Page
     * @var integer the id of post
     */
	public function action($id = false)
	{
        if($id){
            $title = 'Edit';
            $page = Posts::where('type', '=', 'page')
                ->where('id', '=', $id)->first();
            if(empty($page)) return \Redirect::nccms('page');
        }else{
            $title = 'New';
            $page = false;
        }
        $templates = \Nccms::getTemplates();
        $this->layout->title = $title . ' Page - NCCMS';
        $this->layout->with('script', 'nccms::admin.pages.scripts.action')
            ->with('style', 'nccms::admin.pages.styles.action');
        $this->layout->content = \View::make('nccms::admin.pages.action')
            ->with('page', $page)
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
            'p-slug' => 'required|max:254|unique:posts,slug,'.$id,
            'template' => 'required',
            'p-publish' => 'required_if:status,pub',
        );
        $display = array(
            'p-title' => 'Page Title',
            'p-slug' => 'Page Slug',
            'template' => 'Template',
            'p-publish' => 'Publish Date',
        );

        $validator = \Validator::make(\Input::all(), $rules, array(), $display);
        if($validator->fails()) {
            return \Redirect::back()
                ->withErrors($validator)
                ->withInput(\Input::all());
        }else{
            if(\Input::has('p-id')){
                $page = Posts::find(\Input::get('p-id'));
                $page->title = \Input::get('p-title');
                $page->slug = \Input::get('p-slug');
                $page->post = (\Input::has('p-content')) ? \Input::get('p-content'):null;
                $page->excerpt = (\Input::has('p-excerpt')) ? \Input::get('p-excerpt'):null;
                $page->feature_image = (\Input::has('f-image')) ? \Input::get('f-image'):null;
                $page->template = \Input::get('template');
                $page->status = \Input::get('status');
                $page->publish_date = (\Input::has('p-publish')) ? \Format::prepare_date(\Input::get('p-publish')):null;
                $page->save();
            }else{
                $page = Posts::create([
                    'title' => \Input::get('p-title'),
                    'slug' => \Input::get('p-slug'),
                    'post' => (\Input::has('p-content')) ? \Input::get('p-content'):null,
                    'excerpt' => (\Input::has('p-excerpt')) ? \Input::get('p-excerpt'):null,
                    'feature_image' => (\Input::has('f-image')) ? \Input::get('f-image'):null,
                    'type' => 'page',
                    'template' => \Input::get('template'),
                    'status' => \Input::get('status'),
                    'publish_date' => (\Input::has('p-publish')) ? \Format::prepare_date(\Input::get('p-publish')):null,
                    'creator' => \Session::get('logedin')
                ]);
            }
            return \Redirect::nccms('page');
        }
    }

    /**
     * Page Delete action handler
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id = false){
        if($id){
            Posts::where('type', '=', 'page')
                ->where('id', '=', $id)
                ->delete();
        }
        return \Redirect::nccms('page');
    }

}
