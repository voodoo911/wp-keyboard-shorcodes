<?php 
 

// adding main actions in footer to use front back
add_Action('admin_footer', 'wks_wp_footer');
add_Action('wp_footer', 'wks_wp_footer');
function wks_wp_footer(){
	global $custom_actions;
	global $current_user;
	
	
	// processing of codes
	$wks_editor = get_user_meta($current_user->ID, 'wks_editor', true); 
	$wks_settings =  get_user_meta($current_user->ID, 'wks_settings', true); 
	
	//echo 'voodo';
	//var_dump( $wks_editor );
	
	// helper row data container
	$help_row = array();
	
	// top menu functions generation
	$out_functions_generation = array();
	
	for( $i=0; $i < count($wks_editor['combination'] ); $i++ ){
		
		if( @substr_count( '.php', $wks_editor['menu_element'][$i] ) > 0 ){
			$menu_element = $wks_editor['menu_element'][$i];
		}else{
			$menu_element = $wks_editor['menu_element'][$i];
		}
		
		// init arrach for action trace
		$comb_array[] = array( 
			'hash' => md5($wks_editor['combination'][$i]), 
			'combination' => $wks_editor['combination'][$i], 
			'small_url' => str_replace( get_option('home').'/wp-admin/', '', $wks_editor['menu_element'][$i] ), 
			'action' => $wks_editor['action'][$i], 
			'menu_element' => $wks_editor['menu_element'][$i], 
			'custom_action' => $wks_editor['custom_action'][$i], 
			'click_emulation_selector' => $wks_editor['click_emulation_selector'][$i] 
		);
		
		
		
		switch( $wks_editor['action'][$i] ){
			
			//get titles and menus for helper
			case "custom_action":
				$title = "Custom Action";
				foreach( $custom_actions as $k => $v ){
					if( $v == $wks_editor['custom_action'][$i] ){
						$value = $k;
					}
				}				
			break;
			case "click_emulation":
				$title = "Click Emulation";
				$value = $wks_editor['click_emulation_selector'][$i];
				
				$out_functions_generation[] =  '
					function emu_fn_'.md5($wks_editor['combination'][$i]).'(){
						jQuery("'.stripslashes( str_replace( '"', "'",  $wks_editor['click_emulation_selector'][$i] ) ).'").click();
					}
				';
				
			break;
			case "menu_action":
				$title = "Menu Action";			
				$value = wks_get_menu_name( $wks_editor['menu_element'][$i] );
			break;
		}
		
		// helper init
		$help_row[] = '
		 <tr>  
            <td>'.$wks_editor['small_descr'][$i].'</td>  
			<td>'.$wks_editor['combination'][$i].'</td>  
            <td>'.$title.'</td>  
            <td>'.$value.'</td>  
 
          </tr>  
		';
	}
	
	//var_dump( $comb_array );
	
	// reminder functionality
	$helper_code .= '
	<style>
	.shortcode_helper{
		position:fixed;
		top:50px;
		right:0px;
		z-index:10000;
	}
	.shortcode_helper .info_icon{
		    float: left;
		/* background: #fff; */
		color: #0044cc;
		padding: 10px;
		cursor: pointer;
		opacity: 0.3;
	}
	.shortcode_helper .info_icon .fa{
		font-size:30px;
	}
	.shortcode_helper .info_data{
		float:left;
		padding:5px;
		background:#fff;
		display:none;
		border-radius:5px;
		-webkit-box-shadow: 0px 0px 17px 1px rgba(0,0,0,0.75);
		-moz-box-shadow: 0px 0px 17px 1px rgba(0,0,0,0.75);
		box-shadow: 0px 0px 17px 1px rgba(0,0,0,0.75);
	}
	.shortcode_helper .help_table tr td, .shortcode_helper .help_table tr th{
		padding:5px;
		font-size:12px;
	}
	</style>
	<div class="shortcode_helper">
		<div class="info_icon">
			<i class="fa fa-question-circle show_info_block" aria-hidden="true"></i>
		</div>
		<div class="info_data">
			<table class="help_table">  
				<thead>  
				  <tr>  
					<th>Name</th> 
					<th>Combination</th>  
					<th>Action Type</th>  
					<th>Info</th>  
					
				  </tr>  
				</thead>  
				'.implode('', $help_row).'
				<tbody> 
				</tbody>  
			</table>  
		</div>
		<div class="clearfix"></div>
	</div>';
	if( isset($wks_settings['show_helper']) ){
		if( $wks_settings['show_helper'] == 'on' ){
			echo $helper_code;
		}
	}
	
	
	
	// top helpers
	/*
	echo '
	<style>
	.button_block_cont{
		position:fixed;
		top:0px;
		left:0px;
		width:100%;
		background:#fff;
		z-index:1000000000;
	}
	.button_block_cont .alt_container, .button_block_cont .control_container, .button_block_cont .shift_container{
		display:none;
	}
	</style>
	<div class="button_block_cont">
		<div class="alt_container">ALT CONT</div>
		<div class="control_container">CTRL CONT</div>
		<div class="shift_container">Shift</div>
	</div>
	';
	*/
 
 
	// js processing
	echo '
	<script>
	'.implode("\n", $out_functions_generation ).'
	</script>
	<input type="hidden" id="actions_list" value="'.htmlentities( json_encode( $comb_array ) ).'" />
	<script>
	jQuery(document).ready(function($){
		
		/*
		// adding to menu bar
		$("#wp-admin-bar-root-default").append("<li><a href=\"asdasd\"><span>111</span></a></li>")
		*/
		';
		
		//settings to show menu data
		if( $wks_settings['show_menu_help'] == 'on' ){
		echo '
		// adding subtext to menu
			var all_actions = $("#actions_list").val();
			var obj = jQuery.parseJSON(all_actions);
					
			$.each(obj, function(key,value) {
				if( value.action == "menu_action" ){
	
					var menu_href = value.small_url;
					var combination = value.combination;
					$("#adminmenu .wp-submenu a").each(function(){
	
						if( $(this).attr("href") == menu_href ){
							$(this).parents("li").css("position", "relative");
							$(this).after("<span class=\"link_conbination_helper\">"+combination+"</span>");
						}
					})
							
				}	
			});	';
		}
		
		echo '		
		/*
		// extra top hor  helper show
		var key_presed = "";
		$("body").on("keydown", function( e ){	
 
			var reportStr   =		
			( e.ctrlKey  ? "control" : "" ) +
			( e.shiftKey ? "shift"   : "" ) +
			( e.altKey   ? "alt"     : "" ) +
			( e.metaKey  ? "meta"    : "" );	
			if( key_presed == "" ){
				key_presed = reportStr;								
				$("."+key_presed+"_container").fadeIn();				
			 
			}
			
		})
		$("body").on("keyup", function( e ){
			if( key_presed != "" ){
				$("."+key_presed+"_container").fadeOut();
				key_presed = "";
	 
			}
		});
		*/
		
		// keypress tracing
		$("body").on("keydown", function( e ){									
			proces_button_click(e);			
		})
		
		// main processing function
		function proces_button_click(e){
			console.log( "clicked" );
			
			// check if input inside input field
			if( $( document.activeElement ).filter("input,textarea").length > 0) {			
				console.log( "in focus" );';
				// trace input check
				if( $wks_settings['trace_input'] != 'on' ){
					echo ' return false;';
				}
				echo '
			}else{
				console.log( "not focused" );
			}
			
	
			
			var reportStr =  get_conbination_from_obj(e);
			
			//console.log( reportStr );
		 
			var combination_hash =  md5 ( reportStr ) ;

			var all_actions = $("#actions_list").val();
			var obj = jQuery.parseJSON(all_actions);
					
			// check all combinations to find correct one
			$.each(obj, function(key,value) {
					if( combination_hash == value.hash){

						if( value.action == "menu_action" ){	
							var this_action = value.menu_element;
							window.location.href = this_action;
							
						}
						if( value.action == "custom_action" ){							
							var target = value.custom_action;	
							$(target).click();
						}
						if( value.action == "click_emulation" ){
							var target = value.click_emulation_selector;
							target = stripSlashes( target ); 
							console.log( target );
							
							$(target).click();
							console.log( "click emulated" );
						}
							//console.log("prevent");				
						e.preventDefault ? e.preventDefault() : (e.returnValue = false);
						e.stopPropagation ();
						e.preventDefault ()
					}
				  
				});	
		}
		';
		
		// trace input in textareas and text fields
		if( $wks_settings['trace_input'] == 'on'   ){
		echo '
		// init checking of tinymce
		setTimeout(function(){			
			if(  typeof(tinymce) != "undefined" ){
				if( tinymce.editors.length > 0 ){
					var b = tinymce.editors[0].on("keydown", function(e){
						proces_button_click(e);				
					});
				}
			}			
		}, 300);
		
		// on tab change tiny check
		$("#content-tmce").click(function(){
			setTimeout(function(){
				if(  typeof(tinymce) != "undefined" ){
					if( tinymce.editors.length > 0 ){
						var b = tinymce.editors[0].on("keydown", function(e){
							proces_button_click(e);				
						});
					}
				}
				
			}, 300);
		})';
		}
		echo '
		
		 
		
	})
	</script>
	';
	
}


