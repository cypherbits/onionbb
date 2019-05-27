<?php
/**
*
* Onionbb: Tor hardening. An extension for the phpBB Forum Software package.
*
* @copyright (c) 2019, cypherbits
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace cypherbits\onionbb\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Onionbb: Tor hardening Event listener.
*/
class main_listener implements EventSubscriberInterface
{
	public static function getSubscribedEvents()
	{

		return array(
			'core.common' => 'onionbb_load',
		);
	}

	/* @var \phpbb\language\language */
	protected $language;

	/* @var \phpbb\controller\helper */
	protected $helper;

	/* @var \phpbb\template\template */
	protected $template;

	/** @var string phpEx */
	protected $php_ext;

	/**
	* Constructor
	*
	* @param \phpbb\language\language	$language	Language object
	* @param \phpbb\controller\helper	$helper		Controller helper object
	* @param \phpbb\template\template	$template	Template object
	* @param string                    $php_ext    phpEx
	*/
	public function __construct(\phpbb\language\language $language, \phpbb\controller\helper $helper, \phpbb\template\template $template, $php_ext)
	{
		$this->language = $language;
		$this->helper   = $helper;
		$this->template = $template;
		$this->php_ext  = $php_ext;
	}

	/**
	*
	* @param \phpbb\event\data	$event	Event object
	*/
	public function onionbb_load($event){

		global $config;
		global $request;

		$tor2web = "X-Tor2web";
		$tor2web = strtoupper($tor2web);
		$tor2web = str_replace("-", "_",$tor2web);

		$checkIP = (bool) $config['cypherbits_onionbb_checkIP'];
		$checkIPList = explode(',',(string)$config['cypherbits_onionbb_checkIP_list']);
		$checkTor2Web = (bool) $config['cypherbits_onionbb_blockTor2Web'];
		$checkTor2WebDNT = (bool) $config['cypherbits_onionbb_blockTor2Web_DNT'];
		$checkHostHeader = (bool) $config['cypherbits_onionbb_host'];
		$checkHostHeaderList = explode(',',(string) $config['cypherbits_onionbb_host_list']);
		$checkUserAgents = (bool) $config['cypherbits_onionbb_userAgents'];
		$checkUserAgentsTB8 = (bool) $config['cypherbits_onionbb_userAgentsTB8'];

		$currentIP = $request->server('REMOTE_ADDR','');
		$currentTor2Web = $request->server('HTTP_'.$tor2web,'');
		$currentTor2WebDNT = $request->server('HTTP_DNT','');
		$currentHostHeader = $request->server('HTTP_HOST','');
		$currentUserAgent = $request->server('HTTP_USER_AGENT','');

		if ($checkIP){
			if (!in_array($currentIP, $checkIPList, true)){
				http_response_code(403);
				die('Forbidden');
			}
		}


		if ($checkTor2Web){

			if ($currentTor2Web !== ""){
				http_response_code(403);
				die('Forbidden');
			}

			if ($checkTor2WebDNT && $currentTor2WebDNT !== ""){
				http_response_code(403);
				die('Forbidden');
			}
		}

		if ($checkHostHeader){
			if (!in_array($currentHostHeader, $checkHostHeaderList, true)){
				http_response_code(403);
				die('Forbidden');
			}
		}

		if($checkUserAgents){
			if ($checkUserAgentsTB8){
				$useragentok = [
					"Mozilla/5.0 (Windows NT 6.1; rv:60.0) Gecko/20100101 Firefox/60.0",
					"Mozilla/5.0 (Android 6.0; Mobile; rv:60.0) Gecko/20100101 Firefox/60.0",
					"Mozilla/5.0 (X11; Linux x86_64; rv:60.0) Gecko/20100101 Firefox/60.0"
				];

				if (!in_array($currentUserAgent, $useragentok, true)){
					http_response_code(403);
					die('Forbidden');
				}
			}else{
				//TODO: check with regex.
				if (strpos($currentUserAgent, "Mozilla/5.0") !== 0){
					http_response_code(403);
					die('Forbidden');
				}
			}
		}

	}

}
