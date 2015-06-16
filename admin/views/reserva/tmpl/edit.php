<?php
/*
 * Es el layout de la vista para editar
 */
defined('_JEXEC') or die;
JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');
/*
$items = JFormHelper::loadFieldType('itemsselect', false);
$itemsOptions=$items->getOptions();
*/
?>
<form action="<?php echo JRoute::_('index.php?option=com_reserva&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
	<div class="row-fluid">
		<div class="span10 form-horizontal">
			<fieldset>
				<?php echo JHtml::_('bootstrap.startPane', 'myTab', array('active' => 'details')); ?>
				<?php echo JHtml::_('bootstrap.addPanel', 'myTab', 'details', empty($this->item->id) ?
					JText::_('COM_RESERVA_NEW_RESERVA', true) : JText::sprintf('COM_RESERVA_EDIT_RESERVA',$this->item->id, true)); ?>
				<div class="control-group">
					<div class="control-label"> <?php echo $this->form->getLabel('id'); ?> </div>
					<div class="controls"> <?php echo $this->form->getInput('id'); ?> </div>
				</div>
				<div class="control-group">
					<div class="control-label"> <?php echo $this->form->getLabel('evento_id'); ?> </div>
					<div class="controls"> <?php echo $this->form->getInput('evento_id'); ?> </div>
				</div>
				<div class="control-group">
					<div class="control-label"> <?php echo $this->form->getLabel('item_id'); ?> </div>
					<div class="controls"> <?php echo $this->form->getInput('item_id'); ?> </div>
				</div>
				<div class="control-group">
					<div class="control-label"> <?php echo $this->form->getLabel('precio'); ?> </div>
					<div class="controls"> <?php echo $this->form->getInput('precio'); ?> </div>
				</div>
				<div class="combo-items">
					<select name="filter_type" class="inputbox">
						<option value=""> - Select Items - </option>
						<?php echo JHtml::_('select.options', $itemsOptions, 'value', 'text');?>
					</select>
                                </div>
                                
				<?php echo JHtml::_('bootstrap.endPanel'); ?>
				<input type="hidden" name="task" value="" />
				<?php echo JHtml::_('form.token'); ?>
				<?php echo JHtml::_('bootstrap.endPane'); ?>
			</fieldset>
		</div>
	</div>
</form>