<?php

@ ini_set( 'date.timezone', 'Etc/GMT＋0' );
@ date_default_timezone_set( 'Etc/GMT＋0' );

@ ini_set( 'display_errors',	'on' );
@ ini_set( 'max_execution_time',	'60' );
@ ini_set( 'max_input_time',	'0' );
@ ini_set( 'memory_limit',	'512M' );

//	mb 环境定义
mb_internal_encoding( "UTF-8" );

//	Turn on output buffering
ob_start();


require_once( dirname( __DIR__ ) . "/vendor/autoload.php" );
require_once( dirname( __DIR__ ) . "/vendor/dekuan/delib/src/CLib.php" );
require_once( dirname( __DIR__ ) . "/vendor/dekuan/vdata/src/CConst.php" );
require_once( dirname( __DIR__ ) . "/src/CMessageSender.php" );



use dekuan\demsgsender\CMessageSender;


/**
 *	class
 */
class CTestSendMsg extends PHPUnit_Framework_TestCase
{
	/**
	 * @runInSeparateProcess
	 */
	public function testSender()
	{
	}
}
