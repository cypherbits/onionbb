<?php
/**
 *
 * Onionbb: Tor hardening. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, cypherbits
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace cypherbits\onionbb\controller;

/**
 * Onionbb: Tor hardening ACP controller.
 */
class acp_controller
{
    /** @var \phpbb\config\config */
    protected $config;

    /** @var \phpbb\language\language */
    protected $language;

    /** @var \phpbb\log\log */
    protected $log;

    /** @var \phpbb\request\request */
    protected $request;

    /** @var \phpbb\template\template */
    protected $template;

    /** @var \phpbb\user */
    protected $user;

    /** @var string Custom form action */
    protected $u_action;

    /**
     * Constructor.
     *
     * @param \phpbb\config\config $config Config object
     * @param \phpbb\language\language $language Language object
     * @param \phpbb\log\log $log Log object
     * @param \phpbb\request\request $request Request object
     * @param \phpbb\template\template $template Template object
     * @param \phpbb\user $user User object
     */
    public function __construct(\phpbb\config\config $config, \phpbb\language\language $language, \phpbb\log\log $log, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user)
    {
        $this->config = $config;
        $this->language = $language;
        $this->log = $log;
        $this->request = $request;
        $this->template = $template;
        $this->user = $user;
    }

    /**
     * Display the options a user can configure for this extension.
     *
     * @return void
     */
    public function display_settings()
    {
        // Add our common language file
        $this->language->add_lang('common', 'cypherbits/onionbb');

        // Create a form key for preventing CSRF attacks
        add_form_key('cypherbits_onionbb_acp');

        // Create an array to collect errors that will be output to the user
        $errors = array();

        // Is the form being submitted to us?
        if ($this->request->is_set_post('submit')) {
            // Test if the submitted form is valid
            if (!check_form_key('cypherbits_onionbb_acp')) {
                $errors[] = $this->language->lang('FORM_INVALID');
            }

            // If no errors, process the form data
            if (empty($errors)) {
                // Set the options the user configured
                $this->config->set('cypherbits_onionbb_checkIP', $this->request->variable('cypherbits_onionbb_checkIP', 0));
                $this->config->set('cypherbits_onionbb_checkIP_list', $this->request->variable('cypherbits_onionbb_checkIP_list', ""));
                $this->config->set('cypherbits_onionbb_blockTor2Web', $this->request->variable('cypherbits_onionbb_blockTor2Web', 0));
                $this->config->set('cypherbits_onionbb_blockTor2Web_DNT', $this->request->variable('cypherbits_onionbb_blockTor2Web_DNT', 0));
                $this->config->set('cypherbits_onionbb_host', $this->request->variable('cypherbits_onionbb_host', 0));
                $this->config->set('cypherbits_onionbb_host_list', $this->request->variable('cypherbits_onionbb_host_list', ""));
                $this->config->set('cypherbits_onionbb_userAgents', $this->request->variable('cypherbits_onionbb_userAgents', 0));
                $this->config->set('cypherbits_onionbb_userAgentsTB8', $this->request->variable('cypherbits_onionbb_userAgentsTB8', 0));
                $this->config->set('cypherbits_onionbb_headers_referrer', $this->request->variable('cypherbits_onionbb_headers_referrer', 0));
                $this->config->set('cypherbits_onionbb_headers_contentType', $this->request->variable('cypherbits_onionbb_headers_contentType', 0));
                $this->config->set('cypherbits_onionbb_headers_frame', $this->request->variable('cypherbits_onionbb_headers_frame', 0));
                $this->config->set('cypherbits_onionbb_headers_content', $this->request->variable('cypherbits_onionbb_headers_content', 0));

                // Add option settings change action to the admin log
                $this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_ACP_ONIONBB_SETTINGS');

                // Option settings have been updated and logged
                // Confirm this to the user and provide link back to previous page
                trigger_error($this->language->lang('ACP_ONIONBB_SETTING_SAVED') . adm_back_link($this->u_action));
            }
        }

        $s_errors = !empty($errors);

        // Set output variables for display in the template
        $this->template->assign_vars(array(
            'S_ERROR' => $s_errors,
            'ERROR_MSG' => $s_errors ? implode('<br />', $errors) : '',

            'U_ACTION' => $this->u_action,

            strtoupper('current_ip') => (string)$this->request->server('REMOTE_ADDR', 'empty?'),
            strtoupper('current_host') => (string)$this->request->server('HTTP_HOST', 'empty?'),
            strtoupper('http_user_agent') => (string)$this->request->server('HTTP_USER_AGENT', 'empty?'),
            strtoupper('cypherbits_onionbb_checkIP') => (bool)$this->config['cypherbits_onionbb_checkIP'],
            strtoupper('cypherbits_onionbb_checkIP_list') => (string)$this->config['cypherbits_onionbb_checkIP_list'],
            strtoupper('cypherbits_onionbb_blockTor2Web') => (bool)$this->config['cypherbits_onionbb_blockTor2Web'],
            strtoupper('cypherbits_onionbb_blockTor2Web_DNT') => (bool)$this->config['cypherbits_onionbb_blockTor2Web_DNT'],
            strtoupper('cypherbits_onionbb_host') => (bool)$this->config['cypherbits_onionbb_host'],
            strtoupper('cypherbits_onionbb_host_list') => (string)$this->config['cypherbits_onionbb_host_list'],
            strtoupper('cypherbits_onionbb_userAgents') => (bool)$this->config['cypherbits_onionbb_userAgents'],
            strtoupper('cypherbits_onionbb_userAgentsTB8') => (bool)$this->config['cypherbits_onionbb_userAgentsTB8'],
            strtoupper('cypherbits_onionbb_headers_referrer') => (bool)$this->config['cypherbits_onionbb_headers_referrer'],
            strtoupper('cypherbits_onionbb_headers_contentType') => (bool)$this->config['cypherbits_onionbb_headers_contentType'],
            strtoupper('cypherbits_onionbb_headers_frame') => (bool)$this->config['cypherbits_onionbb_headers_frame'],
            strtoupper('cypherbits_onionbb_headers_content') => (bool)$this->config['cypherbits_onionbb_headers_content'],
        ));
    }

    public function display_checks()
    {
        $this->template->assign_vars(array(
            'S_ERROR' => $s_errors,
            'ERROR_MSG' => $s_errors ? implode('<br />', $errors) : '',

            'U_ACTION' => $this->u_action,

            'CYPHERBITS_ONIONBB_CHECK_PASSWORDLENGHT' => (int)$this->config['min_pass_chars'],
            'CYPHERBITS_ONIONBB_CHECK_USERNAMELENGHT' => (int)$this->config['min_name_chars'],
        ));
    }

    /**
     * Set custom form action.
     *
     * @param string $u_action Custom form action
     * @return void
     */
    public function set_page_url($u_action)
    {
        $this->u_action = $u_action;
    }
}
