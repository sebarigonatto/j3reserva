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
}