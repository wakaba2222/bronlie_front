<?php
/**
 * Use this file to override global defaults.
 *
 * See the individual environment DB configs for specific config information.
 */

return array(
	'active' => 'default',
	'default' => array(
		'connection'  => array(
			'dsn'        => 'mysql:host=brec-db-master.cjhgjobanqyz.ap-northeast-1.rds.amazonaws.com;dbname=brec_db',
			'username'   => 'brmaster',
			'password'   => '48ou2EkuD6c3gV4R',
		),
		'profiling'=>false,
	),
	'replica1' => array(
		'type'        => 'pdo',
		'connection'  => array(
			'persistent' => false,
		),
		'identifier'   => '`',
		'table_prefix' => '',
		'charset'      => 'utf8',
		'enable_cache' => true,
		'profiling'=>false,
	),
);
