<?php 
include_once('./api.php');
$api_key = '56dd703295d9f18cd74140bf6c1a7f8cfaa72200';
$file_id = 'IEc2ZTPw';

$api = new LinkvaultApi($api_key);
echo $api->get_download_url($file_id);
