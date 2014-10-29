<?php
defined('_JEXEC') or die;
class ReservaModelItem extends JModelAdmin
{
protected $text_prefix = 'COM_RESERVA';

public function getTable($type = 'Item', $prefix = 'ReservaTable', $config = array())
{
return JTable::getInstance($type, $prefix, $config);
}
public function getForm($data = array(), $loadData = true)
{
    $app = JFactory::getApplication();
    $form = $this->loadForm('com_reserva.item', 'item', array('control' => 'jform','load_data' => $loadData));

    if (empty($form))
    {
     return false;
    }
    return $form;
}
protected function loadFormData()
{
    $data = JFactory::getApplication()->getUserState('com_reserva.edit.item.data', array());
    if (empty($data))
    {
      $data = $this->getItem();
    }
    return $data;
}
protected function prepareTable($table)
{
    $table->nombre = htmlspecialchars_decode($table->nombre,ENT_QUOTES);
}
}