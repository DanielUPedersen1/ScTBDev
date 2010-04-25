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

require_once(__DIR__.DIRECTORY_SEPARATOR.'class_config.php');
require_once(CLASS_PATH.'bt_config.php');

class bt_memcache {
	public static $connected = false;
	private static $servers = array();
	private static $link = NULL;

	public static $count = 0;
	public static $time = 0.0;

	public static $errno = 0;
	public static $error = '';

	public static function set_servers(array $servers) {
		foreach ($servers as $server) {
			// no ip or port set, ignore this server
			if (!isset($server['ip']) || !isset($server['port']))
				continue;

			// if no weight is specified, assume its 1
			if (!isset($server['weight']))
				$server['weight'] = 1;

			// add server to the pool
			self::$servers[] = $server;
		}

		return !(empty(self::$servers));
	}

	public static function connect() {
		if (self::$connected)
			return true;

		// Connect using a persistent connection with the id "MC"
		self::$link = new Memcached('MC');

		// Set options
		if (Memcached::HAVE_IGBINARY) /* Use the igbinary serializer if its available, its much faster and more efficient */
			self::$link->setOption(Memcached::OPT_SERIALIZER, Memcached::SERIALIZER_IGBINARY);

		self::$link->setOption(Memcached::OPT_HASH, Memcached::HASH_MD5);
		self::$link->setOption(Memcached::OPT_DISTRIBUTION, Memcached::DISTRIBUTION_MODULA);
		self::$link->setOption(Memcached::OPT_NO_BLOCK, true);									/* non-blocking I/O */
		self::$link->setOption(Memcached::OPT_CONNECT_TIMEOUT, 50);							/* 50ms connect timeout */
		self::$link->setOption(Memcached::OPT_PREFIX_KEY, bt_config::$conf['memcache_prefix']);						/* set the key prefix */

		$status = count(self::$link->getServerList());
		if (!$status) {
			if (!self::set_servers(bt_config::$conf['memcache_servers'])) {
				trigger_error('Unable to set Memcache server(s) in '.__METHOD__, E_USER_WARNING);
				return false;
			}
			foreach (self::$servers as $server)
				$status += (int)self::$link->addServer($server['ip'], $server['port'], $server['weight']);
		}

		self::$connected = (bool)$status;
		return self::$connected;
	}

	public static function add($key, $var, $expire) {
		if (!self::$connected) {
			trigger_error('Not connected to Memcache server in '.__METHOD__.' KEY = "'.$key.'"', E_USER_WARNING);
			return false;
		}

		self::$count++;
		$time = microtime(true);
		$add = self::$link->add($key, $var, $expire);
		self::$time += (microtime(true) - $time);

		self::set_error(__METHOD__, $key);
		return $add;
	}

	public static function replace($key, $var, $expire) {
		if (!self::$connected) {
			trigger_error('Not connected to Memcache server in '.__METHOD__.' KEY = "'.$key.'"', E_USER_WARNING);
			return false;
		}

		self::$count++;
		$time = microtime(true);
		$replace = self::$link->replace($key, $var, $expire);
		self::$time += (microtime(true) - $time);

		self::set_error(__METHOD__, $key);
		return $replace;
	}

	public static function set($key, $var, $expire) {
		if (!self::$connected) {
			trigger_error('Not connected to Memcache server in '.__METHOD__.' KEY = "'.$key.'"', E_USER_WARNING);
			return false;
		}

		self::$count++;
		$time = microtime(true);
		$set = self::$link->set($key, $var, $expire);
		self::$time += (microtime(true) - $time);

		self::set_error(__METHOD__, $key);
		return $set;
	}

	public static function get($key) {
		if (!self::$connected) {
			trigger_error('Not connected to Memcache server in '.__METHOD__.' KEY = "'.$key.'"', E_USER_WARNING);
			return false;
		}

		self::$count++;
		$time = microtime(true);
		$get = self::$link->get($key);
		self::$time += (microtime(true) - $time);

		self::set_error(__METHOD__, $key);

		// New Memcached 2.0.0 PHP Module returns NULL on non-existant key.
		if ($get === NULL)
			return false;

		return $get;
	}

