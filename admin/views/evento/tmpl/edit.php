<?php
/*
 * Es el layout de la vista para editar
 */
defined('_JEXEC') or die;
?>

<form action="<?php echo JRoute::_('index.php?option=com_reserva&layout=edit&id='.(int) $this->item->id); ?>" 
      method="post" name="adminForm" id="adminForm" class="form-validate">
	<div class="row-fluid">
		<div class="span10 form-horizontal">
			<fieldset>
				<?php echo JHtml::_('bootstrap.startPane', 'myTab',array('active' => 'details'));?>
				<?php echo JHtml::_('bootstrap.addPanel', 'myTab','details',empty($this->item->id) ? JText::_('COM_RESERVA_NEW_EVENTO', true) :JText::sprintf('COM_RESERVA_EDIT_EVENTO',$this->item->id, true));?>
				<?php foreach ($this->form->getFieldset('myfields') as $field): ?>
					<div class="control-group">
						<div class="control-label">
							<?php echo $field->label; ?>
						</div>
						<div class="controls">
							<?php echo $field->input; ?>
						</div>
				   </div>
				<?php endforeach; ?> 
				<?php echo JHtml::_('bootstrap.endPanel'); ?>
				<input type="hidden" name="task" value="" />
				<?php echo JHtml::_('form.token'); ?>
				<?php echo JHtml::_('bootstrap.endPane'); ?>
			</fieldset>
		</div>
	</div>
</form>
