jQuery(document).ready(function($){

	/*---------------------------------------*/
	/* Static Methods
	/*---------------------------------------*/

	var themeblvdColumns = {};

	if ( 'undefined' !== typeof window.themeblvd ) {

		if ( 'undefined' !== typeof window.themeblvd.options ) {

			if ( 'undefined' !== typeof window.themeblvd.options.columnWidths ) {

				themeblvdColumns = window.themeblvd.options.columnWidths;

			}
		}
	}

	var themeblvd_generator = {

		/**
		 * Setup preview area for shortcode
		 */
		preview: function( $section ) {

			var type = $section.data('type'),
				markup = '',
				$preview = $section.find('.shortcode-preview'),
				content = '',
				include_content = $preview.data('content'),
				raw = $preview.data('raw'),
				clean = $preview.data('clean'),
				counter = 0,
				arg = '',
				val = '',
				custom_button = false,
				shadow_line = false,
				has_icon = false;

			if ( raw ) {
				markup += '[raw]<br>';
			}

			if ( type == 'tabs' ) {

				var num = $section.find('select[name="tabs[num]"]').val(),
					style = $section.find('select[name="tabs[style]"]').val(),
					nav = $section.find('select[name="tabs[nav]"]').val();

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

				var num = $section.find('select[name="accordion[num]"]').val();

				markup += '[accordion]<br>';

				for ( var i = 1; i <= num; i++ ) {
					markup += '[toggle title="Toggle #'+i+'"]Content of toggle #'+i+'.[/toggle]<br>';
				}

				markup += '[/accordion]';

			} else {

				markup += '['+type;

				$section.find('.of-input, .of-radio-img-radio, .tb-color-picker').each(function(){

					if ( $(this).hasClass('of-radio-img-radio') && ! $(this).prop('checked') ) {
						return;
					}

					arg = $(this).attr('id');
					val = $(this).val();

					// Any argments that should be skipped
					if ( arg == 'custom_include_bg' || arg == 'custom_include_border' ) {
						return;
					}

					// Fix "excerpt" arg; workaround for bug where WP uses our
					// id="excerpt" to save excerpt of post.
					if ( arg == 'excerpt-option' ) {
						arg = 'excerpt';
					}

					// Check for custom button
					if ( type == 'button' && arg == 'color' && val == 'custom' ) {
						custom_button = true;
					}

					// Divider
					if ( type == 'divider' && arg == 'style' && val == 'shadow' ) {
						shadow_line = true;
					}

					if ( shadow_line && arg != 'style' && arg != 'width' ) {
						return;
					}

					if ( type == 'divider' && arg == 'icon' && val ) {
						has_icon = true;
					}

					if ( type == 'divider' && ! has_icon && ( arg == 'icon_color' || arg == 'icon_size' ) ) {
						return;
					}

					// Image radio's ID's aren't structured the same as other inputs
					if ( $(this).hasClass('of-radio-img-radio') ) {
						arg = arg.replace(new RegExp('_'+val, 'g'), '');
					}

					if ( val && val !== '0' ) {

						if ( arg != 'sc_content' ) {
							markup += ' '+arg+'="'+val+'"';
						}

						if ( arg == 'sc_content' ) {
							content = val;
						}
					}

					if ( arg != 'sc_content' ) {
						counter++;
					}
				});

				// Handle custom button arguments
				if ( custom_button ) {

					var button_args = {};

					$section.find('.section-button').find('input.color-picker, .checkbox').each(function(){

						var $el = $(this);

						arg = $el.attr('id');
						arg = arg.replace('custom_', '');

						if ( $el.hasClass('checkbox') ) {
							if ( $el.prop('checked') ) {
								val = 'true';
							} else {
								val = 'false';
							}
						} else {
							val = $el.val();
						}

						button_args[arg] = val;
					});

					for ( var arg in button_args ) {
    					if ( button_args.hasOwnProperty(arg) ) {

    						if ( arg == 'bg' || arg == 'border' ) {
    							if ( arg == 'bg' && button_args.include_bg == 'true' ) {
    								markup += ' '+arg+'="'+button_args[arg]+'"';
    							} else if ( arg == 'border' && button_args.include_border == 'true' ) {
    								markup += ' '+arg+'="'+button_args[arg]+'"';
    							}
    						} else {
    							markup += ' '+arg+'="'+button_args[arg]+'"';
    						}

    					}
    				}

				}

				markup += ']';

				if ( include_content ) {

					content = content.replace(/</g, '&lt;');
					content = content.replace(/>/g, '&gt;');
					content = content.replace(/(\r\n|\n|\r)/gm, '<br>');

					if ( ( raw || clean ) && content ) {
						markup += '<br>'+content+'<br>';
					} else {
						markup += content;
					}

					markup += '[/'+type+']';
				}
			}

			if ( raw ) {
				markup += '<br>[/raw]';
			}

			$preview.attr('data-type', type).html(markup);
		},

		/**
		 * Columns
		 */
		preview_columns: function( $section ) {

			var $preview = $section.find('.shortcode-preview'),
				markup = '[raw]<br>',
				wpautop = false;

			if ( $section.find('#section-wpautop input').is(':checked') ) {
				wpautop = true;
			}

			if ( $.isEmptyObject( themeblvdColumns ) ) {

				// Theme Blvd Framework v2.4 (@deprecated)

				var num = $section.find( '.column-num' ).val(),
					setup = $section.find( '.column-width-' + num ).val(),
					setup = setup.split( '-' ),
					column = '',
					size;

				for ( var i = 0; i < num; i++ ) {

					column = '';

					switch( setup[ i ] ) {

						case 'grid_3' :
							size = '1/4';
							break;

						case 'grid_4' :
							size = '1/3';
							break;

						case 'grid_6' :
							size = '1/2';
							break;

						case 'grid_8' :
							size = '2/3';
							break;

						case 'grid_9' :
							size = '3/4';
							break;

						case 'grid_fifth_1' :
							size = '1/5';
							break;

						case 'grid_fifth_2' :
							size = '2/5';
							break;

						case 'grid_fifth_3' :
							size = '3/5';
							break;

						case 'grid_fifth_4' :
							size = '4/5';
							break;

						case 'grid_tenth_3' :
							size = '3/10';
							break;

						case 'grid_tenth_7' :
							size = '7/10';
							break;

					}

					column += '[column size="'+size+'"';

					if (  wpautop ) {
						column += ' wpautop="true"';
					}

					if ( i == num-1 ) {
						column += ' last';
					}

					column += ']<br>';
					column += 'Column '+(i+1)+'...<br>';
					column += '[/column]';

					if ( i < num-1 ) {
						column += '<br>';
					}

					markup += column;
				}

			} else {

				// Theme Blvd Framework 2.7+

				var setup = $section.find('.column-width-input').val(),
					setup = setup.split('-');

				for ( var i = 0; i < setup.length; i++ ) {

					markup += '[column size="'+setup[i]+'"';

					if ( wpautop ) {
						markup += ' wpautop="true"';
					}

					markup += ']<br>';
					markup += 'Column '+(i+1)+'...<br>';
					markup += '[/column]';

					if ( i < setup.length-1 ) {
						markup += '<br>';
					}
				}

			}

			markup += '<br>[/raw]';

			// Append final markup
			$preview.html(markup);

		},
		columns_wpauto: function() {

			var $el = $(this),
				$preview = $(this).closest('.shortcode-options').find('.shortcode-preview'),
				markup = $preview.html();

			// Remove value, no matter what
			markup = markup.replace(/ wpautop="true"/g, '');

			// Add value, if wpautop is on
			if ( $el.is(':checked') ) {
				markup = markup.replace(/"]/g, '" wpautop="true"]');
				markup = markup.replace(/last]/g, ' wpautop="true" last]');
			}

			$preview.html(markup);
		},

		/**
		 * Tooltips
		 */
		tooltip_on: function( link ) {

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
		tooltip_off: function( link ) {
			link.closest('.tooltip-wrap').find('.tooltip').remove();
		}

	}; // end themeblvd_generator

	/*---------------------------------------*/
	/* Setup Modal
	/*---------------------------------------*/

	// Show modal window
	$('.tb-insert-shortcode').on( 'click', function(){
		$('#tb-shortcode-generator').show();
		$('body').addClass('themeblvd-stop-scroll themeblvd-shortcode-generator-on');
		return false;
	});

	// Hide modal window
	$('#tb-shortcode-generator .media-modal-close, #tb-shortcode-generator .media-modal-backdrop').on( 'click', function(){
		$('#tb-shortcode-generator').hide();
		$('body').removeClass('themeblvd-stop-scroll themeblvd-shortcode-generator-on');
		return false;
	});

	// Setup general option types from framework
	$('#tb-shortcode-generator').themeblvd('init');
	$('#tb-shortcode-generator').themeblvd('options', 'bind');
	$('#tb-shortcode-generator').themeblvd('options', 'setup');
	$('#tb-shortcode-generator').themeblvd('options', 'column-widths');
	// $('#tb-shortcode-generator').themeblvd('options', 'media-uploader');

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
	$('#tb-shortcode-generator .of-input').on( 'change.generator propertychange.generator keyup.generator input.generator paste.generator', function(){
		themeblvd_generator.preview( $(this).closest('.shortcode-options') );
	});
	$('#tb-shortcode-generator .of-radio-img-img').on( 'click.generator', function(){
		themeblvd_generator.preview( $(this).closest('.shortcode-options') );
	});
	$('#tb-shortcode-generator .shortcode-options-column select').on( 'change.generator', function(){
		themeblvd_generator.preview( $(this).closest('.shortcode-options') );
	});

	// Unbind for columns; we'll use different handlers later.
	$('#tb-shortcode-generator #wpautop').off('change.generator');
	$('#tb-shortcode-generator .shortcode-options-column .section-columns select').off('change.generator');

	if ( $.isFunction( $.fn.wpColorPicker ) ) {
		$('#tb-shortcode-generator .color-picker, #tb-shortcode-generator .tb-color-picker').wpColorPicker({
			change: function() {
				themeblvd_generator.preview( $(this).closest('.shortcode-options') );
			},
			clear: function() {
				themeblvd_generator.preview( $(this).closest('.shortcode-options') );
			}
		});

		$('#tb-shortcode-generator .wp-color-result').on('click', function(){
			themeblvd_generator.preview( $(this).closest('.shortcode-options') );
		});

		/*
		$('#tb-shortcode-generator .iris-palette').on('click', function(){
			themeblvd_generator.preview( $(this).closest('.shortcode-options') );
		});
		*/
	}

	/*---------------------------------------*/
	/* Setup icon browser
	/*---------------------------------------*/

	// Theme Blvd Framework 2.4

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

	// Theme Blvd Framework 2.7+

	$( '#themeblvd-icon-browser-vector .media-button-insert' ).on( 'themeblvd-modal-insert', function( event, self ) {

		var icon  = self.$modalWindow.find( '.icon-selection' ).val(),
			$link = $( self.$element );

		$link.closest( '.input-wrap' ).find( 'input' ).val( icon );

		themeblvd_generator.preview( $link.closest( '.shortcode-options' ) );

	} );

	/*---------------------------------------*/
	/* Setup color browser
	/*---------------------------------------*/

	// Select a color
	$('#tb-shortcode-generator .color-browser .select-color').on( 'click', function(){

		var $el = $(this);

		// Select color
		$el.closest('.color-browser').find('.select-color-wrap').removeClass('selected');
		$el.closest('.select-color-wrap').addClass('selected');

		// Update input
		$('#tb-shortcode-generator input[name="button[color]"]').val( $el.data('color') );

		// Show/hide custom color option
		if ( $el.data('color') == 'custom' ) {
			$el.closest('.options-wrap').find('.section-button').show();
		} else {
			$el.closest('.options-wrap').find('.section-button').hide();
		}

		// Update live preview
		themeblvd_generator.preview( $el.closest('.shortcode-options') );

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

	/**
	 * Send columns configuration to shortcode
	 * output.
	 *
	 * The following only supports framework v2.4
	 * and v2.7+.
	 *
	 * Those using framework 2.5-2.6 should update
	 * their themes to get this functionality.
	 */
	if ( $.isEmptyObject( themeblvdColumns ) ) {

		// Theme Blvd Framework v2.4 (@deprecated)

		$('#tb-shortcode-generator').find('.column-num, .column-width').on('change', function(){
			themeblvd_generator.preview_columns( $(this).closest('.shortcode-options') );
		});

		$('#tb-shortcode-generator .columns').each(function(){
			$(this).find('.column-num option:first-child').remove();
			$(this).find('.column-width-1').remove();
		});

	} else {

		// Theme Blvd framework v2.7+

		$('#tb-shortcode-generator .column-width-input').on('themeblvd-update-columns', function(){
			themeblvd_generator.preview_columns( $(this).closest('.shortcode-options') );
		});

	}

	$('#tb-shortcode-generator #wpautop').on('change', themeblvd_generator.columns_wpauto);

	/*---------------------------------------*/
	/* Send to editor
	/*---------------------------------------*/

	$('#tb-shortcode-to-editor').on( 'click', function(){

		var $modal = $(this).closest('#tb-shortcode-generator'),
			type = $(this).data('insert'),
			content = $modal.find('.shortcode-preview-'+type).html(),
			text = true;

		if ( $('#wp-content-wrap').hasClass('tmce-active') ) {
			text = false;
		}

		// Remove any HTML from shortcode content
		content = content.replace(/<hr>/gi, '');

		// HTML decode, if necessary
		if ( type == 'icon_list' ) {
			content = $("<div/>").html(content).text();
			content = content.replace(/<ul>/gi, '\n<ul>\n');
			content = content.replace(/<\/li>/gi, '<\/li>\n');
			content = content.replace(/<\/ul>/gi, '<\/ul>\n');
		}

		// Remove line break HTML if going to raw Text editor
		if ( text ) {
			content = content.replace(/<br>/gi, '\n');
		}

		// Send shortcode to WP Editor
		window.send_to_editor(content);

		// Allow page to scroll again
		$('body').removeClass('themeblvd-stop-scroll themeblvd-shortcode-generator-on');

		// Hide modal window
		$modal.hide();

		return false;
	});

});
