<?php

/**
 * controlador del vista Lista:Reservas
 * notar que nombre es el plural de la vista formulario de edicion:Reserva
 * 
 */
defined('_JEXEC') or die;
class ReservaControllerReservas extends JControllerAdmin
{
public function getModel($name = 'Reservas', $prefix = 'ReservaModel', $config = array('ignore_request' => true))
{
    $model = parent::getModel($name, $prefix, $config);
    return $model;
}
}