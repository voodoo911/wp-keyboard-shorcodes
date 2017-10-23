<?php 

class forex_widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'forex_widget', // Base ID
			'Forex Widget', // Name
			array( 'description' => __( 'Forex Widget', 'text_domain' ), ) // Args
		);
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$number = apply_filters( 'widget_title', $instance['number'] );

		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
		
		$out .= '
			<div class="tw-bs">
				<table class="table">  
				<thead>  
				  <tr>  
					<th>Forex Robot</th>  
					<th>Monthly Gain</th>  
					<th>Chart</th>  
				  </tr>  
				</thead>  
				<tbody> '; 
				$args = array(
					'showposts' => ( $number ? $number : 5 ),
					'post_type' => 'fx_system',
					'orderby'   => 'meta_value_num',
					'meta_key'  => 'monthly',
				);
				$all_posts = get_posts( $args );
				foreach( $all_posts as $single_post ){
					$out .= '
					  <tr>  
						<td class="al_c"><a target="_blank" href="'.get_post_meta( $single_post->ID, 'f_r_u', true ).'">';
						if( get_post_meta( $single_post->ID, 'f_r_l', true ) ){
							$out .= '
							<div class="logo_block">
								<img src="'.get_post_meta( $single_post->ID, 'f_r_l', true ).'" />
							</div>
							';
						}
						$out .= get_post_meta( $single_post->ID, 'f_r_n', true ).'</a></td>  
						<td>';
						if( substr_count( get_post_meta( $single_post->ID, 'monthly', true ), '+'  ) > 0 || 1 == 1 ){
							$out .= '<span class="green">'.get_post_meta( $single_post->ID, 'monthly', true ).'</span>';
						}
						/*
						if( substr_count( get_post_meta( $single_post->ID, 'monthly', true ), '-'  ) > 0 ){
							$out .= '<span class="red">'.get_post_meta( $single_post->ID, 'monthly', true ).'</span>';
						}
							*/
						$out .= '</td>   
						<td>'.( get_post_meta( $single_post->ID, 'chart', true ) ? '<a target="_blank" href="'.get_post_meta( $single_post->ID, 's_u', true ).'"><img class="widget_image" src="'.get_post_meta( $single_post->ID, 'chart', true ).'" /></a>' : '' ).'</td>
					  </tr>';
				}
				  
				$out .= '
				</tbody>  
			  </table>  
			</div>
			';	

		
		
		echo $out;
		echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = strip_tags( $new_instance['number'] );

		return $instance;
	}

	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
			$number = $instance[ 'number' ];
		}
		else {
			$title = __( 'New title', 'text_domain' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Number of items:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" />
		</p>
		<?php 
	}

} // class Foo_Widget
// register Foo_Widget widget
add_action( 'widgets_init', create_function( '', 'register_widget( "forex_widget" );' ) );

?>