<?php

class ReservaModelEvento extends JModelAdmin
{
protected $text_prefix = 'COM_RESERVA';
public $typeAlias = 'com_reserva.evento';
/**
 * obtiene la tabla en cual se guardara y obtendra nuestros 
 * datos en la base de datos 
 * @param type $type
 * @param type $prefix
 * @param type $config
 * @return type
 */
public function getTable($type = 'Evento', $prefix = 'ReservaTable', $config = array())
{        echo 'llega aca';
	return JTable::getInstance($type, $prefix, $config);
        echo 'pasoo por aca muere en otro lado';
}
/**
 * obtiene el formulario evento.xml 
 * @param type $data
 * @param type $loadData
 * @return boolean
 */
public function getForm($data = array(), $loadData = true)
{	
	$form = $this->loadForm('com_reserva.evento', 'evento',array('control' => 'jform', 'load_data' => $loadData));
	if (empty($form))
	{
		return false;
	}     
	return $form;
}
protected function loadFormData()
{
	$data = JFactory::getApplication()->getUserState('com_reserva.edit.evento.data', array());
	if (empty($data))
	{
		$data = $this->getItem();
	}
	return $data;
}
/**
 * Cambia los datos antes de ser mostrado
 * @param type $table
 * 
 */
protected function prepareTable($table)
{
	$table->titulo = htmlspecialchars_decode($table->titulo,ENT_QUOTES);
}


/**
 *  controla permisos para borrar items
 * @param type $record
 * @return type
 */
protected function canDelete($record)
{
if (!empty($record->id))
{
if ($record->state != -2)
{
return;
}
$user = JFactory::getUser();
if ($record->catid)
{
return $user->authorise('core.delete','com_reserva.category.'.(int) $record->catid);
}
else
{
return parent::canDelete($record);
}
}
}
/**
 * permisos para cambiar el estado de los items publicar/despublicar/papelera/archivar
 * @param type $record
 * @return type
 */
protected function canEditState($record)
{
$user = JFactory::getUser();
if (!empty($record->catid))
{
return $user->authorise('core.edit.state','com_reserva.category.'.(int) $record->catid);
}
else
{
return parent::canEditState($record);
}
}
}