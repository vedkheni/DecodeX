<?php
namespace App\Libraries;
class Mailfunction 
{
	function mail_send($data=array()){
        // $data = array();
        $mail = \Config\Services::email();
        /* $this->load->library('phpmailer_lib');
        $mail = $this->phpmailer_lib->load(); */
        /* $mail->IsSMTP();
        $mail->CharSet   = "UTF-8";
        $mail->ContentType   = "text/html";
        $mail->SMTPDebug  = 0;  
        $mail->SMTPAuth   = TRUE;
        $mail->SMTPSecure = "tls";
        $mail->Port       = 587;
        $mail->Host       = "smtp.gmail.com";
        $mail->Username   = "contact@decodex.io";
        $mail->Password   = "auxbmclkwwexoeke"; */
        $form = 'contact@decodex.io';
        if($data['to'] && $data['subject'] && $data['name'] && $data['base_url'] && $data['title'] && $data['message'] && $data['img_name'] && $data['greeting']){
            $to = $data['to'];
            $subject = $data['subject'];
            $name = $data['name'];
            $mail_type = $data['mail_type'];
        
            $msg = $this->get_mail_html($data);
            /* if($mail_type == 'salary_pay_mail'){
                $msg .= $this->salary_paymail_html($data);
            }elseif($mail_type == 'welcome_mail'){
                $msg .= $this->welcome_mail_html($data);
            } */
            $mail->setFrom($form, 'DecodeX Infotech');
            $mail->setTo($to);
            $mail->setSubject($subject);
            $mail->setMessage($msg);
           /* $mail->isHTML(true);
            $mail->From = $form;
            $mail->FromName = 'DecodeX Infotech';
            $mail->addAddress($to,$name);
            $mail->Sender = $to;
            $mail->Subject = $subject;
            $mail->Body = $msg; */ 
            if (!$mail->send()) {
                return $mail->printDebugger(['headers']);
            }else{
                return $mail->send();
            }
        }else{
            return 'error';
        }
    }
    function get_header($data = array()){
        $msg = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>'.$data['subject'].'</title>
            <link rel="preconnect" href="https://fonts.gstatic.com">
            <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
        </head>
        <body style="display: block;font-family: `Poppins`, sans-serif;">
            <table style="width:100%;max-width:512px;margin:0 auto;"> 
            <!-- <table style="width:100%;max-width:600px;margin:0 auto;background-image: url('.$data['base_url'].'assets/images/geek-logo-tile.png);background-size: 200px;padding: 15px;border: 1px solid rgba(0,0,0,0.1);"> -->
                <tbody>
                    <tr>
                        <td>
                            <table cellspacing="0" cellpadding="0" style="width:100%;border-radius: 8px;background: #ffffff;border: 1px solid rgba(0,0,0,0.1);">
                                <thead style="background: transparent;border-bottom: 3px solid rgb(6, 117, 232);">
                                    <tr>
                                        <th style="box-sizing: border-box;padding: 30px 0;">
                                            <a href="https://decodex.io" style="display: block; width: 60%; max-width: 260px; margin: 0 auto;">
                                                <img src="'.$data['base_url'].'assets/images/decodex.png" alt="image" style="width: 100%; height: auto;">
                                            </a>
                                        </th>
                                    </tr>
                                </thead>';
        return $msg;    
    }
    function get_footer($data = array()){
        $msg = '  <tfoot>
                    <tr>
                        <td style="position: relative;display: table-cell;border-top: 1px solid rgba(0,0,0,0.1);padding: 30px 12px;">
                            <span style="display:block;text-align:center;">
                                <a href="https://www.facebook.com/DecodeX-Infotech-110737274944956/" title="Facebook" style="display: inline-flex;vertical-align: middle;margin: 0 5px;">
                                    <img src="'.$data['base_url'].'assets/images/facebook.png" alt="image" height="26" width="26">
                                </a>
                                <a href="https://www.linkedin.com/company/decodex-infotech/" title="Linkedin" style="display: inline-flex;vertical-align: middle;margin: 0 5px;">
                                    <img src="'.$data['base_url'].'assets/images/linkedin.png" alt="image" height="26" width="26">
                                </a>
                                <a href="https://www.instagram.com/decodex.io/" title="Linkedin" style="display: inline-flex;vertical-align: middle;margin: 0 5px;">
                                    <img src="'.$data['base_url'].'assets/images/instagram.png" alt="image" height="26" width="26">
                                </a>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 15px">
                            <p style="text-align: center;padding: 0 21%;margin: 0;font-size: 16px;">1101, Excellent Business Hub, Laldarwaja, Ring Rd, nr. Railway Station Road, Gotalawadi, Tunki, Patel Nagar, Surat, Gujarat 395003</p>
                            <span style="padding: 12px 0;font-size: 16px;display: block;text-align: center;">
                                <a href="https://decodex.io/contact-us/" style="color: #000;">Contact Us</a>
                                <span style="padding: 0 10px;">|</span>
                                <a href="https://decodex.io/terms-conditions/" style="color: #000;">Terms</a>
                            </span>
                            <p style="text-align: center;margin: 0 0 0 0;font-size: 16px;">If you have any quetions please contact us <a href="mailto:contact@decodex.io" style="color: #000000; display:block;">contact@decodex.io</a></p>
                        </td>
                    </tr>
                </tfoot>
            </table>
            </td>
            </tr>
            </tbody>
        </table>
        </body>
        </html>
        <tfoot>';
        return $msg;    
        
    }
    function get_mail_html($data = array()){
        $msg = $this->get_header($data);
        $msg .= '<tbody>
                <tr>
                    <td>
                        <a href="https://decodex.io" style="display: block;width: calc(100% - 30px);margin: 0 auto;">
                            <img src="'.$data['base_url'].'assets/images/'.$data['img_name'].'" alt="Image" style="width: 100%;">
                        </a>
                    </td>
                </tr>
                <tr>
                    <table style="width:100%;padding-top: 10px;">
                        <tbody>
                        <tr>
                        <!-- <td style="vertical-align: middle;width: 50%;">
                            <table width="100%">
                                <tr>
                                    <td style="background-color:rgba(0,0,0,0.1);height:1px;width:calc(100% - 15px);"></td>
                                </tr>
                            </table>
                        </td> -->
                        <td>
                            <h2 style="position: relative;text-align:center; display:block; margin: 0;padding: 0 30px;z-index: 1;background: #ffffff;color: #525252;">'.$data['title'].'</h2>
                        </td>
                        <!-- <td style="vertical-align: middle;width: 50%;">
                            <table  width="100%">
                                <tr>
                                    <td style="background-color:rgba(0,0,0,0.1);height:1px;width:calc(100% - 15px);"></td>
                                </tr>
                            </table>
                        </td> -->
                    </tr>
                        </tbody>
                    </table>
                </tr>
                <tr>
                    <td colspan="3" style="position: relative;display: table-cell;padding: 10px 20px 30px 20px; text-align: left;">
                        <h4 style="margin-top: 0;">'.$data['greeting'].' '.$data['name'].', </h4>
                        <span>'.$data['message'].'</span>
                        <span style="margin-top: 25px;display: block;color:#000000;">
                            <p style="margin: 0;">Thanks &amp; Regards,</p>
                            <h4 style="margin: 0;">DecodeX Infotech</h4>
                        </span>
                    </td>
                </tr>
            </tbody>';
            $msg .= $this->get_footer($data);
            return $msg;
    }
    function salary_paymail_html($data = array()){
        $msg = $this->get_header($data);
        $msg .= '<tbody>
                <tr>
                    <td>
                        <a href="javascript:void(0);" style="display: block;width: calc(100% - 30px);margin: 0 auto;">
                            <img src="'.$data['base_url'].'assets/images/salary-paid.png" alt="Image" style="width: 100%;">
                        </a>
                    </td>
                </tr>
                <tr>
                    <td style="position: relative;text-align: center; padding: 10px 0;">
                        <h2 style="position: relative;display: inline-block; margin: 0;padding: 0 15px;z-index: 1;background: #ffffff;color: #525252;">Welcome to DecodeX Family</h2>
                        <span style="position: absolute;display: block; height: 1px;width: 100%;background: rgba(0,0,0,0.1);top: 50%;transform: translateY(-50%);"></span>
                    </td>
                </tr>
                <tr>
                    <td style="position: relative;display: table-cell;padding: 10px 20px 30px 20px; text-align: left;">
                        <h4 style="margin-top: 0;">Welcome '.$data['name'].', </h4>
                        <span>
                            <p>Congratulations on joining our team! We hope we can work well together and share many successes in DecodeX Infotech.</p>
                            <p>We believe that each employee contributes directly to the DecodeX Infotech growth and success, and we hope you will take pride in being a member of our team.</p>
                            <p>We hope that your experience here will be challenging, enjoyable, and rewarding. Again, welcome!</p>
                        </span>
                        <span style="margin-top: 25px;display: block;">
                            <p style="margin: 0;">Thanks &amp; Regards,</p>
                            <h4 style="margin: 0;">DecodeX Infotech</h4>
                        </span>
                    </td>
                </tr>
            </tbody>';
            $msg .= $this->get_footer($data);
            return $msg;
    }
    function welcome_mail_html($data = array()){
        $msg = $this->get_header($data);
        $msg .= '<tbody>
            <tr>
                <td>
                    <a href="javascript:void(0);" style="display: block;width: calc(100% - 30px);margin: 0 auto;">
                        <img src="'.$data['base_url'].'assets/images/handshake.png" alt="Image" style="width: 100%;">
                    </a>
                </td>
            </tr>
            <tr>
                <td style="position: relative;text-align: center; padding: 10px 0;">
                    <h2 style="position: relative;display: inline-block; margin: 0;padding: 0 15px;z-index: 1;background: #ffffff;color: #525252;">Welcome to DecodeX Family</h2>
                    <span style="position: absolute;display: block; height: 1px;width: 100%;background: rgba(0,0,0,0.1);top: 50%;transform: translateY(-50%);"></span>
                </td>
            </tr>
            <tr>
                <td style="position: relative;display: table-cell;padding: 10px 20px 30px 20px; text-align: left;">
                    <h4 style="margin-top: 0;">Welcome '.$data['name'].', </h4>
                    <span>
                        <p>Congratulations on joining our team! We hope we can work well together and share many successes in DecodeX Infotech.</p>
                        <p>We believe that each employee contributes directly to the DecodeX Infotech growth and success, and we hope you will take pride in being a member of our team.</p>
                        <p>We hope that your experience here will be challenging, enjoyable, and rewarding. Again, welcome!</p>
                    </span>
                    <span style="margin-top: 25px;display: block;">
                        <p style="margin: 0;">Thanks &amp; Regards,</p>
                        <h4 style="margin: 0;">DecodeX Infotech</h4>
                    </span>
                </td>
            </tr>
        </tbody>';
        $msg .= $this->get_footer($data);
        return $msg;
    }
}
?>