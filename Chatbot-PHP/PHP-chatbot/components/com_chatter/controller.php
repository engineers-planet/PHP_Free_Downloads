<?php

error_reporting(E_ALL);

defined('_JEXEC') or die('Access denied');

include('simple_html_dom.php');

jimport('joomla.application.component.controller');

class ChatterController extends JControllerLegacy
{

	/**
	* Default function to initiate chat window and set the chat going.
	*/
	function chat()					# Default function 'chat'
	{
		$doc = JFactory::getDocument();
		$doc->addStyleSheet(JURI::root().'media/com_chatter/css/chatter.css');		# Link custom CSS file
		$doc->addScript(JURI::root().'media/com_chatter/js/jquery-3.4.0.min.js');	# Link the jQuery file
		$doc->addScript(JURI::root().'media/com_chatter/js/frontend.js');		# Link custom JS file

		if(!JRequest::getVar('view'))
		{
			JRequest::setVar('view','chatter');
		}

		parent::display();
	}


	/**
	* Function to send the input message as ajax request in form of JSON object.
	*/
	function getMsgRequest()			# Function to get input from user and send ajax request as JSON
	{
		$app = JFactory::getApplication();
		$msg = JRequest::getString('msg');
		$user = JFactory::getUser()->id;
         

		$res = array();

		if($user == 0)						# Check if the user is logged in or not
		{
			$res['status'] = false;
			$res['msg'] = 'Please login first!';
			echo json_encode($res);
			exit();
		}

		if($msg == "")						# Check if the input is blank/null
		{
			$res['status'] = false;
			$res['msg'] = 'Please enter message!';
			echo json_encode($res);
			exit();
		}

		if($chatID = $this->chatToDb($msg,$user))		# 1. Call to insert input msg from user and get last
		{							# inserted ID.
			$msgDtl = $this->showLastMsg($chatID);		# 2. Call to fetch the msg using last inserted ID.
			$res['chatDetails'] = $msgDtl;
			$res['status'] = true;
		}
		else
		{
			$res['status'] = false;
		}
		echo json_encode($res);					# Sending JSON encoded data with status check
		$app->close();
	}


	/**
	* Function to insert and store the last msg input by user.
	* 
	* @param string $msg
	*			The string input from user.
	*
	* @param int $user
	*			The user id from which the message was inserted. 
	*
	* @return int $inserted_id
	*			The id of last successfully inserted row.
	*/
	function chatToDb($msg, $user)
	{
		$model = $this->getModel('Chatter');			# Getting model instance of 'Chatter' model
		$inserted_id = $model->insert($msg, $user);		# get last insert id

		return $inserted_id;
	}


	/**
	* Function to select last inserted chat msg w.r.t last inserted ID.
	* 
	* @param int $id
	*			The last inserted row ID returned from the above function 'chatToDb'.
	*
	* @return array $lastIns
	*			Array containing the message, user id w.r.t last inserted id. 
	*/
	private function showLastMsg($id)
	{
		$model = $this->getModel('Chatter');			# Getting model instance of 'Chatter' model
		$lastIns = $model->selectLastInserted($id);		# get msg of last inserted id

		return $lastIns;
	}


	/**
	* Function to scrap html from any URL.
	* 
	* @param string $url
	*			The URL from which the data is to be scraped.
	*
	* @return object $html_output
	*			The html parsed from the URL passed using cURL.
	*/
	// 
	function scrapHTML($url)
	{
		if(!function_exists('curl_init'))
		{
			die('cURL is not installed. Please install!');
		}

		$options = Array(
            CURLOPT_RETURNTRANSFER => TRUE,  // Setting cURL's option to return the webpage data
            CURLOPT_FOLLOWLOCATION => TRUE,  // Setting cURL to follow 'location' HTTP headers
            CURLOPT_AUTOREFERER => TRUE, // Automatically set the referer where following 'location' HTTP headers
            CURLOPT_CONNECTTIMEOUT => 120,   // Setting the amount of time (in seconds) before the request times out
            CURLOPT_TIMEOUT => 120,  // Setting the maximum amount of time for cURL to execute queries
            CURLOPT_MAXREDIRS => 10, // Setting the maximum number of redirections to follow
            CURLOPT_USERAGENT => "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1a2pre) Gecko/2008073000 Shredder/3.0a2pre ThunderBrowse/3.2.1.8",  // Setting the useragent
            CURLOPT_URL => $url, // Setting cURL's URL option with the $url variable passed into the function
        );

		$curl = curl_init();	
		curl_setopt_array($curl, $options);
		$html_output = curl_exec($curl);

		if(curl_errno($curl))
		{
			$curl_err = "Scraping error : ".curl_error($curl);
				
			var_dump($curl_err);				
			exit();
		}

		curl_close($curl);

		return $html_output;
	}


