<?php
/** WECODE EDITS **/
add_action( 'wp_ajax_send_email', 'send_email_callback' );
add_action( 'wp_ajax_nopriv_send_email', 'send_email_callback' );

function send_email_callback(){
    
    //MAIL 1
	//$mailTo = 'simonetta.soerensen@flexfunding.com, info@flexfunding.com';
    $mailTo = 'johan.peen@flexfunding.com';
    $mailFrom = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $headers = 'From: Låneansøgning <'.$mailFrom.'>;';
			
    wp_mail($mailTo, $subject, $message, $headers);
    
    //MAIL 2
    //$mailTo = $_POST['email'];
    add_filter('wp_mail_content_type',create_function('', 'return "text/html"; '));
    $mailTo = 'johan.peen@flexfunding.com';
    $mailFrom = $_POST['email_from'];
    $headers = 'From: Simonetta Sørensen - Flex Funding A/S <'.$mailFrom.'>;';
    
    $subject = 'Tak for din ansøgning!';
    $message = 'Kære '.$_POST['name']. '<br/><br/>Endnu engang velkommen hos Flex Funding.
<br/><br/>Som lovet får du her mine kontaktoplysninger. Hvis du har spørgsmål til ansøgningsprocessen, eller tilføjelser til din ansøgning, så er du altid velkommen til at kontakte mig.<br/><br/>

I hverdage kan du forvente svar på din ansøgning inden for 24 timer.<br/><br/>

Hvis du ikke allerede har været inde og læse mere om ansøgningsprocessen, så kan du gøre det her:<br/> https://www.flexfunding.com/da/lantager/<br/><br/>

Du kan desuden hurtigt, og gratis, oprette dig som kunde gå på opdagelse i crowdlending universet her:<br/> https://app.flexfunding.com/RegistrationProcess/Registration/Register<br/><br/>

Bedste hilsner,<br/><br/>

<strong>Simonetta Sørensen</strong><br/>
<img width="100" src="https://www.flexfunding.com/wp-content/uploads/2016/02/signature.png" /><br/>
+45 7060 5200<br/>
simonetta.soerensen@flexfunding.com
';    
        
    wp_mail($mailTo, $subject, $message, $headers);
    
    echo $mailFrom;
    
	wp_die();
}

