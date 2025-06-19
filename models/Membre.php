<?php
    class Membre extends Utilisateur {
        private $pseudo;

        public function __construct() {
            parent::__construct();
        }

        /**
         * Setter
         */
        public function setPseudo($pseudo) {
            $this->pseudo = $pseudo;
        }

        /**
         * Getter
         */
        public function getPseudo() {
            return $this->pseudo;
        }
    }
?>