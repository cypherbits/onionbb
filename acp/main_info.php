<?php
/**
 *
 * Onionbb: Tor hardening. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, cypherbits
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace cypherbits\onionbb\acp;

/**
 * Onionbb: Tor hardening ACP module info.
 */
class main_info
{
	public function module()
	{
		return array(
			'filename'	=> '\cypherbits\onionbb\acp\main_module',
			'title'		=> 'ACP_ONIONBB_TITLE',
			'modes'		=> array(
				'settings'	=> array(
					'title'	=> 'ACP_ONIONBB',
					'auth'	=> 'ext_cypherbits/onionbb && acl_a_board',
					'cat'	=> array('ACP_ONIONBB_TITLE')
				),
				'checks'	=> array(
					'title'	=> 'ACP_ONIONBB_CHECKS',
					'auth'	=> 'ext_cypherbits/onionbb && acl_a_board',
					'cat'	=> array('ACP_ONIONBB_TITLE')
				),
			),
		);
	}
}
