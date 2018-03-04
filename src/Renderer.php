<?php
namespace emyu10\PhpView;

use emyu10\PhpView\FileNotFoundException;

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
     * Initializes all the properties in a single call and then renders the view
     * file by evaluating variables and expressions.
     *
     * If the $return property is true, the method returns the file as a string.
     * Throws \emyu10\PhpView\FileNotFoundException if the view file is not found.
     *
     * @param string $path the path
     * @param string $file the name of the file
     * @param array|null $data the data to be passed
     * @param bool $return
     * @throws \emyu10\PhpView\FileNotFoundException
     * @return string|void
     */
    public static function staticRender($path, $file, array $data = null, $return = false)
    {
        $instance = new self();
        $instance->initialize($path, $file, $data, $return);
        return $instance->render();
    }

    /**
     * Initialize all the properties in a single call.
     *
     * Use this method to set all the properties in a single call instead of
     * setPath(), setFile(), setData(), setReturn() methods individually.
     *
     * @param string $path the path
     * @param string $file the name of the file
     * @param array|null $data the data to be passed
     * @param bool $return
     * @return void
     */
    public function initialize($path, $file, array $data = null, $return = false)
    {
        $this->setPath($path);
        $this->setFile($file);
        $this->setData($data);
        $this->setReturn($return);
    }

    /**
     * Sets the absolute path to the view file without the file name.
     *
     * @param string $path the path
     * @return void
     */
    public function setPath($path)
    {
        $this->path = rtrim($path, '/') . '/';
    }

    /**
     * Sets the file name without the file extension. File extension is assumed
     * .php
     *
     * @param string $file the name of the file
     * @return void
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * Sets any data that need to be passed as an associative array.
     *
     * The keys become actual variables in the view file.
     *
     * @param array|null $data the data to be passed
     * @return void
     */
    public function setData(array $data = null)
    {
        $this->data = $data;
    }

    /**
     * Sets whether to echo out the file or to return the contents of the file
     * as a string. Default is to echo the file to the output stream.
     *
     * @param bool $return
     * @return void
     */
    public function setReturn($return)
    {
        $this->return = $return;
    }

    /**
     * Renders the view file by evaluating variables and expressions. If the
     * $return property is true, the method returns the file as a string.
     *
     * Throws \emyu10\PhpView\FileNotFoundException if the view file is not found.
     *
     * @throws \emyu10\PhpView\FileNotFoundException
     * @return string|void
     */
    public function render()
    {
        if ($this->data != null && is_array($this->data)) {
            extract($this->data);
        }

        $pathInfo = pathinfo($this->file);
        $ext = $pathInfo['extension'];

        if ($ext == 'php') {
            $file = $this->path . $this->file;
        } else {
            $file = $this->path . $this->file . '.php';
        }

        $contents = null;

        if (file_exists($file)) {
            if ($this->return) {
                ob_start();
                include($file);
                $contents = ob_get_contents();
                ob_end_clean();
                return $contents;
            } else {
                include($file);
            }
        } else {
            throw new FileNotFoundException($file);
        }
    }
}
