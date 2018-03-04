<?php
namespace emyu10\PhpView;

/**
 * FileNotFoundException class
 *
 * throw this exception if a view file is not found.
 * this class extends \Exception class
 *
 * @since 2018-03-01
 * @author Mohamed Usman <emyu10@gmail.com>
 */
class FileNotFoundException extends \Exception
{
	/**
	 * Constructor.
	 *
	 * extends \Exception
	 *
	 * @param string $file name of the file.
	 */
	public function __construct($file)
    {
		$message = "{$file} is not found.";
		parent::__construct($message);
	}
}
