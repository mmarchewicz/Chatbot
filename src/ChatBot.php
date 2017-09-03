<?php
namespace mmarchewicz\chatbot;

use Exception;
use mmarchewicz\chatbot\Receive;
use mmarchewicz\chatbot\Send;
use mmarchewicz\chatbot\PrepareAnswer;

/**
 * main class which manage alle the flow in application 
 */
class ChatBot
{
	private $hubVerifyToken;
	private $accessToken;
	protected $client = null;
	 
	function __construct($hubVerifyToken, $accessToken)
	{
		$this->setHubVerifyToken($hubVerifyToken);
		$this->setaccessToken($accessToken);
		echo $this->verifyTokken($_REQUEST['hub_verify_token'], $_REQUEST['hub_challenge']);
	}
	
	/**
	 * Main method resposible for runing application
	 * Call this method from outside to run ChatBot
	 */
	public function init()
	{
		$prepare_answer = new PrepareAnswer;
	
		$input = json_decode(file_get_contents('php://input'), true);
		$message = Receive::getMessage($input);
		$answer = $prepare_answer->prepare($message);//PrepareAnswer::prepare($message);
		$textmessage = $this->sendMessage($message, $answer);
	}
	public function setHubVerifyToken($value)
	{
		$this->hubVerifyToken = $value;
	}

	public function setAccessToken($value)
	{
		$this->accessToken = $value;
	}

	public function verifyTokken($hub_verify_token, $challange)
	{
		try {
			if ($hub_verify_token === $this->hubVerifyToken) {
				return $challange;
			}
			else {
				throw new Exception("Tokken not verified");
			}
		}

		catch(Exception $ex) {
			return $ex->getMessage();
		}
	}

	public function readMessage($input)
	{
		return Receive::getMessage($input);
	}

	public function sendMessage($input, $answer)
	{
		$sendMessage = new Send($this->accessToken);
		return $sendMessage->sendMessage($input, $answer);
	}
}