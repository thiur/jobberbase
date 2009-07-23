<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	escape($_POST);
	$_SESSION['contact_msg_sent'] = -1;
	
	$errors = array();
	if ($contact_name == '')
	{
		$errors['contact_name'] = $translations['contact']['name_error'];
	}
	if ($contact_email == '' || !validate_email($contact_email))
	{
		$errors['contact_email'] = $translations['contact']['email_error'];
	}
	if ($contact_msg == '')
	{
		$errors['contact_msg'] = $translations['contact']['msg_error'];
	}
	
	if (count($errors) > 0) {
		$errors['contact_error'] = $translations['contact']['send_error'];
		$smarty->assign('errors', $errors);
	} else {
		$johnny = new Postman();
		if ($johnny->MailContact($contact_name, $contact_email, $contact_msg))
		{
			$_SESSION['contact_msg_sent'] = 1;
		}
	}
}

$smarty->assign('page', $pageData);