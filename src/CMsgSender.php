<?php
namespace dekuan\demsgsender;


use dekuan\vdata\CConst;
use dekuan\vdata\CRequest;
use dekuan\delib\CLib;


/**
 *	class of CMsgSender
 */
class CMsgSender
{
	//	...
	const CFG_DEFAULT_TIME_OUT		= 5;

	//	...
	const SERVICE_URL			= 'http://msgsender.service.yunkuan.org/sms';
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
	public function Send( $nChannel, $sMobileNumber, $sTemplateCode, $arrData, $sApiKey )
	{
		//
		//	nChannel	- [in] int	channel
		//	sMobileNumber	- [in] string	the number of mobile phone
		//	sTemplateCode	- [in] string	tmp code
		//	arrData		- [in] array	data
		//					[
		//						'code'	=> 356788,
		//						'title'	=> '打死也不要告诉别人的验证码'
		//					]
		//	sApiKey		- [in] string	api key
		//	RETURN		- error id
		//
		$nRet		= CConst::ERROR_UNKNOWN;
		$cRequest	= CRequest::GetInstance();

		if ( ! $this->IsValidChannel( $nChannel ) )
		{
			return CConst::ERROR_PARAMETER;
		}
		if ( ! CLib::IsExistingString( $sMobileNumber ) )
		{
			return CConst::ERROR_PARAMETER;
		}
		if ( ! is_array( $arrData ) )
		{
			return CConst::ERROR_PARAMETER;
		}
		if ( ! CLib::IsExistingString( $sApiKey ) )
		{
			return CConst::ERROR_PARAMETER;
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
							'channel'	=> intval( $nChannel ),
							'mobile'	=> strval( $sMobileNumber ),
							'tplcode'	=> $sTemplateCode,
							'replace'	=> $sData,
							'apikey'	=> $sApiKey,
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
				$nRet = CConstMsgSender::MSGSENDER_ERROR_MOBILE_NUM;
			}
		}
		catch ( \Exception $e )
		{
			$nRet = CConst::ERROR_EXCEPTION;
		}

		return $nRet;
	}


	public function IsValidChannel( $nChannel )
	{
		return ( is_numeric( $nChannel ) &&
			$nChannel >= CConstMsgSender::CHANNEL_MIN_VALUE &&
			$nChannel <= CConstMsgSender::CHANNEL_MAX_VALUE );
	}

}