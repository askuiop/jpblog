<?php
/**
 * Created by PhpStorm.
 * User: jims
 * Date: 16-9-5
 * Time: 上午11:37
 */

namespace Jims\MsgQueueBundle\Service;



class OptionDefinitions
{
	public static function getDefaultOption()
	{
		return array(
			'useCustomLogHandler' => array(
				'type' => 'boolean|object',
				'default' => false,
				'punch' => 'Accepts any callable method to handle all logging',
				'detail' => 'This will replace System_Daemon\'s own logging facility',
				'required' => true,
			),

			'authorName' => array(
				'type' => 'string/0-50',
				'punch' => 'Author name',
				'example' => 'Kevin van zonneveld',
				'detail' => 'Required for forging init.d script',
			),
			'authorEmail' => array(
				'type' => 'string/email',
				'punch' => 'Author e-mail',
				'example' => 'kevin@vanzonneveld.net',
				'detail' => 'Required for forging init.d script',
			),
			'appName' => array(
				'type' => 'string/unix',
				'punch' => 'The application name',
				'example' => 'logparser',
				'detail' => 'Must be UNIX-proof; Required for running daemon',
				'required' => true,
			),
			'appDescription' => array(
				'type' => 'string',
				'punch' => 'Daemon description',
				'example' => 'Parses logfiles of vsftpd and stores them in MySQL',
				'detail' => 'Required for forging init.d script',
			),
			'appDir' => array(
				'type' => 'string/existing_dirpath',
				'default' => '@dirname({SERVER.SCRIPT_NAME})',
				'punch' => 'The home directory of the daemon',
				'example' => '/usr/local/logparser',
				'detail' => 'Highly recommended to set this yourself',
				'required' => true,
			),
			'appExecutable' => array(
				'type' => 'string/existing_filepath',
				'default' => '@basename({SERVER.SCRIPT_NAME})',
				'punch' => 'The executable daemon file',
				'example' => 'logparser.php',
				'detail' => 'Recommended to set this yourself; Required for init.d',
				'required' => true
			),

			'logVerbosity' => array(
				'type' => 'number/0-7',
				'default' => Daemon::LOG_INFO,
				'punch' => 'Messages below this log level are ignored',
				'example' => '',
				'detail' => 'Not written to logfile; not displayed on screen',
				'required' => true,
			),
			'logLocation' => array(
				'type' => 'string/creatable_filepath',
				'default' => '/home/jims/wwwroot/sf3/jpblog/var/logs/{OPTIONS.appName}.log',
				'punch' => 'The log filepath',
				'example' => '/var/log/logparser_daemon.log',
				'detail' => 'Not applicable if you use PEAR Log',
				'required' => false,
			),
			'logPhpErrors' => array(
				'type' => 'boolean',
				'default' => true,
				'punch' => 'Reroute PHP errors to log function',
				'detail' => '',
				'required' => true,
			),
			'logFilePosition' => array(
				'type' => 'boolean',
				'default' => false,
				'punch' => 'Show file in which the log message was generated',
				'detail' => '',
				'required' => true,
			),
			'logTrimAppDir' => array(
				'type' => 'boolean',
				'default' => true,
				'punch' => 'Strip the application dir from file positions in log msgs',
				'detail' => '',
				'required' => true,
			),
			'logLinePosition' => array(
				'type' => 'boolean',
				'default' => true,
				'punch' => 'Show the line number in which the log message was generated',
				'detail' => '',
				'required' => true,
			),
			'appRunAsUID' => array(
				'type' => 'number/0-65000',
				'default' => 1000,
				'punch' => 'The user id under which to run the process',
				'example' => '1000',
				'detail' => 'Defaults to root which is insecure!',
				'required' => true,
			),
			'appRunAsGID' => array(
				'type' => 'number/0-65000',
				'default' => 1000,
				'punch' => 'The group id under which to run the process',
				'example' => '1000',
				'detail' => 'Defaults to root which is insecure!',
				'required' => true,
			),
			'appPidLocation' => array(
				'type' => 'string/unix_filepath',
				'default' => '/home/jims/wwwroot/sf3/jpblog/var/logs/{OPTIONS.appName}/{OPTIONS.appName}.pid',
				'punch' => 'The pid filepath',
				'example' => '/var/run/logparser/logparser.pid',
				'detail' => '',
				'required' => true,
			),
			'appChkConfig' => array(
				'type' => 'string',
				'default' => '- 99 0',
				'punch' => 'chkconfig parameters for init.d',
				'detail' => 'runlevel startpriority stoppriority',
			),
			'appDieOnIdentityCrisis' => array(
				'type' => 'boolean',
				'default' => true,
				'punch' => 'Kill daemon if it cannot assume the identity',
				'detail' => '',
				'required' => true,
			),

			'sysMaxExecutionTime' => array(
				'type' => 'number',
				'default' => 0,
				'punch' => 'Maximum execution time of each script in seconds',
				'detail' => '0 is infinite',
			),
			'sysMaxInputTime' => array(
				'type' => 'number',
				'default' => 0,
				'punch' => 'Maximum time to spend parsing request data',
				'detail' => '0 is infinite',
			),
			'sysMemoryLimit' => array(
				'type' => 'string',
				'default' => '128M',
				'punch' => 'Maximum amount of memory a script may consume',
				'detail' => '0 is infinite',
			),

			'runTemplateLocation' => array(
				'type' => 'string/existing_filepath',
				'default' => false,
				'punch' => 'The filepath to a custom autorun Template',
				'example' => '/etc/init.d/skeleton',
				'detail' => 'Sometimes it\'s better to stick with the OS default,
                and use something like /etc/default/<name> for customization',
			),
			'doTicks' => array(
				'type' => 'boolean',
				'default' => true,
				'punch' => 'Use ticks for daemon signalling (PHP >= 5.3)',
				'detail' => 'If you don\'t set this option, signals will not work unless
                you use the iterate method, or call pcntl_signal_dispatch()
                manually in your daemon\'s main loop',
			),
		);
	}
}