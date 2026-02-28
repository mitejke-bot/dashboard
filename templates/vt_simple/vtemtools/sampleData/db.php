<?php
defined('_JEXEC') or die;
class VTEMSampleData {
	public function installSampleData()
	{
		// Get the application.
		$app = JFactory::getApplication('site');
		$db = JFactory::getDbo();
		$data = dirname(__FILE__).'/sample_data.sql';
		if (!file_exists($data))
		{
			$app->enqueueMessage(JText::sprintf('INSTL_DATABASE_FILE_DOES_NOT_EXIST', $data), 'notice');
			return false;
		}
		elseif (!$this->populateDatabase($db, $data))
		{
			return false;
		}

		return true;
	}

	/**
	 * Method to import a database schema from a file.
	 *
	 * @param   JDatabaseDriver  $db      JDatabase object.
	 * @param   string           $schema  Path to the schema file.
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   3.1
	 */
	public function populateDatabase($db, $schema)
	{
		// Get the application
		/* @var InstallationApplicationWeb $app */
		$app = JFactory::getApplication('site');

		$return = true;

		// Get the contents of the schema file.
		if (!($buffer = file_get_contents($schema)))
		{
			$app->enqueueMessage($db->getErrorMsg(), 'notice');

			return false;
		}

		// Get an array of queries from the schema and process them.
		$queries = $this->_splitQueries($buffer);

		foreach ($queries as $query)
		{
			// Trim any whitespace.
			$query = trim($query);

			// If the query isn't empty and is not a MySQL or PostgreSQL comment, execute it.
			if (!empty($query) && ($query{0} != '#') && ($query{0} != '-'))
			{
				// Execute the query.
				$db->setQuery($query);

				try
				{
					$db->execute();
				}
				catch (RuntimeException $e)
				{
					$app->enqueueMessage($e->getMessage(), 'notice');
					$return = false;
				}
			}
		}

		return $return;
	}

	/**
	 * Method to split up queries from a schema file into an array.
	 *
	 * @param   string  $query  SQL schema.
	 *
	 * @return  array  Queries to perform.
	 *
	 * @since   3.1
	 */
	protected function _splitQueries($query)
	{
		$buffer = array();
		$queries = array();
		$in_string = false;

		// Trim any whitespace.
		$query = trim($query);

		// Remove comment lines.
		$query = preg_replace("/\n\#[^\n]*/", '', "\n" . $query);

		// Remove PostgreSQL comment lines.
		$query = preg_replace("/\n\--[^\n]*/", '', "\n" . $query);

		// Find function.
		$funct = explode('CREATE OR REPLACE FUNCTION', $query);

		// Save sql before function and parse it.
		$query = $funct[0];

		// Parse the schema file to break up queries.
		for ($i = 0; $i < strlen($query) - 1; $i++)
		{
			if ($query[$i] == ";" && !$in_string)
			{
				$queries[] = substr($query, 0, $i);
				$query = substr($query, $i + 1);
				$i = 0;
			}

			if ($in_string && ($query[$i] == $in_string) && $buffer[1] != "\\")
			{
				$in_string = false;
			}
			elseif (!$in_string && ($query[$i] == '"' || $query[$i] == "'") && (!isset ($buffer[0]) || $buffer[0] != "\\"))
			{
				$in_string = $query[$i];
			}

			if (isset ($buffer[1]))
			{
				$buffer[0] = $buffer[1];
			}

			$buffer[1] = $query[$i];
		}

		// If the is anything left over, add it to the queries.
		if (!empty($query))
		{
			$queries[] = $query;
		}

		// Add function part as is.
		for ($f = 1; $f < count($funct); $f++)
		{
			$queries[] = 'CREATE OR REPLACE FUNCTION ' . $funct[$f];
		}

		return $queries;
	}
}
