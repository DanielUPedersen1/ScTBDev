<?php
/*
 *	ScTBDev - A bittorrent tracker source based on SceneTorrents.org
 *	Copyright (C) 2005-2010 ScTBDev.ca
 *
 *	This file is part of ScTBDev.
 *
 *	ScTBDev is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation, either version 3 of the License, or
 *	(at your option) any later version.
 *
 *	ScTBDev is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *
 *	You should have received a copy of the GNU General Public License
 *	along with ScTBDev.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(__DIR__.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'bittorrent.php');

dbconn();
loggedinorreturn();


header('Content-Type: text/plain');
$name = isset($_GET['name']) ? trim($_GET['name']) : '';

if (!$name)
	die('0');

$q = bt_sql::query('SELECT `id` FROM `torrents` WHERE `name` = '.bt_sql::esc($name));
if (!$q->num_rows)
	die('0');

$torrent = $q->fetch_row();
$q->free();
$id = $torrent[0];
die($id);
?>
