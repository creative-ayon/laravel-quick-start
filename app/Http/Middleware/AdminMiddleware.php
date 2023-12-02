<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Menu;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class AdminMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
	 * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
	 */
	public function handle(Request $request, Closure $next)
	{
		if (!Session::has('locale'))
		{
		   Session::put('locale',Config::get('app.locale'));
		}

		Config::set('app.locale',session('locale'));
		Carbon::setLocale(Config::get('app.locale'));

		// App::setLocale(session('locale'));
		
		// $notifications = $this->service->notifications();

		$alllanguages = \App\Models\Language::enabled()->get();
		
		$dropdown = $alllanguages->where('code','!=',session('locale'))->all();
		$clang = $alllanguages->where('code',session('locale'))->first();

		$parentMenus = Menu::whereNull('parent_id')->with(['menuDetails' => function($query){
													$query->where('language_id', session('locale'));
												}], 'children', 'children.menuDetails')->where('menu_position', '2');

		$parentMenus = $parentMenus->with('children.menuDetails', function($query){
			$query->where('language_id', session('locale'));
		});

		$parentMenus = $parentMenus->orderBy('sortorder')->get();

		$userPermissions = Auth::user()->getAllPermissions()->pluck('name')->toArray();

		View::share('headerlanguages', $dropdown);
		View::share('languages', $alllanguages);
		View::share('clang', $clang);
		View::share(['parentMenus' => $parentMenus, 'userPermissions' => $userPermissions]);
		
		return $next($request);
	}
}
