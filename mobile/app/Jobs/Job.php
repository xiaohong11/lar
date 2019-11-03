<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Jobs;

abstract class Job implements \Illuminate\Contracts\Queue\ShouldQueue
{
	use \Illuminate\Queue\InteractsWithQueue, \Illuminate\Bus\Queueable, \Illuminate\Queue\SerializesModels;
}

?>
