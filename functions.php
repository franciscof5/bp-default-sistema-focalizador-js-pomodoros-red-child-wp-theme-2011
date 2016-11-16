<?php


/**/

add_action( 'admin_menu', 'my_remove_menu_pages' );

function my_remove_menu_pages() {
	//is_author() if (!is_admin() ) { - if(!current_user_can('administrator')) { if ($user_level < 5) {
	get_currentuserinfo();
	if(!current_user_can('administrator')) {
		remove_menu_page('link-manager.php');
		remove_menu_page('themes.php');
		remove_menu_page('index.php');
		remove_menu_page('tools.php');
		remove_menu_page('profile.php');
		remove_menu_page('upload.php');
		remove_menu_page('post.php');
		remove_menu_page('post-new.php');
		remove_menu_page('edit-comments.php');
		remove_menu_page('admin.php');
		remove_menu_page('edit-comments.php');
		remove_submenu_page( 'edit.php', 'post-new.php' );
		remove_submenu_page( 'tools.php', 'wp-cumulus.php' );
		
		 remove_meta_box('linktargetdiv', 'link', 'normal');
		  remove_meta_box('linkxfndiv', 'link', 'normal');
		  remove_meta_box('linkadvanceddiv', 'link', 'normal');
		  remove_meta_box('postexcerpt', 'post', 'normal');
		  remove_meta_box('trackbacksdiv', 'post', 'normal');
		  remove_meta_box('commentstatusdiv', 'post', 'normal');
		  remove_meta_box('postcustom', 'post', 'normal');
		  remove_meta_box('commentstatusdiv', 'post', 'normal');
		  remove_meta_box('commentsdiv', 'post', 'normal');
		  remove_meta_box('revisionsdiv', 'post', 'normal');
		  remove_meta_box('authordiv', 'post', 'normal');
		  remove_meta_box('sqpt-meta-tags', 'post', 'normal');
		  remove_meta_box('submitdiv', 'post', 'normal');
		  remove_meta_box('avhec_catgroupdiv', 'post', 'normal');
		  remove_meta_box('categorydiv', 'post', 'normal');
	}
}

function edit_admin_menus() {  
    global $menu;  
    $menu[5][0] = 'Ciclos'; // Change Posts to Pomodoros
}  
add_action( 'admin_menu', 'edit_admin_menus' ); 

/*SESSION PARA NAO PERDER DADOS DO FORMULARIO*/
add_action('init', 'myStartSession', 1);
add_action('wp_logout', 'myEndSession');
add_action('wp_login', 'myEndSession');

function myStartSession() {
    if(!session_id()) {
        session_start();
        
    }
 
}

function myEndSession() {
    session_destroy ();
}


function save_progress () {
	//http://codex.wordpress.org/Function_Reference/get_current_user_id
	//http://codex.wordpress.org/Function_Reference/get_currentuserinfo
	
	//global $wpdb; // this is how you get access to the database
	//$foi = $wpdb->insert( "wp_usermeta", array( 'umeta_id' => 'NULL', 'user_id' => 2, 'meta_key' => "pomodoro_completed", 'meta_value' => "delete teste" ));	
	
	//$mysqldate = date('Y-m-d H:i:s', $phpdate);
	//$phpdate = strtotime($mysqldate);
	//$foi1 = add_user_meta(get_current_user_id(), "point_date", date("Y-m-d H:i:s"));
	//$foi2 = add_user_meta(get_current_user_id(), "point_desc", $_POST['descri']);
	
	date_default_timezone_set("Brazil/East");
	//DONT NEED SECONDS $pomo_completed = date("Y-m-d H:i:s")."|".$_POST['descri'];
	$pomo_completed = date("Y-m-d H:i")."|".$_POST['descri'];
	$save_progress = add_user_meta(get_current_user_id(), "pomodoro_completed", $pomo_completed);
	if($save_progress) {
		echo "true";
	} else {
		echo "false";
	}
	
	$tagsinput = explode(" ", $_POST['post_tags']);
	
	
	
	$my_post = array(
		'post_title' => $_POST['post_titulo'],
		'post_content' => $_POST['post_descri'],
		//'post_status' => $_POST['post_priv'],
'post_status' => 'publish',
		'post_category' => array(1/*, $_POST['post_cat']*/),
		'post_author' => $current_user->ID,
		'tags_input' => array($_POST['post_tags'])
		//'post_category' => array(0)
	);
	wp_insert_post( $my_post );
	
	die(); 
	//$whatever = $_POST['whatever'];
	//$whatever += 10;
	//echo $whatever;
	
	/*$save_query = $wpdb->insert( $wpdb->usermeta, array(
            'option_name',
            'new_option_key',
            'option_value' => 'New Option Value',
            'autoload' => 'yes' )
        );*/
	//$myrows = $wpdb->get_row("SELECT user_nicename FROM wp_users WHERE id=2");
        //$mylink = $wpdb->get_row("SELECT * FROM $wpdb->links WHERE link_id = 8");
	//$mylink = $wpdb->get_row("SELECT * FROM wp_links WHERE link_id = 8");
	
	/*
	FUNCIONA DESCOMENTA ACIMA

	$mylink = $wpdb->query("SELECT * FROM wp_users WHERE ID=20 ");
	//$mylink = $wpdb->get_row("SELECT * FROM wp_users");
	echo $mylink; // prints "10"
	//echo $mylink['link_id']; // prints "10"
	//echo " -> fechado";
	*/
	
	// this is required to return a proper result	
	//$date = date('Y-m-d H:i:s'); 

	/*$save_query = $wpdb->insert( $wpdb->usermeta, array(
		    'option_name',
		    'new_option_key',
		    'option_value' => 'New Option Value',
		    'autoload' => 'yes' )
		    );
	
	if($save_query)
	echo "Pomodoro salvado com sucesso";
	else
	echo "Erro ao salvar pomodoro! Você está conectado a internet?";*/
	//echo "<script>alert('Pomodoro salvado com sucesso')</script>";
	//echo "Pomodoro salvado com sucesso";
	//}

	//add_action('wp_ajax_my_action', 'my_action_callback');
	//	echo  "php ready";
}
add_action('wp_ajax_save_progress', 'save_progress');
add_action('wp_ajax_nopriv_save_progress', 'save_progress');

