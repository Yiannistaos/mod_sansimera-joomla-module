<?php
defined('_JEXEC') or die;

JLoader::register('ModSanSimeraHelper', __DIR__ . '/helper.php');
$datetime_now = JHTML::_('date', strtotime('Y-m-d H:i:s'), "Y-m-d H:i:s"); 

$list  = ModSanSimeraHelper::getList($params);

require JModuleHelper::getLayoutPath('mod_sansimera', $params->get('layout', 'default'));