<?php namespace Ngungut\Nccms\Controller;

use BaseController;
use Ngungut\Nccms\Model\Media;
use Ngungut\Nccms\Libraries\UploadHandler;

/**
 * Class CkeditorController
 * Contain Media Libraries, Upload, Handler For CKEditor Browse Server Dialog
 */
class CkeditorController extends BaseController {
    /**
     * set default layout
     * @var string
     */
    protected $layout = 'nccms::layouts.ckeditor';

    /**
     * Media Upload
     */
	public function upload()
	{
        $title = 'Media Upload';
        $this->layout->title = $title . ' - NCCMS';
        $this->layout->with('script', 'nccms::admin.ckeditor.scripts.upload')
            ->with('style', 'nccms::admin.ckeditor.styles.upload');
        $this->layout->content = \View::make('nccms::admin.ckeditor.upload')
            ->with('script', 'nccms::admin.ckeditor.scripts.upload')
            ->with('style', 'nccms::admin.ckeditor.styles.upload')
            ->with('title', $title);
	}

    /**
     * Upload action handler
     * upload/resize image
     * @return json
     */
    public function doUpload(){
        $upload_handler = new UploadHandler();
        exit;
    }

    public function libraries(){
        $title = 'Multimedia Libraries';
        $this->layout->title = $title . ' - NCCMS';
        $this->layout->with('script', 'nccms::admin.ckeditor.scripts.libraries')
            ->with('style', 'nccms::admin.ckeditor.styles.libraries');
        $this->layout->content = \View::make('nccms::admin.ckeditor.libraries')
            ->with('script', 'nccms::admin.ckeditor.scripts.libraries')
            ->with('style', 'nccms::admin.ckeditor.styles.libraries')
            ->with('libraries', Media::getMultimedia())
            ->with('title', $title);
    }

    public function image(){
        if(\Input::has('CKEditorFuncNum')) \Session::put('FuncNum', \Input::get('CKEditorFuncNum'));
        $title = 'Image Media Libraries';
        $this->layout->title = $title . ' - NCCMS';
        $this->layout->with('script', 'nccms::admin.ckeditor.scripts.libraries')
            ->with('style', 'nccms::admin.ckeditor.styles.libraries');
        $this->layout->content = \View::make('nccms::admin.ckeditor.libraries')
            ->with('script', 'nccms::admin.ckeditor.scripts.libraries')
            ->with('style', 'nccms::admin.ckeditor.styles.libraries')
            ->with('libraries', Media::getImage())
            ->with('title', $title);
    }

}