	/**
	* Function for checking for a response of msg entered.
	*/
	function checkForResponse()
	{	
		$app = JFactory::getApplication();
        $msg=JRequest::getVar('msg');				# Getting request from JS with msg-content


		$res = array();

		#-------------------------- Predefined commands ---------------------------------------------#

		$greets = array('hi','hey','hello','hola','hey there', 'hi there', 'hello there','namaste','bonjour');

		$abouts = array('how are you','hi how are you','hey how are you', 'hello how are you','how are you today','how are you feeling',' how are you feeling today','how are you doing','how you doin');

		$whos = array('who are you', 'whats your name', 'who am I talking to', 'what are you', 'what is your name','what are you called','what do people call you');

		$byes = array('bye','until next time','bye bye','good bye','see you soon','chao','goodbye','catch you later','see you next time','see you later');

		$locate = array('location','my current location','my location','current location','where am i', 'what is my location', 'what is my current location', 'whats my location','whats my current location', 'get my location', 'what is this place');

		$weather = array('weather','how is the weather today','how is the weather right now','weather right now','current weather','current weather conditions','how is the weather','weather conditions','weather forecast');

		$times = array('current time', 'what is the time right now', 'time right now', 'tell me the time', 'what is the time', 'whats the time', 'whats the time right now');

		$dates = array('what is the date today','todays date','what is the date','whats the date','whats the date today','current date','date today');

		$day_ask = array('todays day','what is the day today','current day','the day today','current day','day today');

		$helper_cmd = array('commands','chatbot help','help for chatbot','help us','all commands');

		#--------------------------------------------------------------------------------------------#

		#--------------------------- Bot Responses --------------------------------------------------#

		$about_resp = array('i am fine.', 'i am doing great.', 'i\'m fine, thank you.', 'i am doing good and am glad you asked, thank you.','everything is good, thank you.', 'everything is great.', 'everything Seems good.');
		
		$whos_resp = array('My name is bot.','I am the bot, your helping hand.','The name is bot... Chat Bot!','I am the bot.','People call me bot.');

		#---------------------------------------------------------------------------------------------#

		$msg_ext = strtolower($msg);
		$msg_arr = explode(' ', $msg_ext);

		$msg = strtolower(trim(str_replace(array('/','?','!',';',',','.','@','$','#','*','^','%','~','%','(',')','{','}','[',']',':','&','"','\'','<','>','\\'), '', $msg)));
  
		$Bot = 'BOT';
		$resp = '';

		$respDtl = array();


		if(in_array($msg, $greets))			# Check for greetings
		{
			$resp = array_rand($greets);
			$resp=$greets[$resp].' !'; 
		}
		else if(in_array($msg,$abouts))			# Check for abouts
		{
			$resp = array_rand($about_resp);
		    $resp=$about_resp[$resp];
		}
		else if(in_array($msg, $whos))			# Check for whos
		{
			$resp = array_rand($whos_resp);
		    $resp=$whos_resp[$resp];
		}
		else if(in_array($msg, $byes))			# Check for Byes
		{
			$resp = array_rand($byes);
		    $resp=$byes[$resp];
		}
		else if(in_array($msg, $times))			# Check for current time
		{
			$curr_time = date('h:i:s A');
			$resp = "current time is : ".$curr_time;
		}
		else if(in_array($msg, $dates))			# Check for current date
		{
			$curr_date = date('F d, Y');
			$resp = "Date today is : ".$curr_date;			
		}
		else if(in_array($msg, $day_ask))		# Check for current day
		{
			$curr_day = date('l');
			$resp = "Day today is : ".$curr_day;			
		}
		else if(in_array($msg, $locate))		# Check for current location : Based on IP
		{
			$locate_url = 'http://ip-api.com/json/';
			$curr_loc = json_decode(file_get_contents($locate_url));
			$locate_data = array($curr_loc->city, $curr_loc->regionName, $curr_loc->country);

			$resp = implode(', ', $locate_data);
		}
		else if(in_array($msg, $weather))		# Check for weather w.r.t current location
		{
			$app = JFactory::getApplication();
			$locate_url = 'http://ip-api.com/json/';
			$curr_loc = json_decode(file_get_contents($locate_url));
			$curr_city = $curr_loc->city;
			$curr_state = $curr_loc->regionName;
			$curr_country = $curr_loc->country;


			$weather_url = 'http://api.apixu.com/v1/current.json?key=6a796cd5ec244b74be4112646192204&q='.$curr_city;
			$weather_data = json_decode(file_get_contents($weather_url));

			$temp_c = ($weather_data->current)->temp_c;
			$temp_f = ($weather_data->current)->temp_f;
		
			$resp = 'Current temperature in '.$curr_city.' : '.$temp_c.' &deg;C | '.$temp_f.' &deg;F';
		}
		else if(in_array($msg, $helper_cmd))		# Check for help commands
		{
			$resp = "List of commands available :-<ol list-style-type='1'>
				<li>Greetings (Eg. - Hi)</li>
				<li>Abouts (Eg. - How are you?).</li>
				<li>Who's (Eg. Who are you?)</li>
				<li>Date, time or Day (Eg. date today, current time or day today)</li>
				<li>Current Geo-location (Eg. Where am I?)</li>
				<li>Current temperature (Eg. Current weather)</li>
				<li>Basic arithmetic caclulation (Eg. calc 3 + 2)</li>
				<li>Search for anything (Eg. Search Potato)</li>
				<li>Byes (Eg. Goodbye)</li></ol>";
		}
		else if((strpos($msg, 'calculate') === 0) || (strpos($msg, 'calc') === 0))	# Check for calculator
		{
			if(($msg_arr[0] == 'calculate') || ($msg_arr[0] == 'calc'))
			{
				if($msg_arr[2] == '+')
				{
					$calc = ((double)$msg_arr[1]) + ((double)$msg_arr[3]);
					$calc = "Sum would be : ".$calc;
				}
				else if($msg_arr[2] == '-')
				{
					$calc = ((double)$msg_arr[1]) - ((double)$msg_arr[3]);
					$calc = "Difference would be : ".$calc;
				}
				else if($msg_arr[2] == '*')
				{
					$calc = ((double)$msg_arr[1]) * ((double)$msg_arr[3]);
					$calc = "Product would be : ".$calc;
				}
				else if($msg_arr[2] == '/')
				{
					if($msg_arr[3] == 0)
					{
						$calc = "Any number cannot be divided by zero!";
					}
					else
					{
						$calc = ((double)$msg_arr[1]) / ((double)$msg_arr[3]);
						$calc = "Division would be : ".$calc;						
					}
				}
				else
				{
					$calc = "Only four basic arithmetic operation (+, -, *, /) are supported right now!";
				}

				$resp = $calc;
			}	
		}
		else if((strpos($msg, 'search') === 0))		# Check for search
		{
			array_shift($msg_arr);
			$search_str = implode(' ',$msg_arr);
			$search_url = "https://en.wikipedia.org/wiki/".$search_str;

			$html = file_get_html($search_url);

			$def_flag = 0;

			foreach($html->find('p') as $para)
			{
				if($def_flag < 1)
				{
					$def = $para->plaintext;
					if((($def != null) || ($def != "")) && (!preg_match('/:$/i', $def)))
					{
						$def_flag++;
					}				
				}
				else
				{
					break;
				}
			}

			if((preg_match('/to:$/i',$def)) || (preg_match('/'.$search_str.':$/i',$def)))
			{
				$resp = $def."<br><a href='".$search_url."' target='_blank'>Read here.</a>";				
			}
			else
			{
				$def = preg_replace('/\[[0-9]+\]/','',html_entity_decode($def));
				$resp = $def;
			}

		}
		else 				# If no commands is applicable, show default text
		{
			$resp = 'No response available for - "'.$msg.'". Check for wrong spellings or commands, for all available commands, type "chatbot help" or "all commands".';
		}

		$resp = ucfirst($resp);

		$respDtl['name'] = $Bot;
		$respDtl['resp'] = $resp;

		$res['status'] = true;
		$res['respDetails'] = $respDtl;
		
		echo json_encode($res);		# send bot response as ajax request, JSON encoded
		exit();
	}

// End of class	
}
