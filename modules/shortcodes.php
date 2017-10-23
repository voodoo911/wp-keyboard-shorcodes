<?php  
add_shortcode( 'forex_list', 'wfd_forex_list' );
function wfd_forex_list( $atts, $content = null ){
	
	$out .= '
	<div class="tw-bs">
		
		<div class="filtering_block">
			<div class="inner_filtering_block">
				<div class="sort_by_resp filter_picker filter_title_text">Sort By</div>
				<div class="sort_picker filter_picker">
					<select id="select_order"> 
						<option value="-">Choose a column</option>
						<option value="2">Deposit</option> 
						<option value="3">Balance</option>  
						<option value="4">Gain</option>  
						<option value="5" selected >Monthly</option>  
						<option value="6">Daily</option>  
						<option value="7">Drawdown</option>  
						
						<option value="8">PF</option>  
						<option value="9">Days</option>  
					  </select>
				</div>
				
				<div class="sort_button filter_picker">
					<input type="button" class="bnt btn-success"   value="Sort" id="sort_action" />
				</div>

			</div>
		</div>
		
		<div class="filtering_block">
			<div class="inner_filtering_block">
				<div class="filter_picker filter_title_text">Filter By</div>
				<div class="filter_picker">
					<select id="select_filtering" class="width_150"> 
						<option value="-">Select Value</option>
						<option value="2">Deposit</option> 
						<option value="3">Balance</option>  
						<option value="4">Gain</option>  
						<option value="5">Monthly</option>  
						<option value="6">Daily</option>  
						<option value="7">Drawdown</option>  					
						<option value="8">PF</option>  
						<option value="9">Days</option>  
					  </select>
				</div>
				
				<div class="filter_picker">
					<input type="text" class="input-mini" placeholder="Min"  value="" id="filter_min" />
					<input type="text" class="input-mini" placeholder="Max"  value="" id="filter_max" />
				</div>
							
				
				<div class="filter_picker">
					<select id="acc_type_filtering" class="width_150"> 
						<option value="-">Real or Demo</option>
						<option value="Real">Real</option> 
						<option value="Demo">Demo</option> 
					</select>
				</div>
				
				<div class="filter_picker">
					<input type="button" class="bnt btn-success"   value="Filter" id="filter_action" />
					<input type="button" class="bnt btn-danger"   value="Clear" id="clear_action" />
				</div>
			
			</div>
		</div>
		
		
		<style>
	
		</style>
	
	
		<table class="table tablesorter sort_table">  
        <thead>  
          <tr>  
		  <!--
		  //Forex Robot | Review | Deposit | Balance | Gain | Monthly | Daily | Drawdown | PF (Profit Factor) | Days | Chart | Account 
		  -->
            <th data-sorter="false" class="sorter-false"  >Forex Robot</th>  
            <th>Review</th>  
            <th class="{sorter: \'fancyNumber\'}">Deposit</th>
			<th class="{sorter: \'fancyNumber\'}" >Balance</th>
			<th>Gain</th>  
			<th>Monthly</th>  
			<th>Daily</th>  						 			
			<th>Drawdown</th>  						
			<th>PF</th>  
			<th>Days</th> 			
			<th>Chart</th> 
			
			<th>Account</th>  			
          </tr>  
        </thead>  
        <tbody> '; 
		$args = array(
			'showposts' => -1,
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
				<td><a href="'.get_post_meta( $single_post->ID, 'f_r_r_u', true ).'" target="_blank">'.get_post_meta( $single_post->ID, 'r_n', true ).'</a> </td>  
				
				<td>'.get_post_meta( $single_post->ID, 'deposit', true ).'</td>
				<td>'.get_post_meta( $single_post->ID, 'balance', true ).'</td>
				
				<td>';
				if( substr_count( get_post_meta( $single_post->ID, 'gain', true ), '+'  ) > 0 ){
					$out .= '<span class="green">'.get_post_meta( $single_post->ID, 'gain', true ).'</span>';
				}
				if( substr_count( get_post_meta( $single_post->ID, 'gain', true ), '-'  ) > 0 ){
					$out .= '<span class="red">'.get_post_meta( $single_post->ID, 'gain', true ).'</span>';
				}
					
				$out .= '</td>  
				<td>'.get_post_meta( $single_post->ID, 'monthly', true ).'</td>  
				<td>'.get_post_meta( $single_post->ID, 'daily', true ).'</td>  

				<td>'.get_post_meta( $single_post->ID, 'drawdown', true ).'</td>   				
				<td>'.get_post_meta( $single_post->ID, 'profit', true ).'</td> 
				<td>';
				
				
				$diff = time() - strtotime( get_post_meta( $single_post->ID, 'timeline', true ) );						
				$diff  = $diff / ( 60*60*24 );
				$diff = (int)$diff;				
				if( get_post_meta( $single_post->ID, 'days', true ) ){
					$out .=  (int)get_post_meta( $single_post->ID, 'days', true );
				}elseif(get_post_meta( $single_post->ID, 'timeline', true )){
					$out .=  $diff;
				}
				$out .= '</td>  				
				<td>'.( get_post_meta( $single_post->ID, 'chart', true ) ? '<a target="_blank" href="'.get_post_meta( $single_post->ID, 's_u', true ).'"><img class="table_chart" src="'.get_post_meta( $single_post->ID, 'chart', true ).'" /></a>' : '' ).'</td> 
				<td>'.get_post_meta( $single_post->ID, 'a_t', true ).'</td> 
			  </tr>';
		}
		  
		$out .= '
        </tbody>  
      </table>  
	  
	  
	  
	  
	  
	  
	  
	   '; 
		$args = array(
			'showposts' => -1,
			'post_type' => 'fx_system',
			'orderby'   => 'meta_value_num',
			'meta_key'  => 'monthly',
		);
		$all_posts = get_posts( $args );
		
		$out .= '<div class="mobile_container">';
		
		foreach( $all_posts as $single_post ){
			$out .= '
		<table class="table responsive_table">  
     
        <tbody>
			<tr>  
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>  
				<td class="resp_head" colspan="2"><a target="_blank" href="'.get_post_meta( $single_post->ID, 'f_r_u', true ).'">';
				if( get_post_meta( $single_post->ID, 'f_r_l', true ) ){
					$out .= '
					<div class="logo_block">
						<img src="'.get_post_meta( $single_post->ID, 'f_r_l', true ).'" />
					</div>
					';
				}
				$out .= get_post_meta( $single_post->ID, 'f_r_n', true ).'</a></td>
			</tr>
			<tr>  
				<td>Review</td>
				<td><a href="'.get_post_meta( $single_post->ID, 'f_r_r_u', true ).'" target="_blank">'.get_post_meta( $single_post->ID, 'r_n', true ).'</a> </td>
			</tr>
			<tr>  
				<td>Deposit</td>
				<td>'.get_post_meta( $single_post->ID, 'deposit', true ).'</td>
			</tr>
			<tr>  
				<td>Balance</td>
				<td>'.get_post_meta( $single_post->ID, 'balance', true ).'</td>
			</tr>
			<tr>  
				<td>Gain</td>
				<td>';
				if( substr_count( get_post_meta( $single_post->ID, 'gain', true ), '+'  ) > 0 ){
					$out .= '<span class="green">'.get_post_meta( $single_post->ID, 'gain', true ).'</span>';
				}
				if( substr_count( get_post_meta( $single_post->ID, 'gain', true ), '-'  ) > 0 ){
					$out .= '<span class="red">'.get_post_meta( $single_post->ID, 'gain', true ).'</span>';
				}
					
				$out .= '</td> 
			</tr>
			<tr>  
				<td>Monthly</td>
				<td>'.get_post_meta( $single_post->ID, 'monthly', true ).'</td> 
			</tr>
			<tr>  
				<td>Daily</td>
				<td>'.get_post_meta( $single_post->ID, 'daily', true ).'</td>  
			</tr>
			<tr>  
				<td>Drawdown</td>
				<td>'.get_post_meta( $single_post->ID, 'drawdown', true ).'</td>  
			</tr>
			<tr>  
				<td>PF</td>
				<td>'.get_post_meta( $single_post->ID, 'profit', true ).'</td>  
			</tr>
			<tr>  
				<td>Days</td>
				<td>';
				
				
				$diff = time() - strtotime( get_post_meta( $single_post->ID, 'timeline', true ) );						
				$diff  = $diff / ( 60*60*24 );
				$diff = (int)$diff;				
				if( get_post_meta( $single_post->ID, 'days', true ) ){
					$out .=  (int)get_post_meta( $single_post->ID, 'days', true );
				}elseif(get_post_meta( $single_post->ID, 'timeline', true )){
					$out .=  $diff;
				}
				$out .= '</td>  
			</tr>
			<tr>  
				<td>Chart</td>
				<td>'.( get_post_meta( $single_post->ID, 'chart', true ) ? '<a target="_blank" href="'.get_post_meta( $single_post->ID, 's_u', true ).'"><img class="table_chart" src="'.get_post_meta( $single_post->ID, 'chart', true ).'" /></a>' : '' ).'</td>   
			</tr>
			<tr>  
				<td>Account</td>
				<td>'.get_post_meta( $single_post->ID, 'a_t', true ).'</td> 
			</tr>
			</tbody>  
		</table>  
			';
		}
		  
		$out .= '
     </div>  
	  
		<div class="tmp_cont"></div>
	  
	  
	  
	</div>
	';
	
	return $out;	
}

?>