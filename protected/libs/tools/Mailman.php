<?php

require_once LIBRARY_PATH . 'PHPMailer_v5.1/class.phpmailer.php';


class Mailman
{
    public static function sendMail($email_to, $subject, $body, $from_name, $from_email, $host, $port, $login, $password, $encoding, $hidden_copy = false)
    {   
        $enc = "UTF-8";
    
        $subject = iconv($enc, "{$encoding}//IGNORE", $subject);

        $from_name  = iconv($enc, "{$encoding}//IGNORE", $from_name);
        $from_email = iconv($enc, "{$encoding}//IGNORE", $from_email);

        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        $mail->CharSet       = $encoding;
        $mail->SMTPDebug     = 1;
        $mail->Host          = $host;
        $mail->SMTPAuth      = true;
        $mail->SMTPKeepAlive = true;
        $mail->Port          = 25;
        $mail->Username      = $login;
        $mail->Password      = $password;
        
        try
        {
            $mail->AddReplyTo($from_email, $from_name);

            $add_address_method = $hidden_copy ? 'AddBCC' : 'AddAddress';

            if (is_array($email_to))
            {
                foreach ($email_to as $ind => $email)
                {
                    $mail->$add_address_method($email, $email);
                }
            } 
            else
            {
                $mail->$add_address_method($email_to, $email_to);
            }

            $mail->SetFrom($from_email, $from_name);
            $mail->Subject = "=?koi8-r?B?".base64_encode($subject)."?=";
            $mail->MsgHTML(iconv($enc,"{$encoding}//IGNORE", $body));
            $mail->Send();

            return true;
        } 
        catch (phpmailerException $e)
        {
            echo $e->errorMessage();
            $mail->SmtpClose();
            $mail->SmtpConnect();
        } 
        catch (Exception $e)
        {
            echo $e->getMessage();
        }

        $mail->ClearAttachments();
        $mail->ClearBCCs();
        $mail->ClearAddresses();
    }
}





