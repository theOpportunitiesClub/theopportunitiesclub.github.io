<?php
if(!isset($_POST['submit']))
{
	header('Location: index.html');
}

//Variables
$name = $_POST['fullname'];
$visitor_email = $_POST['email'];
$message = $_POST['message'];

//Validation
if(empty($name)||empty($visitor_email))
{
	echo "Name and Email are required!";
	exit;
}

//Spam Check
if(IsInjected($visitor_email))
{
    echo "Bad email value!";
    exit;
}

//Create email
$email_from = "$visitor_email";
$email_subject = "General Inquiry from theopclub.com";
$email_body = "$name ($visitor_email) says: \n\n";
$email_body .= "$message";

$to = "theopclubsjsu@gmail.com";
$headers = "From: $email_from \r\n";

//Spammer check code
function IsInjected($str)
{
    $injections = array('(\n+)',
           '(\r+)',
           '(\t+)',
           '(%0A+)',
           '(%0D+)',
           '(%08+)',
           '(%09+)'
           );

    $inject = join('|', $injections);
    $inject = "/$inject/i";

    if(preg_match($inject,$str))
    {
      return true;
    }
    else
    {
      return false;
    }
}

//Send email
mail($to,$email_subject,$email_body,$headers);
header('Location: index.html');
?>
