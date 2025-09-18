<?php
/**
 * The development database settings. These get merged with the global settings.
 */

return array(
	'default' => array(
		'connection'  => array(
			'dsn'        => 'mysql:host=brec-db-master.cjhgjobanqyz.ap-northeast-1.rds.amazonaws.com;dbname=brec_db',
			'username'   => 'brmaster',
			'password'   => '48ou2EkuD6c3gV4R',
		),
		'profiling'=>false,
	),
	'replica1' => array(
		'connection'  => array(
			'dsn'        => 'mysql:host=brec-db-second.cjhgjobanqyz.ap-northeast-1.rds.amazonaws.com;dbname=brec_db',
			'username'   => 'brmaster',
			'password'   => '48ou2EkuD6c3gV4R',
		),
		'profiling'=>false,
	),
    'redis' => array(
        'default' => array(
            'hostname' => '127.0.0.1',
            'port'     => 6379,
            'timeout'    => null,
            'database' => 0,
        ),
    ),
);
