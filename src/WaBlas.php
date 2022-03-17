<?php

namespace River13Lab\WaBlas;
//use config;

/**
 * Basic Wa Blas.
 *
 */
class WaBlas
{
    private $domain;
    private $token;

    function __construct()
    {
        $this->domain = config('wablas.domain');
        $this->token = config('wablas.api');
    }

    function sendText($phone, $message)
    {
        $curl = curl_init();
        $token = $this->token;
        $data = [
            'phone' => $phone,
            'message' => $message,
            'secret' => false, // or true
            'priority' => false, // or true
        ];

        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array(
                "Authorization: $token",
            )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL, $this->domain."/api/send-message");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);
    }
	
	function sendBulkText($phones, $message)
    {
        $curl = curl_init();
        $token = $this->token;
        $payload = [
			"data" => [
				foreach($phones as $phone)
				{
					[
						'phone' => $phone,
						'message' => $message,
						'secret' => false, // or true
						'priority' => false, // or true
					],
				}
			]
        ];

        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array(
                "Authorization: $token",
				"Content-Type: application/json"
            )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($curl, CURLOPT_URL, $this->domain."/api/v2/send-bulk/text");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);
    }

    function sendImage($phone, $image, $caption = null)
    {
        $curl = curl_init();
        $token = $this->token;
        $data = [
            'phone' => $phone,
            'caption' => $caption, // can be null
            'image' => $image,
            'secret' => false, // or true
            'priority' => false, // or true
        ];

        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array(
                "Authorization: $token",
            )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL, $this->domain."/api/send-image");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);
    }

    function cek()
    {
        echo $this->domain;
    }

}
