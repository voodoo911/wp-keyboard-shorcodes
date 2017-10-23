<?php 

//add_Action('admin_footer', 'wks_admin_footer');
function wks_admin_footer(){
	global $post;	
}

// adding main actions in footer to use front back
add_Action('admin_footer', 'wks_wp_footer');
add_Action('wp_footer', 'wks_wp_footer');
function wks_wp_footer(){
	global $custom_actions;
	
	// processing of codes
	$wks_editor = get_option('wks_editor'); 
	$wks_settings = get_option('wks_settings'); 
	
	//echo 'voodo';
	//var_dump( $wks_editor );
	
	
	$help_row = array();
	for( $i=0; $i < count($wks_editor['combination'] ); $i++ ){
		
		if( @substr_count( '.php', $wks_editor['menu_element'][$i] ) > 0 ){
			$menu_element = $wks_editor['menu_element'][$i];
		}else{
			$menu_element = $wks_editor['menu_element'][$i];
		}
		
		
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
			break;
			case "menu_action":
				$title = "Menu Action";			
				$value = wks_get_menu_name( $wks_editor['menu_element'][$i] );
			break;
		}
		
		$help_row[] = '
		 <tr>  
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
	if( $wks_settings['show_helper'] == 'on' ){
		echo $helper_code;
	}
	
	// top helpers
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
	
 
	echo '
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
		// extra helper show
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
			
			console.log( reportStr );
		 
			var combination_hash =  md5 ( reportStr ) ;

			var all_actions = $("#actions_list").val();
			var obj = jQuery.parseJSON(all_actions);
					
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
							$(target).click();
						}
							console.log("prevent");				
						e.preventDefault ? e.preventDefault() : (e.returnValue = false);
						e.stopPropagation ();
						e.preventDefault ()
					}
				  
				});	
		}
		';
		
		// trace input in textareas and text fields
		if( $wks_settings['trace_input'] == 'on' ){
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

	// add a parent item
	$args = array(
		'id'    => 'parent_node',
		'title' => 'parent node',
		
	);
	$wp_admin_bar->add_node( $args );

	// add a child item to our parent item
	$args = array(
		'id'     => 'child_node',
		'title'  => 'child node',
		'parent' => 'parent_node',
		'href' => 'http://mail.com',
	);
	$wp_admin_bar->add_node( $args );

	// add a group node with a class "first-toolbar-group"
	$args = array(
		'id'     => 'first_group',
		'parent' => 'parent_node',
		'meta'   => array( 'class' => 'first-toolbar-group' ),
	);
	$wp_admin_bar->add_group( $args );

	// add an item to our group item
	$args = array(
		'id'     => 'first_grouped_node',
		'title'  => 'first group node',
		'parent' => 'first_group',
	);
	$wp_admin_bar->add_node( $args );

	// add another child item to our parent item (not to our first group)
	$args = array(
		'id'     => 'another_child_node',
		'title'  => 'another child node',
		'parent' => 'parent_node',
	);
	$wp_admin_bar->add_node( $args );

}

?>