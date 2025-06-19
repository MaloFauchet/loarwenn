<?php
require $_SERVER['DOCUMENT_ROOT']. '/vendor/autoload.php';

use OTPHP\TOTP;
use Psr\Clock\ClockInterface;

class MyClock implements ClockInterface
{
    public function now(): \DateTimeImmutable
    {
        return new \DateTimeImmutable();
    }
}

class OTP
{
    private $conn;
    private $otp;
    private $secret;
    private $mail;

    public function __construct($mail = "") {
        $this->mail = $mail;
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function genererOTP() {
        $clock = new MyClock();
        $this->otp = TOTP::generate($clock);
        $this->otp->setLabel('PACT - ' . $this->mail);
        $this->secret = $this->otp->getSecret();

        return $this->otp;
    }

    public function verifierOTP($inputCode, $secret) {
        if (!$secret) return false;

        $otp = TOTP::createFromSecret($secret);
        return $otp->verify($inputCode, null, 1);
    }

    public function insertSecret($id_pro, $secret) {
        if (empty($id_pro)) {
            throw new InvalidArgumentException('id professionnel vide.');
        }

        if ($secret === null) {
            throw new RuntimeException('Aucun secret généré pour cet OTP.');
        }

        $sql = "
            UPDATE tripenazor.professionnel
            SET code_secret = :code_secret
            WHERE id_utilisateur = :id_utilisateur
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':code_secret', $secret);
        $stmt->bindParam(':id_utilisateur', $id_pro);

        return $stmt->execute();
    }

    public function getSecret($id_pro = null) {
        if ($id_pro === null) {
            return $this->secret;
        }

        $sql = "
            SELECT code_secret FROM tripenazor.professionnel
            WHERE id_utilisateur = :id_utilisateur
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_utilisateur', $id_pro);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['code_secret'] ?? null;
    }

    public function getOTP() {
        if ($this->otp === null) {
            throw new RuntimeException('Aucun OTP généré.');
        }
        return $this->otp;
    }

    public function getQRCode() {
        if ($this->otp === null) {
            throw new RuntimeException('Aucun OTP généré.');
        }

        return $this->otp->getQrCodeUri(
            'https://api.qrserver.com/v1/create-qr-code/?data=[DATA]&size=300x300&ecc=M',
            '[DATA]'
        );
    }

    public function secretGenere($id_pro) {
        $secret = $this->getSecret($id_pro);
        return !empty($secret);
    }
}