function submit_loan_function ($args){
    $adminurl = admin_url('admin-ajax.php');
    $search_form = "<div class='white_form'>
    <form id='ansoeg_form' method='post'>
    <h3 class='ansoeg_header'>ANSØG PÅ 30 SEKUNDER</h3>
    <input type='text' id='laanebeloeb' placeholder='Skriv lånebeløb her...' />
    <br/>
    <ul>
    <li>Lån fra 200.000 - 5 mio. kr.</li>
    <li>Løbetid op til 10 år</li>
    <li>Fast rente</li>
    <li>Ingen genforhandling</li>
    </ul>
    <br/>
    <input class='sf-button medium blue sf-icon-stroke ansoeg_button' type='submit' value='".$args['button_text']."'/>
    <span class='button_sub_text'>Gratis. Ingen binding.</span>    
    </form>
    <form id='details_form' method='post' style='display:none;'>
    <small>Her er alt, hvad vi behøver fra dig for at kunne vende tilbage:</small>
    <input class='input_details_form' type='text' id='name' name='name' placeholder='Dit navn' />
    <input class='input_details_form' type='text' id='company_name' name='company_name' placeholder='Virksomhedens navn' />
    <input class='input_details_form' type='text' id='cvr' name='cvr' placeholder='CVR nr.' />
    <input class='input_details_form' type='text' id='email' name='email' placeholder='E-mail' />
    <select class='input_details_form' name='use' id='loan_use' value='Hvad skal lånet bruges til?'>
        <option value='' disabled selected>Hvad skal lånet bruges til?</option>
        <option value='driftsfinansiering'>Driftsfinansiering</option>
        <option value='ekspansion'>Ekspansion(nye markeder, nye produkter o.l.)
</option>
        <option value='Finansiering af anlæg og faciliteter'>Finansiering af anlæg og faciliteter</option>
        <option value='Engangsudgifter'>Engangsudgifter</option>
        <option value='Overtagelse af eksisterende lån'>Overtagelse af eksisterende lån</option>
        <option value='Mellem finansiering (ordrefinansiering, factoring o.l.)'>Mellem finansiering (ordrefinansiering, factoring o.l.)</option>
        <option value='Finansiering af produktionsudstyr/driftsudstyr'>Finansiering af produktionsudstyr/driftsudstyr</option>
        <option value='Overtagelse af eksisterende lån'>Overtagelse af eksisterende lån</option>
        <option value='Generationsskifte'>Generationsskifte</option>
        <option value='Ejendomsfinansiering'>Ejendomsfinansiering</option>
    </select> 
    <select class='input_details_form' name='loebetid' id='loan_run_time' value='Vælg lånets løbetid'>
        <option value='' disabled selected>Vælg lånets løbetid</option>
        <option value='6'>6</option>
        <option value='12'>12</option>
        <option value='24'>24</option>
        <option value='36'>36</option>
        <option value='48'>48</option>
        <option value='60'>60</option>
        <option value='120'>120</option>
    </select>
    <input type='hidden' value='' id='laanebeloeb_details' />
    <input class='sf-button medium blue sf-icon-stroke ansoeg_button input_details_form' type='submit' value='Send ansøgning'/>    
    </form>
    <div id='thanks' style='display:none;'>
    <h3>Tak for din ansøgning!</h3>
    <span>Kære <span id='name_thanks'></span></span><br/><br/>
    <small id='thanks_text'>
    Velkommen hos Flex Funding!
    <br/><br/>
    Mit navn er Simonetta Sørensen og jeg har fået fornøjelsen af at være din personlige rådgiver.
    <br/><br/>
    Vi er allerede i fuld gang med at behandle din låneansøgning. I hverdage vender vi tilbage med svar på din ansøgning inden for 24 timer.
    <br/><br/>
    Jeg har sendt dig en mail med mine kontaktinformationer. Du er altid velkommen til at kontakte mig med spørgsmål.
    <br/><br/>
    I mellemtiden kan du læse mere om ansøgningsprocessen her: <a href='https://www.flexfunding.com/da/lantager/'>https://www.flexfunding.com/da/lantager/</a>
    <br/><br/>
    Alle oplysninger behandles dybt fortroligt.
    </small>
    <br/>
    <img width='100' src='https://www.flexfunding.com/wp-content/uploads/2015/04/Simonetta_full_magic.jpg' alt='Simonette Sørensen' />
    <span class='signature'>Bedste hilsner, <br/>Simonette Sørensen<br/>Flex Funding A/S</span>
    </div>
    </div>
    <script>
    jQuery(document).ready(function($){
        $('#ansoeg_form').on('submit', function(event) {
            var laanebeloeb = $('#laanebeloeb').val();
            $('#laanebeloeb_details').val(laanebeloeb);
            event.preventDefault();
            $('#ansoeg_form').hide();
            $('#details_form').css('display','block');
        });
        $('#details_form').on('submit', function(event) {
            var name = $('#name').val();
            var company_name = $('#company_name').val(); 
            var cvr = $('#cvr').val();
            var email = $('#email').val();
            var loan_use = $('#loan_use').val();
            var loan_run_time = $('#loan_run_time').val();
            var loan_size = $('#laanebeloeb_details').val();
            var email_from = 'simonetta.soerensen@flexfunding.com';
            var subject = 'Lånansøgning';
            event.preventDefault();
            $('#details_form').hide();
            $('#name_thanks').text(name);
            $('#thanks').css('display','block');
            $('.white_form').addClass('no_bottom');
            var data = {
			'action': 'send_email',
            'name': name,
            'cvr': company_name,
            'email': email,
            'loan_use': loan_use,
            'loan_run_time': loan_run_time,
            'loan_size': loan_size,
            'email_from': email_from,
            'subject': subject,
            'message': 'Låneansøg fra ' + company_name + ' med CVR ' + cvr + '. Deres email er ' + email + '. De ønsker et lån på: ' + loan_size + ' til ' + loan_use + ' over ' + loan_run_time + ' måneder.'
            };
            jQuery.post('".$adminurl."', data, function(response) {
                console.log('Email was sent from: ' + response);
            });
            });
        });    
    </script>
    ";
    return $search_form;
}
add_shortcode( 'submit_loan', 'submit_loan_function' );

	/*
	*
	*	Atelier Functions - Child Theme
	*	------------------------------------------------
	*	These functions will override the parent theme
	*	functions. We have provided some examples below.
	*
	*
	*/
	
	/* LOAD PARENT THEME STYLES
	================================================== */
	function atelier_child_enqueue_styles() {
	    wp_enqueue_style( 'atelier-parent-style', get_template_directory_uri() . '/style.css' );
	    wp_enqueue_style( 'jquery-ui-style', get_stylesheet_directory_uri() . '/assets/css/jquery-ui.min.css' );
	    wp_enqueue_style( 'calculator-style', get_stylesheet_directory_uri() . '/assets/css/calculator.css' );
	    wp_enqueue_style( 'pages-style', get_stylesheet_directory_uri() . '/assets/css/pages.css' );
	}
	add_action( 'wp_enqueue_scripts', 'atelier_child_enqueue_styles' );

	function atelier_child_enqueue_responsive_styles() {
		wp_enqueue_style( 'responsive-style', get_stylesheet_directory_uri() . '/assets/css/responsive.css' );
	}

	add_action( 'wp_enqueue_scripts', 'atelier_child_enqueue_responsive_styles', 100 );

	function atelier_child_enqueue_scripts() {
		wp_enqueue_script( 'jquery-ui-core');
		wp_enqueue_script( 'jquery-ui-slider');
		wp_enqueue_script( 'calculator-js', get_stylesheet_directory_uri() . '/assets/js/flex_calc.calculator.js', array('jquery') );

	}

	add_action( 'wp_enqueue_scripts', 'atelier_child_enqueue_scripts' );

	
	/* LOAD THEME LANGUAGE
	================================================== */
	/*
	*	You can uncomment the line below to include your own translations
	*	into your child theme, simply create a "language" folder and add your po/mo files
	*/
	
	// load_theme_textdomain('swiftframework', get_stylesheet_directory().'/language');
	
	
	/* REMOVE PAGE BUILDER ASSETS
	================================================== */
	/*
	*	You can uncomment the line below to remove selected assets from the page builder
	*/
	
	// function spb_remove_assets( $pb_assets ) {
	//     unset($pb_assets['parallax']);
	//     return $pb_assets;
	// }
	// add_filter( 'spb_assets_filter', 'spb_remove_assets' );	


	/* ADD/EDIT PAGE BUILDER TEMPLATES
	================================================== */
	function custom_prebuilt_templates($prebuilt_templates) {
			
		/*
		*	You can uncomment the lines below to add custom templates
		*/
		// $prebuilt_templates["custom"] = array(
		// 	'id' => "custom",
		// 	'name' => 'Custom',
		// 	'code' => 'your-code-here'
		// );

		/*
		*	You can uncomment the lines below to remove default templates
		*/
		// unset($prebuilt_templates['home-1']);
		// unset($prebuilt_templates['home-2']);

		// return templates array
	    return $prebuilt_templates;

	}
	//add_filter( 'spb_prebuilt_templates', 'custom_prebuilt_templates' );
	
