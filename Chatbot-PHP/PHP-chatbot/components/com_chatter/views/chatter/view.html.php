<?php
error_reporting(E_ALL);
defined('_JEXEC') or die('Access denied');

jimport('joomla.application.component.view');

class ChatterViewChatter extends JViewLegacy
{
	function display($tpl = null)
	{
		$tpl = JRequest::getCmd('layout',null);

		if(JFactory::getUser()->id > 0)
		{
			$tpl = null;
		}
		else
		{
			$tpl = 'guest_view';
		}

		parent::display($tpl);
	}
}