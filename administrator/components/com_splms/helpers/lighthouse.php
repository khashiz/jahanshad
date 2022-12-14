<?php
/**
 * @package com_splms
 * @author JoomShaper <support@joomshaper.com>
 * @copyright Copyright (c) 2010 - 2020 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Uri\Uri;

require_once __DIR__ . '/traits/AuditTablesTrait.php';
require_once __DIR__ . '/traits/AuditTableFieldsTrait.php';
require_once __DIR__ . '/traits/AuditTableFieldTypesTrait.php';
require_once __DIR__ . '/traits/AuditTableFieldNullableTrait.php';
require_once __DIR__ . '/traits/AuditTableFieldDefaultTrait.php';

/**
 * Joomla! System Logging Plugin.
 *
 * @since  1.5
 */
class Lighthouse
{
	/**
	 * HTML contents to render
	 *
	 * @var		array	$html	The HTML contents to render
	 * @since	1.0.0
	 */
	private $html = [];

	/**
	 * Errors array
	 *
	 * @var		array	$errors		The errors while performing sql operations
	 * @since	1.0.0
	 */
	private $errors = [];

	/**
	 * Tables structures
	 *
	 * @var		array	$tables		The tables structure array
	 * @since	1.0.0
	 */
	private $tables = [];

	/**
	 * Installed table description
	 *
	 * @var		array	$installedTables	Installed table description
	 * @since	1.0.0
	 */
	private $installedTables = [];

	/**
	 * Tables fields
	 *
	 * @var		array	$fields		The fields of a table
	 * @since	1.0.0
	 */
	private $fields = [];

	/**
	 * Table field types
	 *
	 * @var		array	$types		The tables field types
	 * @since	1.0.0
	 */
	private $types = [];

	/**
	 * Table field's default values
	 *
	 * @var		array	$defaults		The table field's default values
	 * @since	1.0.0
	 */
	private $defaults = [];

	/**
	 * Nullable fields
	 *
	 * @var		array	$nullables		The nullable fields
	 * @since	1.0.0
	 */
	private $nullables = [];

	/**
	 * Database Name
	 *
	 * @var		string	$db		The database name.
	 * @since	1.0.0
	 */
	private $db = null;

	/**
	 * Database Prefix
	 *
	 * @var		string	$prefix		The database prefix.
	 * @since	1.0.0
	 */
	private $prefix = null;

	use AuditTablesTrait;
	use AuditTableFieldsTrait;
	use AuditTableFieldTypesTrait;
	use AuditTableFieldNullableTrait;
	use AuditTableFieldDefaultTrait;

	/**
	 * Constructor.
	 *
	 * @param   object  &$subject  The object to observe.
	 * @param   array   $config    An optional associative array of configuration settings.
	 *
	 * @since   3.9.0
	 */
	public function __construct()
	{
		$this->html = [];

		$conf = Factory::getConfig();

		$this->db = $conf->get('db', '');
		$this->prefix = $conf->get('dbprefix', '');

		$this->setSqlModes();
		$this->extractSQL();
	}

	public function run()
	{
		$app = Factory::getApplication();
		$input = $app->input;

		$this->auditAndFixTables();
		$this->generateInstalledTablesDescriptions();

		$this->auditMissingFields();
		$this->auditRemovedFields();

		$this->auditFieldTypesMismatches();

		$this->auditNullTypeMismatches();

		$this->auditDefaultValueMismatches();
	}

	public function fix()
	{
		$this->auditAndFixTables();
		$this->generateInstalledTablesDescriptions();

		$this->auditAndFixTableFields();
		$this->auditAndFixFieldTypeMismatches();
		$this->auditAndFixNullTypeMismatches();
		$this->auditAndFixDefaultValueMismatches();
	}

	public function getHtml()
	{
		return $this->html;
	}

	public function getErrors()
	{
		return $this->errors;
	}

	private function setSqlModes()
	{
		try
		{
			$db 	= Factory::getDbo();
			$query 	= "SET GLOBAL SQL_MODE='ALLOW_INVALID_DATES,ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION'";
			$db->setQuery($query);
			$db->execute();
		}
		catch (Exception $e)
		{
			$this->errors[] = $e->getMessage();
			echo $e->getMessage();
		}
	}

	private function getInstallationFile($path)
	{
		if (Folder::exists($path))
		{
			$files = Folder::files($path);
			$folders = Folder::folders($path);

			if (!empty($files))
			{
				foreach ($files as $file)
				{
					if (preg_match("@^install.*\.sql$@i", $file))
					{
						return $path . '/' . $file;
					}
				}
			}

			if (!empty($folders))
			{
				foreach ($folders as $folder)
				{
					$result = $this->getInstallationFile($path . '/' . $folder);

					return $result;
				}
			}
		}

		return false;
	}

