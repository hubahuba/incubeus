<?php namespace Themes\Waldo;

use Ngungut\Nccms\ThemeCore;

class Theme extends ThemeCore {

    public function themeDetails()
    {
        return [
            'name' => 'Waldo',
            'description' => 'NCCMS Default Theme.',
            'author' => '@bravocado',
            'author_url' => 'https://twitter.com/bravocado'
        ];
    }
}