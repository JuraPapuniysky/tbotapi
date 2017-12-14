<?php
/**
 * Created by PhpStorm.
 * User: wsst17
 * Date: 14.12.17
 * Time: 9:31
 */

namespace common\models;


class Error
{
    public $code;
    public $message;
    public $data;

    public function __construct($code = 0, $message, $data = null)
    {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
    }
}