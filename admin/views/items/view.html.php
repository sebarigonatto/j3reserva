<?php
defined('_JEXEC') or die;
class ReservaViewItems extends JViewLegacy
{
    protected $items;
   
    public function display($tpl = null)
    {
        $this->items = $this->get('Items');
        if (count($errors = $this->get('Errors')))
        {
            JError::raiseError(500, implode("\n", $errors));
            return false;
        }
        $this->addToolbar();
        parent::display($tpl);
    }
    
    protected function addToolbar()
    {
        $canDo = ReservaHelper::getActions();
        $bar = JToolBar::getInstance('toolbar');
        JToolbarHelper::title(JText::_('COM_RESERVA_MANAGER_ITEMS'), '');
        JToolbarHelper::addNew('item.add');
        
        if ($canDo->get('core.edit'))
        {
            JToolbarHelper::editList('item.edit');
        }
         if ($canDo->get('core.admin'))
        {
            JToolbarHelper::preferences('com_reserva');
        }
        if ($canDo->get('core.delete'))
	{
			JToolBarHelper::deleteList('', 'items.delete', 'JTOOLBAR_DELETE');
	}
    }
}