<?php
require_once('../config.php');

$result = $mysqli->query("SELECT * FROM employee WHERE `status` = '1' ORDER BY `fname` ASC");
// $result1 = $mysqli->query("SELECT * FROM mail_content WHERE `slug` = 'birthday_mail'");
$data = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['date_of_birth']) {
            $dob = date('d-m', strtotime($row['date_of_birth']));
            if ($dob == date('d-m')) {
               if ($row['personal_email']) {
                    $data['mail_type'] = 'birthday_mail';
                    $data['base_url'] = $base_url;
                    $data['subject'] = 'A special wishes for your birthday';
                    $data['name'] = $row['fname'] . ' ' . $row['lname'];
                    $data['message'] = get_content($mysqli,'birthday_mail');
                    $data['to'] = $row['personal_email'];
                    if (bob_mail_send($mail, $data)) {
                        echo "Birthday Wishes Send SuccessFully.";
                    }
                } else {
                    echo "Employee Personal Mail Not Found.";
                }
            }
        } else {
            echo "Date Of Birth Not Found.";
        }
    }
} else {
    echo "Employee Not Found.";
}

function get_content($mysqli,$slug){
    $result = $mysqli->query("SELECT * FROM mail_content WHERE `slug` = '".$slug."'");
    while ($row = $result->fetch_assoc()) {
        return $row['content'];
    }
}
function bob_mail_send($mail, $data)
{
    $mail->IsSMTP();
    $mail->CharSet   = "UTF-8";
    $mail->ContentType   = "text/html";
    $mail->SMTPDebug  = 0;
    $mail->SMTPAuth   = TRUE;
    $mail->SMTPSecure = "tls";
    $mail->Port       = 587;
    $mail->Host       = "smtp.gmail.com";
    $mail->Username   = "sagargeek435@gmail.com";
    $mail->Password   = "ellzdagkbhlxydxf";
    $form = 'sagargeek435@gmail.com';
    $to = $data['to'];
    $subject = $data['subject'];
    // $message = $data['message'];
    $name = $data['name'];
    $mail_type = $data['mail_type'];

    $msg = '';
    if ($mail_type == 'birthday_mail') {
        $msg .= birthday_mail_html($data);
    }

    $mail->isHTML(true);
    // $mail->setFrom($form,'Sagar S Rathod');
    $mail->From = $form;
    $mail->FromName = 'DecodeX Infotch';
    $mail->addAddress($to, $name);
    $mail->Sender = $to;
    $mail->Subject = $subject;
    $mail->Body = $msg;

    return $mail->Send();
}

function birthday_mail_html($data = array())
{
    $msg = '<html lang="en" style="">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>' . $data['subject'] . '</title>
            <style>
                body {
                    background-color: #000000;
                }
            </style>
            <link rel="preconnect" href="https://fonts.gstatic.com">
            <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@1,400;1,600;1,700&amp;family=Merriweather:ital,wght@1,400;1,700&amp;display=swap" rel="stylesheet">
        </head>
        <body style="font-family: &quot;Segoe UI&quot;, Tahoma, Geneva, Verdana, sans-serif; margin: 0px;">
            <div class="mail-sec">
                <table style="max-width:600px;width:100%;margin:0 auto;padding: 25px;background-color: #6ab8de;background-image: url(' . $data['base_url'] . 'assets/images/pattern.png);background-size: 100% auto;background-repeat: repeat-y;" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr>
                            <td>
                                <table cellspacing="0" cellpadding="0" style="background-color: #ffffff; padding: 20px; border-radius: 8px;">
                                    <tbody>
                                        <tr>
                                            <td style="text-align: center">
                                                <a href="#" style="width: 80%; max-width: 230px; display: block; margin: 0 auto;">
                                                    <img src="' . $data['base_url'] . 'assets/images/geekwebsoloution.png" alt="DecodeX Infotch" style="width: 100%; height: auto;">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table cellspacing="0" cellpadding="0" style="width:100%;">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <table cellpadding="0" cellspacing="0" style="width: 100%;margin: 0 auto;padding-top:30px;text-align: center;">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="padding-bottom:15px;">
                                                                                <img src="' . $data['base_url'] . 'assets/images/balloon.png" alt="Happy Birthday" style="width:60%;max-width: 220px;height:auto;">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <h1 style="font-family: `Lora`, serif;">Happy Birthday</h1>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-size: 18px; font-family: `Lora`, serif;">
                                                                                <strong>Dear <span>' . $data['name'] . '</span></strong>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td cellspacing="0" cellpadding="0" style="padding: 15px 0;">
                                                                                <table style="width: 40%; margin: 0 auto;">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td style="height: 1px; background-color: #000000;">
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-family: `Merriweather`, serif;">
                                                                                <strong>
                                                                                    We Wish You a Many Many Happy Returns Of The Day.
                                                                                </strong>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td cellspacing="0" cellpadding="0" style="padding: 10px 0;">
                                                                                <table style="width: 40%; margin: 0 auto;">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td style="height: 1px; background-color: #000000;">
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="/* padding-bottom: 15px; */">
                                                                                <p style="font-size:18px;margin:0;font-family: `Merriweather`, serif;">From DecodeX Infotch</p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
        
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                            '.$data['message'].'
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 100%;">
                                                <table cellspacing="0" cellpadding="0" style="margin: 0 0 12px;">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <p style="margin: 0;padding-bottom: 0;">Thanks &amp; Regards,</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <strong>DecodeX Infotch.</strong>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </body>
        </html>';
    return $msg;
}
?>