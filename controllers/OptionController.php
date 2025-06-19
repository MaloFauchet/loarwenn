<?php
require_once $_SERVER['DOCUMENT_ROOT'] .'/../models/Option.php';

class OptionController {
    private $optionModel;

    public function __construct() {
        $this->optionModel = new Option();
    }

    public function getOption() {
        return $this->optionModel->getOption();
    }
}