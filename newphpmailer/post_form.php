<?php

//This File is required with class.phpmailer.php, class.smtp.php, class.pop3.php for the email
require 'PHPMailerAutoload.php';
require_once ("upload_class.php");

//There should be submit button in your form with name="submit"
$submit=$_POST['submit'];
$msg = "";
$max_size = 1024*1024*8; // the max. size for uploading
$error = '';

if(!empty($submit)){
	
$headers = "From: ".$_REQUEST['forename'].":\r\n";
//$headers .= "Reply-To: ". FROM_ADDRESS . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=utf-8\r\n";
//Create html page for the users data 
$message = '<html><body>';
$message .= '<table cellspacing="0" cellpadding="0" border="0" align="center" width="100%">
              <tr>
                <td width="35%" class="contact-form">Name:<font color="red" size="3">*</font></td>
                <td width="5%" class="contact-form">:</td>
                <td width="70%" class="contact-text-form">'.$_REQUEST['forename'].'</td>
              </tr>
              <tr>
                <td class="contact-form">Email:<font color="red" size="3">*</font></td>
                <td class="contact-form">:</td>
                <td width="70%" class="contact-text-form">'.$_REQUEST['surname'].'</td>
              </tr>
              <tr>
                <td class="contact-form">City:<font color="red" size="3">*</font></td>
                <td class="contact-form">:</td>
                <td width="70%" class="contact-text-form">'.$_REQUEST['email'].'</td>
              </tr>
              <tr>
                <td class="contact-form">Age:<font color="red" size="3">*</font></td>
                <td class="contact-form">:</td>
                <td width="70%" class="contact-text-form">'.$_REQUEST['designation'].'</td>
              </tr> 
			</table>';
$message .= '</body></html>';
//End Html Page Here

$mail = new PHPMailer;
$mail->SMTPDebug = 1;	// Enable verbose debug output
$mail->isSMTP();	// Set mailer to use SMTP
$mail->Host = 'makewhale.com';	// Specify main and backup SMTP servers
$mail->SMTPAuth = true;	// Enable SMTP authentication
$mail->Username = 'smsah';	// SMTP username
$mail->Password = '603Niranjan604';	// SMTP password
$mail->SMTPSecure = 'tls';	// Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;	// TCP port to connect to
$mail->SMTPDebug = 0;
$mail->SMTPDebug = 1;
$mail->SMTPDebug = 2;


$mail->From = 'info@impactinvestmentpartners.com';	//Any Email Can be put here
$mail->FromName = 'impactinvestmentpartners.com';	//Any Name Can be put here

$mail->addAddress('vishal@togglehead.in', 'Vishal');	// Add a recipient
$mail->addAddress('tanvi@togglehead.in', 'Tanvi');		// Name is optional
//$mail->addReplyTo('info@example.com', 'Information');
$mail->addCC('vishal@togglehead.in');
$mail->addBCC('tanvi@togglehead.in');

//Looping Files Here
$num_files = count($_FILES['upload']['name']);
	for ($i = 0; $i < $num_files; $i++) {
		if ($_FILES['upload']['name'][$i] != '') {

			$my_upload = new file_upload;
			$my_upload->rename_file = true;
			$my_upload->upload_dir = "files/mail"; 
			$my_upload->extensions = array(".png", ".jpg", ".gif", ".docx", ".doc", ".jpeg", ".pdf"); 
			$my_upload->the_temp_file = $_FILES['upload']['tmp_name'][$i];
			$my_upload->the_file = $_FILES['upload']['name'][$i];
			$my_upload->http_error = $_FILES['upload']['error'][$i];
			$my_upload->replace = "n"; 
			if ($my_upload->upload()) { 
				$full_path = $my_upload->upload_dir.$my_upload->file_copy;
				echo"$full_path";
				$mail->addAttachment($full_path); // Add attachments
				$error .= 'File &quot;'.$my_upload->file_copy.'&quot; uploaded<br />';
			} else {
				break;
				$error = 'Error uploading file(s)';
			}
		}
	}
//End Looping Files

//$mail->addAttachment('../images', '3C Collective.jpg');    // Optional name
$mail->isHTML(true);	// Set email format to HTML
$mail->Subject = 'EMAIL FROM IIP WEBSITE';
$mail->Body    = $message;
//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}

}else{
	echo 'any field value is missing or you have not given name="submit" to submit button';
}

?>