add_action( 'admin_bar_menu', 'add_nodes_and_groups_to_toolbar', 999 );
function add_nodes_and_groups_to_toolbar( $wp_admin_bar ) {
	global $current_user;
	 $config =  get_user_meta($current_user->ID, 'wks_settings', true); 
	 
	 
	 if( $config['show_in_admin_bar'] != 'on' ){ return false; }

	// getting settings
	$wks_editor = get_option('wks_editor'); 
	$wks_settings = get_option('wks_settings'); 
	
	// add a parent item
	$args = array(
		'id'    => 'main_node',
		'title' => 'Shortcuts',
		
	);
	$wp_admin_bar->add_node( $args );
	
	
	for( $i=0; $i < count($wks_editor['combination'] ); $i++ ){
		
		/*
		if( @substr_count( '.php', $wks_editor['menu_element'][$i] ) > 0 ){
			$menu_element = $wks_editor['menu_element'][$i];
		}else{
			$menu_element = $wks_editor['menu_element'][$i];
		}
		*/
		$menu_element = $wks_editor['menu_element'][$i];
		
		$comb_array = array( 
			'hash' => md5($wks_editor['combination'][$i]), 
			'combination' => $wks_editor['combination'][$i], 
			'small_url' => str_replace( get_option('home').'/wp-admin/', '', $wks_editor['menu_element'][$i] ), 
			'action' => ( isset( $wks_editor['action'][$i] ) ? $wks_editor['action'][$i]  : '' ), 
			'admin_bar' => ( isset( $wks_editor['admin_bar'][$i] ) ? $wks_editor['admin_bar'][$i]  : '' ), 
			'menu_element' => $wks_editor['menu_element'][$i], 
			'menu_name' => $wks_editor['small_descr'][$i], 
			'custom_action' => $wks_editor['custom_action'][$i], 
			'click_emulation_selector' => $wks_editor['click_emulation_selector'][$i] 
		);
		
		if( $comb_array['admin_bar'] != 'on' ){ continue; }
		
		switch( $wks_editor['action'][$i] ){
			case "custom_action":
				$title = "Custom Action";
				foreach( $custom_actions as $k => $v ){
					if( $v == $wks_editor['custom_action'][$i] ){
						$value = $k;
					}
				}
				
			break;
			case "click_emulation":
				$title = "Click Emulation";
				$value = $wks_editor['click_emulation_selector'][$i];
				
				// add a child item to our parent item
				$args = array(
					'id'     => 'node_'.$comb_array['hash'],
					'title'  => $comb_array['menu_name'],
					'parent' => 'main_node',
					'href' => '#',
					'meta' => array(
						'onclick' => htmlentities(  "emu_fn_".$comb_array['hash']."(); return false;" )
					)
				);
				$wp_admin_bar->add_node( $args );
				
				
			break;
			case "menu_action":
				$title = "Menu Action";			
				$value = wks_get_menu_name( $wks_editor['menu_element'][$i] );
				
				// add a child item to our parent item
				$args = array(
					'id'     => 'node_'.$comb_array['hash'],
					'title'  => $comb_array['menu_name'],
					'parent' => 'main_node',
					'href' => $comb_array['menu_element'],
				);
				$wp_admin_bar->add_node( $args );
				
			break;
		}
 
	}
	



}


// process settings save process
add_Action('init', 'wks_init');
function wks_init(){
	global $current_user; 
	
	
	if( isset($_POST['wks_editor_field']) ){
		if( wp_verify_nonce( $_POST['wks_editor_field'], 'wks_editor_action' )  ){

				$options = array();
				foreach( $_POST as $key=>$value ){
					$options[$key] = $value;
				}
				update_user_meta($current_user->ID, 'wks_editor', $options );
			   wp_redirect( get_option('home').'/wp-admin/admin.php?page=wks_editor&status=save' , 301 );
		}
	}
	
	if( isset($_POST['wks_settings_field']) ){
		if( wp_verify_nonce( $_POST['wks_settings_field'], 'wks_settings_action' )  ){
			
				$wks_settings = array();
				foreach( $_POST as $key=>$value ){
					$wks_settings[$key] = $value;
				}
				
			 
				
			  update_user_meta($current_user->ID, 'wks_settings', $wks_settings );
			  wp_redirect( get_option('home').'/wp-admin/admin.php?page=wks_settings&status=save', 301 );
		}
	}
	
}

?>