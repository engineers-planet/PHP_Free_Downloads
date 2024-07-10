var jq = jQuery.noConflict();

jq(document).ready(function(){

	/**
	* Function to "auto-scroll" the chat box to latest response
	*/
	function scrolltoLatest()
	{
		jq('div.msg-disp').scrollTop(jq('div.msg-disp')[0].scrollHeight);
	}


	/**
	* Function for checking Responses from bot PHP function in controller - checkForResp
	* 
	* @param string msg
	*			The input msg for which the response is to be matched.
	*
	* @return html respTags
	*			appends the html code with the appropriate response found in PHP controller 
	*/
  	function giveResp(msg)
	{
		var param = {};
		param.option = 'com_chatter';
		param.task = 'checkForResponse';
		param.msg = msg;

		jq.ajax({
			url:'index.php',
			method:'POST',
			data:param,
			success:function(response)
			{	
				console.log(response);

				response=JSON.parse(response);
                respDtls=response.respDetails;
                var respTags = "";
               
               respTags+='<div class="the-resp"><p class="bot-resp">' + respDtls.name + '</p><p class="resp-content">' + respDtls.resp + '</p></div>';
		       jq('div.msg-disp').append(respTags);

		       scrolltoLatest();
			}
		});
	}

	jq(".msg-input").keypress(function(e){
	    if(e.which == 13){
	        jq('#send-btn').click();//Trigger search button click event
	    }
	});	
	
	jq(document).on('keydown','.msg-input', function(e){
		jq('.typing').show();
	});

	jq(document).on('keyup','.msg-input', function(e){
		jq('.typing').hide();
	});

	/**
	* Onclick chat button
	*/
	jq(document).on('click','#send-btn',function(){
		var msg = jq('.msg-input').val().trim();


		if(msg == "")
		{
			alert('Please enter message!');
			return false;
		}
       

       	// Passing initial parameters - Msg, sender id, task
		var param = {};
		param.option = 'com_chatter';
		param.task = 'getMsgRequest';
		param.msg = msg;

		jq.ajax({							// First Ajax call to PHP function - getMsgReq
			url:'index.php',
			method:'POST',
			data:param,
			success:function(response)
			{  
				jq(".msg-input").val('');		
				response=JSON.parse(response);
                actualresponse=response.chatDetails;
                var chatMsgHTML = "";

				chatMsgHTML+='<div class="the-msg-text"><p class="msg-sender">' + actualresponse.name + '</p><p class="msg-content">' + actualresponse.msgs + '</p></div>';
				jq('div.msg-disp').append(chatMsgHTML);
				
				// Call to JS function giveResp to check response from bot
				giveResp(msg);
			}
		});		
	});
});