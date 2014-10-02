<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
defined('_JEXEC') or die;

class FolioModelFolios extends JModelList
{
public function __construct($config = array())
{
    parent::__construct($config);
}

protected function getListQuery()
{
    $db = $this->getDbo();
    $query = $db->getQuery(true);
    $query->select('c.*');
    $query->from($db->quoteName('#__items').' AS c');
    return $query;
}
}
