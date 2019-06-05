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
	
$headers = "From: ".$_REQUEST['joml'].":\r\n";
$headers .= "Reply-To: ". FROM_ADDRESS . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=utf-8\r\n";
//Create html page for the users data 
$message = '<html><body>';
$message .= '<table cellspacing="0" cellpadding="0" border="0" align="center" width="100%">
              <tr>
                <td width="35%" class="contact-form">Forename:<font color="red" size="3">*</font></td>
                <td width="5%" class="contact-form">:</td>
                <td width="70%" class="contact-text-form">'.$_REQUEST['joml'].'</td>
              </tr>
			</table>';
$message .= '</body></html>';
//End Html Page Here

$mail = new PHPMailer;
//$mail->SMTPDebug = 1;	// Enable verbose debug output
$mail->isSMTP();	// Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';	// Specify main and backup SMTP servers
$mail->SMTPAuth = true;	// Enable SMTP authentication
$mail->Username = 'alerts@sanathan.com';	// SMTP username
$mail->Password = 'togglehead@123';	// SMTP password
$mail->SMTPSecure = 'tls';	// Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;	// TCP port to connect to
//$mail->SMTPDebug = 0;
//$mail->SMTPDebug = 1;
//$mail->SMTPDebug = 2;


$mail->From = ''.$_REQUEST['Email'];	//Any Email Can be put here
$mail->FromName = ''.$_REQUEST['Forename'];	//Any Name Can be put here

$mail->addAddress('gaurav@togglehead.in');	// Add a recipient
$mail->addAddress('shaili@togglehead.in');		// Name is optional
$mail->addReplyTo('info@example.com', 'Information');
$mail->addCC('hr@sanathan.com');
$mail->addCC('varun_dattani@sanathan.com');
$mail->addCC('sammir_dattani@sanathan.com');
$mail->addCC('mikesh_dattani@sanathan.com');
$mail->addCC('ajay_dattani@sanathan.com');
/*$mail->addCC('tanvi@togglehead.in');*/

//Looping Files Here
$num_files = count($_FILES['upload']['name']);
	for ($i = 0; $i < $num_files; $i++) {
		if ($_FILES['upload']['name'][$i] != '') {

			$my_upload = new file_upload;
			$my_upload->rename_file = true;
			$my_upload->upload_dir = "files/mail"; //make a folder named files/mail on newphp mailer folder
			$my_upload->extensions = array(".png", ".jpg", ".gif", ".docx", ".doc", ".jpeg", ".pdf"); 
			$my_upload->the_temp_file = $_FILES['upload']['tmp_name'][$i];
			$my_upload->the_file = $_FILES['upload']['name'][$i];
			$my_upload->http_error = $_FILES['upload']['error'][$i];
			$my_upload->replace = "n"; 
			if ($my_upload->upload()) { 
				$full_path = $my_upload->upload_dir.$my_upload->file_copy;
//				echo"$full_path";
				$mail->addAttachment($full_path); // Add attachments
				$error .= 'File &quot;'.$my_upload->file_copy.'&quot; uploaded<br />';
			} else {
				break;
				$error = 'Error uploading file(s)';
			}
		}
	}
//End Looping Files

//$mail->addAttachment($_FILES['upload']);    // Optional name
$mail->isHTML(true);	// Set email format to HTML
$mail->Subject = 'Email From Sanathan Website - Career Form';
$mail->Body    = $message;
//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent. Your Email Format should be abc@example.com';
 //   echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
//    echo ' Message has been sent';
}
header("Location:../thank-you.php");
exit();
}
else{
	echo 'any field value is missing or you have not given name="submit" to submit button';
}

?>