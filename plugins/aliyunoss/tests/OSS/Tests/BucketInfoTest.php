<?php
//源码由旺旺:ecshop2012所有 未经允许禁止倒卖 一经发现停止任何服务
namespace OSS\Tests;

class BucketInfoTest extends \PHPUnit_Framework_TestCase
{
	public function testConstruct()
	{
		$bucketInfo = new \OSS\Model\BucketInfo('cn-beijing', 'name', 'today');
		$this->assertNotNull($bucketInfo);
		$this->assertEquals('cn-beijing', $bucketInfo->getLocation());
		$this->assertEquals('name', $bucketInfo->getName());
		$this->assertEquals('today', $bucketInfo->getCreateDate());
	}
}

?>
