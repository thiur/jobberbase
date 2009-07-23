<?php
/**
 * jobber job board platform
 *
 * @author     Filip C.T.E. <http://www.filipcte.ro> <me@filipcte.ro>
 * @license    You are free to edit and use this work, but it would be nice if you always referenced the original author ;)
 *             (see license.txt).
 * 
 * Misc functions
 */

function add_single_quotes($arg) 
{
	/* single quote and escape single quotes and backslashes */ 
	return "'" . addcslashes($arg, "'\\") . "'"; 
}

function get_categories()
{
    global $db;
    $categories = array();
    $sql = 'SELECT *
                   FROM categories
                   ORDER BY `category_order` ASC';
    $result = $db->query($sql);
    while ($row = $result->fetch_assoc())
    {
        $categories[] = array('id' => $row['id'], 'name' => $row['name'], 'var_name' => $row['var_name'], 'title' => $row['title'], 'description' => $row['description'], 'keywords' => $row['keywords']);
    }
    return $categories;
}

function get_seo_title($id)
{
    global $db;
    $sql = 'SELECT *
                   FROM categories
                   WHERE var_name = "'.$id.'"';
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    return $row['title'];
}

function get_seo_desc($id)
{
    global $db;
    $sql = 'SELECT *
                   FROM categories
                   WHERE var_name = "'.$id.'"';
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    return $row['description'];
}
function get_seo_keys($id)
{
    global $db;
    $sql = 'SELECT *
                   FROM categories
                   WHERE var_name = "'.$id.'"';
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    return $row['keywords'];
}

function get_articles()
{
	global $db;
	$articles = array();
	$sql = 'SELECT id, `title`, `page_title`, `url`
	               FROM `pages`
	               ORDER BY `title` ASC';
	$result = $db->query($sql);
	while ($row = $result->fetch_assoc())
	{
		$articles[$row['url']] = $row;
	}
	return $articles;
}

function get_types()
{
	global $db;
	$types = array();
	$sql = 'SELECT id, name
	               FROM types
	               ORDER BY id ASC';
	$result = $db->query($sql);
	while ($row = $result->fetch_assoc())
	{
		$types[] = array('id' => $row['id'], 'name' => $row['name']);
	}
	return $types;
}

function get_cities()
{
	global $db;
	
	$cities = array();
	
	$sql = 'SELECT id, name, ascii_name
	               FROM cities
	               ORDER BY id ASC';
	
	$result = $db->query($sql);
	
	while ($row = $result->fetch_assoc())
	{
		$cities[] = array('id' => $row['id'], 'name' => $row['name'], 'ascii_name' => $row['ascii_name']);
	}
	
	return $cities;
}

function get_categ_id_by_varname($var_name)
{
	global $db;
	$sql = 'SELECT id FROM categories WHERE var_name = "' . $var_name . '"';
	$result = $db->query($sql);
	$row = $result->fetch_assoc();
	return $row['id'];
}

function get_city_id_by_asciiname($ascii_name)
{
	global $db;
	
	$city = null;
	
	$sql = 'SELECT id, name
	               FROM cities
	               WHERE ascii_name = "' . $ascii_name . '"';

	$result = $db->query($sql);
	$row = $result->fetch_assoc();
	
	if ($row)
		$city = array('id' => $row['id'], 'name' => $row['name']);
		
	return $city;
}

/**
* Converts the multidimensional array that results after calling parse_ini_file (filePath, processSections = true)
* to a JSON string.
* The resulting JSON string will look something like this:
* {"sectionOne": {"messageKeyOne": "messageTextOne", "messageKeyTwo": "messageTextTwo"}, "sectionTwo": {....},....}
*
* @author putypuruty
*/
function iniSectionsToJSON($iniSections)
{
	$translationsJson = "{";
	$sectionsCount = 0;
		
	foreach ($iniSections as $section => $sectionMessages)
	{
		$translationsJson = $translationsJson . "\"" . $section . "\": {";
		$sectionMessagesCount = 0;
		
		foreach ($sectionMessages as $messageKey => $messageText)
		{
			$translationsJson = $translationsJson . "\"".$messageKey . "\":\"" . preg_replace("/\r?\n/", "\\n", addslashes($messageText)) . "\"";
			
			$sectionMessagesCount++;
			
			if ($sectionMessagesCount < count($sectionMessages))
				$translationsJson .= ",";
		}
		$translationsJson .= "}";
		
		$sectionsCount++;

		if ($sectionsCount < count($iniSections))
			$translationsJson .= ",";
	}
	
	$translationsJson = $translationsJson."}";
	
	return $translationsJson;
}

/**
 * Returns the city with the specified ID or null
 * if the city was not found.
 *
 * @param $cityID
 * @return 
 */
function get_city_by_id($cityID)
{
	global $db;
	
	$city = null;
	
	$sql = 'SELECT id, name
	               FROM cities
	               WHERE id = ' . $cityID;
	$result = $db->query($sql);
	
	$row = $result->fetch_assoc();
	
	if ($row)
		$city = array('id' => $row['id'], 'name' => $row['name']);
		
	return $city;  
}
?>