<?php 
//addmin menues 
add_action('admin_menu', 'wks_item_menu');

function wks_item_menu() {
	add_menu_page(   __('WKS Editor', 'sc'), __('WKS Editor', 'sc'), 'edit_published_posts', 'wks_editor', 'wks_editor');
	add_submenu_page( 'wks_editor',  __('Settings', 'sc'), __('Settings', 'sc'), 'edit_published_posts', 'wks_settings', 'wks_settings');	
}

// main editor
function wks_editor(){
	global $custom_actions;
?>
<div class="wrap tw-bs">
<h2><?php _e('Correspondence', 'wcc'); ?></h2>
<hr/>
 <?php if(  wp_verify_nonce($_POST['_wpnonce']) ): ?>
  <div id="message" class="updated" ><?php _e('Saved successfully', 'wcc'); ?></div>  
  <?php 
  $config = get_option('wks_editor'); 
 
	foreach( $_POST as $key=>$value ){
		$options[$key] = $value;
	}
  update_option('wks_editor', $options );
  

  else:  ?>

  <?php //exit; ?>
  
  <?php endif; ?> 
<form class="form-horizontal" method="post" action="" id="submit_shortcodes" enctype="multipart/form-data" >
<?php wp_nonce_field();  
$config = get_option('wks_editor'); 

$menu_array = wks_return_manu_array();
 //var_dump( $menu_array );
?>  
<fieldset>
	 
	<table class="table editor_table">  
        <thead> 
			<tr>  
				<th> </th>  
				<th> </th>  
				<th> </th>  
				<th> </th>  
				<th><input type="button" class="btn btn-success add_row" value="Add Row" /></th>  
			</tr>
		
          <tr>  
            <th>Combination</th>  
            <th>&nbsp;</th> 
			<th>Action Type</th>  
            <th>Details</th>  
            <!-- <th>Admin Bar</th>  -->
            <th>Actions</th>  
          </tr>  
		  
		 
		  
        </thead>  
        <tbody class="editor_content">  
		
		<?php if( is_array($config['combination'])&& count( $config['combination'] ) > 0 ): ?>
		
		<?php 

			for( $i=0; $i < count($config['combination'] ); $i++ ){
				?>
				
				 <tr>  
					<td><input name="combination[]" id="keyPrssInp" class="shortcut_input_field" type="text" value="<?php echo $config['combination'][$i];  ?>" /></td>  
					<td><input class="enter_combination btn btn-warning" type="button"  value="Enter Combination" /></td>  
					<td>
						<select name="action[]" class="action_picker">
							<option  <?php if( $config['action'][$i] == 'menu_action' ){ echo ' selected ';} ?> value="menu_action">Menu Action
							<option <?php if( $config['action'][$i] == 'custom_action' ){ echo ' selected ';} ?> value="custom_action">Custom Action
							<option <?php if( $config['action'][$i] == 'click_emulation' ){ echo ' selected ';} ?> value="click_emulation">Click Emulation
						</select>
																	
						
					</td>  
					<td class="pickers_block">
						<?php 
					 
						if( $config['action'][$i] == 'menu_action' ){ 
							$out_style = ' style="display:block;" '; 
						}else{
							$out_style = ' style="display:none;" '; 
						} 
						?>
						<select name="menu_element[]" class="menu_action second_stage_picker" <?php echo $out_style; ?> >
							<option value="">Select Menu
						<?php 
							foreach( $menu_array as $single_menu ){
							 								
								echo '<option '.( $single_menu['prefix'] == '' ? ' style="background:#ccc;" ' : '' ).' '.( $config['menu_element'][$i] == get_option('home').'/wp-admin/'.$single_menu['url'] ? ' selected ' : '' ).' value="' ;
								echo get_option('home').'/wp-admin/'.$single_menu['url'];
								echo '">'.$single_menu['prefix'].$single_menu['name'];
							}
						?>
						</select>
						
						<?php 
						if( $config['action'][$i] == 'custom_action' ){ 
							$out_style = ' style="display:block;" '; 
						}else{
							$out_style = ' style="display:none;" '; 
						} 
						?>
						<select name="custom_action[]" class="custom_action second_stage_picker" <?php echo $out_style; ?> >
							<option value="">Select Action
							
							<?php 
							foreach( $custom_actions as $key => $value ){
								echo '<option value="'.$value.'" '.( $config['custom_action'][$i] == $value  ? ' selected ' : '').' >'.$key;
							}
							?>

						</select>
						
						<?php 
						if( $config['action'][$i] == 'click_emulation' ){ 
							$out_style = ' style="display:block;" '; 
						}else{
							$out_style = ' style="display:none;" '; 
						} 
						?>
						<input name="click_emulation_selector[]"  class="click_emulation second_stage_picker" <?php echo $out_style; ?> value="<?php echo $config['click_emulation_selector'][$i]; ?>" />
					</td>  
					<!--
					<td>
						<input type="checkbox" class="admin_bar_checkbox" name="admin_bar" value="on" <?php if( $config['admin_bar'][$i] == "on" ){ echo ' checked '; } ?>  />
					</td>
					-->
					<td>
						<button type="button" class="btn btn-success clone_row" ><span class="dashicons dashicons-screenoptions" title="<?php _e('Clone Element', 'wks') ?>"></span></button>
						<button type="button" class="btn btn-danger delete_row" ><span class="dashicons dashicons-trash" title="<?php _e('Delete Element', 'wks') ?>"></span></button>
						
					</td>  
				  </tr> 
				
			<?php
			}
		?>
		
		<?php else: ?>
			 <tr>  
					<td><input name="combination[]" id="keyPrssInp" class="shortcut_input_field" type="text" value="<?php echo $config['combination'][$i];  ?>" /></td>  
					<td><input class="enter_combination btn btn-warning" type="button"  value="Enter Combination" /></td>  
					<td>
						<select name="action[]" class="action_picker">
							<option  <?php if( $config['action'][$i] == 'menu_action' ){ echo ' selected ';} ?> value="menu_action">Menu Action
							<option <?php if( $config['action'][$i] == 'custom_action' ){ echo ' selected ';} ?> value="custom_action">Custom Action
							<option <?php if( $config['action'][$i] == 'click_emulation' ){ echo ' selected ';} ?> value="click_emulation">Click Emulation
						</select>
						
						
						
						
					</td>  
					<td class="pickers_block">
		
						<select name="menu_element[]" class="menu_action second_stage_picker"  >
							<option value="">Select Menu
						<?php 
							foreach( $menu_array as $single_menu ){
								 
								echo '<option '.( $single_menu['prefix'] == '' ? ' style="background:#ccc;" ' : '' ).' '.( $config['menu_element'][$i] == get_option('home').'/wp-admin/'.$single_menu['url'] ? ' selected ' : '' ).' value="'.get_option('home').'/wp-admin/'.$single_menu['url'].'">'.$single_menu['prefix'].$single_menu['name'];
							}
						?>
						</select>

						<select name="custom_action[]" class="custom_action second_stage_picker" >
							<option value="">Select Action
							
							<?php 
							foreach( $custom_actions as $key => $value ){
								echo '<option value="'.$value.'" '.( $config['custom_action'][$i] == $value  ? ' selected ' : '').' >'.$key;
							}
							?>

						</select>

						<input name="click_emulation_selector[]"  class="click_emulation second_stage_picker"  value="<?php echo $config['click_emulation_selector'][$i]; ?>" />
					</td>  
					
					<td>
						<input type="checkbox admin_bar_checkbox" name="admin_bar" value="on"   />
					</td>
					
					<td>
						<button type="button" class="btn btn-success clone_row" ><span class="dashicons dashicons-screenoptions" title="<?php _e('Clone Element', 'wks') ?>"></span></button>
						<button type="button" class="btn btn-danger delete_row" ><span class="dashicons dashicons-trash" title="<?php _e('Delete Element', 'wks') ?>"></span></button>
						
					</td>  
				  </tr>
		
		<?php endif;?>
		
		
           
 
        </tbody>  
      </table>  	
	 
	  
	 
		
		
          <div class="form-actions">  
            <button type="submit" class="btn btn-primary">Save Settings</button>  

          </div>  
        </fieldset>   

</form>

</div>


<?php 
}

