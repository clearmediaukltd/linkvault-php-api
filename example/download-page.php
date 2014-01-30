<?php    
// Include the linkvault API
include_once('./api.php');    

// Grab the user input from the form
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
	$api = new LinkvaultApi('56dd703295d9f18cd74140bf6c1a7f8cfaa72200');
	$link_url = $api->get_download_url('IEc2ZTPw');
	if($link_url != '') {
		echo '<a href="' . $link_url . '">Click here to download the file</a>';
	} else {
		echo 'There was a problem';
	}
}
?>