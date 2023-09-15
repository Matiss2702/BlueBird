<?php

namespace App\Models;

use App\Core\Model;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require __DIR__ . '/../../public/vendor/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../../public/vendor/PHPMailer/src/Exception.php';
require __DIR__ . '/../../public/vendor/PHPMailer/src/SMTP.php';

class EmailActivationToken extends Model
{
    protected static $table = DB_PREFIX . 'email_activation_token';
    protected static $fillable = ['id_user', 'token', 'verified_at', 'sent_at'];

    protected $id;

    protected $id_user;
    protected $token;
    protected $verified_at;
    protected $sent_at;

    public function getId() {
        return $this->id;
    }

    public function getIdUser()
    {
        return $this->id_user;
    }

    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    public function getVerifiedAt()
    {
        return $this->verified_at;
    }

    public function setVerifiedAt($verified_at)
    {
        $this->verified_at = $verified_at;
    }

    public function getsentAt()
    {
        return $this->sent_at;
    }

    public function setSentAt($sent_at)
    {
        $this->sent_at = $sent_at;
    }

    public static function createToken($id_user, $token = null)
    {
        if (!$token) {
            $token = uniqid();
        }

        $EmailActivationToken = new static();
        $EmailActivationToken->setIdUser($id_user);
        $EmailActivationToken->setToken($token);
        if ($EmailActivationToken->create()) {
            $EmailActivationToken->id = $EmailActivationToken->getPDO()->lastInsertId();
        }

        return $EmailActivationToken;
    }

    public static function sendActivationEmail(User $user)
    {
        if (!$user) {
            return;
        }

        $EAT = self::where('id_user', $user->getId());
        if ($EAT) { // Un premier mail à déjà été envoyé
            $EAT->setToken(uniqid());
        } else {
            $EAT = self::createToken($user->getId());
        }

        $token = $EAT->getToken();
        $baseUrl = getBaseUrl();

        $mail = new PHPMailer(true); // Ajoutez le paramètre true pour activer les exceptions

        try {
            //Server settings
            $mail->SMTPDebug = APP_DEBUG ? SMTP::DEBUG_SERVER : SMTP::DEBUG_OFF; // Configure le mode de débogage en fonction de APP_DEBUG
            $mail->isSMTP();                                                     // Utilise le protocole SMTP
            $mail->Host       = PHPMAILER_HOST;                                  // Définit le serveur SMTP
            $mail->SMTPAuth   = true;                                            // Active l'authentification SMTP
            $mail->Username   = EMAIL_NO_REPLY;                                  // Nom d'utilisateur SMTP
            $mail->Password   = PHPMAILER_PASSWORD;                              // Mot de passe SMTP
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;                  // Active le chiffrement SSL/TLS
            $mail->Port       = PHPMAILER_PORT;                                  // Port TCP à utiliser

            //Recipients
            $mail->CharSet = 'UTF-8';
            $mail->setFrom(EMAIL_NO_REPLY, 'Équipe de support');
            $recipientMail = APP_DEBUG ? EMAIL_DEV : $user->getEmail();
            $mail->addAddress($recipientMail, $user->getFirstname()); // Ajoute un destinataire

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Activation de votre compte';
            $mail->Body = self::getRandomBody($user->getFirstname(), $token);

            // Envoie le mail
            if ($mail->send()) {
                $EAT->setSentAt(date('Y-m-d H:i:s.u'));
                $EAT->update();
                return $EAT;
            }
        } catch (Exception $e) {
            if (APP_DEBUG) {
                echo "Une erreur s'est produite lors de l'envoi du courriel : {$mail->ErrorInfo}";
                exit();
            }

            return null;
        }
    }

    // TODO : dynamiser les différents mails
    public static function getRandomBody(string $firstname, string $token): string
    {
        $baseUrl = getBaseUrl();
        $randomBodies = [
            "<div style='background-color: #f4f4f4; padding: 20px;'>
                <h2 style='color: #333; font-size: 24px; margin-bottom: 20px;'>Bonjour {$firstname},</h2>
                <p style='color: #555; font-size: 16px;'>Veuillez cliquer sur le lien ci-dessous pour activer votre compte :</p>
                <p style='margin-top: 20px;'>
                    <a href='$baseUrl/activate-account/$token' style='display: inline-block; background-color: #007bff; color: #fff; text-decoration: none; padding: 10px 20px; border-radius: 5px;'>Activer mon compte</a>
                </p>
            </div>",

            "<div style='background-color: #f4f4f4; padding: 20px;'>
                <h2 style='color: #333; font-size: 24px; margin-bottom: 20px;'>Cher {$firstname},</h2>
                <p style='color: #555; font-size: 16px;'>Merci de cliquer sur le lien suivant pour activer votre compte :</p>
                <p style='margin-top: 20px;'>
                    <a href='$baseUrl/activate-account/$token' style='display: inline-block; background-color: #007bff; color: #fff; text-decoration: none; padding: 10px 20px; border-radius: 5px;'>Cliquez ici</a>
                </p>
            </div>",

            "<div style='background-color: #f4f4f4; padding: 20px;'>
                <h2 style='color: #333; font-size: 24px; margin-bottom: 20px;'>Bienvenue {$firstname},</h2>
                <p style='color: #555; font-size: 16px;'>Nous vous prions de bien vouloir activer votre compte en cliquant sur le lien ci-dessous :</p>
                <p style='margin-top: 20px;'>
                    <a href='$baseUrl/activate-account/$token' style='display: inline-block; background-color: #007bff; color: #fff; text-decoration: none; padding: 10px 20px; border-radius: 5px;'>Cliquez ici</a>
                </p>
            </div>"
        ];

        $randomBody = $randomBodies[array_rand($randomBodies)];

        return $randomBody;
    }

    public static function verifyTokenSetup(User $user)
    {
        if (!$user) {
            return;
        }

        $EAT = self::where('id_user', $user->getId());
        if($EAT){
            $EAT->setVerifiedAt(date('Y-m-d H:i:s'));
        }
    }

    public function isVerified()
    {
        return !is_null($this->getVerifiedAt());
    }
}
