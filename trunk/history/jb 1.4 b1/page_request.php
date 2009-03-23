<?php
switch($id)
{
	case '':
		$req = new JobRequest();
		$smarty->assign('req_params_tip', $req->GetParams('type'));
		$smarty->assign('req_params_kh', $req->GetParams('know-how'));
		$smarty->assign('req_params_company', $req->GetParams('company'));
		$smarty->assign('req_params_level', $req->GetParams('level'));
	
		// this branch executes after first writing a post and hitting the submit button
		if (isset($_POST['action']) && $_POST['action'] && $_POST['action'] == 'publish')
		{
			escape($_POST);
			$errors = array();
		
			// validation
			if ($name == '')
			{
				$errors['name'] = $translations['idealjob']['name_error'];
			}
			if ($email == '' && validate_email($email))
			{
				$errors['email'] = $translations['idealjob']['email_error'];
			}
			if (count($req_params) < 1)
			{
				$errors['the_params'] = $translations['idealjob']['params_error'];
			}

			// no errors, save request
			if (empty($errors))
			{
				$data = array('name' => $name,
				              'email' => $email,
				              'params' => $req_params);
				if ($req->Create($data))
				{
					redirect_to(BASE_URL . 'ideal-job/saved/');	
				}
				else
				{
				redirect_to(BASE_URL . 'ideal-job/unsaved/');	
				}
			
				exit;
			}
			// if errors exist, go back and edit the post
			else
			{
				$smarty->assign('errors', $errors);
			}
		}
	
		$html_title = $translations['idealjob']['title'];
		$template = 'request-job.tpl';
		break;
		
	case 'saved':
		$smarty->assign('status', 1);
		$html_title = $translations['idealjob']['thankyou_message'];
		$template = 'request-job-confirmation.tpl';
		break;

	case 'unsaved':
		$smarty->assign('status', 0);
		$html_title = $translations['idealjob']['thankyou_message'];
		$template = 'request-job-confirmation.tpl';
		break;
}
?>