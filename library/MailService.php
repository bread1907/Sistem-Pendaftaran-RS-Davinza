<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../PHPMAILER/Exception.php';
require __DIR__ . '/../PHPMAILER/PHPMailer.php';
require __DIR__ . '/../PHPMAILER/SMTP.php';

class MailService {

    public function kirimKodeVerifikasi(string $email, string $kode): bool {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'dindxsalsa@gmail.com';
            $mail->Password   = 'lhpoeeoetfexpauq';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // 👇 DEBUG DI SINI
            // $mail->SMTPDebug = 2;
            // $mail->Debugoutput = 'html';

            $mail->CharSet    = 'UTF-8';
            $mail->setFrom('dindxsalsa@gmail.com', 'Davinza Hospital');
            $mail->isHTML(true);

            // DEBUG sementara
            // $mail->SMTPDebug = 2;

            $mail->addAddress($email);
            $mail->Subject = 'Kode Verifikasi Akun Davinza Hospital';
            $mail->Body    = "
                <p>Halo,</p>
                <p>Berikut kode verifikasi akun Anda:</p>
                <h2>$kode</h2>
                <p>Berlaku 10 menit.</p>
            ";

            return $mail->send();

        } catch (Exception $e) {
            $_SESSION['error'] = "Mailer error: " . $mail->ErrorInfo;
            return false;
        }
    }
}

