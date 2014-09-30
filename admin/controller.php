<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

defined('_JEXEC') or die;
class ReservaController extends JControllerLegacy
{
    //defeni la vista por defecto si no conside con el nombre del componente
protected $default_view = 'reservas';

public function display($cachable = false, $urlparams = false)
{   
    //realiza el chequeo de permisos para realizar la tarea
    require_once JPATH_COMPONENT.'/helpers/reserva.php';
   //obtener las variables del la URL,sino esta nada definido se setea la vista reservas
   // ejemplo index.php?option=com_folio&view=folio&layout=edit
    $view = $this->input->get('view', 'reservas');
    //obtener las variables del la URL,sino esta nada definido se setea el layout
    $layout = $this->input->get('layout', 'default');
    $id = $this->input->getInt('id');
    
    if ($view == 'reserva' && $layout == 'edit' && 
       !$this->checkEditId('com_reserva.edit.reserva', $id))
    {
        $this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
        $this->setMessage($this->getError(), 'error');
        $this->setRedirect(JRoute::_('index.php?option=com_reserva&view=reservas', false));
        return false;
    }
    parent::display();
    return $this;
}
} 
