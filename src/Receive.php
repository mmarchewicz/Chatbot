<?php
namespace mmarchewicz\chatbot;

/**
 * Class responsible for preparing obtained message from Massenger
 */
class Receive
{
	/**
	 * Prepare array with data needed for sending message to Messenger
	 *
	 * @param array $input
	 *
	 * @return mixed if everything ok method will return prepared arrat if not method will return the error message
	 */	
	public function getMessage($input){
		
		try {
			$payloads = null;
			$senderId = $input['entry'][0]['messaging'][0]['sender']['id'];
			$messageText = $input['entry'][0]['messaging'][0]['message']['text'];
			$postback = $input['entry'][0]['messaging'][0]['postback'];
			$loctitle = $input['entry'][0]['messaging'][0]['message']['attachments'][0]['title'];
			if (!empty($postback)) {
				$payloads = $input['entry'][0]['messaging'][0]['postback']['payload'];
				return ['senderid' => $senderId, 'message' => $payloads];
			}

			if (!empty($loctitle)) {
				$payloads = $input['entry'][0]['messaging'][0]['postback']['payload'];
				return ['senderid' => $senderId, 'message' => $messageText, 'location' => $loctitle];
			}

			return ['senderid' => $senderId, 'message' => $messageText];
		}
		catch(Exception $ex) {
			return $ex->getMessage();
		}
	
	}
}