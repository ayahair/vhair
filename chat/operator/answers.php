<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH / Version 3.6.2                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2018 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Check if the file is accessed only via index.php if not stop the script from running
if (!defined('JAK_ADMIN_PREVENT_ACCESS')) die('You cannot access this file directly.');

// Check if the user has access to this file
if (!jak_get_access("answers", $jakuser->getVar("permissions"), JAK_SUPERADMINACCESS)) jak_redirect(BASE_URL);

// All the tables we need for this plugin
$errors = array();
$jaktable = 'answers';
$jaktable1 = 'departments';

// Now start with the plugin use a switch to access all pages
switch ($page1) {

	case 'delete':
		 
		// Check if user exists and can be deleted
		if (is_numeric($page2)) {
		        
			// Now check how many languages are installed and do the dirty work
			$result = $jakdb->delete($jaktable, ["id" => $page2]);
		
		if (!$result) {
		    $_SESSION["infomsg"] = $jkl['i'];
		    jak_redirect($_SESSION['LCRedirect']);
		} else {
			
			// Now let us delete the define cache file
			$cachestufffile = APP_PATH.JAK_CACHE_DIRECTORY.'/stuff.php';
			if (file_exists($cachestufffile)) {
				unlink($cachestufffile);
			}
			
		    $_SESSION["successmsg"] = $jkl['g14'];
		    jak_redirect($_SESSION['LCRedirect']);
		}
		    
		} else {
		    
		   	$_SESSION["errormsg"] = $jkl['i3'];
		    jak_redirect($_SESSION['LCRedirect']);
		}
		
	break;
	case 'edit':
	
		// Check if the user exists
		if (is_numeric($page2) && jak_row_exist($page2,$jaktable)) {
		
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			    $jkp = $_POST;
			
			    if (empty($jkp['title'])) {
			        $errors['e'] = $jkl['e2'];
			    }
			    
			    if (empty($jkp['answer'])) {
			        $errors['e1'] = $jkl['e1'];
			    }
			    
			    // Let's check if we have a welcome message already in the same language
			    if ($jkp['jak_msgtype'] != 1) {

					$rowa = $jakdb->get($jaktable, ["id", "title"], ["AND" => ["id[!]" => $page2, "department" => $jkp['jak_depid'], "lang" => $jkp['jak_lang'], "msgtype" => $jkp['jak_msgtype']]]);
			        if ($rowa) {
			        	$errors['e2'] = sprintf($jkl['e25'], '<a href="'.JAK_rewrite::jakParseurl('answers', 'edit', $rowa["id"]).'">'.$rowa["title"].'</a>');
			        }
			    }
		    
			    if (count($errors) == 0) {
			
					$result = $jakdb->update($jaktable, ["department" => $jkp['jak_depid'],
					"lang" => $jkp['jak_lang'],
					"title" => $jkp['title'],
					"message" => $jkp['answer'],
					"fireup" => $jkp['jak_fireup'],
					"msgtype" => $jkp['jak_msgtype']], ["id" => $page2]);
			
					if (!$result) {
					    $_SESSION["infomsg"] = $jkl['i'];
		    			jak_redirect($_SESSION['LCRedirect']);
					} else {
						
						// Now let us delete the define cache file
						$cachestufffile = APP_PATH.JAK_CACHE_DIRECTORY.'/stuff.php';
						if (file_exists($cachestufffile)) {
							unlink($cachestufffile);
						}
						
					    $_SESSION["successmsg"] = $jkl['g14'];
		    			jak_redirect($_SESSION['LCRedirect']);
					}
			
				// Output the errors
				} else {
			    	$errors = $errors;
				}
			
			}
		
			// Title and Description
			$SECTION_TITLE = $jkl["m21"];
			$SECTION_DESC = "";
			
			// Get all departments
			$JAK_DEPARTMENTS = $jakdb->select($jaktable1, ["id", "title"], ["ORDER" => ["dorder" => "ASC"]]);
			
			// Call the settings function
			$lang_files = jak_get_lang_files();
		
			$JAK_FORM_DATA = jak_get_data($page2, $jaktable);
			
			// Get the template
			$template = 'editanswer.php';
		
		} else {
		    
		   	$_SESSION["errormsg"] = $jkl['i3'];
		   	jak_redirect(JAK_rewrite::jakParseurl('answers'));
		}
		
	break;
	default:
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $jkp = $_POST;

		    if (isset($jkp['insert_answer'])) {
		    
			    if (empty($jkp['title'])) {
			            $errors['e'] = $jkl['e2'];
			        }
			        
			        if (empty($jkp['answer'])) {
			            $errors['e1'] = $jkl['e1'];
			        }
			        
			        // Let's check if we have a welcome message already in the same language
			        if ($jkp['jak_msgtype'] != 1) {

				        $rowa = $jakdb->get($jaktable, ["id", "title"], ["AND" => ["department" => $jkp['jak_depid'], "lang" => $jkp['jak_lang'], "msgtype" => $jkp['jak_msgtype']]]);

				        if ($rowa) {
				        	$errors['e2'] = sprintf($jkl['e25'], '<a href="'.JAK_rewrite::jakParseurl('answers', 'edit', $rowa["id"]).'">'.$rowa["title"].'</a>');
				        }
				    }
			        
			        if (count($errors) == 0) {

			        	$jakdb->insert($jaktable, ["department" => $jkp['jak_depid'],
						"lang" => $jkp['jak_lang'],
						"title" => $jkp['title'],
						"message" => $jkp['answer'],
						"fireup" => $jkp['jak_fireup'],
						"msgtype" => $jkp['jak_msgtype'],
						"created" => $jakdb->raw("NOW()")]);

						$lastid = $jakdb->id();
			    
			    		if (!$lastid) {
			    		    $_SESSION["infomsg"] = $jkl['i'];
			    			jak_redirect($_SESSION['LCRedirect']);
			    		} else {
			    			
			    			// Now let us delete the define cache file
			    			$cachestufffile = APP_PATH.JAK_CACHE_DIRECTORY.'/stuff.php';
			    			if (file_exists($cachestufffile)) {
			    				unlink($cachestufffile);
			    			}
			    			
			    		    $_SESSION["successmsg"] = $jkl['g14'];
			    			jak_redirect($_SESSION['LCRedirect']);
			    		}
			    
			    // Output the errors
			    } else {
			    
			        $errors = $errors;
			    }
			}

			if (isset($jkp['create_language_pack'])) {

		    	if (isset($jkp['jak_lang_pack']) && !empty($jkp['jak_lang_pack']) && $jakdb->has($jaktable, ["lang[!]" => $jkp['jak_lang_pack']])) {

			    	// That will create a complete entry for one lanugage
			    	$jakdb->query("INSERT INTO ".JAKDB_PREFIX."answers (`id`, `department`, `lang`, `title`, `message`, `fireup`, `msgtype`, `created`) VALUES
					(NULL, 0, '".$jkp['jak_lang_pack']."', 'Enters Chat', '%operator% enters the chat.', 15, 2, NOW()),
					(NULL, 0, '".$jkp['jak_lang_pack']."', 'Expired', 'This session has expired!', 15, 4, NOW()),
					(NULL, 0, '".$jkp['jak_lang_pack']."', 'Ended', '%client% has ended the conversation', 15, 3, NOW()),
					(NULL, 0, '".$jkp['jak_lang_pack']."', 'Welcome', 'Welcome %client%, a representative will be with you shortly.', 15, 5, NOW()),
					(NULL, 0, '".$jkp['jak_lang_pack']."', 'Leave', 'has left the conversation.', 15, 6, NOW()),
					(NULL, 0, '".$jkp['jak_lang_pack']."', 'Start Page', 'Please insert your name to begin, a representative will be with you shortly.', 15, 7, NOW()),
					(NULL, 0, '".$jkp['jak_lang_pack']."', 'Contact Page', 'None of our representatives are available right now, although you are welcome to leave a message!', 15, 8, NOW()),
					(NULL, 0, '".$jkp['jak_lang_pack']."', 'Feedback Page', 'We would appreciate your feedback to improve our service.', 15, 9, NOW()),
					(NULL, 0, '".$jkp['jak_lang_pack']."', 'Quickstart Page', 'Please type a message and hit enter to start the conversation.', 15, 10, NOW()),
					(NULL, 0, '".$jkp['jak_lang_pack']."', 'Group Chat Welcome Message', 'Welcome to our weekly support session, sharing experience and feedback.', 0, 11, NOW()),
					(NULL, 0, '".$jkp['jak_lang_pack']."', 'Group Chat Offline Message', 'The public chat is offline at this moment, please try again later.', 15, 12, NOW()),
					(NULL, 0, '".$jkp['jak_lang_pack']."', 'Group Chat Full Message', 'The public chat is full, please try again later.', 15, 13, NOW())");

					// Now let us delete the define cache file
			    	$cachestufffile = APP_PATH.JAK_CACHE_DIRECTORY.'/stuff.php';
			    	if (file_exists($cachestufffile)) {
			    		unlink($cachestufffile);
			    	}
			    			
			    	$_SESSION["successmsg"] = $jkl['g14'];
			    	jak_redirect($_SESSION['LCRedirect']);

				} else {

					$_SESSION["infomsg"] = $jkl['i4'];
			    	jak_redirect($_SESSION['LCRedirect']);

			    }
			}
		}
		 
		// Get all departments
		$JAK_DEPARTMENTS = $jakdb->select($jaktable1, ["id", "title"], ["ORDER" => ["dorder" => "ASC"]]);
		
		// Get all responses
		$ANSWERS_ALL = jak_get_page_info($jaktable);
		
		// Call the settings function
		$lang_files = jak_get_lang_files();

		// Get only the not used language files
		$only_used_lang = $jakdb->select($jaktable, "lang", ["GROUP" => "lang"]);
		$unique_lang = array_diff($lang_files, $only_used_lang);
		
		// Title and Description
		$SECTION_TITLE = $jkl["m20"];
		$SECTION_DESC = "";
		
		// Include the javascript file for results
		$js_file_footer = 'js_pages.php';
		 
		// Call the template
		$template = 'answers.php';
}
?>