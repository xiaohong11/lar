<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Http\Middleware;

class Authenticate
{
	/**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
	protected $auth;

	public function __construct(\Illuminate\Contracts\Auth\Factory $auth)
	{
		$this->auth = $auth;
	}

	public function handle($request, \Closure $next, $guard = NULL)
	{
		if ($this->auth->guard($guard)->guest()) {
			return response('Unauthorized.', 401);
		}

		return $next($request);
	}
}


?>
