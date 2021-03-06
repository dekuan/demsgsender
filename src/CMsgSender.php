<?php
namespace dekuan\demsgsender;


use dekuan\vdata\CConst;
use dekuan\vdata\CRequest;
use dekuan\delib\CLib;


/**
 *	class of CMsgSender
 */
class CMsgSender extends CMsgSenderConst
{
	//
	//	...
	//
	const CFG_DEFAULT_TIME_OUT		= 5;	//	in seconds

	//	...
	const DEFAULT_SERVICE_URL		= 'http://msgsender.service.yunkuan.org/sms';
	const DEFAULT_SERVICE_TIMEOUT		=  5;		//	in seconds
	const DEFAULT_SERVICE_VERSION		=  '1.0';	//	default version


	//
	//	static
	//
	private static $g_cStaticInstance;

	//
	//	private
	//
	private $m_sServiceUrl;
	private $m_sServiceTimeout;


	public function __construct()
	{
		$this->m_sServiceUrl		= self::DEFAULT_SERVICE_URL;
		$this->m_sServiceTimeout	= self::DEFAULT_SERVICE_TIMEOUT;
	}
	public static function GetInstance()
	{
		if ( is_null( self::$g_cStaticInstance ) || ! isset( self::$g_cStaticInstance ) )
		{
			self::$g_cStaticInstance = new self();
		}
		return self::$g_cStaticInstance;
	}


	//
	//	Set services url
	//
	public function SetServiceUrl( $sUrl )
	{
		//
		//	sUrl	- [in] string	The new services url
		//	RETURN	- boolean
		//
		$bRet	= false;

		if ( CLib::IsExistingString( $sUrl ) )
		{
			$bRet = true;
			$this->m_sServiceUrl = $sUrl;
		}

		return $bRet;
	}

	//
	//	Set services calling timeout
	//
	public function SetServiceTimeout( $nTimeout )
	{
		//
		//	$nTimeout	- [in] int,	timeout in seconds
		//	RETURN		- boolean
		//
		$bRet	= false;

		if ( is_numeric( $nTimeout ) && $nTimeout > 0 )
		{
			$bRet = true;
			$this->m_sServiceTimeout = $nTimeout;
		}

		return $bRet;
	}


	//
	//	send verification code
	//
	public function SendVerifyCode( $nChannel, $sMobileNumber, $sCode, $sApiKey, $sVersion = self::DEFAULT_SERVICE_VERSION )
	{
		//
		//	nChannel	- [in] int	channel
		//	sMobileNumber	- [in] string
		//	sCode		- [in] array	verify code
		//	sApiKey		- [in] string	api key
		//	sVersion	- [in] string	required service version
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
		if ( ! CLib::IsExistingString( $sCode ) )
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
				$arrResponse	= [];
				$arrPostData	= $this->_GetPostDataByChannel( $nChannel, $sMobileNumber, $sCode, $sApiKey );
				$sVersion	= ( CLib::IsExistingString( $sVersion, true ) ? trim( $sVersion ) : self::DEFAULT_SERVICE_VERSION );
				$nRpcCall	= $cRequest->Post
				(
					[
						'url'		=> $this->m_sServiceUrl,
						'data'		=> $arrPostData,
						'version'	=> $sVersion,
						'timeout'	=> $this->m_sServiceTimeout,
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
				$nRet = self::MSGSENDER_ERROR_MOBILE_NUM;
			}
		}
		catch ( \Exception $e )
		{
			$nRet = CConst::ERROR_EXCEPTION;
		}

		return $nRet;
	}


	//
	//	is valid channel number
	//
	public function IsValidChannel( $nChannel )
	{
		return ( is_numeric( $nChannel ) &&
			$nChannel >= self::CHANNEL_MIN_VALUE &&
			$nChannel <= self::CHANNEL_MAX_VALUE );
	}



	////////////////////////////////////////////////////////////////////////////////
	//	Private
	//
	private function _GetPostDataByChannel( $nChannel, $sMobileNumber, $arrData, $sApiKey )
	{
		$arrRet	= [];

		if ( self::CHANNEL_ALI_DAYU == $nChannel )
		{
			$arrRet = $this->_GetPostDataByAliDaYu( $nChannel, $sMobileNumber, $arrData, $sApiKey );
		}

		return $arrRet;
	}

	//
	//	阿里大鱼数据格式
	//
	private function _GetPostDataByAliDaYu( $nChannel, $sMobileNumber, $sCode, $sApiKey )
	{
		return
		[
			'channel'	=> intval( $nChannel ),
			'mobile'	=> strval( $sMobileNumber ),
			'code'		=> $sCode,
			'apikey'	=> $sApiKey,
		];
	}
}