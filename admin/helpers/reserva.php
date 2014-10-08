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


	//agregar sub menus de barranavegacion
	//esta funcion crean un link a la vista por defecto reservas(vista de lista)
	// y  link a la vista de categorias
public static function addSubmenu($vName = 'reservas')
{
	JHtmlSidebar::addEntry(
	JText::_('COM_RESERVA_SUBMENU_RESERVAS'),
	'index.php?option=com_reserva&view=reservas',
	$vName == 'reservas'
	);
	JHtmlSidebar::addEntry(JText::_(
	'COM_RESERVA_SUBMENU_EVENTOS'),
	'index.php?option=com_categories&extension=com_reserva',
	$vName == 'eventos'
	);
		
	JHtmlSidebar::addEntry(
	JText::_('COM_RESERVA_SUBMENU_ESTADISTICA'),
	'index.php?option=com_reserva&view=estadisticas',
	$vName == 'estadistica'
	);
}
}