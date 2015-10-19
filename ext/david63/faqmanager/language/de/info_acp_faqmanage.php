<?php
/**
*
* @package FAQ Manager
* @copyright (c) 2015 david63
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
* German translation by tas2580 (http://tas2580.net) 
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

$lang = array_merge($lang, array(
	'BACKUP_LOCATION_NO_WRITE'	=> 'Konnte die Backup Datei nicht anlegen. Bitte prüfe die Rechte für store/faq_backup/ und alle Verzeichnise und Dateien darin.',
	'BAD_FAQ_FILE'				=> 'Die Datei die du versuchst zu bearbeiten ist keine FAQ-Datei.',

	'CREATE_CATEGORY'			=> 'Kategorie anlegen',
	'CREATE_FIELD'				=> 'Thema anlegen',

	'DELETE_CAT'				=> 'Kategorie löschen',
	'DELETE_VAR'				=> 'Thema löschen',

	'FAQ_CAT_LIST'				=> 'Hier kannst du die vorhandenen Kategorien anzeigen und bearbeiten.<br /><br /><strong>Beachte: Eine Kategorie mit dem Namen -- legt einen neuen Abschnitt auf der FAQ Seite an.</strong>',
	'FAQ_EDIT_SUCCESS'			=> 'Die FAQ wurden erfolgreich aktualisiert.',
	'FAQ_FILE_NOT_EXIST'		=> 'Die Datei die du bearbeiten willst existiert nicht.',
	'FAQ_FILE_NO_WRITE'			=> 'Die Datei kann nicht aktualisiert werden. Bitte prüfe die Rechte für die Datei die du bearbeiten möchstest.',
	'FAQ_FILE_SELECT'			=> 'Wähle die Datei die du bearbeiten möchtest.',
	'FAQ_MANAGER'				=> 'FAQ Manager',
	'FAQ_MANAGE'				=> 'Verwalte FAQs',

	'LOAD_BACKUP'				=> 'Backup laden',

	'LOG_FAQ_ADD'				=> '<strong>FAQ Eintrag hinzugefügt</strong>',
	'LOG_FAQ_DELETE'			=> '<strong>FAQ Eintrag gelöscht</strong>',
	'LOG_FAQ_EDIT'				=> '<strong>FAQ Eintrag bearbeitet</strong>',
	'LOG_FAQ_RESTORE'			=> '<strong>FAQ aus dem Backup wiederhergestellt</strong>',

	'NOT_ALLOWED_OUT_OF_DIR'	=> 'Du bist nicht berechtigt Dateien außerhalb des Ordners für Sprach-Dateien zu bearbeiten.',
	'NO_FAQ_FILES'				=> 'Keine verfügbaren FAQ Dateien.',
	'NO_FAQ_VARS'				=> 'In der Datei gibt es keine FAQ',
	
	'VAR_NOT_EXIST'				=> 'Die angeforderte Variable existiert nicht.',
));
