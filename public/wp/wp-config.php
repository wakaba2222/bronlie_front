<?php
/**
 * WordPress の基本設定
 *
 * このファイルは、インストール時に wp-config.php 作成ウィザードが利用します。
 * ウィザードを介さずにこのファイルを "wp-config.php" という名前でコピーして
 * 直接編集して値を入力してもかまいません。
 *
 * このファイルは、以下の設定を含みます。
 *
 * * MySQL 設定
 * * 秘密鍵
 * * データベーステーブル接頭辞
 * * ABSPATH
 *
 * @link http://wpdocs.osdn.jp/wp-config.php_%E3%81%AE%E7%B7%A8%E9%9B%86
 *
 * @package WordPress
 */

// 注意:
// Windows の "メモ帳" でこのファイルを編集しないでください !
// 問題なく使えるテキストエディタ
// (http://wpdocs.osdn.jp/%E7%94%A8%E8%AA%9E%E9%9B%86#.E3.83.86.E3.82.AD.E3.82.B9.E3.83.88.E3.82.A8.E3.83.87.E3.82.A3.E3.82.BF 参照)
// を使用し、必ず UTF-8 の BOM なし (UTF-8N) で保存してください。

// ** MySQL 設定 - この情報はホスティング先から入手してください。 ** //
/** WordPress のためのデータベース名 */
define('DB_NAME', 'brec_db');

/** MySQL データベースのユーザー名 */
define('DB_USER', 'brmaster');

/** MySQL データベースのパスワード */
define('DB_PASSWORD', '48ou2EkuD6c3gV4R');

/** MySQL のホスト名 */
define('DB_HOST', 'brec-db-master.cjhgjobanqyz.ap-northeast-1.rds.amazonaws.com');

/** データベースのテーブルを作成する際のデータベースの文字セット */
define('DB_CHARSET', 'utf8mb4');

/** データベースの照合順序 (ほとんどの場合変更する必要はありません) */
define('DB_COLLATE', '');

/**#@+
 * 認証用ユニークキー
 *
 * それぞれを異なるユニーク (一意) な文字列に変更してください。
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org の秘密鍵サービス} で自動生成することもできます。
 * 後でいつでも変更して、既存のすべての cookie を無効にできます。これにより、すべてのユーザーを強制的に再ログインさせることになります。
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'fgxm#^T`[%v_D~Y3pL X|PF(gl-8B$%zmY;A/Pjd4Uf9LRHOGcG.T}S||?^]l40e');
define('SECURE_AUTH_KEY',  '%]Jl7SZl!*9]cp,]hphWG=xB$Rj(_]%l%UoV#Vb{y]iX)Up=zZzI5`ezRMjnCFhq');
define('LOGGED_IN_KEY',    'oWDa,x;v@+fm+V?3h5~o^%(t{-X&#}}-Axi2IwQ|!i&x;A(vENyIA~]&/Aqjl <k');
define('NONCE_KEY',        'n9De7>&9b;=F]%bM|-Zjh(96A/$jsb9dl8:C$l<1:]h1!PM#Qse]ufa0KX~0}_?=');
define('AUTH_SALT',        '_+J=2t2HFN vr-I0R%X^=f_rH{L5#mk<;viBG/| rXuOjb|3y_wd6C*hTXgHsgub');
define('SECURE_AUTH_SALT', '14nl#wo>)!x&KeD)arZHa_eiBbmacW|nJ!5#Gh,t8O_4UmO8(Y9q2l]BIro`=`$S');
define('LOGGED_IN_SALT',   'b$sHbv=[:7.d/R_N|ua)]Jm%Qs[jQ$c:f[m~#1Wr%McO? wl)B{{)ia[ W4l(K}#');
define('NONCE_SALT',       '4pU|A5I2XAh6KBb?*9^>bq.EPMJ5chQ@/9KSRKP!LM<q4`I|4]BjoF!QDs41T+qe');

/**#@-*/

/**
 * WordPress データベーステーブルの接頭辞
 *
 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を
 * インストールすることができます。半角英数字と下線のみを使用してください。
 */
$table_prefix  = 'wp_';

/**
 * 開発者へ: WordPress デバッグモード
 *
 * この値を true にすると、開発中に注意 (notice) を表示します。
 * テーマおよびプラグインの開発者には、その開発環境においてこの WP_DEBUG を使用することを強く推奨します。
 *
 * その他のデバッグに利用できる定数については Codex をご覧ください。
 *
 * @link http://wpdocs.osdn.jp/WordPress%E3%81%A7%E3%81%AE%E3%83%87%E3%83%90%E3%83%83%E3%82%B0
 */
define('WP_DEBUG', false);

define('WP_SITEURL', 'https://origin.bronline.jp/wp');

define('WP_HOME', 'https://origin.bronline.jp/wp');

/* 編集が必要なのはここまでです ! WordPress でブログをお楽しみください。 */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
