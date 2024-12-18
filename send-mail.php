<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "vendor/autoload.php";

    $email_vars = array(
        'first_name' => (!empty($_POST['first_name'])) ? $_POST['first_name'] : 'NA',
        'last_name' => (!empty($_POST['last_name'])) ? $_POST['last_name'] : 'NA',
        'email' => (!empty($_POST['email'])) ? $_POST['email'] : 'na',
        'phone' => (!empty($_POST['phone'])) ? $_POST['phone'] : 'NA',
        'msg' => (!empty($_POST['msg'])) ? $_POST['msg'] : 'NA'
    );

    $admin_email = file_get_contents('admin-email.html');
    if(isset($email_vars)){
        foreach($email_vars as $k=>$v){
            $admin_email = str_replace('{'.$k.'}', $v, $admin_email);
        }
    }


    if((!empty($_POST['email']))){
        $name = $_POST['first_name'].' '.$_POST['last_name'];
        $email = $_POST['email'];

        $autoresponse_email = file_get_contents('autoresponse-email.html');
        # Autoresponse email
        try{
            //PHPMailer Object
            $mail = new PHPMailer(true);

            //From email address and name
            $mail->From = "noreplay@daskhaman.com";
            $mail->FromName = "Das Khmana";

            //To address and name
            $mail->addAddress($email, $name);
            #$mail->addAddress("recepient1@example.com"); //Recipient name is optional

            //Address to which recipient will reply
            #$mail->addReplyTo("reply@yourdomain.com", "Reply");

            //CC and BCC
            #$mail->addCC("cc@example.com");
            #$mail->addBCC("bcc@example.com");

            //Send HTML or Plain Text email
            $mail->isHTML(true);

            $mail->Subject = "Thank you for submitting inquiry";
            $mail->Body = $autoresponse_email;
            #$mail->AltBody = "This is the plain text version of the email content";

            $mail->send();
           # echo 'Message has been sent';

        } catch (Exception $e){
            #echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    }

    # admin email
    try{
        //PHPMailer Object
        $mail = new PHPMailer(true);

        //From email address and name
        $mail->From = "noreplay@daskhaman.com";
        $mail->FromName = "Das Khmana";

        //To address and name
        $mail->addAddress("kunal1203@gmail.com", "Kunal");
        #$mail->addAddress("recepient1@example.com"); //Recipient name is optional

        //Address to which recipient will reply
        #$mail->addReplyTo("reply@yourdomain.com", "Reply");

        //CC and BCC
        #$mail->addCC("cc@example.com");
        #$mail->addBCC("bcc@example.com");

        //Send HTML or Plain Text email
        $mail->isHTML(true);

        $mail->Subject = "New Inquiry received from contact us from";
        $mail->Body = $admin_email;
        #$mail->AltBody = "This is the plain text version of the email content";

        $mail->send();
        #echo 'Message has been sent';

    } catch (Exception $e){
        #echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
    header('Location: thank-you.html');
    exit;