	private function lines()
	{
		$input = Factory::getApplication()->input;
		$component = $input->get('option');

		if (empty($component))
		{
			throw new Exception(sprintf('No Component Found!'));
		}

		$sqlPath = JPATH_ROOT . '/administrator/components/' . $component . '/sql';

		$sqlFile = $this->getInstallationFile($sqlPath);

		if (empty($sqlFile))
		{
			throw new \Exception('No sql file found!');
		}

		$file = fopen($sqlFile, 'r');

		$lineNumber = 0;

		while (($line = fgets($file)) !== false)
		{
			$lineNumber++;
			yield $lineNumber => $line;
		}

		fclose($file);
	}

	private function extractSQL()
	{
		$lastTableEncountered = '';

		foreach ($this->lines() as $lineNo => $line)
		{
			$line = trim($line);

			if (preg_match("@^--.*@", $line))
			{
				continue;
			}

			if (preg_match("@(?<=\s)`(#__.+)`(?=\s)@", $line, $matches))
			{
				$lastTableEncountered = $matches[1];
				$this->tables[$lastTableEncountered] = [];
			}

			if (!empty($lastTableEncountered))
			{
				if (preg_match("@[^\s]+@", $line))
				{
					$this->tables[$lastTableEncountered][] = $line;
				}
			}

			if (preg_match("@^`(.+)`@", $line, $matches))
			{
				$this->fields[$lastTableEncountered][$matches[1]] = preg_replace("@,$@", "", $line);
			}

			if (preg_match("@^`(.+)`\s+((.+(\([\d,\s]+\))|([a-z]+))(\s+unsigned)?)@i", $line, $matches))
			{
				$this->types[$lastTableEncountered][$matches[1]] = strtolower($matches[2]);
			}

			if (preg_match("@^`(.+)`(.+(not\s+null))?@i", $line, $matches))
			{
				$isNull = !empty($matches[3]) ? 'no' : 'yes';

				if (preg_match("@default\s+null@i", $line))
				{
					$isNull = 'yes';
				}

				$this->nullables[$lastTableEncountered][$matches[1]] = $isNull;
			}

			if (preg_match("@^`(.+)`.*(?<=default\s)([\'\"])?(?(2)([a-z\d\-_\:\s\*\&\$\?\<\>\!\^\#\%\(\)\[\]\.]+)|(\b\w+\b))?@i", $line, $matches))
			{
				if (isset($matches[4]))
				{
					$value = $matches[4];
				}
				elseif (isset($matches[3]))
				{
					$value = $matches[3];
				}
				else
				{
					$value = '';
				}

				$value = strtolower($value) === 'null' ? null : $value;
				$this->defaults[$lastTableEncountered][$matches[1]] = $value;
			}
		}
	}

	private function generateInstalledTablesDescriptions()
	{
		if (!empty($this->tables))
		{
			foreach ($this->tables as $table => $structure)
			{
				$this->installedTables[$table] = $this->getTableDescription($table);
			}
		}
	}

	private function stylesheets()
	{
		$cssPath = Uri::root() . '/plugins/system/lighthouse/assets/lighthouse.css';

		return "<link rel='stylesheet' href='" . $cssPath . "' />";
	}

	private function scripts()
	{
		$jsPath = Uri::root() . '/plugins/system/lighthouse/assets/lighthouse.js';

		return "<script src='" . $jsPath . "'></script>";
	}


	private function getRealTableName($table)
	{
		return preg_replace("@^#__@", $this->prefix, $table);
	}

	private function getAllTheInstalledTables()
	{
		try
		{
			$db 	= Factory::getDbo();
			$query 	= $db->getQuery(true);
			$query->select('table_name')
				->from($db->quoteName('information_schema.tables'))
				->where($db->quoteName('table_schema') . ' = ' . $db->quote($this->db));
			$db->setQuery($query);

			$tables = $db->loadObjectList();

			$output = [];

			if (!empty($tables))
			{
				foreach ($tables as $table)
				{
					$output[] = $table->table_name;
				}
			}

			return $output;
		}
		catch (Exception $e)
		{
			return $e->getMessage();
		}
	}

	private function getTableNames()
	{
		return array_keys($this->tables);
	}

	private function getTableColumns($tableName)
	{
		$db = Factory::getDbo();

		return array_keys($db->getTableColumns($tableName));
	}

	private function getTableDescription($table)
	{
		try
		{
			$db = Factory::getDbo();
			$sql = "DESCRIBE " . $db->quoteName($table);
			$db->setQuery($sql);

			$description = $db->loadObjectList();
		}
		catch (Exception $e)
		{
			echo $e->getMessage();
		}

		return $description;
	}

	private function getTableInformation($table, $prop)
	{
		$prop = ucfirst($prop);
		$data = $this->installedTables[$table];

		$information = [];

		if (!empty($data))
		{
			foreach ($data as $row)
			{
				switch ($prop)
				{
					case 'Type':
					case 'Null':
					case 'Key':
						$value = strtolower($row->$prop);
					break;
					default:
						$value = $row->$prop;
					break;
				}

				$information[$row->Field] = $value;
			}
		}

		return $information;
	}
}
