<?php

namespace App\Traits;

use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| CustomEncript Trait
|--------------------------------------------------------------------------
|
| This trait will be used for any response we sent to clients.
|
*/

trait CustomEncript
{

	public function encrypt($string, $key) {
		$result = '';
		for($i=0; $i<strlen($string); $i++) {
		   $char = substr($string, $i, 1);
		   $keychar = substr($key, ($i % strlen($key))-1, 1);
		   $char = chr(ord($char)+ord($keychar));
		   $result.=$char;
		}
		return base64_encode($result);
	}

	public function decrypt($string, $key) {
		$result = '';
		$string = base64_decode($string);
		for($i=0; $i<strlen($string); $i++) {
		   $char = substr($string, $i, 1);
		   $keychar = substr($key, ($i % strlen($key))-1, 1);
		   $char = chr(ord($char)-ord($keychar));
		   $result.=$char;
		}
		return $result;
	 }

}