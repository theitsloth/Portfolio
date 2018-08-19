<?php

/**
 * {@link str_replace} but only once
 */
function str_replace_first($from, $to, $content)
{
	$from = '/'.preg_quote($from, '/').'/';
	return preg_replace($from, $to, $content, 1);
}

/**
 * Executes php script and gets the output values.
 */
function get_php_results($filename) {
	ob_start();
	require $filename;
	return ob_get_clean();
}

/**
 * {@link explode} but with delimiter array
 */
function multiexplode ($delimiters,$string) {
	$ready = str_replace($delimiters, $delimiters[0], $string);
	$launch = explode($delimiters[0], $ready);
	return  $launch;
}

/**
 * Returns bool if string2 starts with string1
 * @param string $with string to start with
 * @param string $string string that starts with the previous param.
 */
function startswith($with, $string) {
	return strpos($string, $with) === 0;
}
function endswith($with, $string) {
	return strpos($string, $with) === strlen($string)-strlen($with);
}

?>
