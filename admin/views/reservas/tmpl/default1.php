<?php defined('_JEXEC') or die; 

/*
 * muestra la salida por pantalla de la vista ver 295
 */
?>
<div class="mypreview">

	<?php foreach ($this->items as $item) : ?>
	<div class="mireserva">
		<div class="reserva_title">
			<a href="<?php echo JRoute::_('index.php?option=com_reserva&view=reserva&id='.(int)$item->id); ?>"><?php echo $item->title;?>
			</a>
		</div>
		<div class="reserva_element_full">
			<a href="<?php echo $item->url; ?>" target="_blank" rel="nofollow">
				<img src="<?php echo $item->img; ?>">
			</a>
		</div>
		<div class="reserva_element_full">
			<strong><?php echo JText::_('COM_RESERVA_EVENTOS_TITULO');?></strong>
		<?php echo $item->titulo; ?>
		</div>
		<div class="reserva_element_full">
			<strong>
				<?php echo JText::_('COM_RESERVA_EVENTOS_INICIO');?>
			</strong><?php echo $item->inicio; ?>
		</div>
		<div class="reserva_element_full">
			<?php echo $item->description; ?>
		</div>
	</div>
	<?php endforeach; ?>
</div>
