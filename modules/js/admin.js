jQuery(document).ready(function($){
	
	$('#submit_shortcodes').submit(function( e ){
		
		// add index to cehckboxes
		var cnt = 0;
		$('.admin_bar_checkbox').each(function(){
			
			var this_name = $(this).attr('name');
			this_name = this_name + '['+cnt+']';
			$(this).attr('name', this_name);
			cnt++;
						
		})
		
		$('.hasPair').removeClass('hasPair');
		
		var allValues = [];
		$('.shortcut_input_field').each(function(){
			allValues.push( $(this).val() );
		})
		var sorted_arr = allValues.slice().sort();
		
		var results = [];
		for (var i = 0; i < allValues.length - 1; i++) {
			if (sorted_arr[i + 1] == sorted_arr[i]) {
				results.push(sorted_arr[i]);
			}
		}
		
		console.log(results);
		
		 
		$('.shortcut_input_field').each(function(){
			console.log( $.inArray( $(this).val(), results ) );
			if( $.inArray( $(this).val(), results ) !== -1 ){
				$(this).addClass('hasPair');
			}
		})
		console.log( results.length );
		if( results.length > 0 ){
			alert('You have duplicates in your shortkeys');
			e.preventDefault();
		}
		
	})
	
	
	$('body').on('click', '.delete_row', function(){
		var pnt = $(this).parents('tr');
		pnt.fadeOut(function(){
			pnt.replaceWith('');
		})
	})
	$('body').on('click', '.clone_row', function(){
		var pnt = $(this).parents('tr');
		var new_row = pnt.clone();
		new_row.hide();
		pnt.after( new_row );
		new_row.fadeIn();
	})
	$('body').on('change', '.action_picker', function(){
		var pnt = $(this).parents('tr');
		$('.second_stage_picker', pnt).hide();
		$('.'+$('.action_picker', pnt).val(), pnt).fadeIn();
	})
	
	
	$('body').on('keydown', '.shortcut_input_field', function( e ){
 
		$(this).val( get_conbination_from_obj(e) );
		
		e.stopPropagation ();
		e.preventDefault ()
		
	})
	
	
	$('body').on('click', '.add_row', function(){
		var first_line = $('.editor_content tr:first-child').clone();
		$('.pickers_block .second_stage_picker', first_line ).hide();
		$('.pickers_block .second_stage_picker:first-child', first_line ).show();
		$('input[type=text]', first_line).val('');
		$('select.action_picker', first_line).val('menu_action');
		$('select.second_stage_picker', first_line).val('');
		$('.editor_content').append( first_line );
	})
	$('body').on('click', '.enter_combination', function(){
		var pnt = $(this).parents('tr');
		$('.shortcut_input_field', pnt).focus();
	})
	
	
	/*
	$(document).on("keydown", function(e) { 
	
		console.log( ' ' );
		console.log( 'Ctrl: '+e.ctrlKey  );
		console.log( 'Alt: '+e.altKey  );
		console.log( 'Shift: '+e.shiftKey  );
		console.log( 'Button '+e.which  );
		console.log( 'Button '+e.code  );
		console.log( ' ' );
	
		if ( e.ctrlKey && ( e.which === 46 ) ) {
		  console.log( "You pressed CTRL + Del" );
		}
		 e.stopPropagation ();
			e.preventDefault ();
	})
	*/
	
	

});


