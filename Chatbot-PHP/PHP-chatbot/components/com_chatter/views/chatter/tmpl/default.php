<?php
error_reporting(E_ALL);

defined('_JEXEC') or die('Access denied');
?>
	<div class='chat-div'>
		<h2 class='chat-app-title'>ChatBot!</h2><hr/>	
		<p style='min-height:20px;'><span class='typing' style='display:none;'><?php echo JFactory::getUser()->name;?> is Typing.....</span></p>
		<div class='chat-msgarea'>
			<div class='msg-disp'>
				
			</div>
			

		</div><br>
		<div class='chat-panel'>
			<input type='text' name='msg' class='msg-input' placeholder='Enter your message...'><br/>
			<button id='send-btn' class='send-btn' name='chatSubmit'>Send</button>
		</div>
	</div>