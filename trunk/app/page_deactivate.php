<?php
	$j = new Job($id);
	// if auth code used, check it and allow editing
	if ((isset($_SESSION['later_edit']) && $_SESSION['later_edit'] == $j->GetAuth()) || ($extra != '' && $extra == $j->GetAuth()))
	{
		$deleter = $j->Deactivate();
		$_SESSION['status'] = $translations['jobs']['delete_success'];
		redirect_to(BASE_URL);
		exit;
	}

	if ($_SERVER['HTTP_REFERER'] == BASE_URL . 'verificate/' . $id . '/' && $id != 0 && $_SERVER['REMOTE_ADDR'] == $_SESSION['user_ip'])
	{
		$job = new Job($id);
		if ($job->GetTempStatus() == 1 || $job->GetActiveStatus() == 0)
		{
			$info = $job->Deactivate();
			$_SESSION['status'] = $translations['jobs']['confirmation_success'];
			redirect_to(BASE_URL);
			exit;
		}
		else
		{
			redirect_to(BASE_URL);
			exit;
		}
	}
	else
	{
		redirect_to(BASE_URL . 'job/' . $id . '/');
		exit;
	}
?>