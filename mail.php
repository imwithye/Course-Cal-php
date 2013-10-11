<?php
    require_once 'libs/phpmailer/class.phpmailer.php';
    function report($body){
        $mail = new PHPMailer;
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup server
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'imwithye.report@gmail.com';                            // SMTP username
        $mail->Password = 'Tiamo.Jia';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

        $mail->From = 'from@example.com';
        $mail->FromName = 'Course Cal';
        $mail->addAddress('imwithye@gmail.com');
        $mail->addReplyTo('imwithye.report@gmail.com', 'Report');

        $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
        $mail->isHTML(TRUE);                                  // Set email format to HTML

        $mail->Subject = 'Course Cal Report';
        $mail->Body    = $body;
        $mail->send();
    }
?>