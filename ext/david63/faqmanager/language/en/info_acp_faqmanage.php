<?php
/**
*
* @package FAQ Manager
* @copyright (c) 2015 david63
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
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
	'BACKUP_LOCATION_NO_WRITE'	=> 'Unable to create a backup file. Please check the directory permissions for store/faq_backup/ and every directory and file in it.',
	'BAD_FAQ_FILE'				=> 'The file you are attempting to edit is not a FAQ file.',

	'CREATE_CATEGORY'			=> 'Create category',
	'CREATE_FIELD'				=> 'Create topic',

	'DELETE_CAT'				=> 'Delete category',
	'DELETE_VAR'				=> 'Delete topic',

	'FAQ_ANSWER'				=> 'FAQ answer',
	'FAQ_CAT_CAT'				=> 'From here you can edit a FAQ category.',
	'FAQ_CAT_EDIT'				=> 'From here you can edit a FAQ topic.',
	'FAQ_CAT_FAQ'				=> 'From here you can add a FAQ topic into the category.',
	'FAQ_CAT_FILES'				=> 'Select the FAQ file that you want to edit.',
	'FAQ_CAT_LIST'				=> 'From here you can manage the categories in the selected file.<br /><br /><strong>Note that a category named “--” is the section break for the FAQ display page.</strong>',
	'FAQ_CAT_SUCCESS'			=> 'The category was added successfully.',
	'FAQ_CAT_QUESTION'			=> 'From here you can manage the FAQ topics in the selected category.',
	'FAQ_CAT_TOPIC'				=> 'From here you can create a new FAQ topic.',
	'FAQ_DELETE_SUCCESS'		=> 'The FAQ data was deleted successfully.',
	'FAQ_EDIT_SUCCESS'			=> 'The FAQ was updated successfully.',
	'FAQ_TOPIC_SUCCESS'			=> 'The topic was added successfully.',
	'FAQ_FILE_NOT_EXIST'		=> 'The file you are attempting to edit does not exist.',
	'FAQ_FILE_NO_WRITE'			=> 'Unable to update the file.  Please check the file permissions for the file you are attempting to edit.',
	'FAQ_FILE_SELECT'			=> 'Select the file you would like to edit.',
	'FAQ_LANGUAGE'				=> 'Language',
	'FAQ_LOCATION'				=> 'Location',
	'FAQ_MANAGER'				=> 'FAQ Manager',
	'FAQ_MANAGE'				=> 'Manage FAQs',
	'FAQ_NAME'					=> 'Name',
	'FAQ_QUESTION'				=> 'FAQ topic',
	'FAQ_CAT_QUESTION'			=> 'FAQ category',
	'FAQ_SETTINGS'				=> 'Create/edit FAQ topic',
	'FAQ_CAT_SETTINGS'			=> 'Edit FAQ category',

	'LOAD_BACKUP'				=> 'Load Backup',

	'LOG_FAQ_ADD'				=> '<strong>FAQ item added</strong>',
	'LOG_FAQ_DELETE'			=> '<strong>FAQ item deleted</strong>',
	'LOG_FAQ_EDIT'				=> '<strong>FAQ item edited</strong>',
	'LOG_FAQ_RESTORE'			=> '<strong>FAQ restored from backup</strong>',

	'NOT_ALLOWED_OUT_OF_DIR'	=> 'You are not allowed to edit files out of the language directory.',
	'NO_FAQ_FILES'				=> 'No Available FAQ Files.',
	'NO_FAQ_VARS'				=> 'There are no FAQs in the file.',

	'ON_TO_NEXT'				=> 'Go to next step',

	'VAR_NOT_EXIST'				=> 'The requested variable does not exist.',
));
