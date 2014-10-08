<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
defined('_JEXEC') or die;

class ReservaTableEvento extends JTable
{
    
    public function __construct(&$db)
    {
        parent::__construct('#__eventos', 'id', $db);
    }

    /**
     * La funcion bind(enlace) se utiliza para preparar los datos 
     * inmediatamente antes de que se guarden el base de datos
     * @param type $array
     * @param type $ignore
     * @return type
     */
    public function bind($array, $ignore = '')
    {
            return parent::bind($array, $ignore);
    }
/**
 * guada los datos en la base de datos
 * @param type $updateNulls
 * @return type
 */
    public function store($updateNulls = false)
    {
        return parent::store($updateNulls);
    }
    
    /**
     * realiza la actualizacion del campo state en la base de datos
     * published/trashed/unpublish
     * @param type $pks
     * @param type $state
     * @param type $userId
     * @return boolean
     */
public function publish($pks = null, $state = 1, $userId = 0)
	{
	$k = $this->_tbl_key;
	JArrayHelper::toInteger($pks);
	$state = (int) $state;
	if (empty($pks))
	{
		if ($this->$k)
		{
			$pks = array($this->$k);
		}
		else
		{
			$this->setError(JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));
			return false;
		}
	}
	$where = $k . '=' . implode(' OR ' . $k . '=', $pks);
	$query = $this->_db->getQuery(true)->update($this->_db->quoteName($this->_tbl))->set($this->_db->quoteName('state') . ' = ' . (int) $state)->where($where);
	$this->_db->setQuery($query);
	try
	{
		$this->_db->execute();
	}
	catch (RuntimeException $e)
	{
		$this->setError($e->getMessage());
		return false;
	}
	if (in_array($this->$k, $pks))
	{
		$this->state = $state;
	}
	$this->setError('');
	return true;
}
}