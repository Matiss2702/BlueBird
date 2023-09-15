<?php

namespace App\Models;

use App\Core\Model;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require __DIR__ . '/../../public/vendor/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../../public/vendor/PHPMailer/src/Exception.php';
require __DIR__ . '/../../public/vendor/PHPMailer/src/SMTP.php';

class ForgotPassword extends Model
{
    protected static $table = DB_PREFIX . 'forgot_password' ;
    protected static $fillable = ['id_user', 'token', 'created_at', 'send_at', 'completed_at'];

    protected $id;
    protected $id_user;
    protected $token;
    protected $created_at;
    protected $send_at;
    protected $completed_at;

    public function getId()
    {
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

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function getSendAt()
    {
        return $this->send_at;
    }

    public function setSendAt($send_at)
    {
        $this->send_at = $send_at;
    }

    public function getCompletedAt()
    {
        return $this->completed_at;
    }

    public function setCompletedAt($completed_at)
    {
        $this->completed_at = $completed_at;
    }

    public static function createToken($id_user, $token = null)
    {
        if (!$token) {
            $token = uniqid();
        }

        $FP = new static();
        $FP->setIdUser($id_user);
        $FP->setToken($token);
        $FP->setCreatedAt(date("Y-m-d H:i:s"));

        if ($FP->create()) {
            $FP->id = $FP->getPDO()->lastInsertId();
        }

        return $FP;
    }

    public static function sendRecoveryPassword(User $user)
    {

        if (!$user) {
            return;
        }

        $SRP = self::createToken($user->getId());

        $token = $SRP->getToken();
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
            $mail->Subject = 'Mot de passe oublié';
            $mail->Body = self::getRandomBody($user->getFirstname(), $token);

            // Envoie le mail
            if ($mail->send()) {
                $SRP->setSendAt(date('Y-m-d H:i:s.u'));
                $SRP->update();
                return $SRP;
            }
        } catch (Exception $e) {
            if (APP_DEBUG) {
                echo "Une erreur s'est produite lors de l'envoi du courriel : {$mail->ErrorInfo}";
                exit();
            }

            return null;
        }
    }

    public static function getRandomBody(string $firstname, string $token): string
    {
        $baseUrl = getBaseUrl();
        $randomBodies = [
            "<div style='background-color: #f4f4f4; padding: 20px;'>
                <h2 style='color: #333; font-size: 24px; margin-bottom: 20px;'>Bonjour {$firstname},</h2>
                <p style='color: #555; font-size: 16px;'>Vous avez fait une demande récupération de mot de passe ?</p>
                <p style='margin-top: 20px;'>
                    <a href='$baseUrl/forgot-password/$token' style='display: inline-block; background-color: #007bff; color: #fff; text-decoration: none; padding: 10px 20px; border-radius: 5px;'>Modifier mon mot de passe</a>
                </p>
                <p style='margin-top: 30px;'>
                    Si vous n'avez pas fait la demande de récupération de mot passe, ignorez cet email.
                </p>
            </div>",

            "<div style='background-color: #f4f4f4; padding: 20px;'>
                <h2 style='color: #333; font-size: 24px; margin-bottom: 20px;'>Cher {$firstname},</h2>
                <p style='color: #555; font-size: 16px;'>Vous venez de faire une demande récupération de mot de passe</p>
                <p style='margin-top: 20px;'>
                    Si tel est le cas, <a href='$baseUrl/forgot-password/$token' style='display: inline-block; background-color: #007bff; color: #fff; text-decoration: none; padding: 10px 20px; border-radius: 5px;'>Cliquez ici pour modifier votre mot de passe</a>
                </p>
                <p style='margin-top: 30px;'>
                    Si vous n'avez pas fait la demande de récupération de mot passe, ignorez cet email.
                </p>
            </div>",

            "<div style='background-color: #f4f4f4; padding: 20px;'>
                <h2 style='color: #333; font-size: 24px; margin-bottom: 20px;'>Demande de récupération de mot de passe</h2>
                <p style='color: #555; font-size: 16px;'>Bonjour {$firstname}, Il semblerait que vous avez fait la demande de récupération de mot de passe...</p>
                <p style='margin-top: 20px;'>
                    <a href='$baseUrl/forgot-password/$token' style='display: inline-block; background-color: #007bff; color: #fff; text-decoration: none; padding: 10px 20px; border-radius: 5px;'>Cliquez ici pour récupérer votre mot de passe</a>
                </p>
                <p style='margin-top: 30px;'>
                    Si vous n'avez pas fait la demande de récupération de mot passe, ignorez cet email.
                </p>
            </div>"
        ];

        $randomBody = $randomBodies[array_rand($randomBodies)];

        return $randomBody;
    }

    public function isCompletedAt()
    {
        return !is_null($this->getCompletedAt());
    }
}