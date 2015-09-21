<?php

include_once 'psl-config.php';
include("PHPMailer/class.phpmailer.php");
date_default_timezone_set('America/Lima');

class Mail {

    function sendMail($Subject, $cuerpo, $correo,$MsgHTML) {
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = SMTP;
        $mail->SMTPSecure = SSL;
        $mail->Username = USERNAME;
        $mail->Password = PASSWORDSMTP;
        $mail->CharSet = "UTF-8";
        $mail->Port = PORT;
        $mail->From = FROM;
        $mail->FromName = FROMNAME;
        $mail->Subject = $Subject;
        $mail->WordWrap = WORDWRAP;
        $mail->IsHTML(true);
        $mail->MsgHTML($this->$MsgHTML($cuerpo, $Subject));
        $mail->AddReplyTo(FROM, FROMNAME);
        $mail->AddAddress($correo);
         if(AddBCC){
                $Cc = explode(",",AddBCC);
                foreach ($Cc as $value) {
                    $mail->AddBCC($value);
                }
            }
        
        if (!$mail->Send()) {
            echo "Error de envío de email: " . $mail->ErrorInfo;
            exit;
        } else {
            return;
        }
    }

    function bodyMail($cuerpo, $Subject) {

        $html = '<html>
                    <head>
                    <title>' . $Subject . '</title>
                    </head>
                    <body>
                    <u>' . $Subject . '</u> 
                    <br>&nbsp;';
        foreach ($cuerpo as $key => $value) {
            $html .= '<div>' . $value['nombre'] . ' : ' . $value['valor'] . '</div>';
        }
        $html .= ' </body>
                </html>';
        return $html;
    }

    function bodyMailTable($cuerpo, $Subject) {
        $html = '<!DOCTYPE html>
                <html>
                <head>
                <title>' . $Subject . '</title>
                </head>
                <body>
                <table style="width:700px;border: 1px solid black;border-collapse: collapse">
                  <tr style="border: 1px solid black;border-collapse: collapse">
                    <th style="width:30%">Campo</th>
                    <th style="width:70%">Descripción</th>		
                  </tr>';
        foreach ($cuerpo as $key => $value) {
            $html .= '<tr style="border: 1px solid black;border-collapse: collapse">
                <td style="width:30%;border: 1px solid black; border-collapse: collapse">' . $value['nombre'] . '</td> <td style="width:70%;border: 1px solid black; border-collapse: collapse"> ' . $value['valor'] . '</td></tr>';
        }
        $html .= ' </table>
                </body>
                </html>';
        return $html;
    }

}
