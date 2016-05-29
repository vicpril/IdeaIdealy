<?php

// the form is being processed to send the mail now

    // check all input variables
    $cid = $this->ctf_clean_input($_POST['si_contact_CID']);
    if(empty($cid)) {
       $this->si_contact_error = 1;
       $si_contact_error_contact = ($si_contact_opt['error_contact_select'] != '') ? esc_html($si_contact_opt['error_contact_select']) : esc_html( __('Selecting a contact is required.', 'si-contact-form') );
    }
    else if (!isset($contacts[$cid]['CONTACT'])) {
        $this->si_contact_error = 1;
        $si_contact_error_contact = __('Requested Contact not found.', 'si-contact-form');
    }
    if (empty($ctf_contacts)) {
       $this->si_contact_error = 1;
    }
    $mail_to    = ( isset($contacts[$cid]['EMAIL']) )   ? $this->ctf_clean_input($contacts[$cid]['EMAIL'])  : '';
    $to_contact = ( isset($contacts[$cid]['CONTACT']) ) ? $this->ctf_clean_input($contacts[$cid]['CONTACT']): '';

    $name    = $this->ctf_name_case($this->ctf_clean_input($_POST['si_contact_name']));
    $email   = strtolower($this->ctf_clean_input($_POST['si_contact_email']));
    if ($ctf_enable_double_email == 'true') {
       $email2 = strtolower($this->ctf_clean_input($_POST['si_contact_email2']));
    }
    if ($si_contact_opt['hidden_subject_enable'] != 'true') {

      if(isset($_POST['si_contact_subject'])) {
            $subject = $this->ctf_name_case($this->ctf_clean_input($_POST['si_contact_subject']));
      }else{
         $sid = $this->ctf_clean_input($_POST['si_contact_subject_ID']);
         if(empty($sid)) {
             $this->si_contact_error = 1;
             $si_contact_error_subject = ($si_contact_opt['error_subject'] != '') ? esc_html($si_contact_opt['error_subject']) : esc_html( __('Selecting a subject is required.', 'si-contact-form') );
         }
         else if (empty($subjects) || !isset($subjects[$sid])) {
             $this->si_contact_error = 1;
             $si_contact_error_subject = __('Requested subject not found.', 'si-contact-form');
         } else {
             $subject = $this->ctf_clean_input($subjects[$sid]);
         }
      }
    } // end if hidden  subject

    if ($si_contact_opt['hidden_message_enable'] != 'true') {
       $message = $this->ctf_clean_input($_POST['si_contact_message']);
    }
    if ( $this->isCaptchaEnabled() ) {
     $captcha_code = $this->ctf_clean_input($_POST['si_contact_captcha_code']);
    }

    // check posted input for email injection attempts
    // fights common spammer tactics
    // look for newline injections
    $this->ctf_forbidifnewlines($name);
    $this->ctf_forbidifnewlines($email);
    if ($ctf_enable_double_email == 'true') {
       $this->ctf_forbidifnewlines($email2);
    }
    $this->ctf_forbidifnewlines($subject);

    // look for lots of other injections
    $forbidden = 0;
    $forbidden = $this->ctf_spamcheckpost();
    if ($forbidden) {
       wp_die(__('Contact Form has Invalid Input', 'si-contact-form'));
    }

   // check for banned ip
   if( $ctf_enable_ip_bans && in_array($_SERVER['REMOTE_ADDR'], $ctf_banned_ips) ) {
      wp_die(__('Your IP is Banned', 'si-contact-form'));
   }

   // CAPS Decapitator
   if ($si_contact_opt['name_case_enable'] == 'true' && !preg_match("/[a-z]/", $message)) {
      $message = $this->ctf_name_case($message);
   }

   if(empty($name)) {
       $this->si_contact_error = 1;
       $si_contact_error_name =  ($si_contact_opt['error_name'] != '') ? esc_html($si_contact_opt['error_name']) : esc_html( __('Your name is required.', 'si-contact-form') );
   }
   if (!$this->ctf_validate_email($email)) {
       $this->si_contact_error = 1;
       $si_contact_error_email = ($si_contact_opt['error_email'] != '') ? esc_html($si_contact_opt['error_email']) : esc_html(  __('A proper e-mail address is required.', 'si-contact-form') );
   }
   if ($ctf_enable_double_email == 'true' && !$this->ctf_validate_email($email2)) {
       $this->si_contact_error = 1;
       $si_contact_error_email2 = ($si_contact_opt['error_email'] != '') ? esc_html($si_contact_opt['error_email']) : esc_html(  __('A proper e-mail address is required.', 'si-contact-form') );
   }
   if ($ctf_enable_double_email == 'true' && ($email != $email2) ) {
       $this->si_contact_error = 1;
       $si_contact_error_double_email = ($si_contact_opt['error_email2'] != '') ? esc_html($si_contact_opt['error_email2']) : esc_html(  __('The two e-mail addresses did not match, please enter again.', 'si-contact-form') );
   }

   // optional extra fields
      for ($i = 1; $i <= $si_contact_gb['max_fields']; $i++) {
        if ($si_contact_opt['ex_field'.$i.'_label'] != '') {
          ${'ex_field'.$i} = ( empty($_POST["si_contact_ex_field$i"]) ) ? '' : $this->ctf_clean_input($_POST["si_contact_ex_field$i"]);
          if(empty(${'ex_field'.$i}) && $si_contact_opt['ex_field'.$i.'_req'] == 'true') {
             $this->si_contact_error = 1;
             ${'si_contact_error_ex_field'.$i} = ($si_contact_opt['error_field'] != '') ? esc_html($si_contact_opt['error_field']) : esc_html(  __('This field is required.', 'si-contact-form') );
          }
        }
      } // end foreach

   if ($si_contact_opt['hidden_subject_enable'] != 'true' && empty($subject)) {
       $this->si_contact_error = 1;
       if (count($subjects) == 0) {
         $si_contact_error_subject = ($si_contact_opt['error_subject'] != '') ? esc_html($si_contact_opt['error_subject']) : esc_html(  __('Subject text is required.', 'si-contact-form') );
       }
   }
   if($si_contact_opt['hidden_message_enable'] != 'true' &&  empty($message)) {
       $this->si_contact_error = 1;
       $si_contact_error_message = ($si_contact_opt['error_message'] != '') ? esc_html($si_contact_opt['error_message']) : esc_html(  __('Message text is required.', 'si-contact-form') );
   }

   // Check with Akismet, but only if Akismet is installed, activated, and has a KEY. (Recommended for spam control).
   if($si_contact_opt['hidden_message_enable'] != 'true' && function_exists('akismet_http_post') && get_option('wordpress_api_key') ){
			global $akismet_api_host, $akismet_api_port;
			$c['user_ip']    		= preg_replace( '/[^0-9., ]/', '', $_SERVER['REMOTE_ADDR'] );
			$c['user_agent'] 		= (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : '';
			$c['referrer']   		= (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
			$c['blog']       		= get_option('home');
			$c['permalink']       	= get_permalink();
			$c['comment_type']      = 'sicontactform';
			$c['comment_author']    = $name;
			$c['comment_content']   = $message;
            //$c['comment_content']  = "viagra-test-123";  // uncomment this to test spam detection

			$ignore = array( 'HTTP_COOKIE' );

			foreach ( $_SERVER as $key => $value )
				if ( !in_array( $key, $ignore ) )
					$c["$key"] = $value;

			$query_string = '';
			foreach ( $c as $key => $data )
				$query_string .= $key . '=' . urlencode( stripslashes($data) ) . '&';
			$response = akismet_http_post($query_string, $akismet_api_host, '/1.1/comment-check', $akismet_api_port);
			if ( 'true' == $response[1] ) {
                $this->si_contact_error = 1; // Akismet says it is spam.
                $si_contact_error_message = ($si_contact_opt['error_input'] != '') ? esc_html($si_contact_opt['error_input']) : esc_html( __('Contact Form has Invalid Input', 'si-contact-form') );
			}
    } // end if(function_exists('akismet_http_post')){

  // begin captcha check if enabled
  // captcha is optional but recommended to prevent spam bots from spamming your contact form
  if ( $this->isCaptchaEnabled() ) {

// uncomment for temporary advanced debugging only
/*echo "<pre>";
   echo "COOKIE ";
   var_dump($_COOKIE);
   echo "\n\n";
   echo "SESSION ";
   var_dump($_SESSION);
echo "</pre>\n";*/


    if (!isset($_SESSION['securimage_code_ctf_'.$form_id_num]) || empty($_SESSION['securimage_code_ctf_'.$form_id_num])) {
          $this->si_contact_error = 1;
          $si_contact_error_captcha = __('Could not read CAPTCHA cookie. Make sure you have cookies enabled and not blocking in your web browser settings. Or another plugin is conflicting. See plugin FAQ.', 'si-contact-form');
    }else{
       if (empty($captcha_code) || $captcha_code == '') {
         $this->si_contact_error = 1;
         $si_contact_error_captcha = ($si_contact_opt['error_captcha_blank'] != '') ? esc_html($si_contact_opt['error_captcha_blank']) : esc_html( __('Please complete the CAPTCHA.', 'si-contact-form') );
       } else {
         require_once "$captcha_path_cf/securimage.php";
         $img = new Securimage();
         $img->form_num = $form_id_num; // makes compatible with multi-forms on same page
         $valid = $img->check("$captcha_code");
         // Check, that the right CAPTCHA password has been entered, display an error message otherwise.
         if($valid == true) {
             // ok can continue
         } else {
              $this->si_contact_error = 1;
              $si_contact_error_captcha = ($si_contact_opt['error_captcha_wrong'] != '') ? esc_html($si_contact_opt['error_captcha_wrong']) : esc_html( __('That CAPTCHA was incorrect.', 'si-contact-form') );
         }
    }
   }
  } // end if enable captcha
  // end captcha check

  if (!$this->si_contact_error) {
     // ok to send the email, so prepare the email message

     // lines separated by \n on Unix and \r\n on Windows
     if (!defined('PHP_EOL'))
           define ('PHP_EOL', strtoupper(substr(PHP_OS,0,3) == 'WIN') ? "\r\n" : "\n");

     if(isset($_POST['si_contact_subject'])) {
          $subj = ($si_contact_opt['hidden_subject_enable'] == 'true') ? $si_contact_opt['email_subject'] : $si_contact_opt['email_subject'] ." $subject";
     }else{
          $subj = ($si_contact_opt['hidden_subject_enable'] == 'true') ? $si_contact_opt['email_subject'] : $subject;
     }

     $msg = __('To', 'si-contact-form').": $to_contact\n\n".__('From', 'si-contact-form').":\n$name\n$email\n\n";

     // optional extra fields
     for ($i = 1; $i <= $si_contact_gb['max_fields']; $i++) {
        if ( $si_contact_opt['ex_field'.$i.'_label'] != '' && !empty(${'ex_field'.$i}) ) {
           if ($si_contact_opt['ex_field'.$i.'_type'] == 'select' || $si_contact_opt['ex_field'.$i.'_type'] == 'radio') {
              list($exf_opts_label, $value) = explode(",",$si_contact_opt['ex_field'.$i.'_label']);
              $msg .= $exf_opts_label."\n${'ex_field'.$i}\n\n";
           } else {
              $msg .= $si_contact_opt['ex_field'.$i.'_label']."\n${'ex_field'.$i}\n\n";
           }
       }
    }
    if ($si_contact_opt['hidden_message_enable'] != 'true') {
        $msg .= __('Message', 'si-contact-form').":\n$message\n\n";
    }

    // add some info about sender to the email message
    $userdomain = '';
    $userdomain = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    $user_info_string = '';
    if ($user_ID != '' && !current_user_can('level_10') ) {
        //user logged in
        $user_info_string .= __('From a WordPress user', 'si-contact-form').': '.$current_user->user_login . PHP_EOL;
    }
    $user_info_string .= __('Sent from (ip address)', 'si-contact-form').': '.$_SERVER['REMOTE_ADDR']." ($userdomain)" . PHP_EOL;
    $user_info_string .= __('Date/Time', 'si-contact-form').': '.date_i18n(get_option('date_format').' '.get_option('time_format'), time() ) . PHP_EOL;
    $user_info_string .= __('Coming from (referer)', 'si-contact-form').': '.get_permalink() . PHP_EOL;
    $user_info_string .= __('Using (user agent)', 'si-contact-form').': '.$this->ctf_clean_input($_SERVER['HTTP_USER_AGENT']) . PHP_EOL . PHP_EOL;
    $msg .= $user_info_string;

    // wordwrap email message
    if ($ctf_wrap_message) {
             $msg = wordwrap($msg, 70);
    }

    $header = '';
    // prepare the email header
    if ($ctf_email_on_this_domain != '') {
         // $header =  "From: $ctf_email_on_this_domain" . PHP_EOL;
         $this->si_contact_mail_from = $ctf_email_on_this_domain;
         add_filter( 'wp_mail_from', array(&$this,'si_contact_form_mail_from'));
    } else {
         // $header = "From: $name <$email>" . PHP_EOL;
         $this->si_contact_mail_from = $email;
         $this->si_contact_from_name = $name;
         add_filter( 'wp_mail_from', array(&$this,'si_contact_form_mail_from'),1);
         add_filter( 'wp_mail_from_name', array(&$this,'si_contact_form_from_name'),1);
    }

    if ($ctf_email_address_bcc !='')
            $header .= "Bcc: " . $ctf_email_address_bcc . PHP_EOL;
    $header .= "Reply-To: $email" . PHP_EOL;
    $header .= "Return-Path: $email" . PHP_EOL;

    /* almost made X-Priority: 1 an option but class-phpmailer.php already sets X-Priority: 3.
       It is hard coded to do that. So you would have both 1 and 3 in the mail header and I cannot do that. */
    // $header .= "X-Priority: 1 (High)" . PHP_EOL;

    $header .= 'Content-type: text/plain; charset='. get_option('blog_charset') . PHP_EOL;

    // @ini_set('sendmail_from', $email); // needed for some windows servers

    if (!wp_mail($mail_to,$subj,$msg,$header)) {
		die('<p>' . __('The e-mail could not be sent.', 'si-contact-form') . "<br />\n" .
        __('Possible reason: your host may have disabled the mail() function.', 'si-contact-form') . '</p>');
    }

    $message_sent = 1;

  } // end if ! error

?>