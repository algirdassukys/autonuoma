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
}

?>