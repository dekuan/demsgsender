<?php

require_once( dirname( __DIR__ ) . "/vendor/autoload.php" );
require_once( dirname( __DIR__ ) . "/vendor/dekuan/delib/src/CLib.php" );
require_once( dirname( __DIR__ ) . "/vendor/dekuan/vdata/src/CConst.php" );
require_once( dirname( __DIR__ ) . "/vendor/dekuan/vdata/src/CCors.php" );
require_once( dirname( __DIR__ ) . "/vendor/dekuan/vdata/src/CVData.php" );
require_once( dirname( __DIR__ ) . "/vendor/dekuan/vdata/src/CRequest.php" );
require_once( dirname( __DIR__ ) . "/src/CMsgSender.const.php" );
require_once( dirname( __DIR__ ) . "/src/CMsgSender.php" );



use dekuan\demsgsender\CMsgSender;


/**
 *	class
 */
class CTestSendMsg extends PHPUnit_Framework_TestCase
{
	public function testSenderMsg()
	{

	}
}
