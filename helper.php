<?php
defined('_JEXEC') or die;

abstract class ModSanSimeraHelper
{
	public static function getList()
	{
		// get the correct offset and timezone
		$config = JFactory::getConfig();
		$offset = $config->get('offset'); // Europe/Athens
		$timezone = new DateTimeZone(JFactory::getConfig()->get('offset'));
		$offset = $timezone->getOffset(new DateTime)/3600; // 2

		// get the san simera articles
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName('a.id', 'id'));
		$query->select($db->quoteName('a.title'));
		$query->select($db->quoteName('a.alias'));
		$query->select($db->quoteName('a.introtext'));
		$query->select($db->quoteName('a.state'));
		$query->select($db->quoteName('f.value'));
		$query->select('CURDATE() as current_yt_date');
		$query->select('DATE_FORMAT(CURDATE(), "%m-%d") as current_yt_date_format');
		$query->select('(DATE_FORMAT(f.value, "%Y-%m-%d %H:%i:%s")) AS sansimera_date1');
		$query->select('CONVERT_TZ(f.value, "UTC", "EST") AS sansimera_date2');
		$query->select('DATE_FORMAT(DATE_ADD(f.value, INTERVAL 3 HOUR), "%m-%d") AS sansimera_date3');
		$query->select('DATE_FORMAT(CONVERT_TZ(DATE_FORMAT(f.value, "%Y-%m-%d %H:%i:%s"), "+00:00", "+03:00"), "%Y-%m-%d") AS sansimera_date4');

		$query->from($db->quoteName('#__content', 'a'));
		$query->join('LEFT', '#__fields_values AS f ON f.item_id = a.id');

		$query->order('a.id DESC');
		$query->where('DATE_FORMAT(CURDATE(), "%m-%d") = DATE_FORMAT(DATE_ADD(f.value, INTERVAL 3 HOUR), "%m-%d")');

		$db->setQuery($query);

		try
		{
			return $db->loadObjectList();
		}
		catch (RuntimeException $e)
		{
			JError::raiseError(500, $e->getMessage());
			return false;
		}
	}
}