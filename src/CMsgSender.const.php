<?php

namespace dekuan\demsgsender;

use dekuan\vdata\CConst;


class CMsgSenderConst
{
	//	...
	const CHANNEL_MIN_VALUE			= 1;
	const CHANNEL_ALI_DAYU			= 1;
	const CHANNEL_MAX_VALUE			= 1;


	//	...
	const MSGSENDER_ERROR_API_KEY			= CConst::ERROR_USER_START + 100;	//	-1
	const MSGSENDER_ERROR_MOBILE_NUM		= CConst::ERROR_USER_START + 105;	//	-2
	const MSGSENDER_ERROR_CONTENT_EMPTY		= CConst::ERROR_USER_START + 110;	//	-3
	const MSGSENDER_ERROR_CONTENT_TOO_LONGER	= CConst::ERROR_USER_START + 115;	//	-4
	const MSGSENDER_ERROR_SYSTEM			= CConst::ERROR_USER_START + 120;	//	-5
	const MSGSENDER_ERROR_CURL_NOT_INSTALL		= CConst::ERROR_USER_START + 121;	//
	const MSGSENDER_ERROR_MOBILE_IN_BLACK		= CConst::ERROR_USER_START + 125;	//	-6
	const MSGSENDER_ERROR_SEND_TOO_MORE		= CConst::ERROR_USER_START + 130;	//	-7
	const MSGSENDER_ERROR_SMS_CONNECT		= CConst::ERROR_USER_START + 140;	//	-9
	const MSGSENDER_ERROR_ACCOUNT_OUTAGE		= CConst::ERROR_USER_START + 145;	//	-10
	const MSGSENDER_ERROR_ACCOUNT_OVERDUE		= CConst::ERROR_USER_START + 150;	//	-11
	const MSGSENDER_ERROR_MOBILE_EMPTY		= CConst::ERROR_USER_START + 160;	//	-12
	const MSGSENDER_ERROR_SEND_LIMIT_PER_MOBILE	= CConst::ERROR_USER_START + 165;	//	-13

	const MSGSENDER_ERROR_SMS_TIMEOUT		= CConst::ERROR_USER_START + 175;	//	-15
	const MSGSENDER_ERROR_LOST_TAG			= CConst::ERROR_USER_START + 180;	//	-50
	const MSGSENDER_ERROR_IP_LIMIT			= CConst::ERROR_USER_START + 185;	//	-51
	const MSGSENDER_ERROR_CONTENT_ILLEGAL		= CConst::ERROR_USER_START + 190;	//	99

	const MSGSENDER_ERROR_CURL_INIT			= CConst::ERROR_USER_START + 170;	//	-14
	const MSGSENDER_ERROR_CURL_REQUEST_TIMEOUT	= CConst::ERROR_USER_START + 195;	//	98
	const MSGSENDER_ERROR_CURL_CONNECT_ERROR	= CConst::ERROR_USER_START + 200;	//	97
	const MSGSENDER_ERROR_CURL_POST			= CConst::ERROR_USER_START + 260;	//	200

	const MSGSENDER_ERROR_WAY			= CConst::ERROR_USER_START + 220;	//	102
	const MSGSENDER_ERROR_TMPLATE			= CConst::ERROR_USER_START + 225;	//	103
	const MSGSENDER_ERROR_TMPLATE_LOST_PARA		= CConst::ERROR_USER_START + 235;	//	105
	const MSGSENDER_ERROR_MOBILE_NUM_MORE		= CConst::ERROR_USER_START + 230;	//	104

	const MSGSENDER_ERROR_GET_CONFIG		= CConst::ERROR_USER_START + 240;	//	106
	const MSGSENDER_ERROR_SEND_FREQUENT		= CConst::ERROR_USER_START + 245;	//	107

	//	...
	const MSGSENDER_ERROR_CHANNEL			= CConst::ERROR_USER_START + 300;	//	300
}