<?php
/*
 * Es el layout de la vista para editar
 */
defined('_JEXEC') or die;
/*
JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');
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
					JText::_('COM_RESERVA_NEW_EVENTO', true) : JText::sprintf('COM_RESERVA_EDIT_EVENTO',$this->item->id, true)); ?>
					<div class="control-group">
						<div class="controls"> <?php echo $this->form->getInput('id'); ?> </div>
					</div>
					<div class="control-group">
						<div class="control-label"> <?php echo $this->form->getLabel('titulo'); ?> </div>
						<div class="controls"> <?php echo $this->form->getInput('titulo'); ?> </div>
					</div>
					<div class="control-group">
						<div class="control-label"> <?php echo $this->form->getLabel('descripcion'); ?> </div>
						<div class="controls"> <?php echo $this->form->getInput('descripcion'); ?> </div>
					</div>
					<div class="control-group">
						<div class="control-label"> <?php echo $this->form->getLabel('lugar'); ?> </div>
						<div class="controls"> <?php echo $this->form->getInput('lugar'); ?> </div>
					</div>
					<div class="control-group">
						<div class="control-label"> <?php echo $this->form->getLabel('inicio'); ?> </div>
						<div class="controls"> <?php echo $this->form->getInput('inicio'); ?> </div>
					</div>
					<div class="control-group">
						<div class="control-label"> <?php echo $this->form->getLabel('fin'); ?> </div>
						<div class="controls"> <?php echo $this->form->getInput('fin'); ?> </div>
					</div>
					<div class="control-group">
						<div class="control-label"> <?php echo $this->form->getLabel('items_checkboxes'); ?> </div>
						<div class="controls" style="display: block"><?php echo $this->form->getInput('items_checkboxes'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"> <?php echo $this->form->getLabel('precio'); ?> </div>
						<div class="controls"> <?php echo $this->form->getInput('precio'); ?> </div>
					</div>
					<div class="control-group">
						<div class="control-label"> <?php echo $this->form->getLabel('tel'); ?> </div>
						<div class="controls"> <?php echo $this->form->getInput('tel'); ?> </div>
					</div>
					<div class="control-group">
						<div class="control-label"> <?php echo $this->form->getLabel('mail'); ?> </div>
						<div class="controls"> <?php echo $this->form->getInput('mail'); ?> </div>
					</div>
				<?php echo JHtml::_('bootstrap.endPanel'); ?>
				<input type="hidden" name="task" value="" />
				<?php echo JHtml::_('form.token'); ?>
				<?php echo JHtml::_('bootstrap.endPane'); ?>
			</fieldset>
		</div>
	</div>
</form>