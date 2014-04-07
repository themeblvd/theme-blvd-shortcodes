jQuery(document).ready(function($){

	/*---------------------------------------*/
	/* Static Methods
	/*---------------------------------------*/

	var themeblvd_generator = {

		/**
		 * Setup preview area for shortcode
		 */
		preview : function( section ) {

			var type = section.data('type'),
				markup = '',
				preview = section.find('.shortcode-preview'),
				content = '',
				include_content = preview.data('content'),
				raw = preview.data('raw'),
				clean = preview.data('clean'),
				arg,
				val;

			if ( raw ) {
				markup += '[raw]<br>';
			}

			if ( type == 'column' ) {

				var num = section.find('.column-num').val(),
					setup = section.find('.column-width-'+num+' select').val(),
					setup = setup.split('-'),
					column = '',
					col_type;

				for ( var i = 0; i < num; i++ ) {

					column = '';

					switch(setup[i]) {

						case 'grid_3' :
							col_type = 'one_fourth';
							break;

						case 'grid_4' :
							col_type = 'one_third';
							break;

						case 'grid_6' :
							col_type = 'one_half';
							break;

						case 'grid_8' :
							col_type = 'two_third';
							break;

						case 'grid_9' :
							col_type = 'three_fourth';
							break;

						case 'grid_fifth_1' :
							col_type = 'one_fifth';
							break;

						case 'grid_fifth_2' :
							col_type = 'two_fifth';
							break;

						case 'grid_fifth_3' :
							col_type = 'three_fifth';
							break;

						case 'grid_fifth_4' :
							col_type = 'four_fifth';
							break;

						case 'grid_tenth_3' :
							col_type = 'three_tenth';
							break;

						case 'grid_tenth_7' :
							col_type = 'seven_tenth';
							break;

					}

					column += '['+col_type;

					if ( i == num-1 ) {
						column += ' last';
					}

					column += ']<br>';
					column += 'Column '+(i+1)+'...<br>';
					column += '[/'+col_type+']<br>';

					markup += column;
				}

				markup += '[clear]';

			} else if ( type == 'tabs' ) {

				var num = section.find('select[name="tabs[num]"]').val(),
					style = section.find('select[name="tabs[style]"]').val(),
					nav = section.find('select[name="tabs[nav]"]').val();

				markup += '[tabs style="'+style+'" nav="'+nav+'"';

				for ( var i = 1; i <= num; i++ ) {
					markup += ' tab_'+i+'="Title #'+i+'"';
				}

				markup += ']<br>';

				for ( var i = 1; i <= num; i++ ) {
					markup += '[tab_'+i+']Tab '+i+'...[/tab_'+i+']<br>';
				}

				markup += '[/tabs]';

			} else if ( type == 'accordion' ) {

				var num = section.find('select[name="accordion[num]"]').val();

				markup += '[accordion]<br>';

				for ( var i = 1; i <= num; i++ ) {
					markup += '[toggle title="Toggle #'+i+'"]Content of toggle #'+i+'.[/toggle]<br>';
				}

				markup += '[/accordion]';

			} else {

				markup += '['+type+' ';

				section.find('.of-input, .of-radio-img-radio').each(function(){

					if( $(this).hasClass('of-radio-img-radio') && !$(this).prop('checked') ) {
						return;
					}

					arg = $(this).attr('id');
					val = $(this).val();

					// Image radio's ID's aren't structured the same as other inputs
					if ( $(this).hasClass('of-radio-img-radio') ) {
						arg = arg.replace(new RegExp('_'+val, 'g'), '');
					}

					if ( val ) {

						if ( ( type == 'icon' || val != 'none' ) && arg != 'sc_content' ) {
							markup += ' '+arg+'="'+val+'"';
						}

						if ( arg == 'sc_content' ) {
							content = val;
						}
					}
				});

				markup += ']';

				if ( include_content ) {

					content = content.replace(/</g, '&lt;');
					content = content.replace(/>/g, '&gt;');
					content = content.replace(/(\r\n|\n|\r)/gm, '<br>');

					if ( ( raw || clean ) && content ) {
						markup += '<br>'+content+'</br />';
					} else {
						markup += content;
					}

					markup += '[/'+type+']';
				}
			}

			if ( raw ) {
				markup += '<br>[/raw]';
			}

			preview.attr('data-type', type).html(markup);
		},

		/**
		 * Tooltips
		 */
		tooltip_on : function( link ) {

			var	container = link.closest('.tooltip-wrap'),
				icon_id = link.data('tooltip-text'),
				markup =  '<div class="tooltip top"> \
							   <div class="tooltip-inner"> \
							     text \
							   </div> \
							   <div class="tooltip-arrow"></div> \
							 </div>';

			markup = markup.replace('text', icon_id);
			container.append(markup);

			var tooltip = container.find('.tooltip');

			tooltip.css({
				'top' : '-'+tooltip.height()+'px',
				'left' : '50%',
				'margin-left' : '-'+tooltip.width()/2+'px'
			}).addClass('fade in');
		},
		tooltip_off : function( link ) {
			link.closest('.tooltip-wrap').find('.tooltip').remove();
		}

	}; // end themeblvd_generator

	/*---------------------------------------*/
	/* Setup Modal
	/*---------------------------------------*/

	// Show modal window
	$('.tb-insert-shortcode').on( 'click', function(){
		$('#tb-shortcode-generator').show();
		return false;
	});

	// Hide modal window
	$('#tb-shortcode-generator .media-modal-close, #tb-shortcode-generator .media-modal-backdrop').on( 'click', function(){
		$('#tb-shortcode-generator').hide();
		return false;
	});

	// Setup general option types from framework
	$('#tb-shortcode-generator').themeblvd('init');
	$('#tb-shortcode-generator').themeblvd('options', 'bind');
	$('#tb-shortcode-generator').themeblvd('options', 'setup');

	// Generator left-side navigation
	$('#tb-shortcode-generator .media-menu-item').on( 'click', function(){

		var button = $(this),
			id = button.data('id'),
			name = button.text().trim(),
			hide_router = true,
			modal = button.closest('#tb-shortcode-generator'),
			insert = '';

		// Change Button
		modal.find('.media-menu-item').removeClass('active');
		button.addClass('active');

		// Change Title
		modal.find('.media-frame-title h1').text(name);

		// Change router menu
		modal.find('.media-frame').addClass('hide-router');

		modal.find('.media-frame-router').each(function(){

			var el = $(this);

			if ( el.data('group') == id ) {
				el.show();
				hide_router = false;
			} else {
				el.hide();
			}
		});

		if ( ! hide_router ) {
			modal.find('.media-frame').removeClass('hide-router');
		}

		// Change Content
		modal.find('.tb-group').removeClass('tb-group-show').addClass('tb-group-hide');
		modal.find('#tb-group-'+id).addClass('tb-group-show').removeClass('tb-group-hide');

		// Send to editor button
		modal.find('#tb-group-'+id+' .shortcode-options').each(function(){
			if ( !$(this).hasClass('hide') ) {
				insert = $(this).data('type');
			}
		});

		$('#tb-shortcode-to-editor').data('insert', insert);

		return false;
	});

	// Generator top, tabbed navigation
	$('#tb-shortcode-generator .media-frame-router').hide().closest('.media-frame').addClass('hide-router');

	$('#tb-shortcode-generator .tb-tab-menu-item').on( 'click', function(){

		var el = $(this),
			group = el.closest('.media-frame-router').data('group'),
			sub_group = el.data('sub-group')
			modal = el.closest('#tb-shortcode-generator');

		// Add "active" class to tab
		el.closest('.media-frame-router').find('.tb-tab-menu-item').removeClass('active');
		el.addClass('active');

		// Show content
		modal.find('#tb-group-'+group+' .shortcode-options').hide().addClass('hide');
		modal.find('#tb-group-'+group+' .shortcode-options-'+sub_group).removeClass('hide').show();

		// Send to editor button
		$('#tb-shortcode-to-editor').data('insert', sub_group);

		return false;
	});

	/*---------------------------------------*/
	/* Spy for changes to build preview
	/*---------------------------------------*/

	// Build shortcode preview
	$('#tb-shortcode-generator .of-input').on( 'change propertychange keyup input paste', function(){
		themeblvd_generator.preview( $(this).closest('.shortcode-options') );
	});
	$('#tb-shortcode-generator .of-radio-img-img').on( 'click', function(){
		themeblvd_generator.preview( $(this).closest('.shortcode-options') );
	});
	$('#tb-shortcode-generator .shortcode-options-column select').on( 'change', function(){
		themeblvd_generator.preview( $(this).closest('.shortcode-options') );
	});

	/*---------------------------------------*/
	/* Setup icon browser
	/*---------------------------------------*/

	// Vector icon browser
	$('#tb-shortcode-generator .icon-browser-content').hide();

	$('#tb-shortcode-generator .icon-browser-title a').on( 'click', function(){

		var browser = $(this).closest('.icon-browser').find('.icon-browser-content');

		if( browser.hasClass('open') ) {
			$(this).find('.fa').removeClass('fa-rotate-180');
			browser.hide().removeClass('open');
		} else {
			$(this).find('.fa').addClass('fa-rotate-180');
			browser.show().addClass('open');
		}

		return false;
	});

	$('#tb-shortcode-generator .icon-browser .select-icon').on( 'mouseenter', function(){
		themeblvd_generator.tooltip_on($(this));
	});

	$('#tb-shortcode-generator .icon-browser .select-icon').on( 'mouseleave', function(){
		themeblvd_generator.tooltip_off($(this));
	});

	$('#tb-shortcode-generator .icon-browser .select-icon').on( 'click', function(){

		// Select icon
		$(this).closest('.icon-browser').find('.select-icon').removeClass('selected');
		$(this).addClass('selected');

		// Update input
		$('#tb-shortcode-generator input[name="vector_icon[icon]"]').val( $(this).data('id') );

		// Update live preview
		themeblvd_generator.preview( $(this).closest('.shortcode-options') );

		return false;
	});

	/*---------------------------------------*/
	/* Setup color browser
	/*---------------------------------------*/

	// Select a color
	$('#tb-shortcode-generator .color-browser .select-color').on( 'click', function(){

		// Select color
		$(this).closest('.color-browser').find('.select-color-wrap').removeClass('selected');
		$(this).closest('.select-color-wrap').addClass('selected');

		// Update input
		$('#tb-shortcode-generator input[name="button[color]"]').val( $(this).data('color') );

		// Update live preview
		themeblvd_generator.preview( $(this).closest('.shortcode-options') );

		return false;

	});

	// Tooltips
	$('#tb-shortcode-generator .color-browser .select-color').on( 'mouseenter', function(){
		themeblvd_generator.tooltip_on($(this));
	});

	$('#tb-shortcode-generator .color-browser .select-color').on( 'mouseleave', function(){
		themeblvd_generator.tooltip_off($(this));
	});

	/*---------------------------------------*/
	/* Columns
	/*---------------------------------------*/

	$('#tb-shortcode-generator .columns').each(function(){
		$(this).find('.column-num option:first-child').remove();
		$(this).find('.column-width-1').remove();
	});

	/*---------------------------------------*/
	/* Send to editor
	/*---------------------------------------*/

	$('#tb-shortcode-to-editor').on( 'click', function(){

		var modal = $(this).closest('#tb-shortcode-generator'),
			type = $(this).data('insert'),
			content = modal.find('.shortcode-preview-'+type).html(),
			text = true;

		if ( $('#wp-content-wrap').hasClass('tmce-active') ) {
			text = false;
		}

		// Remove any HTML from shortcode content
		content = content.replace(/<hr>/gi, '');

		// Remove line break HTML if going to raw Text editor
		if ( text ) {
			content = content.replace(/<br>/gi, '\n');
		}

		// Send shortcode to WP Editor
		window.send_to_editor(content);

		// Hide modal window
		modal.hide();

		return false;
	});

});