<?php namespace Ngungut\Nccms\Controller;

use BaseController;
use Ngungut\Nccms\Model\Media;
use Ngungut\Nccms\Libraries\UploadHandler;

/**
 * Class CkeditorController
 * Contain Media Libraries, Upload, Handler For CKEditor Browse Server Dialog
 */
class FimageController extends BaseController {
    /**
     * set default layout
     * @var string
     */
    protected $layout = 'nccms::layouts.feature-image';

    /**
     * Media Upload
     */
	public function upload()
	{
        $title = 'Media Upload';
        $this->layout->title = $title . ' - NCCMS';
        $this->layout->with('script', 'nccms::admin.feature-image.scripts.upload')
            ->with('style', 'nccms::admin.feature-image.styles.upload');
        $this->layout->content = \View::make('nccms::admin.feature-image.upload')
            ->with('script', 'nccms::admin.feature-image.scripts.upload')
            ->with('style', 'nccms::admin.feature-image.styles.upload')
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

    public function image(){
        $title = 'Image Media Libraries';
        $this->layout->title = $title . ' - NCCMS';
        $this->layout->with('script', 'nccms::admin.feature-image.scripts.libraries')
            ->with('style', 'nccms::admin.feature-image.styles.libraries');
        $this->layout->content = \View::make('nccms::admin.feature-image.libraries')
            ->with('script', 'nccms::admin.feature-image.scripts.libraries')
            ->with('style', 'nccms::admin.feature-image.styles.libraries')
            ->with('libraries', Media::getImage())
            ->with('title', $title);
    }

}
