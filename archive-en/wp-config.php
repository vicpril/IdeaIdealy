<?php
/** 
 * Основные параметры WordPress.
 *
 * Этот файл содержит следующие параметры: настройки MySQL, префикс таблиц,
 * секретные ключи, язык WordPress и ABSPATH. Дополнительную информацию можно найти
 * на странице {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Кодекса. Настройки MySQL можно узнать у хостинг-провайдера.
 *
 * Этот файл используется сценарием создания wp-config.php в процессе установки.
 * Необязательно использовать веб-интерфейс, можно скопировать этот файл
 * с именем "wp-config.php" и заполнить значения.
 *
 * @package WordPress
 */

// ** Настройки MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'topmollru_ideen');

/** Имя пользователя MySQL */
define('DB_USER', 'root');

/** Пароль пользователя MySQL */
//define('DB_PASSWORD', 'nhbns,kjrf');
define('DB_PASSWORD', '');

/** Адрес сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных при создании таблиц. */
define('DB_CHARSET', 'utf8');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи для аутентификации.
 *
 * Смените значение каждого ключа на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется снова авторизоваться.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'sdgsdfgsdfgsdf sdf gsdfgsdfgsdfgsdf gsdfg');
define('SECURE_AUTH_KEY', 'sdfhdfhdsf gdsfg sdfg sdfg sdf gsdfgergrgg55');
define('LOGGED_IN_KEY', 'yu yukluyk ui kkuikui k78kk 7 kuik ikui ki');
define('NONCE_KEY', 'tjtyjtey je56 e56 57e567e56 e567e56 7');
/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько блогов в одну базу данных, если вы будете использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Язык локализации WordPress, по умолчанию английский.
 *
 * Измените этот параметр, чтобы настроить локализацию. Соответствующий MO-файл
 * для выбранного языка должен быть установлен в wp-content/languages.
 */
//define ('WPLANG', 'ru_RU');
define ('WPLANG', 'en_EN');

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
?>