<?php
defined('_JEXEC') or die('Restricted access');
 
JFormHelper::loadFieldClass('list');

class JFormFieldItemsselect extends JFormFieldList
{
	public $type = 'itemsselect';
	
	public function getOptions()
	{
		$options = array();
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('a.id As value, CONCAT(a.nombre, " $", CAST(a.costo AS CHAR)) As text');
		$query->from($db->quoteName('#__reserva_item').' AS a');
		$db->setQuery($query);
		$options = $db->loadObjectList();
		
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}
		return $options;
	}
}