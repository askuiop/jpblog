<?php
/**
 * Created by PhpStorm.
 * User: jims
 * Date: 16-9-6
 * Time: 下午4:41
 */

namespace Jims\MsgQueueBundle\Service;


class DaemonLog
{
	/**
	 * System is unusable (will throw a self_Exception as well)
	 */
	const LOG_EMERG = 0;

	/**
	 * Immediate action required (will throw a self_Exception as well)
	 */
	const LOG_ALERT = 1;

	/**
	 * Critical conditions (will throw a self_Exception as well)
	 */
	const LOG_CRIT = 2;

	/**
	 * Error conditions
	 */
	const LOG_ERR = 3;

	/**
	 * Warning conditions
	 */
	const LOG_WARNING = 4;

	/**
	 * Normal but significant
	 */
	const LOG_NOTICE = 5;

	/**
	 * Informational
	 */
	const LOG_INFO = 6;

	/**
	 * Debug-level messages
	 */
	const LOG_DEBUG = 7;

	/**
	 * Available log levels
	 *
	 * @var array
	 */
	static protected $_logLevels = array(
		self::LOG_EMERG   => 'emerg',
		self::LOG_ALERT   => 'alert',
		self::LOG_CRIT    => 'crit',
		self::LOG_ERR     => 'err',
		self::LOG_WARNING => 'warning',
		self::LOG_NOTICE  => 'notice',
		self::LOG_INFO    => 'info',
		self::LOG_DEBUG   => 'debug',
	);
	
	/**
	 * Logging shortcut
	 *
	 * @return boolean
	 */
	public static function emerg()
	{
		$arguments = func_get_args(); array_unshift($arguments, __FUNCTION__);
		call_user_func_array(array(self::class, '_ilog'), $arguments);
		return false;
	}

	/**
	 * Logging shortcut
	 *
	 * @return boolean
	 */
	public static function alert()
	{
		$arguments = func_get_args(); array_unshift($arguments, __FUNCTION__);
		call_user_func_array(array(self::class, '_ilog'), $arguments);
		return false;
	}

	/**
	 * Logging shortcut
	 *
	 * @return boolean
	 */
	public static function crit()
	{
		$arguments = func_get_args(); array_unshift($arguments, __FUNCTION__);
		call_user_func_array(array(self::class, '_ilog'), $arguments);
		return false;
	}

	/**
	 * Logging shortcut
	 *
	 * @return boolean
	 */
	public static function err()
	{
		$arguments = func_get_args(); array_unshift($arguments, __FUNCTION__);
		call_user_func_array(array(self::class, '_ilog'), $arguments);
		return false;
	}

	/**
	 * Logging shortcut
	 *
	 * @return boolean
	 */
	public static function warning()
	{
		$arguments = func_get_args(); array_unshift($arguments, __FUNCTION__);
		call_user_func_array(array(self::class, '_ilog'), $arguments);
		return false;
	}

	/**
	 * Logging shortcut
	 *
	 * @return boolean
	 */
	public static function notice()
	{
		$arguments = func_get_args(); array_unshift($arguments, __FUNCTION__);
		call_user_func_array(array(self::class, '_ilog'), $arguments);
		return true;
	}

	/**
	 * Logging shortcut
	 *
	 * @return boolean
	 */
	public static function info()
	{
		$arguments = func_get_args(); array_unshift($arguments, __FUNCTION__);
		call_user_func_array(array(self::class, '_ilog'), $arguments);
		return true;
	}

	/**
	 * Logging shortcut
	 *
	 * @return boolean
	 */
	public static function debug()
	{
		$arguments = func_get_args(); array_unshift($arguments, __FUNCTION__);
		call_user_func_array(array(self::class, '_ilog'), $arguments);
		return true;
	}

	/**
	 * Internal logging function. Bridge between shortcuts like:
	 * err(), warning(), info() and the actual log() function
	 *
	 * @param mixed $level As string or constant
	 * @param mixed $str   Message
	 *
	 * @return boolean
	 */
	protected static function _ilog($level, $str)
	{
		$arguments = func_get_args();
		$level     = $arguments[0];
		$format    = $arguments[1];

		if (is_string($level)) {
			if (false === ($l = array_search($level, self::$_logLevels))) {
				self::log(LOG_EMERG, 'No such loglevel: '. $level);
			} else {
				$level = $l;
			}
		}

		unset($arguments[0]);
		unset($arguments[1]);

		$str = $format;
		if (count($arguments)) {
			foreach ($arguments as $k => $v) {
				$arguments[$k] = self::semantify($v);
			}
			$str = vsprintf($str, $arguments);
		}

		self::_optionObjSetup();
		$str = preg_replace_callback(
			'/\{([^\{\}]+)\}/is',
			array(self::$_optObj, 'replaceVars'),
			$str
		);


		$history  = 2;
		$dbg_bt   = @debug_backtrace();
		$class    = (string)@$dbg_bt[($history-1)]['class'];
		$function = (string)@$dbg_bt[($history-1)]['function'];
		$file     = (string)@$dbg_bt[$history]['file'];
		$line     = (string)@$dbg_bt[$history]['line'];
		return self::log($level, $str, $file, $class, $function, $line);
	}

