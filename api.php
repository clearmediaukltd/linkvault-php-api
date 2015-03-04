<?php
/**
 * Linkvault a web app for providing secure download links
 *
 * @package		ClearMedia
 * @author		Clear Media UK Ltd Dev Team
 * @copyright	Copyright (c) 2008 Clear Media UK Ltd.
 * @license		MIT
 * @link		http://linkvau.lt/
 * @since		Version 1.0
 * @filesource
 */
/**
 * Linkvault\Api
 *
 * @package		Safelinks
 * @category	API Class
 * @author		Clear Media UK Ltd Dev Team
 * @link		http://linkvau.lt/
 */
class LinkvaultApi 
{
	private $api_url = 'https://linkvau.lt/api/';
	public $debug_level = 0;
	public $method = 'get';

	/**
	 * Constructor, simply sets up the API key
	 *
	 * @param string
	 * @return void
	 * @access public
	 */
	public function __construct($api_key = '')
	{
		$this->api_key = $api_key;
		return;
	}

	// ------------------------------------------------

	/**
	 * Makes the API calls using cURL
	 *
	 * @param string $api_endpoint
	 * @param string $options
	 * @return mixed CURLOPT_RETURNTRANSFER is set to 1 so we get the result back
	 * @access public
	 * @todo abstract this to allow other methods of accessing the API
	 */
	public function make_call($api_endpoint, $postdata = array())
	{
		$url = $this->api_url . $api_endpoint;	
		$ch = curl_init();
		if($this->method != 'get') {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		}		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, 'LinkvaultApi');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		if($this->debug_level > 0) {
			curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, TRUE);

			$verbose = fopen('php://temp', 'rw+');
			curl_setopt($ch, CURLOPT_STDERR, $verbose);

			rewind($verbose);
			$verbose_log = stream_get_contents($verbose);

			echo "Verbose information:\n<pre>", htmlspecialchars($verbose_log), "</pre>\n";		
		}
		
		$res = curl_exec($ch);
		curl_close($ch);
		return $res;
	}

	// ------------------------------------------------
	
		
	/**
	 * allows posting of a url to the site, the link will appear in the dashboard
	 * returns a file_id which can be used by 
	 *
	 * @param
	 * @return
	 * @access
	 */
	public function post_url($url, $downloads_per_link = 3, $link_expires_after = 0)
	{
		$this->method = 'post';
		$postfields = array(
								'url_source' => $url,
								'downloads_per_link' => (int)$downloads_per_link,
								'link_expires_after' => (int)$link_expires_after,
							);

		$result = json_decode($this->make_call('add/url/' . $this->api_key, $postfields));
		$this->method = 'get';

		return $result;
	}

	// -------------------------	

	/**
	 * Returns the secure download URL for a file
	 *
	 * @param string $file_id the unique(ish) id of the file
	 * @return string
	 * @access public
	 */
	public function get_download_url($file_id)
	{
		$data = json_decode($this->make_call('get/link/' . $this->api_key . '/' . $file_id));
		return $data->link;
	}	

	// ------------------------------------------------
	
	/**
	 * Get download link html
	 * returns an HTML link to the download URL
	 * 
	 * @param string
	 * @return string
	 * @access public
	 * @todo allow users to send their own link text
	 */
	public function get_download_link_html($file_id)
	{
	 	$data = json_decode($this->make_call('get/link/' . $this->api_key . '/' . $file_id));
		return '<a href="' . $data->link . '">Click to Download</a>';
	}
	 
	// ------------------------------------------------

	/**
	 * Returns a list of files as a PHP array of objects
	 *
	 * @param void
	 * @return array
	 * @access public
	 */
	public function get_files()
	{
		$data = json_decode($this->make_call('get/files/' . $this->api_key));
		return $data;
	}

	// ------------------------------------------------

}

/* End of file: api.php */
/* Location: */
