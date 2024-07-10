<?php

defined('_JEXEC') or die('Access denied');

jimport('joomla.application.component.controller');

$controller = JControllerLegacy::getInstance('Chatter');

$controller->execute(JRequest::getCmd('task'));

$controller->redirect();