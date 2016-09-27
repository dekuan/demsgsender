<?php
namespace dekuan\demsgsender;


use dekuan\vdata\CRequest;
use dekuan\vdata\CConst;
use dekuan\delib\CLib;


/**
 *	class of CMessageSender
 */
class CMessageSender
{
	const CODE_REMOTE_APIK_ERROR		= -1;
	const CODE_MOBILE_NUM_ERROR		= -2;
	const CODE_CONTENT_EMPTY		= -3;
	const CODE_CONTENT_TOO_LONGER		= -4;
	const CODE_SYSTEM_ERROR			= -5;
	const CODE_MOBILE_IN_BLACK		= -6;
	const CODE_SEND_TOO_MORE		= -7;
	const CODE_APIK_ERROR			= -8;
	const CODE_SMS_CONNECT_ERROR		= -9;
	const CODE_ACCOUN_OUTAGE		= -10;
	const CODE_ACCOUNT_OVERDUE		= -11;
	const CODE_MOBILE_EMPTY			= -12;
	const CODE_SEND_LIMIT_FOR_ONE_MOBILE	= -13;
	const CODE_CLIENT_CURL_INIT_ERROR	= -14;
	const CODE_SMS_TIMEOUT			= -15;
	const CODE_CONTENT_ILLEGAL		= 99;
	const CODE_REMOTE_TIMEOUT		= 98;
	const CODE_REMOTE_CONNECT_ERROR		= 97;
	const CODE_REMOTE_CURL_INIT_ERROR	= 96;
	const CODE_ERROR_INPUT_PARA		= 101;

	//	...
	const SERVICE_URL			= 'http://msgsender.service.yunkuan.org/sendmessage';
	const SERVICE_TIMEOUT			=  5;


	//	...
	private static $g_cStaticInstance;


	public static function getInstance()
	{
		if ( is_null( self::$g_cStaticInstance ) || ! isset( self::$g_cStaticInstance ) )
		{
			self::$g_cStaticInstance = new self();
		}
		return self::$g_cStaticInstance;
	}

	//
	//	send sms message
	//
	public function Send( $sMobileNumber, $sTemplateCode, $arrData, $sApiKey )
	{
		//
		//	sMobileNumber	- [in] string	the number of mobile phone
		//	sTemplateCode	- [in] string	tmp code
		//	arrData		- [in] array	data
		//	sApiKey		- [in] string	api key
		//	RETURN		- error id
		//
		$nRet		= CConst::ERROR_UNKNOWN;
		$cRequest	= CRequest::GetInstance();

		if ( ! CLib::IsExistingString( $sMobileNumber ) )
		{
			return self::CODE_ERROR_INPUT_PARA;
		}
		if ( ! is_array( $arrData ) )
		{
			return self::CODE_ERROR_INPUT_PARA;
		}
		if ( ! CLib::IsExistingString( $sApiKey ) )
		{
			return self::CODE_ERROR_INPUT_PARA;
		}


		//	...
		try
		{
			if ( CLib::IsValidMobile ( $sMobileNumber , true ) )
			{
				$sData		= json_encode( $arrData );
				$arrResponse	= [];
				$nRpcCall	= $cRequest->Post
				(
					[
						'url'		=> self::SERVICE_URL,
						'data'		=>
						[
							'mobile'	=> ( 'm' . $sMobileNumber ),
							'tmpcode'	=> $sTemplateCode,
							'replace'	=> $sData,
							'auth'		=> $sApiKey,
						],
						'version'	=> '1.0',
						'timeout'	=> self::SERVICE_TIMEOUT,
					],
					$arrResponse
				);
				if ( CConst::ERROR_SUCCESS == $nRpcCall )
				{
					if ( $cRequest->IsValidVData( $arrResponse ) )
					{
						$nRet = $arrResponse[ 'errorid' ];
					}
					else
					{
						$nRet = CConst::ERROR_JSON;
					}
				}
				else
				{
					$nRet = $nRpcCall;
				}
			}
			else
			{
				$nRet = self::CODE_MOBILE_NUM_ERROR;
			}
		}
		catch ( \Exception $e )
		{
			$nRet = CConst::ERROR_EXCEPTION;
		}

		return $nRet;
	}
}