/**/

function save_modelnow () {
	if(isset($_POST['post_para_deletar'])) {
		wp_delete_post($_POST['post_para_deletar']);
		//echo "Arriba amigos";
	} else {
		date_default_timezone_set("Brazil/East");
		$tagsinput = explode(" ", $_POST['post_tags']);	
		$my_post = array(
			'post_title' => $_POST['post_titulo'],
			'post_content' => $_POST['post_descri'],
			'post_status' => "pending",
			'post_author' => $current_user->ID,
			'tags_input' => array($_POST['post_tags'])
		);
		$idofpost = wp_insert_post( $my_post );
		echo $idofpost;
		die();
	}
}
add_action('wp_ajax_save_modelnow', 'save_modelnow');
add_action('wp_ajax_nopriv_save_modelnow', 'save_modelnow');

/**/

	register_sidebar( array(
		'name' => __( 'painel'),
		'id' => 'painel',
		'description' => 'exibida no painel principal',
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'geral'),
		'id' => 'geral',
		'description' => __( 'Sidebar geral'),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );



/**/
function buddypack_add_custom_header_support() {
	define( 'HEADER_TEXTCOLOR', 'FFFFFF' );
	define( 'HEADER_IMAGE', '%s/_inc/images/darwin-sample-x.gif' ); // %s is theme dir uri
	define( 'HEADER_IMAGE_WIDTH', 1250 );
	define( 'HEADER_IMAGE_HEIGHT', 125 );

	function buddypack_header_style() { ?>
		<style type="text/css">
			#header { background-image: url(<?php header_image() ?>); }
			<?php if ( 'blank' == get_header_textcolor() ) { ?>
			#header h1, #header #desc { display: none; }
			<?php } else { ?>
			#header h1 a, #desc { color:#<?php header_textcolor() ?>; }
			<?php } ?>
		</style>
	<?php
	}

	function buddypack_admin_header_style() { ?>
		<style type="text/css">
			#headimg {
				position: relative;
				color: #fff;
				background: url(<?php header_image() ?>);
				-moz-border-radius-bottomleft: 6px;
				-webkit-border-bottom-left-radius: 6px;
				-moz-border-radius-bottomright: 6px;
				-webkit-border-bottom-right-radius: 6px;
				margin-bottom: 20px;
				height: 100px;
				padding-top: 25px;
			}

			#headimg h1{
				position: absolute;
				bottom: 15px;
				left: 15px;
				width: 44%;
				margin: 0;
				font-family: Arial, Tahoma, sans-serif;
			}
			#headimg h1 a{
				color:#<?php header_textcolor() ?>;
				text-decoration: none;
				border-bottom: none;
			}
			#headimg #desc{

				color:#<?php header_textcolor() ?>;
				font-size:1em;
				margin-top:-0.5em;
			}

			#desc {
				display: none;
			}

			<?php if ( 'blank' == get_header_textcolor() ) { ?>
			#headimg h1, #headimg #desc {
				display: none;
			}
			#headimg h1 a, #headimg #desc {
				color:#<?php echo HEADER_TEXTCOLOR ?>;
			}
			<?php } ?>
		</style>
	<?php
	}
	add_custom_image_header( 'buddypack_header_style', 'buddypack_admin_header_style' );
}

?>