// settings page
function wks_settings(){
	$config_big = array(
		array(
			'name' => 'show_helper',
			'type' => 'checkbox',
			'title' => 'Show Helper',
			'text' => 'Turn on if you would like to show helper icon top right, that will show you all your combinations',
			'sub_text' => '',
			'style' => ''
		),
		array(
			'name' => 'show_menu_help',
			'type' => 'checkbox',
			'title' => 'Show Menu Help',
			'text' => 'Turn on if you would like to show helper text on menus',
			'sub_text' => '',
			'style' => ''
		),
		array(
			'name' => 'trace_input',
			'type' => 'checkbox',
			'title' => 'Trace Clicks on input',
			'text' => 'Turn on if you would like to trace clinks on user input in input field, or textarea.',
			'sub_text' => '',
			'style' => ''
		),
	
	
		
	);

?>
<div class="wrap tw-bs">
<h2><?php _e('Settings', 'sc'); ?></h2>
<hr/>
 <?php if(  wp_verify_nonce($_POST['_wpnonce']) ): ?>
  <div id="message" class="updated" ><?php _e('Settings saved successfully', 'sc'); ?></div>  
  <?php 
  $config = get_option('wks_settings'); 

	foreach( $_POST as $key=>$value ){
		$wks_settings[$key] = $value;
	}
  update_option('wks_settings', $wks_settings );
  ?>
  <?php else:  ?>

  <?php //exit; ?>
  
  <?php endif; ?> 
<form class="form-horizontal" method="post" action="">
<?php wp_nonce_field();  
$config = get_option('wks_settings'); 

//var_dump( $config );
?>  
<fieldset>

	<?php 
	foreach( $config_big as $key=>$value ){
		switch( $value['type'] ){
			case "text":
				$out .= '
				<div class="control-group">  
					<label class="control-label" for="'.$value['id'].'">'.$value['title'].'</label>  
					<div class="controls">  
					  <input type="text"  class="'.$value['class'].'"  name="'.$value['name'].'" id="'.$value['id'].'" placeholder="'.$value['placeholder'].'" value="'.esc_html( stripslashes( $config[$value['name']] ) ).'">  
					  <p class="help-block">'.$value['sub_text'].'</p>  
					</div>  
				  </div> 
				';
			break;
			case "select":
				$out .= '
				<div class="control-group">  
					<label class="control-label" for="'.$value['id'].'">'.$value['title'].'</label>  
					<div class="controls">  
					  <select  style="'.$value['style'].'" class="'.$value['class'].'" name="'.$value['name'].'" id="'.$value['id'].'">' ; 
					  foreach( $value['value'] as $k => $v ){
						  $out .= '<option value="'.$k.'" '.( $config[$value['name']]  == $k ? ' selected ' : ' ' ).' >'.$v.'</option> ';
					  }
				$out .= '		
					  </select>  
					  <p class="help-block">'.$value['sub_text'].'</p> 
					</div>  
				  </div>  
				';
			break;
			case "checkbox":
				$out .= '
				<div class="control-group">  
					<label class="control-label" for="'.$value['id'].'">'.$value['title'].'</label>  
					<div class="controls">  
					  <label class="checkbox">  
						<input  class="'.$value['class'].'" type="checkbox" name="'.$value['name'].'" id="'.$value['id'].'" value="on" '.( $config[$value['name']] == 'on' ? ' checked ' : '' ).' > &nbsp; 
						'.$value['text'].'  
						<p class="help-block">'.$value['sub_text'].'</p> 
					  </label>  
					</div>  
				  </div>  
				';
			break;
			case "radio":
				$out .= '
				<div class="control-group">  
					<label class="control-label" for="'.$value['id'].'">'.$value['title'].'</label>  
					<div class="controls">';
						foreach( $value['value'] as $k => $v ){
							$out .= '
							<label class="radio">  
								<input  class="'.$value['class'].'" type="radio" name="'.$value['name'].'" id="'.$value['id'].'" value="'.$k.'" '.( $config[$value['name']] == $k ? ' checked ' : '' ).' >&nbsp;  
								'.$v.'  
								<p class="help-block">'.$value['sub_text'].'</p> 
							  </label> ';
						}
					$out .= '
					   
					</div>  
				  </div>  
				';
			break;
			case "textarea":
				$out .= '
				<div class="control-group">  
					<label class="control-label" for="'.$value['id'].'">'.$value['title'].'</label>  
					<div class="controls">  
					  <textarea style="'.$value['style'].'" class="'.$value['class'].'" name="'.$value['name'].'" id="'.$value['id'].'" rows="'.$value['rows'].'">'.esc_html( stripslashes( $config[$value['name']] ) ).'</textarea>  
					  <p class="help-block">'.$value['sub_text'].'</p> 
					</div>  
				  </div> 
				';
			break;
			case "multiselect":
				$out .= '
				<div class="control-group">  
					<label class="control-label" for="'.$value['id'].'">'.$value['title'].'</label>  
					<div class="controls">  
					  <select  multiple="multiple" style="'.$value['style'].'" class="'.$value['class'].'" name="'.$value['name'].'[]" id="'.$value['id'].'">' ; 
					  foreach( $value['value'] as $k => $v ){
						  $out .= '<option value="'.$k.'" '.( @in_array( $k, $config[$value['name']] )   ? ' selected ' : ' ' ).' >'.$v.'</option> ';
					  }
				$out .= '		
					  </select>  
					  <p class="help-block">'.$value['sub_text'].'</p> 
					</div>  
				  </div>  
				';
			break;
		}
	}
	echo $out;
	?>

		
          <div class="form-actions">  
            <button type="submit" class="btn btn-primary">Save Settings</button>  
          </div>  
        </fieldset>  

</form>

</div>


<?php 
}




?>