<?php
namespace mmarchewicz\chatbot;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

use Exception;


/**
 * Class responsible for sending information to Messenger
 */
class Send
{
	function __construct($accessToken)
	{	
		$this->accessToken = $accessToken;
	}
	/**
	 * Send Message to Messenger
	 * If something goes wrong error message will be stored inside error.json
	 *
	 * @param array $input
	 * @param string $answer Message to send
	 *
	 * @return mixed if everything ok method will return true if not method will return the response
	 */	
	public function sendMessage($input, $answer){
	
		try {
			$client = new GuzzleHttpClient();
			$url = "https://graph.facebook.com/v2.6/me/messages";
			
			$senderId = $input['senderid'];
			
			$response = null;
			$header = array(
			'content-type' => 'application/json'
			);
			
			
			
			$response = [
					'recipient' => ['id' => $senderId], 
					'message' => $answer, 
					'access_token' => $this->accessToken
				];
			$response = $client->post($url, ['query' => $response, 'headers' => $header]);

			return true;
		}

		catch(RequestException $e) {
			$response = json_decode($e->getResponse()->getBody(true)->getContents());
			file_put_contents("error.json", json_encode($response));
			return $response;
		}
	
	}
}