<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Console;

class Kernel extends \Laravel\Lumen\Console\Kernel
{
	/**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
	protected $commands = array('App\\Console\\Commands\\RestoreModels');

	protected function schedule(\Illuminate\Console\Scheduling\Schedule $schedule)
	{
	}
}

?>
