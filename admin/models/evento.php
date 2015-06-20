<?php
defined('_JEXEC') or die;
class ReservaModelEvento extends JModelAdmin
{
	//Prefijo que será usado con los mensajes del controlador
	protected $text_prefix = 'COM_RESERVA';
	
	/**
	 * El modelo llama a la tabla
	 * La tabla tiene el prefijo [ComponentName]Table, y un tipo que coincide con el nombre de la vista
	 * @param type $type
	 * @param type $prefix
	 * @param type $config
	 * @return type
	 */
	public function getTable($type = 'Evento', $prefix = 'ReservaTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	
	/**
	 * Se usa para obtener el formulario, basado en el archivo XML donde se definieron todos los campos 
	 * @param type $data
	 * @param type $loadData
	 * @return boolean
	 */
	public function getForm($data = array(), $loadData = true)
	{
		$app = JFactory::getApplication();
		$form = $this->loadForm('com_reserva.evento', 'evento', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}
		return $form;
	}
	
	// Carga los datos en el formulario
	protected function loadFormData()
	{
		$data = JFactory::getApplication()->getUserState('com_reserva.edit.evento.data', array());
		if (empty($data))
		{
			$data = $this->getItem();
		
		}
			$data->items_checkboxes=$this->getEventosItemlist();
		return $data;
	}
	
	protected function getEventosItemlist()
	{//darle el tilde a los checkboxes
		if (empty( $this->_itemslist )) {
			$db = $this->getDbo();
			$query = $db->getQuery(true);
                        $query->select('r.item_id');
			$query->from('#__reserva_evento AS e');
                        $query->innerjoin('#__reserva_reserva AS r ON r.evento_id = e.id');
                        $query->where('e.id = '.(int) $this->getItem()->id);
			             $db->setQuery($query);
                        $this->_itemslist = $db->loadColumn();
                }

                return $this->_itemslist;
	
	}
	/**
	 * Transforma algunos datos antes de que sean mostrados
	 * @param type $table
	 */
	protected function prepareTable($table)
	{
		//$table->title = htmlspecialchars_decode($table->title, ENT_QUOTES);
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
	
	public function save($data)//***************************************************** ver esta función
	{	
		$dispatcher = JDispatcher::getInstance();
		$table = $this->getTable();
		$key = $table->getKeyName();
		$pk = (!empty($data[$key])) ? $data[$key] : (int)$this->getState($this->getName().'.id');
		$isNew = true;
		
		$table_reserva = $this->getTable('Reserva', 'ReservaTable', array());
		$table_evento = $this->getTable('Evento', 'ReservaTable', array());
		
		
		if (!$table_evento->bind($data))
		{
			$this->setError(JText::sprintf('EVENTO BIND FAILED', $user->getError()));
			return false;
		}
		//$id_evento = $table_evento->save($data);
		if (!$table_evento->save($data))
		{
			$this->setError($user->getError());
			return false;
		}
		
		$data['evento_id'] = (int) $table_evento->id;
		
		$itemsReserva = $data['items_checkboxes'];
		unset($data['items_checkboxes']);
		$data['id'] = '';
		
		$len = count($itemsReserva);
		
		// Bind the data.
		if (!$table_reserva->bind($data))
		{
			$this->setError(JText::sprintf('RESERVA BIND FAILED', $user->getError()));
			return false;
		}
			
 		for($i=0; $i<$len; $i++)
		{
			$data['item_id'] = $itemsReserva[$i];
			
			// Store the data.
			if (!$table_reserva->save($data))
			{
				$this->setError($user->getError());
				return false;
			}
		}
		return true;
	}
}

?>