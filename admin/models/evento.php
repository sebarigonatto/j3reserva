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
	
	// Carga los datos en el formulario. En $data estás los datos de la BD, se le agrega el campo item_checkboxes
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
	{// Se pone el check los items seleccionados
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
	
	public function save($data)
	{	
		
		$table_reserva = $this->getTable('Reserva', 'ReservaTable', array());
		$table_evento = $this->getTable('Evento', 'ReservaTable', array());
		
		$isNew = false;
		
		if ($data['id'] == 0){
			$isNew = true;
		}
		
		// Primero insertar el evento
		if (!$table_evento->bind($data))
		{
			$this->setError(JText::sprintf('EVENTO BIND FAILED', $user->getError()));
			return false;
		}
		if (!$table_evento->save($data))
		{
			$this->setError($user->getError());
			return false;
		}
		
		// Obtener los items nuevos y los existentes
		//$itemsReserva = array();
		if (isset($data['items_checkboxes'])){
			$itemsReserva = $data['items_checkboxes'];
		} else {
			$itemsReserva = array();
		}
		
		// Chequear si el evento editado es nuevo o se está modificando
		//$itemsExistentes = array();
		if ($isNew) {
			$data['evento_id'] = (int) $table_evento->id;
			$itemsExistentes = array();
		}
		else {
			$data['evento_id'] = $data['id'];
			$itemsExistentes = $this->getItemsForEvent($data['id']);
		}
		
		unset($data['items_checkboxes']);
		$data['id'] = '';
		
		$insertarItems = array_diff($itemsReserva, $itemsExistentes);
		$borrarItems = array_diff($itemsExistentes, $itemsReserva);
		
		$this->deleteItems($data['evento_id'], $borrarItems);
		$this->insertItems($table_reserva, $data, $insertarItems);
		
		return true;
	}
	
	protected function insertItems($table_reserva, $data, $items){
		// Bind the data.
		if (!$table_reserva->bind($data))
		{
			$this->setError(JText::sprintf('RESERVA BIND FAILED', $user->getError()));
			return false;
		}
		
		$len = count($items);
		
 		//for($i=0; $i<$len; $i++)
		foreach ($items as $item)
		{
			$data['item_id'] = $item;
			
			// Store the data.
			if (!$table_reserva->save($data))
			{
				$this->setError($user->getError());
				return false;
			}
		}
	}
	
	protected function deleteItems($evento_id, $items){		
		$len = count($items);
		
		$db = &JFactory::getDBO();
 
 		//for($i=0; $i<$len; $i++)
		foreach ($items as $item)
		{
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__reserva_reserva'));
			$query->where($db->quoteName('evento_id') . '=' . $evento_id, 'AND');
			$query->where($db->quoteName('item_id') . '=' . $item);
			$db->setQuery($query);
			$db->query();
		}
		return true;
	}
	
	protected function getItemsForEvent($evento_id){
		$db =&JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('item_id');
		$query->from('#__reserva_reserva'); 
		$query->where($db->quoteName('evento_id') . '=' . $evento_id);
		$db->setQuery($query);
		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		$listaItems = $db->loadObjectList();
		$listaResultado = array();
		$len = count($listaItems);
		
		for($i=0; $i<$len; $i++){
			$listaResultado[$i] = $listaItems[$i]->item_id;
		}
		
		return $listaResultado;
	}
}

?>