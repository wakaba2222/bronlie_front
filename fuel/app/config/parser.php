<?php

return array(
    // 拡張の定義
    'extensions' => array(
        'tpl'    => 'View_Smarty',
    ),
    // Smarty設定 ( http://www.smarty.net/documentation )
    'View_Smarty' => array(
        'auto_encode' => true,
        'delimiters'  => array('left' => '<!--{%', 'right' => '%}-->'),
        'environment' => array(
            'compile_dir'       => APPPATH.'tmp'.DS.'Smarty'.DS.'templates_c'.DS,
            'config_dir'        => APPPATH.'tmp'.DS.'Smarty'.DS.'configs'.DS,
            'cache_dir'         => APPPATH.'cache'.DS.'Smarty'.DS,
            'plugins_dir'       => array(APPPATH.'classes/smarty/'),
            'caching'           => false,
            'cache_lifetime'    => 0,
            'force_compile'     => false,
            'compile_check'     => true,
            'debugging'         => false,
            'autoload_filters'  => array(),
            'default_modifiers' => array('default:""')
        ),
        //'extensions' => array('Smarty_Fuel_Extension')
    )
);
