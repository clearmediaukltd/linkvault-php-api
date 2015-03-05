<?php    
// Include the linkvault API
// would be autoloaded by composer
include_once('./LinkvaultApi.php');    

// Grab the user input from the form
// this example is quite contrived, remember to secure your code properly
$name = $_POST['name'];
$email = $_POST['email'];

function save_user_details($name, $email) {
	// Save the user details to a database here
	return TRUE;
}

// What we are doing here is calling the save
// user details function, if the function succeeds
// we will call the linkvau.lt api and get a secure
// download link to display to our user
if(save_user_details($name, $email) == TRUE) {
	$api = new \Clearmediaukltd\Linkvault\LinkvaultApi('98acc3cb401bd03aa5253a56ae25f73548b5c44c');
	$link_url = $api->getDownloadUrl('6LWH69q6');
	if($link_url != '') {
		echo '<a href="' . $link_url . '">Click here to download the file</a>';
	} else {
		echo 'There was a problem';
	}
}
