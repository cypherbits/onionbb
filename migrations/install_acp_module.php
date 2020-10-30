<?php
/**
 *
 * Onionbb: Tor hardening. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, cypherbits
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace cypherbits\onionbb\migrations;

class install_acp_module extends \phpbb\db\migration\migration
{
    public function effectively_installed()
    {
        return isset($this->config['cypherbits_onionbb_installed']);
    }

    public static function depends_on()
    {
        return array('\phpbb\db\migration\data\v330\v330');
    }

    public function update_data()
    {
        global $request;
        $currentIP = $request->server('REMOTE_ADDR','');

        $currentHost = $request->server('HTTP_HOST','');

        return array(
            array('config.add', array('cypherbits_onionbb_installed', 1)),

            array('config.add', array('cypherbits_onionbb_checkIP', 1)),
            array('config.add', array('cypherbits_onionbb_checkIP_list', '127.0.0.1,'.$currentIP)),

            array('config.add', array('cypherbits_onionbb_blockTor2Web', 1)),
            array('config.add', array('cypherbits_onionbb_blockTor2Web_DNT', 0)),

            array('config.add', array('cypherbits_onionbb_host', 1)),
            array('config.add', array('cypherbits_onionbb_host_list', $currentHost)),

            array('config.add', array('cypherbits_onionbb_userAgents', 1)),
            array('config.add', array('cypherbits_onionbb_userAgentsTB8', 0)),

            array('config.add', array('cypherbits_onionbb_headers_referrer', 0)),
            array('config.add', array('cypherbits_onionbb_headers_contentType', 0)),
            array('config.add', array('cypherbits_onionbb_headers_frame', 0)),
            array('config.add', array('cypherbits_onionbb_headers_content', 0)),

            array('module.add', array(
                'acp',
                'ACP_CAT_DOT_MODS',
                'ACP_ONIONBB_TITLE'
            )),
            array('module.add', array(
                'acp',
                'ACP_ONIONBB_TITLE',
                array(
                    'module_basename'	=> '\cypherbits\onionbb\acp\main_module',
                    'modes'				=> array('settings', 'checks'),
                ),
            )),
        );
    }
}
