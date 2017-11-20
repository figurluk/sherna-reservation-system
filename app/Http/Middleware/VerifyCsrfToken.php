<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Illuminate\Support\Str;

class VerifyCsrfToken extends BaseVerifier
{
	/**
	 * The URIs that should be excluded from CSRF verification.
	 *
	 * @var array
	 */
	protected $except = [
		'admin/sumernote/saveImage',
		'api/reservation/check',
		'reservation/check',
	];
	
	protected function inExceptArray( $request )
	{
		foreach ($this->except as $except) {
			if ($except !== '/') {
				$except = trim($except, '/');
			}
			
			if ($request->is($except) || $request->getHost() == 'api.sherna.siliconhill.cz' || $request->getHost() == 'api.sherna.sh.cvut.cz') {
				return true;
			}
		}
		
		return false;
	}
}
