<?php
/*
 * crea las barras de menu, solocita items etc y el el template presenta los
 * datos que se encuentra en /tmpl/default.php
 * vista Eventos: vista de lista 
 */

defined('_JEXEC') or die;
class ReservaViewEventos extends JViewLegacy
{
	protected $items; //items obtenidos del modelo
	protected $state;//permite saber cual es columna ordenar y la direccion  
	protected $pagination;//paginacion de item 

	public function display($tpl = null)
	{
		$this->items = $this->get('Items');
		$this->state = $this->get('State');
		$this->pagination = $this->get('Pagination');
		//agrega los link de submenus a la barra de navegacion
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
		return false;
		}
		$this->addToolbar();
			//barra de busqueda y fitro
		parent::display($tpl);
	}

	protected function addToolbar()
	{
		$canDo = ReservaHelper::getActions();
		$bar = JToolBar::getInstance('toolbar');
		JToolbarHelper::title(JText::_('COM_RESERVA_MANAGER_EVENTOS'), '');
		JToolbarHelper::addNew('evento.add');
		if ($canDo->get('core.edit'))
		{
			JToolbarHelper::editList('evento.edit');
		}
		if ($canDo->get('core.edit.state')) 
		{
			JToolbarHelper::publish('eventos.publish', 'JTOOLBAR_PUBLISH',true);
			JToolbarHelper::unpublish('eventos.unpublish', 'JTOOLBAR_UNPUBLISH',true);
			JToolbarHelper::archiveList('eventos.archive');
			JToolbarHelper::checkin('eventos.checkin');
		}
		
		//agregar filtro a la vista para busqueda
		JHtmlSidebar::setAction('index.php?option=com_reserva&view=eventos');
		JHtmlSidebar::addFilter(JText::_('JOPTION_SELECT_PUBLISHED'),'filter_state',
		JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'),'value', 'text', 
		$this->state->get('filter.state'), true));
		
		/*
		if ($canDo->get('core.delete'))
		{
			JToolBarHelper::deleteList('', 'eventos.delete', 'JTOOLBAR_DELETE');
		}
		se replaza el boton de borrado por envio a la papelera en vez de borrado completamente
		*/
		$state  = $this->get('State');
		if ($state->get('filter.state') == -2 && $canDo->get('core.delete'))
		{
			JToolbarHelper::deleteList('', 'eventos.delete', 'JTOOLBAR_EMPTY_TRASH');
		} elseif ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::trash('eventos.trash');
		}
		
		if ($canDo->get('core.admin'))
		{
			JToolbarHelper::preferences('com_reserva');
		}
	}
	
	protected function getSortFields()
	{
		return array(
		'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
		'a.state' => JText::_('JSTATUS'),
		'a.title' => JText::_('JGLOBAL_TITLE'),
		'a.id' => JText::_('JGRID_HEADING_ID'));
        }
}