<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Http\Middleware;

class ExampleMiddleware
{
	public function handle($request, \Closure $next)
	{
		return $next($request);
	}
}


?>