	public static function inc($key, $howmuch = 1) {
		if (!self::$connected) {
			trigger_error('Not connected to Memcache server in '.__METHOD__.' KEY = "'.$key.'"', E_USER_WARNING);
			return false;
		}

		self::$count++;
		$time = microtime(true);
		$inc = self::$link->increment($key, $howmuch);
		self::$time += (microtime(true) - $time);

		self::set_error(__METHOD__, $key);
		return $inc;
	}

	public static function dec($key, $howmuch = 1) {
		if (!self::$connected) {
			trigger_error('Not connected to Memcache server in '.__METHOD__.' KEY = "'.$key.'"', E_USER_WARNING);
			return false;
		}

		self::$count++;
		$time = microtime(true);
		$dec = self::$link->decrement($key, $howmuch);
		self::$time += (microtime(true) - $time);

		self::set_error(__METHOD__, $key);
		return $dec;
	}

	public static function append($key, $var) {
		if (!self::$connected) {
			trigger_error('Not connected to Memcache server in '.__METHOD__.' KEY = "'.$key.'"', E_USER_WARNING);
			return false;
		}

		self::$count++;
		$time = microtime(true);
		$append = self::$link->append($key, $var);
		self::$time += (microtime(true) - $time);

		self::set_error(__METHOD__, $key);
		return $append;
	}

	public static function prepend($key, $var) {
		if (!self::$connected) {
			trigger_error('Not connected to Memcache server in '.__METHOD__.' KEY = "'.$key.'"', E_USER_WARNING);
			return false;
		}

		self::$count++;
		$time = microtime(true);
		$prepend = self::$link->prepend($key, $var);
		self::$time += (microtime(true) - $time);

		self::set_error(__METHOD__, $key);
		return $prepend;
	}

	public static function del($key) {
		if (!self::$connected) {
			trigger_error('Not connected to Memcache server in '.__METHOD__.' KEY = "'.$key.'"', E_USER_WARNING);
			return false;
		}

		self::$count++;
		$time = microtime(true);
		$del = self::$link->delete($key);
		self::$time += (microtime(true) - $time);

		self::set_error(__METHOD__, $key);
		return $del;
	}

	public static function remove($key) {
		return self::del($key);
	}

	public static function clean() {
		if (!self::$connected) {
			trigger_error('Not connected to Memcache server in '.__METHOD__, E_USER_WARNING);
			return false;
		}

		self::$count++;
		$time = microtime(true);
		$clean = self::$link->flush();
		self::$time += (microtime(true) - $time);

		self::set_error(__METHOD__);
		return $clean;
	}

	public static function stats() {
		if (!self::$connected) {
			trigger_error('Not connected to Memcache server in '.__METHOD__, E_USER_WARNING);
			return false;
		}

		self::$count++;
		$time = microtime(true);
		$stats = self::$link->getStats();
		self::$time += (microtime(true) - $time);

		self::set_error(__METHOD__);
		return $stats;
	}

	public static function version() {
		if (!self::$connected) {
			trigger_error('Not connected to Memcache server in '.__METHOD__, E_USER_WARNING);
			return false;
		}

		$version = self::$link->getVersion();

		self::set_error(__METHOD__);
		return $version;
	}

	private static function set_error($method, $key = '') {
		self::$errno = self::$link->getResultCode();

		if (self::$errno) {
			self::$error = self::$link->getResultMessage();

			switch (self::$errno) {
				case Memcached::RES_NOTFOUND:
				case Memcached::RES_NOTSTORED:
					break;
				default:
					trigger_error('Error in '.$method.($key ? ' KEY "'.$key.'"' : '').' ['.self::$errno.']: '.
						self::$error, E_USER_WARNING);
					break;
			}
		}
		else
			self::$error = '';
	}
}
?>
