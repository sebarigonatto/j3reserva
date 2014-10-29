<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
defined('_JEXEC') or die;
class ReservaControllerItems extends JControllerAdmin
{
public function getModel($name = 'Item', $prefix = 'ReservaModel', $config = array('ignore_request' => true))
{
    $model = parent::getModel($name, $prefix, $config);
    return $model;
}
}
