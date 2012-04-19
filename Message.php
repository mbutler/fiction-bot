<?php

require_once 'GetRandomText.php';

class Message {

	public $text;

	function __construct($file_path, $reply_to) {

		$MPTextFile = $file_path; //need to be absolute path for cron to work
		$MPSepString = ".";
		$MPTextToHTML = true;
		$output = MPPrintRandomText($MPTextFile, $MPSepString, $MPTextToHTML);

		$cleaned_text = preg_replace("/&#?[a-z0-9]+;/i","", $output);
		$cleaned_with_mention = $reply_to . $cleaned_text;
		$this->text .= checkLength($cleaned_with_mention);
		$this->text .= '. #epistle'; //add a hashtag

	}

}

function checkLength($text) {
	if (strlen($text) <= 136) {
		return $text;

	} else {

		// compute how far over the text length is, leaving room for the hashtag
		$strdiff = (140 - strlen($text)) - 9;
		$newtext = substr($text, 0, $strdiff);

		//takes off the last bit up to a space
		$parts = explode(" ", $newtext);
		$removed = array_pop($parts);
		$newtext = implode(" ", $parts);		

		return $newtext;

	}
}

?>