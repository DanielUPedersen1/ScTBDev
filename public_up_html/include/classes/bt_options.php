<?php
/*
 *	ScTBDev - A bittorrent tracker source based on SceneTorrents.org
 *	Copyright (C) 2005-2010 ScTBDev.ca
 *
 *	This program is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation, either version 3 of the License, or
 *	(at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *
 *	You should have received a copy of the GNU General Public License
 *	along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(__DIR__.DIRECTORY_SEPARATOR.'class_config.php');
require_once(INCL_PATH.'define_bits.php');

class bt_options {
	/* USER FLAGS */
	const USER_CONFIRMED			= BIT_1;	// status				confirmed account?
	const USER_ANON				= BIT_2;	// privacy				hide seeding/leeching torrents (anonymous)
	const USER_ACCEPT_PMS			= BIT_3;	// acceptpms			allow pms from everybody?
	const USER_ACCEPT_FRIEND_PMS	= BIT_4;	// acceptfriendpms		allow pms from friends?
	const USER_AVATAR_PO			= BIT_5;	// avatar_po			my avatar is potentially offensive
//	const USER_DST					= BIT_6;	// dst					daylight savings
	const USER_PM_NOTIFICATION		= BIT_7;	// pmnotif				email notification of pms
	const USER_ENABLED				= BIT_8;	// enabled				enabled account?
	const USER_SHOW_AVATARS		= BIT_9;	// avatars				show avatars
	const USER_SHOW_PO_AVATARS		= BIT_10;	// avatars_po			show potentially offensive avatars
	const USER_DONOR				= BIT_11;	// donor				user has donated
	const USER_WARNED				= BIT_12;	// warned				user is warned
	const USER_DELETE_PMS			= BIT_13;	// deletepms			default to deleting pms from inbox on reply
	const USER_SAVE_PMS			= BIT_14;	// savepms				default to saving sent pms to sentbox
	const USER_SSL_SITE			= BIT_15;	// ssl_site				force use of ssl, redirect from http to https
	const USER_PROTECT				= BIT_16;	// protect				protect users ip, don't store it in the database
	const USER_HIDE_STATS			= BIT_17;	// hide_stats			hide upload/download/class/ratio
	const USER_LOG_USER			= BIT_18;	// log					log everything the user does (really messy atm)
	const USER_UPLOADER			= BIT_19;	// uploader				user is an uploader on the uploader list
	const USER_FIRST_LINE_SUPPORT	= BIT_20;	// fls					user is first line support
	const USER_STATBAR				= BIT_21;	// statbar				show statbar
	const USER_POST_ENABLE			= BIT_22;	// post_enable			enable forum posting
	const USER_IRC_ENABLE			= BIT_23;	// irc_enable			allow in irc channels
	const USER_PROXY_TRACKER		= BIT_24;	// proxy				enable proxy option for tracker
	const USER_SSL_TRACKER			= BIT_25;	// ssl_tracker			enable ssl tracker
	const USER_BYPASS_BANS			= BIT_26;	// bypass_ban			allows a user to bypass bans
	const USER_HIDE_LAST_SEEN		= BIT_27;	// hide_last_seen		hide last seen time from other users
	const USER_DISABLE_INVITE_BUY	= BIT_28;	// disable_invites		disable buying of invites
	const USER_PROBED				= BIT_29;	//
	const USER_CONNECTABLE			= BIT_30;	//
//	const USER_UNALLOCATED31		= BIT_31;	//
//	const USER_UNALLOCATED32		= BIT_32;	//

//	const USER_UNALLOCATED33		= BIT_33;	//
//	const USER_UNALLOCATED34		= BIT_34;	//
//	const USER_UNALLOCATED35		= BIT_35;	//
//	const USER_UNALLOCATED36		= BIT_36;	//
//	const USER_UNALLOCATED37		= BIT_37;	//
//	const USER_UNALLOCATED38		= BIT_38;	//
//	const USER_UNALLOCATED39		= BIT_39;	//
//	const USER_UNALLOCATED40		= BIT_40;	//
//	const USER_UNALLOCATED41		= BIT_41;	//
//	const USER_UNALLOCATED42		= BIT_42;	//
//	const USER_UNALLOCATED43		= BIT_43;	//
//	const USER_UNALLOCATED44		= BIT_44;	//
//	const USER_UNALLOCATED45		= BIT_45;	//
//	const USER_UNALLOCATED46		= BIT_46;	//
//	const USER_UNALLOCATED47		= BIT_47;	//
//	const USER_UNALLOCATED48		= BIT_48;	//
//	const USER_UNALLOCATED49		= BIT_49;	//
//	const USER_UNALLOCATED50		= BIT_50;	//
//	const USER_UNALLOCATED51		= BIT_51;	//
//	const USER_UNALLOCATED52		= BIT_52;	//
	const USER_FORUM_ICONS_1		= BIT_53;	// forum_1				forum_1-4 used for button selection in forums
	const USER_FORUM_ICONS_2		= BIT_54;	// forum_2				"
	const USER_FORUM_ICONS_3		= BIT_55;	// forum_3				"
	const USER_FORUM_ICONS_4		= BIT_56;	// forum_4				"
//	const USER_UNALLOCATED57		= BIT_57;	//
//	const USER_UNALLOCATED58		= BIT_58;	//
//	const USER_UNALLOCATED59		= BIT_59;	//
//	const USER_UNALLOCATED60		= BIT_60;	//
//	const USER_UNALLOCATED61		= BIT_61;	//
//	const USER_UNALLOCATED62		= BIT_62;	//
//	const USER_UNALLOCATED63		= BIT_63;	//
//	const USER_UNALLOCATED64		= BIT_64;	//


	/* TORRENT FLAGA */
	const TORRENT_VISIBLE				= BIT_1;
	const TORRENT_MULTIFILE				= BIT_2;
	const TORRENT_BANNED				= BIT_3;
//	const TORRENT_UNALLOCATED4			= BIT_4;
//	const TORRENT_UNALLOCATED5			= BIT_5;
//	const TORRENT_UNALLOCATED6			= BIT_6;
//	const TORRENT_UNALLOCATED7			= BIT_7;
//	const TORRENT_UNALLOCATED8			= BIT_8;
}
?>
