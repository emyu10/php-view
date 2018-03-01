<?php
namespace emyu10\PhpView;

/**
 * This class renders php files as views.
 *
 * Normally, echoes out the whole file evaluating any variables passed. But it
 * will return the content of the file as a string if an optional $return
 * parameter is true.
 *
 * @version 1
 * @since 2018-03-01
 * @author Mohamed Usman <emyu10@gmail.com>
 */
class Renderer
{
    /**
     * The name of the file to be rendered, without the extension.
     * @var string
     */
    private $file;

    /**
     * The absolute path to the file without the file name.
     * @var string
     */
    private $path;

    /**
     * An (optional) associative array of data to be passed to the file to be evaluated.
     * Index names becomes variables in the file.
     * @var array|null
     */
    private $data;

    /**
     * An optional variable to check if the view should be echoed out or returned
     * as a string. Default echoes out.
     * @var bool
     */
    private $return = false;

    /**
     * Sets the absolute path to the view file without the file name.
     *
     * @param string $path the path
     * @return void
     */
    public function setPath($path){
        $this->path = $path;
    }

    /**
     * Sets the file name without the file extension. File extension is assumed
     * .php
     *
     * @param string $file the name of the file
     * @return void
     */
    public function setFile($file){
        $this->file = $file;
    }

    public function setData(array $data = null){
        $this->data = $data;
    }

    public function setReturn($return){
        $this->return = $return;
    }
}
