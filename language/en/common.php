<?php
/**
 *
 * Onionbb: Tor hardening. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, cypherbits
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

if (!defined('IN_PHPBB')) {
    exit;
}

if (empty($lang) || !is_array($lang)) {
    $lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(

    'ONIONBB_HELLO' => 'Hello %s!',
    'ONIONBB_GOODBYE' => 'Goodbye %s!',

    'ONIONBB_EVENT' => ' :: Onionbb Event :: ',

    'ACP_ONIONBB_GOODBYE' => 'Should say goodbye?',
    'ACP_ONIONBB_SETTING_SAVED' => 'Settings have been saved successfully!',

    'ONIONBB_PAGE' => 'Onionbb Page',
    'VIEWING_CYPHERBITS_ONIONBB' => 'Viewing Onionbb: Tor hardening page',

));
