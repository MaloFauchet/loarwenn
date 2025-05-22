<?php
require_once $_SERVER['DOCUMENT_ROOT'] .'/../models/Tag.php';

class TagController {
    private $tagModel;

    public function __construct() {
        $this->tagModel = new Tag();
    }

    public function getAllTagByIdTagActivite($id_type_activite) {
        return $this->tagModel->getAllTagByIdTagActivite($id_type_activite);
    }
}
