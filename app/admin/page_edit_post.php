<?php
/**
 * @author putypuruty
 * 
 * Business logic for editing a post.
 */
	
	//Note: $id is a job ID
	
if ($id != 0)
	{
		$job = new Job($id);
	}
	else
	{
		$job = new Job();
	}
	
	$jobToEdit = $job->GetInfo();
	$smarty->assign_by_ref('job', $jobToEdit);
	
	$smarty->assign('show_preview', false);
	
	if (!empty($_POST))
	{
		// validation
		$errors = array();
		
		if ($_POST['company'] == '')
			$errors['company'] = $translations['jobs']['name_error'];
		
		if ($_POST['title'] == '')
			$errors['title'] = $translations['jobs']['title_error'];
		
		if ($_POST['description'] == '')
			$errors['description'] = $translations['jobs']['description_error'];
		
		if ($_POST['poster_email'] == '')
			$errors['poster_email'] = $translations['jobs']['email_error'];

		$isCitySelected = false;

		// we didn't receive a city (when the cities combo is disabled)
		if (!isset($_POST['city_id']))
			$city_id = -1;
		else
		{
			$city_id = $_POST['city_id'];
			$isCitySelected = true;
		}
				
		$jobToEdit['company'] = $_POST['company'];
		$jobToEdit['url'] = $_POST['url'];
		$jobToEdit['title'] = $_POST['title'];
		$jobToEdit['city_id'] = $city_id;
		$jobToEdit['location_outside_ro_where'] = ($isCitySelected ? '' : $_POST['location_outside_ro_where']);
		$jobToEdit['category_id'] = $_POST['category_id'];
		$jobToEdit['type_id'] = $_POST['type_id'];
		$jobToEdit['description'] = $_POST['description'];
		$jobToEdit['apply'] = '';
		$jobToEdit['poster_email'] = $_POST['poster_email'];
		$jobToEdit['apply_online'] = $_POST['apply_online'];
		$jobToEdit['type_var_name'] = get_type_varname_by_id($_POST['type_id']);
		$jobToEdit['type_id'] = $_POST['type_id'];
		
		$jobToEdit['textiledDescription'] = $textile->TextileThis($_POST['description']);
		$jobToEdit['location_outside_ro'] = $jobToEdit['location_outside_ro_where'];
		
		if ($isCitySelected)
		{
			$city = get_city_by_id($city_id);
			
			$jobToEdit['location'] = $city['name'];
		}
		else
			$jobToEdit['location'] = $jobToEdit['location_outside_ro'];
			
		// no errors
		if (empty($errors))
		{
			if ($_POST['show_preview'] == 'true')
				$smarty->assign('show_preview', true);
			else
			{
				escape($_POST);	
				
				$data = array('company' => $company,
				          	  'url' => $url,
				              'title' => $title,
				              'city_id' => $city_id,
				              'category_id' => $category_id,
				              'type_id' => $type_id,
				              'description' => $description,
							  'location_outside_ro_where' => ($isCitySelected ? '' : $location_outside_ro_where) ,
				              'apply' => '',
				              'poster_email' => $poster_email,
				              'apply_online' => $apply_online);
				
				if ($id != 0)
				{
					$job->Edit($data);
				}
				else
				{
					$data['is_temp'] = 0;
					$data['is_active'] = 1;
					
					$job->Create($data);
				}
				
				$jobCategName = $job->GetCategVarname($category_id);
				
				redirect_to(BASE_URL . URL_JOBS . '/' . $jobCategName . '/');
				exit;
			}
		}
		else
			$smarty->assign('errors', $errors);
	}
		
	$smarty->assign('categories', get_categories());
	$smarty->assign('types', get_types());
	$smarty->assign('cities', get_cities());
	
	$html_title = $translations['jobs']['title_edit'] . ' / ' . SITE_NAME;
	
	$template = 'edit-post.tpl';
?>