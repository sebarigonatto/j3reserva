

<?php
defined('_JEXEC') or die;
/*
 * muesrta la salida por pantalla de la vista
 */

$listOrder = '';
$listDirn = '';
?>
<form action="<?php echo JRoute::_('index.php?option=com_reserva&view=reservas'); ?>"
      method="post" name="adminForm" id="adminForm">
<div id="j-main-container" class="span10">
    <div class="clearfix"> </div>
        <table class="table table-striped" id="reservaList">
            <thead>
            <tr>
            <th width="1%" class="hidden-phone">
            <input type="checkbox" name="checkall-toggle" value="" 
            titulo="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" 
            onclick="Joomla.checkAll(this)" />
            </th>
           
            <th class="title"><?php echo JHtml::_('grid.sort', 'COM_RESERVA_TITULO','a.titulo', $listDirn, $listOrder); ?></th>
            <th width="1%" class="nowrap center hidden-phone"><?php echo JHtml::_('grid.sort', 'COM_RESERVA_INICIO', 'a.inicio', $listDirn, $listOrder); ?></th>
            <th width="1%" class="nowrap center hidden-phone"><?php echo JHtml::_('grid.sort', 'COM_RESERVA_FIN', 'a.fin', $listDirn, $listOrder); ?></th>
            </tr>
            </thead>

        <tbody>
        <!--  agrega los items obteneidos del modelo a cada fila   -->
        
            <?php foreach ($this->items as $i => $item) :?>
             <tr class="row<?php echo $i % 2; ?>">
                <td class="center hidden-phone">
                    <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                </td>
                <td class="nowrap has-context">
                <a href="<?php echo JRoute::_('index.php?option=com_reserva&task=reserva.edit&id='.(int) $item->id); ?>">
                    <?php echo $this->escape($item->titulo); ?>
                </a>
                </td>
            </tr>
            <?php endforeach; ?>
            
           </tbody>
        </table>

    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
    <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
    <?php echo JHtml::_('form.token'); ?>
    </div>
</form>