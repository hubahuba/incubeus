<?php namespace Ngungut\Nccms;
use Ngungut\Nccms\Facades\Common;

/**
 * Partial manager
 *
 * @package ngungut\nccms
 * @author Alexey Bobkov, Samuel Georges
 */
class ThemesManager
{
    /**
     * Partial Path Variable
     * @var string
     */
    protected $path;
    protected $app;

    /**
     * Text Return From Partial Manager
     * @var string
     */
    protected $themes;

    /**
     * Contruct Partial Manager
     */
    public function __construct(){
        $this->app = \App::make('app');
        $this->path = base_path() . '/nccms/themes';
    }

    public function getThemes(){
        $this->themes = [];
        foreach($this->loadThemes() as $class => $path){
            $themeClassName = $class.'\Theme';
            $themeClassName = $this->normalizeClassName($themeClassName);

            if (!class_exists($themeClassName)) {
                include_once $path.'/Theme.php';
            }

            if (!class_exists($themeClassName)) {
                continue;
            }

            $classObj = new $themeClassName($this->app);
            $classID = $class;
            $this->themes[$classID] = $classObj;
        }
        return $this->themes;
    }

    public function loadThemes(){
        $themes = [];
        $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->path));
        $it->setMaxDepth(1);
        $it->rewind();
        while ($it->valid()) {
            if (($it->getDepth() > 0) && $it->isFile() && (strtolower($it->getFilename()) == "theme.php")) {
                $filePath = dirname($it->getPathname());
                $themeName = basename($filePath);
                $themes[$themeName] = $filePath;
            }

            $it->next();
        }
        return $themes;
    }

    public function normalizeClassName($name)
    {
        if (is_object($name))
            $name = get_class($name);

        $name = '\\Themes\\'.ltrim($name, '\\');
        return $name;
    }
}
