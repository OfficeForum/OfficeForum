<?php
/**
*
* @package FAQ Manager
* @copyright (c) 2015 david63
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace david63\faqmanager\acp;

class faqmanager_info
{
	function module()
	{
		return array(
			'filename'	=> '\david63\faqmanager\acp\faqmanager_module',
			'title'		=> 'FAQ_MANAGER',
			'modes'		=> array(
				'manage'	=> array('title' => 'FAQ_MANAGE', 'auth' => 'ext_david63/faqmanager && acl_a_board', 'cat' => array('FAQ_MANAGER')),
			),
		);
	}
}
