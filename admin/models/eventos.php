<?php

/*
 * modelo para la Vista Eventos
 */

defined('_JEXEC') or die;

class ReservaModelEventos extends JModelList
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
  
 */
$query
     ->select(array('b.*'))
    ->from($db->quoteName('#__eventos', 'b'))
     ;

return $query;
}
}