<?php

namespace App\Traits;

use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Api Responser Trait
|--------------------------------------------------------------------------
|
| This trait will be used for any response we sent to clients.
|
*/

trait GenerateCorrelative
{
	/**
     * Return a success JSON response.
     *
     * @param  array|string  $data
     * @param  string  $message
     * @param  int|null  $code
     * @return \Illuminate\Http\JsonResponse
     */
	protected function generate($lastCorrelative)
	{
		if (!$lastCorrelative) {
			return 'OST-80-23001';
		}

		$lastNumbers = substr($lastCorrelative,9);

		$year = Carbon::now()->format('y');
		if ($lastNumbers) {

			$lastNumbers = str_pad(++$lastNumbers,3,"0",STR_PAD_LEFT);

			return "OST-80-{$year}{$lastNumbers}";

		}else{
			return "OST-80-{$year}001";
		}
	}
}
