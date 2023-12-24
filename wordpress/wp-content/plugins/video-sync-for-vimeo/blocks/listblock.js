( function( blocks, editor, i18n, element, components, _ ) {
	var el = wp.element.createElement;
	var InspectorControls = wp.blockEditor.InspectorControls;
	const { Fragment, useState } = element;
	const { CheckboxControl, Panel, PanelBody, __experimentalNumberControl } = components;
    const { serverSideRender } = wp;

	const $wpvs_update_attribute_string = function(attribute_list, term_id) {
		var wpvs_attribute_items = attribute_list.split(',');
		var term_index = wpvs_attribute_items.indexOf(term_id);
		if( term_index > -1 ) {
			wpvs_attribute_items.splice(term_index, 1);
		} else {
			wpvs_attribute_items.push(term_id);
		}
		return wpvs_attribute_items.join();
	}

    blocks.registerBlockType( 'wpvs-blocks/video-list-block', {
        title: 'WPVS Video List',
        description: 'Displays a list WPVS Videos.',
        category: 'embed',
        icon: 'format-video',
        attributes: {
			videos_per_page: {
                type: 'number',
                default: 12
            },
            categories: {
                type: 'string',
                default: ''
            },
			actors: {
				type: 'string',
                default: ''
            },
			directors: {
				type: 'string',
                default: ''
            },
			tags: {
				type: 'string',
                default: ''
            },
		},
		supports: {
			anchor: true,
			multiple: true
		},
        edit: function( props ) {

			var wpvs_categories = [];
			var wpvs_actors = [];
			var wpvs_directors = [];
			var wpvs_tags = [];

			var wpvs_categories_set = props.attributes.categories.split(',');
			var wpvs_actors_set = props.attributes.actors.split(',');
			var wpvs_directors_set = props.attributes.directors.split(',');
			var wpvs_tags_set = props.attributes.tags.split(',');

		    jQuery.each(wpvsvideolistblock.categories, function(term_id, term_name) {
				var term_index = wpvs_categories_set.indexOf(term_id);
				var term_included = false;
				if( term_index > -1 ) {
					term_included = true;
				}
		        wpvs_categories.push(
					el( CheckboxControl, {
		                key: term_id,
		                label: term_name+' ('+term_id+')',
						checked: term_included,
		                onChange: function( checked ) {
							var new_term_list = $wpvs_update_attribute_string(props.attributes.categories, term_id);
							props.setAttributes( { categories: new_term_list });
		                }
		            })
				 );
		    });

			jQuery.each(wpvsvideolistblock.actors, function(term_id, term_name) {
				var term_index = wpvs_actors_set.indexOf(term_id);
				var term_included = false;
				if( term_index > -1 ) {
					term_included = true;
				}
		        wpvs_actors.push(
					el( CheckboxControl, {
		                key: term_id,
		                label: term_name+' ('+term_id+')',
						checked: term_included,
		                onChange: function( checked ) {
							var new_term_list = $wpvs_update_attribute_string(props.attributes.actors, term_id);
							props.setAttributes( { actors: new_term_list });
		                }
		            })
				 );
		    });

			jQuery.each(wpvsvideolistblock.directors, function(term_id, term_name) {
				var term_index = wpvs_directors_set.indexOf(term_id);
				var term_included = false;
				if( term_index > -1 ) {
					term_included = true;
				}
		        wpvs_directors.push(
					el( CheckboxControl, {
		                key: term_id,
		                label: term_name+' ('+term_id+')',
						checked: term_included,
		                onChange: function( checked ) {
							var new_term_list = $wpvs_update_attribute_string(props.attributes.directors, term_id);
							props.setAttributes( { directors: new_term_list });
		                }
		            })
				 );
		    });

			jQuery.each(wpvsvideolistblock.tags, function(term_id, term_name) {
				var term_index = wpvs_tags_set.indexOf(term_id);
				var term_included = false;
				if( term_index > -1 ) {
					term_included = true;
				}
		        wpvs_tags.push(
					el( CheckboxControl, {
		                key: term_id,
		                label: term_name+' ('+term_id+')',
						checked: term_included,
		                onChange: function( checked ) {
							var new_term_list = $wpvs_update_attribute_string(props.attributes.tags, term_id);
							props.setAttributes( { tags: new_term_list });
		                }
		            })
				 );
		    });

            return [
                el( Fragment, {},
                    el( InspectorControls, {},
						el( PanelBody, { title: 'Videos Per Page', initialOpen: false },
							el( __experimentalNumberControl, {
								min: 1,
								max: 50,
								step: 1,
								value: props.attributes.videos_per_page,
								label: 'Videos Per Page',
								onChange: function( number ) {
									props.setAttributes( { videos_per_page: number });
								}
							})
						),
                        el( PanelBody, { title: 'WPVS Genre / Category', initialOpen: false },
                            wpvs_categories
						),
						el( PanelBody, { title: 'WPVS Actors', initialOpen: false },
                            wpvs_actors
						),
						el( PanelBody, { title: 'WPVS Directors', initialOpen: false },
                            wpvs_directors
						),
						el( PanelBody, { title: 'WPVS Video Tags', initialOpen: false },
                            wpvs_tags
						)
					)
				),
				el( serverSideRender, {
                    block: 'wpvs-blocks/video-list-block',
                    attributes: props.attributes,
                } )
            ]
        },
        save: function( props ) {
			return null;
        },
    } );

} )(
    window.wp.blocks,
    window.wp.editor,
    window.wp.i18n,
    window.wp.element,
    window.wp.components,
    window._,
);
