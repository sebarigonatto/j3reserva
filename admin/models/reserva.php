<?php
defined('_JEXEC') or die;
class ReservaModelReserva extends JModelAdmin
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
	public function getTable($type = 'Reserva', $prefix = 'ReservaTable', $config = array())
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
		$form = $this->loadForm('com_reserva.reserva', 'reserva',
		array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}
		return $form;
	}
	
	// Carga los datos en el formulario
	protected function loadFormData()
	{
		$data = JFactory::getApplication()->getUserState('com_reserva.edit.reserva.data', array());
		if (empty($data))
		{
			$data = $this->getItem();
		}
		return $data;
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
		//$data['items_checkboxes'] = implode(',', $data['items_checkboxes']);
		
		$table_reserva = $this->getTable('Reserva', 'ReservaTable', array());
		
		$itemsReserva = $data['items_checkboxes'];
		unset($data['items_checkboxes']);
		$len = count($itemsReserva);
 		for($i=0; $i<$len; $i++)
		{
			$data['item_id'] = $itemsReserva[$i];
			
			// Bind the data.
			if (!$table_reserva->bind($data))
			{
				$this->setError(JText::sprintf('RESERVA BIND FAILED', $user->getError()));
				return false;
			}
			// Store the data.
			if (!$table_reserva->save($data))
			{
				$this->setError($user->getError());
				return false;
			}
		}
		// Initialise variables.
		//$userId = (!empty($data['id'])) ? $data['id'] : (int)$this->getState('user.id');
		//$user = JFactory::getUser();

		
		//$table_evento = $this->getTable('TableTwo', 'ReservaTable', array());

		
/*
		if (!$table_evento->bind($data))
		{
			$this->setError(JText::sprintf('USERS PROFILE BIND FAILED', $user->getError()));
			return false;
		}
*/
		
/*
		if (!$table_evento->save($data))
		{
			$this->setError($user->getError());
			return false;
		}
*/
		return true;
	}
}

?>