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

$lang = array_merge($lang, array(
	'BACKUP_LOCATION_NO_WRITE'	=> 'No se puede crear un archivo de copia de seguridad. Por favor, compruebe los permisos del directorio store/faq_backup/ y todos los directorios y archivos en ella.',
	'BAD_FAQ_FILE'				=> 'El archivo que está intentando editar no es un archivo de FAQ',

	'CREATE_CATEGORY'			=> 'Crear categoría',
	'CREATE_FIELD'				=> 'Crear tema',

	'DELETE_CAT'				=> 'Borrar categoría',
	'DELETE_VAR'				=> 'Borrar tema',

	'FAQ_CAT_LIST'				=> 'Aquí puede ver y editar las categorías existentes.<br /><br /><strong>Tenga en cuenta que una categoría llamada -- es el salto de sección de la página de FAQ.</strong>',
	'FAQ_EDIT_SUCCESS'			=> 'El FAQ ha sido actualizado correctamente.',
	'FAQ_FILE_NOT_EXIST'		=> 'El archivo que está intentando editar no existe.',
	'FAQ_FILE_NO_WRITE'			=> 'No se puede actualizar el archivo. Por favor, compruebe los permisos del archivo que está intentando editar.',
	'FAQ_FILE_SELECT'			=> 'Seleccione el archivo que desea editar.',
	'FAQ_MANAGER'				=> 'FAQ Manager',
	'FAQ_MANAGE'				=> 'Gestionar FAQs',

	'LOAD_BACKUP'				=> 'Cargar copia de seguridad',

	'LOG_FAQ_ADD'				=> '<strong>Artículo de FAQ añadido</strong>',
	'LOG_FAQ_DELETE'			=> '<strong>Artículo de FAQ borrado</strong>',
	'LOG_FAQ_EDIT'				=> '<strong>Artículo de FAQ editado</strong>',
	'LOG_FAQ_RESTORE'			=> '<strong>Artículo de FAQ restaurado desde la copia de seguridad</strong>',

	'NOT_ALLOWED_OUT_OF_DIR'	=> 'No se le permite editar archivos fuera del directorio de idioma.',
	'NO_FAQ_FILES'				=> 'Archivos de FAQ no disponibles.',
	'NO_FAQ_VARS'				=> 'No hay FAQs en el archivo.',

	'VAR_NOT_EXIST'				=> 'No existe la variable solicitada.',
));