//	function custom_post_thumb_image($thumb_img_url) {
//	    
//	    if ($thumb_img_url == "") {
//	    	global $post;
//	  		ob_start();
//	  		ob_end_clean();
//	  		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
//	  		if (!empty($matches) && isset($matches[1][0])) {
//	  		$thumb_img_url = $matches[1][0];
//	    	}
//	    }
//	    
//	    return $thumb_img_url;
//	}
//	add_filter( 'sf_post_thumb_image_url', 'custom_post_thumb_image' );
	
//	function dynamic_section( $sections ) {
//        //$sections = array();
//        $sections[] = array(
//            'title'  => __( 'Section via hook', 'redux-framework-demo' ),
//            'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'redux-framework-demo' ),
//            'icon'   => 'el-icon-paper-clip',
//            // Leave this as a blank section, no options just some intro text set above.
//            'fields' => array()
//        );
//        return $sections;
//    }
//	
	
//	function custom_style_sheet() {
//	    echo '<link rel="stylesheet" href="'.get_stylesheet_directory_uri() . '/test.css'.'" type="text/css" media="all" />';
//	}
//	add_action('wp_head', 'custom_style_sheet', 100);
	

	// function custom_wishlist_icon() {
	// 	return '<i class="fa-heart"></i>';
	// }
	// add_filter('sf_wishlist_icon', 'custom_wishlist_icon', 100);
	// add_filter('sf_add_to_wishlist_icon', 'custom_wishlist_icon', 100);
	// add_filter('sf_wishlist_menu_icon', 'custom_wishlist_icon', 100);


/* Add telephone to header */
add_filter( 'wp_nav_menu_items', 'ff_menu_language_selector', 10, 2 );
function ff_menu_language_selector ( $items, $args ) {
	if (in_array($args->theme_location, array('top_bar_menu', 'mobile_menu'))) {
		ob_start();
		//do_action('wpml_add_language_selector');
		do_action('icl_language_selector');
		$switcher = ob_get_clean();
		$items = '<li class="language-switcher">' . $switcher . '</li>' . $items;
	}
	return $items;
}

function icl_language_switcher(){
	$languages = icl_get_languages('skip_missing=1');
	if(1 < count($languages)){
		foreach($languages as $l){
			if(!$l['active']) $langs[] = '<a href="'.$l['url'].'">'.$l['translated_name'].'</a>';
		}
		echo join(', ', $langs);
	}
}


add_filter( 'the_content_more_link', 'modify_read_more_link' );
function modify_read_more_link() {
	return '... <a class="more-link" href="' . get_permalink() . '">' . __('Read more', 'swiftframework') . '</a>';
}

add_action( 'customize_preview_init', 'twentytwelve_customize_preview_js' );

add_action( 'wp_head', 'wpml_custom_redirect' );
function wpml_custom_redirect() {
    global $sitepress;
 
    if( $sitepress->get_default_language() == ICL_LANGUAGE_CODE ) {
        $uri = $_SERVER['REQUEST_URI'];
 
        if( ! preg_match( '#/' . ICL_LANGUAGE_CODE . '/#', $uri ) ) {
            wp_redirect( site_url( $sitepress->get_default_language() . '/' ) );
        }
    }
}
