<?php
/**
*
* @package FAQ Manager
* @copyright (c) 2015 david63
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace david63\faqmanager\acp;

class faqmanager_module
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	protected $phpbb_root_path;

	protected $phpEx;

	public $u_action;

	function main($id, $mode)
	{
		global $user, $template, $request, $config, $phpbb_log, $phpbb_root_path, $phpEx;

		$this->config			= $config;
		$this->request			= $request;
		$this->template			= $template;
		$this->user				= $user;
		$this->phpbb_root_path	= $phpbb_root_path;
		$this->phpEx			= $phpEx;

		$this->tpl_name		= 'faq_manage';
		$this->page_title	= $this->user->lang('FAQ_MANAGER');
		$form_key			= 'faq_manage';
		add_form_key($form_key);

		$submit		= ($this->request->is_set_post('submit')) ? true : false;
		$action		= $this->request->variable('action', '');
		$file		= $this->request->variable('file', '');
		$cat_id		= $this->request->variable('cat', 0);
		$field_id	= $this->request->variable('var', 0);
		$new_name	= $this->request->variable('var_name', '', true);
		$new_value	= $this->request->variable('var_value', '', true);

		$cat_edit	= false;
		$faq		= array(); // will hold the FAQ file data
		$self_url	= ($cat_id) ? $this->u_action . "&amp;file={$file}&amp;cat={$cat_id}" . (($field_id) ? "&amp;var={$field_id}" : '') . (($action) ? "&amp;action={$action}" : '') : $this->u_action . "&amp;file={$file}" . (($action) ? "&amp;action={$action}" : '');

		$this->template->assign_vars(array(
			'U_ACTION'			=> $self_url,

			'S_UNDO'			=> ($file && file_exists($this->phpbb_root_path . 'store/faq_backup/' . $file . '.' . $this->phpEx . '.bak')) ? true : false,
			'U_UNDO'			=> $this->u_action . "&amp;file={$file}&amp;action=undo",
		));

		if ($file)
		{
			$faq = $this->build_faq_array($this->load_faq($file));
		}
		else
		{
			// list the available files
			$this->template->assign_vars(array(
				'L_TITLE_EXPLAIN'		=> $this->user->lang['FAQ_FILE_SELECT'],
				'S_CAT_LIST'			=> false,
				'S_DISPLAY_FILE_LIST'	=> true,
			));

			foreach ($this->get_faq_file_list() as $loc)
			{
				$this->template->assign_block_vars('file_list', array(
					'NAME'			=> substr($loc, (strpos($loc, '/help_') + 6)),
					'LANGUAGE'		=> substr($loc, 0, strpos($loc, '/')),
					'LOCATION'		=> 'language/' . $loc . '.' . $this->phpEx,
					'ACTION'		=> '<a href="' . $this->u_action . '&amp;action=file&amp;file=' . $loc . '">' . $this->user->lang['EDIT'] . '</a>',
				));
			}
		}

		$category = $field = '';
		if ($field_id)
		{
			if (!isset($faq[$cat_id]))
			{
				trigger_error('CATEGORY_NOT_EXIST');
			}

			if (!isset($faq[$cat_id][$field_id]))
			{
				trigger_error('VAR_NOT_EXIST');
			}

			$field		= $faq[$cat_id][$field_id][0];
			$category	= $faq[$cat_id]['--'];
		}
		else if ($cat_id)
		{
			if (!isset($faq[$cat_id]))
			{
				trigger_error('CATEGORY_NOT_EXIST');
			}

			$category = $faq[$cat_id]['--'];
		}

		switch ($action)
		{
			case 'undo':
				@copy($this->phpbb_root_path . 'store/faq_backup/' . $file . '.' . $this->phpEx . '.bak', $this->phpbb_root_path . 'language/' . $file . '.' . $this->phpEx);
				$phpbb_log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_FAQ_RESTORE');
				trigger_error($this->user->lang('FAQ_EDIT_SUCCESS') . adm_back_link($this->u_action . "&amp;file={$file}"));
			break;

			case 'add':
				$submit = ($this->request->is_set_post('add') && $this->request->is_set_post('var_value') && !$category) ? true : $submit;

				if ($submit)
				{
					if ($cat_id)
					{
						$faq[$cat_id][] = array(0 => $new_name, 1 => $new_value);
						$success = $this->user->lang['FAQ_TOPIC_SUCCESS'];
					}
					else
					{
						$faq[] = array('--' => $new_value);
						$success = $this->user->lang['FAQ_CAT_SUCCESS'];
					}

					$this->output_faq($faq, $file);
					$phpbb_log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_FAQ_ADD');
					trigger_error($success . $this->adm_next_link($this->u_action . "&amp;action=cat&amp;file={$file}" . (($cat_id) ? "&amp;cat={$cat_id}" : '&amp;cat=' . (sizeof($faq)))));
				}
				else
				{
					$this->template->assign_vars(array(
						'L_TITLE_EXPLAIN'		=> $this->user->lang['FAQ_CAT_TOPIC'],
						'NAVIGATION'			=> "<a href=\"{$this->u_action}&amp;file={$file}\">{$file}</a>" . (($cat_id) ? ' -&gt; ' . "<a href=\"{$this->u_action}&amp;file={$file}&amp;cat={$cat_id}\">{$category}</a>" : ''),
						'VARIABLE_NAME'			=> $new_name,
						'VARIABLE_VALUE'		=> $new_value,
						'S_ADD'					=> true,
						'S_CAT'					=> (!$cat_id),
					));
				}
			break;

			case 'edit':
				if ($submit)
				{
					if ($field_id)
					{
						$faq[$cat_id][$field_id] = array(0 => $new_name, 1 => $new_value);
					}
					else if ($cat_id)
					{
						$faq[$cat_id]['--'] = $new_name;
					}

					$this->output_faq($faq, $file);
					$phpbb_log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_FAQ_EDIT');
					trigger_error($this->user->lang('FAQ_EDIT_SUCCESS') . adm_back_link($this->u_action . "&amp;file={$file}" . (($field_id) ? "&amp;cat={$cat_id}" : '')));
				}
				else
				{
					if ($field_id)
					{
						$explain	= $this->user->lang('FAQ_CAT_EDIT');
					}
					else
					{
						$explain	= $this->user->lang('FAQ_CAT_CAT');
						$cat_edit	= true;
					}
					$this->template->assign_vars(array(
						'L_TITLE_EXPLAIN'		=> $explain,
						'NAVIGATION'			=> "<a href=\"{$this->u_action}&amp;file={$file}\">{$file}</a>" . (($cat_id) ? ' -> ' . "<a href=\"{$this->u_action}&amp;file={$file}&amp;cat={$cat_id}\">{$category}</a>" : '') . (($field_id) ? ' -> ' . $field : ''),
						'VARIABLE_NAME'			=> str_replace('"', '&quot;', ($field_id) ? $faq[$cat_id][$field_id][0] : $faq[$cat_id]['--']),
						'VARIABLE_VALUE'		=> str_replace('"', '&quot;', ($field_id) ? $faq[$cat_id][$field_id][1] : $faq[$cat_id]['--']),
						'S_EDIT'				=> true,
						'S_CAT'					=> (!$field),
						'S_CAT_EDIT'			=> $cat_edit,
					));
				}
			break;

			case 'delete':
				if (confirm_box(true))
				{
					if ($field_id)
					{
						unset($faq[$cat_id][$field_id]);
					}
					else if ($category)
					{
						unset($faq[$cat_id]);
					}

					$this->output_faq($faq, $file);
					$phpbb_log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_FAQ_DELETE');
					trigger_error($this->user->lang('FAQ_DELETE_SUCCESS') . adm_back_link($this->u_action . "&amp;file={$file}" . (($field_id) ? "&amp;cat={$cat_id}" : '')));
				}
				else
				{
					confirm_box(false, ((!$field_id) ? $this->user->lang('DELETE_CAT') : $this->user->lang('DELETE_VAR')));
				}
				redirect($this->u_action);
			break;

			case 'move_down': // we do a trick with the output url, so there is no move_up mode
				$next = false;
				if ($field_id)
				{
					$temp = $faq[$cat_id][$field_id];
					$faq[$cat_id][$field_id] = $faq[$cat_id][$field_id + 1];
					$faq[$cat_id][$field_id + 1] = $temp;
				}
				else if ($cat_id)
				{
					$temp = $faq[$cat_id];
					$faq[$cat_id] = $faq[$cat_id + 1];
					$faq[$cat_id + 1] = $temp;
					$cat_id = 0;
				}

				unset($temp);
				$this->output_faq($faq, $file);
			// no break

			default:
				if ($action == 'file')
				{
					$explain = $this->user->lang('FAQ_CAT_LIST');
				}
				else if ($action == 'cat')
				{
					$explain = $this->user->lang('FAQ_CAT_FAQ');
				}
				else if ($cat_id > 0)
				{
					$explain = $this->user->lang('FAQ_CAT_QUESTION');
				}
				else
				{
					$explain = $this->user->lang('FAQ_CAT_FILES');
				}

				$this->template->assign_vars(array(
					'L_TITLE_EXPLAIN'	=> $explain,
					'L_CREATE'			=> ($cat_id) ? $this->user->lang('CREATE_FIELD') : $this->user->lang('CREATE_CATEGORY'),
					'NAVIGATION'		=> "<a href=\"{$this->u_action}&amp;file={$file}\">{$file}</a>" . (($cat_id) ? ' -> ' . "<a href=\"{$this->u_action}&amp;file={$file}&amp;cat={$cat_id}\">{$category}</a>" : ''),
					'S_DISPLAY_LIST'	=> ($file) ? true : false,
					'S_CAT'				=> (!$cat_id),
				));

				$move_up = '';
				$i = 1;
				foreach ((($cat_id) ? $faq[$cat_id] : $faq) as $data)
				{
					if (!$cat_id)
					{
						$name = $data['--'];
					}
					else
					{
						if (!is_array($data))
						{
							continue;
						}

						$name = $data[0];
					}

					$url = ($cat_id) ? $this->u_action . "&amp;file={$file}&amp;cat={$cat_id}&amp;var={$i}" : $this->u_action . "&amp;file={$file}&amp;cat={$i}";
					$this->template->assign_block_vars('file_list', array(
						'NAME'			=> $name,
						'U_VIEW'		=> (!$cat_id) ? $url : '',
						'U_MOVE_DOWN'	=> $url . '&amp;action=move_down',
						'U_MOVE_UP'		=> $move_up,
						'U_EDIT'		=> $url . '&amp;action=edit',
						'U_DELETE'		=> $url . '&amp;action=delete',
					));
					$move_up = $url . '&amp;action=move_down';
					$i++;
				}
			break;
		}

	}

	/**
	* Output the file
	*
	* @param array $faq - The FAQ list (in the parsed style from build_faq_array())
	* @param string $file - The name of the file that the data will be outputted to
	*/
	protected function output_faq($faq, $file)
	{
		if (strpos($file, '.') !== false)
		{
			trigger_error('NOT_ALLOWED_OUT_OF_DIR');
		}

		$output = '<?php
/**
*
* ' . $file . '
*
* Built with the FAQ Manager Extension
*
*/

if (!defined(\'IN_PHPBB\'))
{
	exit;
}

$help = array(
';
		foreach ($faq as $category)
		{
			foreach ($category as $name => $value)
			{
				if (is_array($value))
				{
					$name	= $value[0];
					$value	= $value[1];
				}

				$output .= "	array(
					0 => '" . str_replace("'", "\'", htmlspecialchars_decode($name)) . "',
					1 => '" . str_replace("'", "\'", htmlspecialchars_decode($value)) . "',
				),";
			}
		}
		$output .= ');

?>';

		// First, make a backup of the current FAQ.
		if (!@file_exists($this->phpbb_root_path . 'store/faq_backup/' . substr($file, 0, strrpos($file, '/'))))
		{
			@mkdir($this->phpbb_root_path . 'store/faq_backup/' . substr($file, 0, strrpos($file, '/')), 0777, true);
		}

		// Probably should not need this but checks that the write permissions have not been changed
		if (!@is_writable($this->phpbb_root_path . 'store/faq_backup/' . substr($file, 0, strrpos($file, '/'))))
		{
			@chmod($this->phpbb_root_path . 'store/faq_backup/' . substr($file, 0, strrpos($file, '/')), 0777);

			// Let's just check that it worked and if not send error message
			if (!@is_writable($this->phpbb_root_path . 'store/faq_backup/' . substr($file, 0, strrpos($file, '/'))))
			{
				trigger_error($this->user->lang['BACKUP_LOCATION_NO_WRITE'] . ' - store/faq_backup/' . substr($file, 0, strrpos($file, '/')));
			}
		}

		@copy($this->phpbb_root_path . 'language/' . $file . '.' . $this->phpEx, $this->phpbb_root_path . 'store/faq_backup/' . $file . '.' . $this->phpEx . '.bak');

		// Now edit the existing file
		if (!@is_writable($this->phpbb_root_path . 'language/' . $file . '.' . $this->phpEx))
		{
			@chmod($this->phpbb_root_path . 'language/' . $file . '.' . $this->phpEx, 0777);

			// Let's just check that it worked and if not send error message
			if (!@is_writable($this->phpbb_root_path . 'language/' . $file . '.' . $this->phpEx))
			{
				trigger_error($this->user->lang['FAQ_FILE_NO_WRITE'] . ' - language/' . $file . '.' . $this->phpEx);
			}
		}

		if ($fp = @fopen($this->phpbb_root_path . 'language/' . $file . '.' . $this->phpEx, 'wb'))
		{
			@flock($fp, LOCK_EX);
			@fwrite($fp, $output);
			@flock($fp, LOCK_UN);
			@fclose($fp);
			@chmod($filename, 0666);
		}
	}

	/**
	* Gets the FAQ File list
	*/
	protected function get_faq_file_list()
	{
		$list	= array();
		$dh		= @opendir($this->phpbb_root_path . 'language/');

		if ($dh)
		{
			while (($file = readdir($dh)) !== false)
			{
				if (strpos($file, '.') === false && is_dir($this->phpbb_root_path . 'language/' . $file))
				{
					$dh1 = @opendir($this->phpbb_root_path . 'language/' . $file);

					if ($dh1)
					{
						while (($file1 = readdir($dh1)) !== false)
						{
							if (strpos($file1, 'help_') === 0 && substr($file1, -(strlen($this->phpEx) + 1)) === '.' . $this->phpEx)
							{
								$list[] = $file . '/' . substr($file1, 0, -(strlen($this->phpEx) + 1));
							}
							else
							{
								if (strpos($file1, '.') === false && is_dir($this->phpbb_root_path . 'language/' . $file . '/' . $file1))
								{
									$dh2 = @opendir($this->phpbb_root_path . 'language/' . $file . '/' . $file1);

									if ($dh2)
									{
										while (($file2 = readdir($dh2)) !== false)
										{
											if (strpos($file2, 'help_') === 0 && substr($file2, -(strlen($this->phpEx) + 1)) === '.' . $this->phpEx)
											{
												$list[] = $file . '/' . $file1 . '/' . substr($file2, 0, -(strlen($this->phpEx) + 1));
											}
										}
										closedir($dh2);
									}
								}
							}
						}
						closedir($dh1);
					}
				}
			}
			closedir($dh);
		}

		return $list;
	}

	/**
	* Loads the FAQ file
	*
	* @param string $file - The file we wish to load.  Include the lang folder name and the file name, like en/help_faq.
	*/
	protected function load_faq($file)
	{
		if (strpos($file, '.') !== false)
		{
			trigger_error('NOT_ALLOWED_OUT_OF_DIR');
		}

		if (file_exists($this->phpbb_root_path . 'language/' . $file . '.' . $this->phpEx))
		{
			include($this->phpbb_root_path . 'language/' . $file . '.' . $this->phpEx);

			if (!isset($help) || !is_array($help))
			{
				trigger_error('BAD_FAQ_FILE');
			}

			return $help;
		}
		else
		{
			trigger_error('FAQ_FILE_NOT_EXIST');
		}
	}

	/**
	* Builds the FAQ array and returns it
	*
	* @param array $help - the raw FAQ data
	*/
	protected function build_faq_array($help)
	{
		$faq	= array();
		$cat_id	= $field_id = 0;
		foreach ($help as $ary)
		{
			if ($ary[0] == '--')
			{
				$cat_id++;
				$faq[$cat_id]['--'] = $ary[1];
				$field_id = 0;
			}
			else
			{
				$field_id++;
				$faq[$cat_id][$field_id] = $ary;
			}
		}

		return $faq;
	}

		/**
	* Generate next link for acp pages
	*/
	protected function adm_next_link($u_action)
	{
		return '<br /><br /><a href="' . $u_action . '"> ' . $this->user->lang['ON_TO_NEXT'] . '&raquo;</a>';
	}
}
