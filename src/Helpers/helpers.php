<?php

/*
 * String
 */
if( !function_exists('slug') ) {
	function slug($string) {
		// replace non letter or digits by -
	  	$string = preg_replace('~[^\pL\d]+~u', '-', $string);

	  	// transliterate
	  	$string = iconv('utf-8', 'us-ascii//TRANSLIT', $string);

	  	// remove unwanted characters
	  	$string = preg_replace('~[^-\w]+~', '', $string);

	  	// trim
	  	$string = trim($string, '-');

	  	// remove duplicate -
	  	$string = preg_replace('~-+~', '-', $string);

	  	// lowercase
	  	$string = strtolower($string);

	  	if (empty($string)) {
	   		return 'n-a';
	  	}

	  	return $string;
	}
}
if( !function_exists('str_spliter') ) {
	function str_spliter( $str, $pattern = '/[\s,.|]/' ) {
		return preg_split( $pattern, $str);
	}
}
if( !function_exists('permission_asset') ) {
	function permission_asset( $path ) {
		return route('permission.asset').'?path='.urlencode($path);
	}
}