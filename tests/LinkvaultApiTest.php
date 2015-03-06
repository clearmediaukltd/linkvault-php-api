<?php
use Clearmediaukltd\Linkvault;


class LinkvaultApiTest extends PHPUnit_Framework_TestCase
{
    /**
     *
     *
     * @param
     * @return
     * @access
     */
    public function testCanGetDownloadUrl()
    {        
        $api = new LinkvaultApi('98acc3cb401bd03aa5253a56ae25f73548b5c44c');
        $link_url = $api->getDownloadUrl('6LWH69q6');
        $this->assertNotEmpty($link_url);
    }
}