<?php

/*
 * modelo para la Vista Reservas
 */

defined('_JEXEC') or die;

class ReservaModelReservas extends JModelList
{
    public function __construct($config = array())
    {//se setean los campos que se necesitaran en la vista
    if (empty($config['filter_fields']))
    {
        $config['filter_fields'] = array(
        'evento_id', 'b.eventos_id',
        'evento_titulo', 'b.titulo',
        'evento_inicio', 'b.inicio',
        'evento_fin', 'b.fin',
        'evento_lugar', 'b.lugar',
        'evento_descripcion', 'b.descripcion',
        'evento_tel', 'b.tel',
        'evento_mail', 'b.mail',
        'items_id', 'c.id',
        'items_nombre', 'c.nombre',
        'items_imagen','c.imagen',
        'items_descripcion','c.descripcion',
        'items_costo','c.costo'           
        );
    }
    parent::__construct($config);
}
protected function getListQuery()
{
$db = $this->getDbo();
$query = $db->getQuery(true);

//realizar un inner join para obtener la relacion Muchos a Muchos entre eventos e items
/* sql probado
 SELECT * FROM (az94y_eventos_items INNER JOIN az94y_eventos ON az94y_eventos_items.eventos_id = az94y_eventos.id) 
          INNER JOIN az94y_items ON az94y_eventos_items.items_id = az94y_items.id
  
 */
$query
     ->select(array('a.*', 'b.*', 'c.*'))
    ->from($db->quoteName('#__eventos_items', 'a'))
    ->join('INNER', $db->quoteName('#__eventos', 'b') . ' ON (' . $db->quoteName('a.eventos_id') . ' = ' . $db->quoteName('b.id') . ')')
    ->join('INNER', $db->quoteName('#__items', 'c') . ' ON (' . $db->quoteName('a.items_id') . ' = ' . $db->quoteName('c.id') . ')')
   ;

return $query;
}
}