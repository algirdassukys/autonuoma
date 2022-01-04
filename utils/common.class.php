<?php

/**
 * Bendrųjų pagalbinių funkcijų klasė.
 *
 * @author ISK
 */

class common {

	/**
	* @desc Nekreipimo funkcija, naudojant Javascript
	* @param url adresas, į kurį nukreipiama
	*/
	public static function redirect($url) {
		echo "<script type='text/javascript'>document.location.href='" . $url . "';</script>";
		echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $url . '">';
	}
	
	public static function logToConsole($output, $with_script_tags = true) {
		$js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
		if ($with_script_tags) {
			$js_code = '<script>' . $js_code . '</script>';
		}
		echo $js_code;
	}
}

?>