<?php
/**
*
* @package FAQ Manager
* @copyright (c) 2015 david63
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace david63\faqmanager\migrations;

class version_1_0_0 extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		return array(
			array('config.add', array('version_faqmanager', '1.0.0')),

			// Add the ACP module
			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'FAQ_MANAGER')),

			array('module.add', array(
				'acp', 'FAQ_MANAGER', array(
					'module_basename'	=> '\david63\faqmanager\acp\faqmanager_module',
					'modes'				=> array('manage'),
				),
			)),
		);
	}
}
