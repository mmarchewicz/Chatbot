<?php
namespace mmarchewicz\chatbot;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Exception;

/**
 * Class responsible for preparing answer for current message from user
 */
class PrepareAnswer
{
	function __construct($accessToken)
	{	
		$this->accessToken = $accessToken;
	}
	
	/**
	 * Prepare string with answer  for sending message to Messenger
	 *
	 * @param array $input
	 *
	 * @return string $answer
	 */	
	public function prepare($input){
		$messageText = strtolower($input['message']);
		$msgarray = explode(' ', $messageText);
		
		$askAndAnswer = [
			'hi' => $this->_standardMessage('Hi, how may I help you?'),
			'whats your name?' => $this->_standardMessage('My name is ChatBot'),
			'what are you?' => $this->_standardMessage('I\'m Bot who is some kind of interface with application'),
			'location' => $this->_location(),
			'list www' => $this->_listWww(),
			'www' => $this->_www()
		];
		
		
		if (array_key_exists($messageText, $askAndAnswer)) {
			$answer = $askAndAnswer[$messageText];
		} 	
		elseif ($messageText == 'show commands') {
			$commands_string = "\n";
			foreach($askAndAnswer as $command => $answer) {$commands_string .= $command."\n";}
			$answer = ["text" => 'Available commands: ' . $commands_string, ];
		}
		elseif (!empty($input['location'])) {
			$answer = ["text" => 'Cool! Your location is: ' . $input['location'], ];
		}
		elseif (!empty($messageText)) {
			$answer = ['text' => 'Sorry, I can not Understand you, please ask me for something else i.e. type: "show commands"'];
		}
			
		return $answer;
	}
	
	private function _location(){
		return [
				"text" => "Please share me your location:", 
				"quick_replies" => [
					[
						"content_type" => "location", 
					]
				]
			];
	}
	
	private function _standardMessage($text){
		return ["text" => $text];
	}
	
	private function _www(){
		return [
			"attachment" => [
				"type" => "template", 
				"payload" => [
					"template_type" => "generic", 
					"elements" => [
						[
							"title" => "Chatbot", 
							"item_url" => "https://github.com/mmarchewicz/Chatbot", 
							"image_url" => "https://avatars0.githubusercontent.com/u/31590229", 
							"subtitle" => "Chatbot Package for Facebook Messenger. Try it now", 
							"buttons" => [
								[
									"type" => "web_url", 
									"url" => "github.com/mmarchewicz/Chatbot", 
									"title" => "View Website"
								], 
								[
									"type" => "postback", 
									"title" => "Say hi to me", 
									"payload" => "hi"
								]
							]
						]
					]
				]
			]
		];

	}
		
	private function _listWww(){
		return [
			"attachment" => [
				"type" => "template", 
				"payload" => [
					"template_type" => "list", 
					"elements" => [
						[
							"title" => "Chatbot", 
							"item_url" => "https://github.com/mmarchewicz/Chatbot", 
							"image_url" => "https://avatars0.githubusercontent.com/u/31590229", 
							"subtitle" => "Chatbot Package for Facebook Messenger. Try it now", 
							"buttons" => [
								[
									"type" => "web_url", "url" => "github.com/mmarchewicz/Chatbot", 
									"title" => "View Website"
								], 
							]
						],
						[
							"title" => "Chatbot", 
							"item_url" => "https://github.com/mmarchewicz/Chatbot", 
							"image_url" => "https://avatars0.githubusercontent.com/u/31590229", 
							"subtitle" => "Chatbot Package for Facebook Messenger. Try it now", 
							"buttons" => [
								[
									"type" => "web_url", "url" => "github.com/mmarchewicz/Chatbot", 
									"title" => "View Website"
								], 
							]
						],
						[
							"title" => "Chatbot", 
							"item_url" => "https://github.com/mmarchewicz/Chatbot", 
							"image_url" => "https://avatars0.githubusercontent.com/u/31590229", 
							"subtitle" => "Chatbot Package for Facebook Messenger. Try it now", 
							"buttons" => [
								[
									"type" => "web_url", "url" => "github.com/mmarchewicz/Chatbot", 
									"title" => "View Website"
								], 
							]
						],
					]
				]
			]
		];
	}
}