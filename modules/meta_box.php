<?php 
		

add_action( 'add_meta_boxes', 'wfd_add_custom_box' );
function wfd_add_custom_box() {
	global $post;
	global $current_user;
		add_meta_box( 
			'wfd_system_editor',
			__( 'System Data', 'wl' ),
			'wfd_system_editor',
			'fx_system' , 'advanced', 'high'
		);

	
	
		
}
function wfd_system_editor(){
	global $post;

	$out .= '

<div class="tw-bs">
	<div class="form-horizontal ">
	
		<div class="control-group">  
            <label class="control-label" for="input01">System URL</label>  
            <div class="controls">  
              <input type="text" class="input-xlarge" name="s_u" id="s_u" value="'.get_post_meta( $post->ID, 's_u', true ).'">  
            </div>  
          </div> 
		<div class="control-group">  
            <label class="control-label" for="input01">Forex Robot Logo</label>  
            <div class="controls">  
              <input type="text" class="input-xlarge" name="f_r_l" id="f_r_l" value="'.get_post_meta( $post->ID, 'f_r_l', true ).'">  
            </div>  
          </div>   
		  
		<div class="control-group">  
            <label class="control-label" for="input01">Forex Robot Name</label>  
            <div class="controls">  
              <input type="text" class="input-xlarge" name="f_r_n" id="f_r_n" value="'.get_post_meta( $post->ID, 'f_r_n', true ).'">  
            </div>  
          </div> 
	
		<div class="control-group">  
            <label class="control-label" for="input01">Forex Robot URL</label>  
            <div class="controls">  
              <input type="text" class="input-xlarge" name="f_r_u" id="f_r_u" value="'.get_post_meta( $post->ID, 'f_r_u', true ).'">  
            </div>  
          </div> 
		  		  
		  
		  <div class="control-group">  
            <label class="control-label" for="input01">Review Name</label>  
            <div class="controls">  
              <input type="text" class="input-xlarge" name="r_n" id="r_n" value="'.get_post_meta( $post->ID, 'r_n', true ).'">  
            </div>  
          </div> 
		  
		  <div class="control-group">  
            <label class="control-label" for="input01">Forex Robot Review URL </label>  
            <div class="controls">  
              <input type="text" class="input-xlarge" name="f_r_r_u" id="f_r_r_u" value="'.get_post_meta( $post->ID, 'f_r_r_u', true ).'">  
            </div>  
          </div> 
		  
			<div class="control-group">  
            <label class="control-label" for="input01">Account Type</label>  
            <div class="controls">  
              <input type="text" class="input-xlarge" name="a_t" id="a_t" value="'.get_post_meta( $post->ID, 'a_t', true ).'">  
            </div>  
          </div> 

		</div>	
	</div>
	';	
	echo $out;
}


add_action( 'save_post', 'wfd_save_postdata' );
function wfd_save_postdata( $post_id ) {
global $current_user; 
 if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

  if ( 'page' == $_POST['post_type'] ) 
  {
    if ( !current_user_can( 'edit_page', $post_id ) )
        return;
  }
  else
  {
    if ( !current_user_can( 'edit_post', $post_id ) )
        return;
  }
  /// User editotions

	if( get_post_type($post_id) == 'fx_system' ){
		foreach( $_POST as $key=>$value ){
			update_post_meta( $post_id, $key, $value );
		}
	
		
		if( isset($_POST['s_u']) ){
			$out_val = wfd_get_remote_data( $post_id );
			foreach( $out_val as $key=>$value ){
				update_post_meta( $post_id, $key, $value );
			}
		}
		
	update_post_meta( $post_id, 'last_fx_update', time() );
	}
	
}

?>