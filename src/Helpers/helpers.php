<?php

/*
 * String
 */
if( !function_exists('slug') ) {
	function slug($string) {
	return str_slug($string);
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