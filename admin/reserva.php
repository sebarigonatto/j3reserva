<?php

/*
 * Punto de Entrada del componente el primer archivo que ejecuta
*/

//evita la ejecucion directa del archivo php(navegacion por url)
defined('_JEXEC') or die;

if (!JFactory::getUser()->authorise('core.manage', 'com_reserva'))
{
    return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}
//crea una instancia del controlador y especifica el nombre del componente
//que sera el prefijo de todas las clases
$controller = JControllerLegacy::getInstance('Reserva');
//como tiene mas de una vista.la Tarea determina lo proximo hara el componente
$controller->execute(JFactory::getApplication()->input->get('task'));
//se redirecciona a la tarea obtenida
$controller->redirect();