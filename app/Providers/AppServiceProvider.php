<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Query\Builder;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
		Builder::macro('fullSql', function () {
			$sql = str_replace(['%', '?'], ['%%', '%s'], $this->toSql());

			$handledBindings = array_map(function ($binding) {
				if (is_numeric($binding)) {
					return $binding;
				}

				$value = str_replace(['\\', "'"], ['\\\\', "\'"], $binding);

				return "'{$value}'";
			}, $this->getConnection()->prepareBindings($this->getBindings()));

			$fullSql = vsprintf($sql, $handledBindings);

			return $fullSql;
		});
		Builder::macro('ddd', function () {
			dd($this->fullSql());
		});
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
		Carbon::useMonthsOverflow(false);
        Carbon::useYearsOverflow(false);
		#\URL::forceScheme('https');
    }
}
