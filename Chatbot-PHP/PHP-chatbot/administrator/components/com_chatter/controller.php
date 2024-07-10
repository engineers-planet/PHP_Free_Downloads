<?php

defined('_JEXEC') or die('Access denied');

jimport('joomla.application.component.controller');

class ChatterController extends JControllerLegacy
{
	// Chat History function
	function chat_hist()
	{
		JToolBarHelper::Title('Chat History');
		echo "Chat history here.";
	}

	function block_usr()
	{
		JToolBarHelper::Title('Blocked Users');
		echo "Blocked user here...";
	}
}