	/**
	 * Almost every deamon requires a log file, this function can
	 * facilitate that. Also handles class-generated errors, chooses
	 * either PEAR handling or PEAR-independant handling, depending on:
	 * self::opt('usePEAR').
	 * Also supports PEAR_Log if you referenc to a valid instance of it
	 * in self::opt('usePEARLogInstance').
	 *
	 * It logs a string according to error levels specified in array:
	 * self::$_logLevels (0 is fatal and handles daemon's death)
	 *
	 * @param integer $level    What function the log record is from
	 * @param string  $str      The log record
	 * @param string  $file     What code file the log record is from
	 * @param string  $class    What class the log record is from
	 * @param string  $function What function the log record is from
	 * @param integer $line     What code line the log record is from
	 *
	 * @throws self_Exception
	 * @return boolean
	 * @see _logLevels
	 * @see logLocation
	 */
	static public function log ($level, $str, $file = false, $class = false, $function = false, $line = false) {
		// If verbosity level is not matched, don't do anything
		if (null === self::opt('logVerbosity')
			|| false === self::opt('logVerbosity')
		) {
			// Somebody is calling log before launching daemon..
			// fair enough, but we have to init some log options
			self::_optionsInit(true);
		}
		if (!self::opt('appName')) {
			// Not logging for anything without a name
			return false;
		}

		if ($level > self::opt('logVerbosity')) {
			return true;
		}

		// Make the tail of log massage.
		$log_tail = '';
		if ($level < self::LOG_NOTICE) {
			if (self::opt('logFilePosition')) {
				if (self::opt('logTrimAppDir')) {
					$file = substr($file, strlen(self::opt('appDir')));
				}

				$log_tail .= ' [f:'.$file.']';
			}
			if (self::opt('logLinePosition')) {
				$log_tail .= ' [l:'.$line.']';
			}
		}


		if (false !== ($cb = self::opt('useCustomLogHandler'))) {
			if (!is_callable($cb)) {
				throw new self_Exception('Your "useCustomLogHandler" ' .
					' is not callable');
			}
			call_user_func($cb, $str . $log_tail, $level);
			return true;
		}

		// Save resources if arguments are passed.
		// But by falling back to debug_backtrace() it still works
		// if someone forgets to pass them.
		if (function_exists('debug_backtrace') && (!$file || !$line)) {
			$dbg_bt   = @debug_backtrace();
			$class    = (isset($dbg_bt[1]['class'])?$dbg_bt[1]['class']:'');
			$function = (isset($dbg_bt[1]['function'])?$dbg_bt[1]['function']:'');
			$file     = @$dbg_bt[0]['file'];
			$line     = @$dbg_bt[0]['line'];
		}

		// Determine what process the log is originating from and forge a logline
		//$str_ident = '@'.substr(self::_whatIAm(), 0, 1).'-'.posix_getpid();
		$str_date  = '[' . date('M d H:i:s') . ']';
		$str_level = str_pad(self::$_logLevels[$level] . '', 8, ' ', STR_PAD_LEFT);
		$log_line  = $str_date . ' ' . $str_level . ': ' . $str . $log_tail; // $str_ident

		$non_debug      = ($level < self::LOG_DEBUG);
		$log_succeeded = true;
		$log_echoed     = false;

		if (!self::isInBackground() && $non_debug && !$log_echoed) {
			// It's okay to echo if you're running as a foreground process.
			// Maybe the command to write an init.d file was issued.
			// In such a case it's important to echo failures to the
			// STDOUT
			echo $log_line . "\n";
			$log_echoed = true;
			// but still try to also log to file for future reference
		}

		if (!self::opt('logLocation')) {
			throw new self_Exception('Either use PEAR Log or specify '.
				'a logLocation');
		}

		// 'Touch' logfile
		if (!file_exists(self::opt('logLocation'))) {
			file_put_contents(self::opt('logLocation'), '');
		}

		// Not writable even after touch? Allowed to echo again!!
		if (!is_writable(self::opt('logLocation'))
			&& $non_debug && !$log_echoed
		) {
			echo $log_line . "\n";
			$log_echoed    = true;
			$log_succeeded = false;
		}

		// Append to logfile
		$f = file_put_contents(
			self::opt('logLocation'),
			$log_line . "\n",
			FILE_APPEND
		);
		if (!$f) {
			$log_succeeded = false;
		}

		// These are pretty serious errors
		if ($level < self::LOG_ERR) {
			// An emergency logentry is reason for the deamon to
			// die immediately
			if ($level === self::LOG_EMERG) {
				self::_die();
			}
		}

		return $log_succeeded;
	}
}