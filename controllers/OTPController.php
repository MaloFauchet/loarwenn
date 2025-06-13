<?php
require_once $_SERVER['DOCUMENT_ROOT'] .'/../models/OTP.php';

class OTPController
{
    private $otp;

    // Constructeur privé
    public function __construct($mail = "") {
        $this->otp = new OTP($mail);
    }

    // Méthodes publiques
    public function genererOTP($label)
    {
        return $this->otp->genererOTP($label);
    }

    public function verifierOTP($input, $secret)
    {
        return $this->otp->verifierOTP($input, $secret);
    }

    public function insertSecret($id_pro, $secret)
    {
        return $this->otp->insertSecret($id_pro, $secret);
    }

    public function getSecret($id_pro)
    {
        return $this->otp->getSecret($id_pro);
    }

    public function getOTP()
    {
        return $this->otp->getOTP();
    }

    public function getQRCode()
    {
        return $this->otp->getQRCode();
    }

    public function secretGenere($id_pro)
    {
        return $this->otp->secretGenere($id_pro);
    }
}
