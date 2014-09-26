<?php
defined('_JEXEC') or die;
class ReservaHelper
{
public static function getActions($categoryId = 0)
{
	$user = JFactory::getUser();
	$result = new JObject;
	if (empty($categoryId))
	{
		$assetName = 'com_reserva';
		$level = 'component';
	}
	else
	{
		$assetName = 'com_reserva.category.'.(int) $categoryId;
		$level = 'category';
	}
	$actions = JAccess::getActions('com_reserva', $level);
	foreach ($actions as $action)
	{
		$result->set($action->name, $user->authorise($action->name,$assetName));
	}
	return $result;
}
}