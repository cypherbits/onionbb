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
 * Onionbb: Tor hardening ACP module.
 */
class main_module
{
    public $page_title;
    public $tpl_name;
    public $u_action;

    /**
     * Main ACP module
     *
     * @param int    $id   The module ID
     * @param string $mode The module mode (for example: manage or settings)
     * @throws \Exception
     */
    public function main($id, $mode)
    {
        global $phpbb_container;

        /** @var \cypherbits\onionbb\controller\acp_controller $acp_controller */
        $acp_controller = $phpbb_container->get('cypherbits.onionbb.controller.acp');

        /** @var \phpbb\language\language $language */
        $language = $phpbb_container->get('language');

        switch($mode){
            case "settings":
                // Load a template from adm/style for our ACP page
                $this->tpl_name = 'acp_onionbb_settings';

                // Set the page title for our ACP page
                $this->page_title = $language->lang('ACP_ONIONBB_TITLE');

                // Make the $u_action url available in our ACP controller
                $acp_controller->set_page_url($this->u_action);

                // Load the display options handle in our ACP controller
                $acp_controller->display_settings();
                break;
            case "checks":
                // Load a template from adm/style for our ACP page
                $this->tpl_name = 'acp_onionbb_checks';

                // Set the page title for our ACP page
                $this->page_title = $language->lang('ACP_ONIONBB_TITLE');

                // Make the $u_action url available in our ACP controller
                $acp_controller->set_page_url($this->u_action);

                // Load the display options handle in our ACP controller
                $acp_controller->display_checks();
                break;
        }


    }
}
