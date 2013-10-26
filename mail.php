<?php
    require_once 'libs/phpmailer/class.phpmailer.php';
    function report($body){
        $mail = new PHPMailer;
        $mail->isSMTP();
        //$mail->Host = 'smtp.example.com';                     // Specify main and backup server
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        //$mail->Username = 'login@example.com';                  // SMTP username
        //$mail->Password = 'password';                         // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

        $mail->FromName = 'Course Cal';
        //$mail->addAddress('report_to@example.com');
        $mail->addCC('imwithye@gmail.com');

        $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
        $mail->isHTML(TRUE);                                  // Set email format to HTML

        $mail->Subject = 'Course Cal Report';
        $mail->Body    = $body;
        return $mail->send();
    }
?>