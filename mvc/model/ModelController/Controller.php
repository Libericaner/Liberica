<?php
/**
 * User: joel-haeberli
 * Date: 11.11.17
 * Time: 14:23
 */

abstract class Controller
{
    protected $executor;

    public function __construct($executor) {
        $this->executor = $executor;
    }
}