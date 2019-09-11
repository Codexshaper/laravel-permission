<?php
use Illuminate\Support\Str;
/*
 * String
 */
if( !function_exists('slug') ) {
	function slug($string, $separator = '-', $language = 'en') {
	return Str::slug($string, $separator = '-', $language = 'en');
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

if( !function_exists( 'permission_url_prefix' ) ) {
	function permission_url_prefix(){
		if( config('permission.prefix') != null ) {
			return config('permission.prefix');
		}

		return '/admin';
	}
}