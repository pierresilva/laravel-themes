<?php
namespace pierresilva\LaravelThemes\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelTheme extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'themes';
	}
}