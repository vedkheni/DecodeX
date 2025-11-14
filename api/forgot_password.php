<?php
header('Content-Type: application/json');
$current_dir = getcwd();
define('__ROOT__', $current_dir);
require_once(__ROOT__ . '/config.php');
$con = $mysqli;
$email = $error = $id = $user_token = $token = $password = $vaidate_token = "";

if (isset($_POST['id']) && isset($_POST['user_token'])) {
	$id = trim($_POST['id']);
	$user_token = trim($_POST['user_token']);

	$sql = "SELECT * FROM employee WHERE `id`='" . $id . "' AND `token`='" . $user_token . "'";
	$row = mysqli_query($con, $sql);
	$num_of_row = mysqli_num_rows($row);
	if ($num_of_row == 0) {
		generate_output(0, "Your reset password link is expired. Please generate new link from forgot password page.");
	}

	if (isset($_POST['vaidate_token'])) {
		generate_output(1, "Token is valid.");
	}
}
if (isset($_POST['id']) && isset($_POST['user_token']) && isset($_POST['password'])) {
	$id = trim($_POST['id']);
	$password = trim($_POST['password']);
	$sql = "SELECT * FROM employee WHERE `id`='" . $id . "'";
	$res = mysqli_query($con, $sql);
	if ($res) {
		$row = mysqli_fetch_array($res);
		if ($row['token'] != null) {
			$encode = md5($password);
			$u = "UPDATE `employee` SET `password`='" . $encode . "', `token`='" . $token . "' WHERE `id`='" . $id . "' ";
			$q = mysqli_query($con, $u);
			if ($q)
				generate_output(1, "Your new password has been generated successfully.");
			else
				generate_output(0, "Please enter valid information.");
		}
	}
	generate_output(0, "Something went wrong with your request. Please try again later.");
}
if (isset($_POST['email'])) {
	$email = trim($_POST['email']);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		generate_output(0, "Invalid email format.");
	}
	$mach = "SELECT * FROM employee WHERE email='" . $email . "'";
	$res = mysqli_query($con, $mach);
	$row2 = $res->fetch_assoc();
	$name = $row2['fname'] . ' ' . $row2['lname'];
	$token = md5(uniqid(rand(), true));
	$row = mysqli_num_rows($res);
	if ($row != '') {
		$to = $email;
		$subject = "Staff DecodeX Infotech Password Recover";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: sagargeek435@gmail.com" . "\r\n";
		// $headers .= "From: contact@decodex.io" . "\r\n";
		// $headers .= "From: contact@geekwebsolution.com" . "\r\n";
			/*$message = '<html><body><div  style="background:#ddd;padding-top: 5px; padding-bottom: 5px;">';
			$message .= '<table style="border:none;padding:0 18px;margin:50px auto;width:500px;"> <tbody>
			<tr width="100%" height="57"> <td valign="top" align="left" style="border-top-left-radius:4px;border-top-right-radius:4px;background: #0a1f26;padding:12px 18px;text-align:center;">
			
			<img height="" width="220" src="'.$base_url.'/assets/images/mail_logo.png" title="DigitalcoinPrice" style="font-weight:bold;font-size:18px;color:#fff;vertical-align:top" class="CToWUd"> </td> </tr>

			<tr width="100%"> <td valign="top" align="left" style="border-bottom-left-radius:4px;border-bottom-right-radius:4px;background:#fff;padding:18px"> <h1 style="font-size:20px;margin:0;color:#333;padding: 20px 0;"> Hello "'.$name.'"  , </h1>

			<p style="font:15px/1.25em "Helvetica Neue",Arial,Helvetica;color:#333"> We heard you need a password reset. Click the link below and you will be redirected to a secure site from which you can set a new password. </p>
			
			<p style="font:15px/1.25em "Helvetica Neue",Arial,Helvetica;margin-bottom:0;text-align:center;color:#333">
			
				 <a href="'.$base_url.'reset-password/'.$row2['id'].'/'.$token.'" style="border-radius:3px;background: #f7931a;color:#fff;display:block;font-weight:700;font-size:16px;line-height:1.25em;margin:24px auto 24px;padding:10px 18px;text-decoration:none;width:180px;text-align:center;" target="_blank"> Reset Password </a> </p>
				 
				 </td></tr></tbody></table>';
			$message .= '</div></body></html>';*/

			$message = '';
			$message .= '<!DOCTYPE html>
            <html lang="en">

                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>' . $subject . '</title>
                    <link rel="preconnect" href="https://fonts.gstatic.com">
                    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
                </head>

                <body style="display: block;font-family: `Poppins`, sans-serif;">
                    <table style="width:100%;max-width:600px;margin:0 auto;background-image: url(' . $base_url . '/assets/images/geek-logo-tile.png);background-size: 200px;padding: 15px;">
                        <tbody>
                            <tr>
                                <td>
                                    <table cellspacing="0" cellpadding="0" style="width:100%;border-radius: 8px;background: #ffffff;border: 1px solid rgba(0,0,0,0.1);">
                                        <thead style="background: transparent;border-bottom: 3px solid rgb(6, 117, 232);">
                                            <tr>
                                                <th style="box-sizing: border-box;padding: 30px 0;">
                                                    <a href="https://geekwebsolution.com" style="display: block; width: 60%; max-width: 260px; margin: 0 auto;">
                                                        <img src="' . $base_url . '/assets/images/geekwebsoloution.png" alt="image" style="width: 100%; height: auto;">
                                                    </a>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <a href="https://geekwebsolution.com" style="display: block;width: calc(100% - 30px);margin: 0 auto;">
                                                        <img src="' . $base_url . '/assets/images/reset-password.png" alt="Image" style="width: 100%;">
                                                    </a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <table style="width:100%;padding-top: 10px;">
                                                    <tbody>
                                                        <tr>
                                                            <td style="vertical-align: middle;width: 50%;">
                                                                <table width="100%">
                                                                    <tr>
                                                                        <td style="background-color:rgba(0,0,0,0.1);height:1px;width:calc(100% - 15px);"></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td style="vertical-align: middle;width: 50%;">
                                                                <table width="100%">
                                                                    <tr>
                                                                        <td style="background-color:rgba(0,0,0,0.1);height:1px;width:calc(100% - 15px);"></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </tr>
                                            <tr width="100%">
                                                <td valign="top" align="left" style="border-bottom-left-radius:4px;border-bottom-right-radius:4px;background:#fff;padding:18px">
                                                    <p style="font-size: 15px;">We heard you need a password reset. Click the link below and you will be redirected to a secure site from which you can set a new password.</p>
                                                    <p><a href="' . $base_url . 'reset-password/' . $row2['id'] . '/' . $token . '" style="color:#fff;background-color:#0069d9;border-color:#0062cc;border-radius:3px;display:block;font-weight:700;font-size:16px;line-height:1.25em;margin:24px auto 24px;padding:10px 18px;text-decoration:none;width:180px;text-align:center;" target="_blank"> Reset Password </a></p>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td style="position: relative;display: table-cell;border-top: 1px solid rgba(0,0,0,0.1);padding: 30px 12px;">
                                                    <span style="display:block;text-align:center;">
                                                        <a href="https://www.facebook.com/geekwebsolution/" title="Facebook" style="display: inline-flex;vertical-align: middle;margin: 0 5px;">
                                                            <img src="' . $base_url . '/assets/images/facebook.png" alt="image" height="26" width="26">
                                                        </a>
                                                        <a href="https://www.linkedin.com/company/geek-web-solution/" title="Linkedin" style="display: inline-flex;vertical-align: middle;margin: 0 5px;">
                                                            <img src="' . $base_url . '/assets/images/linkedin.png" alt="image" height="26" width="26">
                                                        </a>
                                                        <a href="https://www.instagram.com/geekwebsolution/" title="Instagram" style="display: inline-flex;vertical-align: middle;margin: 0 5px;">
                                                            <img src="' . $base_url . '/assets/images/instagram.png" alt="image" height="26" width="26">
                                                        </a>
                                                        <a href="https://twitter.com/GeekWebSolutio1" title="Twitter" style="display: inline-flex;vertical-align: middle;margin: 0 5px;">
                                                            <img src="' . $base_url . '/assets/images/twitter.png" alt="image" height="26" width="26">
                                                        </a>
                                                        <a href="https://in.pinterest.com/Geek_Web_Solution/_created/" title="Pintrest" style="display: inline-flex;vertical-align: middle;margin: 0 5px;">
                                                            <img src="' . $base_url . '/assets/images/pinterest.png" alt="image" height="26" width="26">
                                                        </a>
                                                        <a href="tel:+918866895880" title="Whatsapp" style="display: inline-flex;vertical-align: middle;margin: 0 5px;">
                                                            <img src="' . $base_url . '/assets/images/whatsapp.png" alt="image" height="26" width="26">
                                                        </a>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-bottom: 15px">
                                                    <p style="text-align: center;padding: 0 21%;margin: 0;font-size: 13px;">235-236, Mahek icon, Sumul Dairy Road, Beside Sumul Dairy, Surat - 395004</p>
                                                    <span style="padding: 12px 0;font-size: 13px;display: block;text-align: center;">
                                                        <a href="https://geekwebsolution.com/contact-us/" style="color: #000;">Contact Us</a>
                                                        <span style="padding: 0 10px;">|</span>
                                                        <a href="https://geekwebsolution.com/terms-conditions/" style="color: #000;">Terms</a>
                                                    </span>
                                                    <p style="text-align: center;margin: 0 0 0 0;font-size: 13px;">If you have any quetions please contact us <a href="mailto:contact@geekwebsolution.com" style="color: #000000; display:block;">contact@geekwebsolution.com</a></p>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </body>

            </html>';
        $u = "UPDATE `employee` SET `token`='" . $token . "' WHERE `id`='" . $row2['id'] . "' ";
        $q = mysqli_query($con, $u);
        if ($q){
            $suc_mail = mail($to, $subject, $message, $headers);
            ($suc_mail) ? generate_output(1, '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>We have sent reset password link into your mailbox, Please check your mailbox.</p></div></div></div>')
            : generate_output(0, '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Something went wrong with your mail request mail not send. Please try again later.</p></div></div></div>');       
        }else{
            generate_output(0, '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Something went wrong with your database request. Please try again later.</p></div></div></div>');            
        }
	} else
		generate_output(0, '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter valid information.</p></div></div></div>');
}
generate_output(0, '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Something went wrong with your request. Please try again later.</p></div></div></div>');
mysqli_close($con);
