<?php
// Heading
$_['heading_title']    			= 'Review Invite Cron Job';

// Entry
$_['entry_subject']    			= 'Mail Subject';
$_['entry_message']    			= 'Mail Message';
$_['entry_status']    			= 'Status';
$_['entry_orderstatuses']    	= 'Order Status';
$_['entry_customer_groups']    	= 'Ignore Customer Groups';
$_['entry_dayinterval']    		= 'Re-send E-Mail After x Days';
/*29-08-2018*/$_['entry_maxreminders']    		= 'Max Reminders Set For Review Invite E-mails';/*29-08-2018*/
$_['entry_resendold']    		= 'Re-send E-Mail To Customer?';
$_['entry_onorder']    			= 'Review Invitation mail on order?';


// Text
$_['text_success']     			= 'Success: Review Invite Cron Job Settings Save Successfully!';
/*29-08-2018*/$_['text_success_invite']     			= 'Review Invite Send Successfully!';
$_['text_invite_order_ids']     			= 'Invite Send Order IDS (%s)!';
$_['text_invite_order_notfound']     			= 'Order IDS Not found (%s)!';
$_['text_invite_order_notin_status']     			= 'Order IDS (%s) Status not in selected order statuses!';/*29-08-2018*/
$_['text_invite_order_is_ingore']     			= 'Order IDS (%s) cusomers customer group is in ignored customer groups!';/*29-08-2018*/

// Button
$_['button_save']    			= 'Save & Stay';

// Legend
$_['legend_email']				= 'Email';

// Help
$_['help_orderstatuses']    	= 'Status of order on which review invite email will send.';
$_['help_selectmultiple']    	= 'Keep CTRL pressed for multiple select';
$_['help_orderstatuschange']    = 'Set New Order Status After sending invite email';
$_['help_customer_groups']		= 'Select Customers Groups to which review Invitation mail will not send';
$_['help_dayinterval']    		= 'Review Invite E-mail will send after x days. Current Order Status effective on the day E-Mail will send.';
/*29-08-2018*/$_['help_maxreminders']    		= 'Set max reminders limit. This will tell how many Reviews Invite E-mail send customers. After that customers will no longer receive invite emails. Admin can re-enable send invites fron invite log.';/*29-08-2018*/
$_['help_resendold']    		= 'Re-send Review Invite E-mail to customer to whom already invited and still not give review.';
$_['help_onorder']    			= 'Send Review Invite E-mail to customer On when new order added.';
$_['help_dayinterval1']    			= 'Must set cron job based on above days. Recommend to set cron job daily base';

// Code
$_['code_code']    				= 'Short Codes';
$_['code_translate']    		= 'Names';
$_['code_firstname']    		= 'Customer First Name';
$_['code_lastname']    			= 'Customer Last Name';
$_['code_email']    			= 'Customer E-mail';
$_['code_store_name']    		= 'Store Name';
$_['code_logo']    				= 'Store Logo';
$_['code_products']    			= 'Order Products Information';



// Error
$_['error_permission'] 	 		= 'Warning: You do not have permission to modify asreview module!';
$_['error_warning']         	= 'Warning: Please check the form carefully for errors!';
$_['error_subject']         	= 'E-mail Subject Must Be Between 3 and 255 characters!';
$_['error_message']         	= 'E-mail Message Required!';
$_['error_orderstatuses']       = 'Please select order status';
$_['error_dayinterval']       	= 'Please select day interval when customer got invite email?';
/*29-08-2018*/$_['error_maxreminders']       	= 'Please set max reminders limit.';/*29-08-2018*/