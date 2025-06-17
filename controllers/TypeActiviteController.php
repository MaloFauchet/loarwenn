<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/TypeActivite.php');

class TypeActiviteController {
    private $typeActiviteModel;

    public function __construct() {
        $this->typeActiviteModel = new TypeActivite();
    }

    public function getAllTypeActivite() {
        return $this->typeActiviteModel->getAllActivite();
    }

    public function getTagIdByTypeActivite($id_activite,$name_activite) {
        $typeActiviteModel = new TypeACtivite();
        return $typeActiviteModel->getTagIdByTypeActivite($id_activite,$name_activite);
    }
}