<?php
/**
 * PHPMailer exception handler.
 *
 * @date May 18 2015
 */
namespace lib\helper\PhpMailer;

/**
 * Exceptions for PHPMailer.
 */
class Exception extends \Exception
{
    /**
     * Prettify error message output.
     *
     * @return string
     */
    public function errorMessage()
    {
        //TODO:$this->getMessage() send to sysadmins
    }
}
