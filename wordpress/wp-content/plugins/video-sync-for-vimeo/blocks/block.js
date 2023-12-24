( function( blocks, editor, i18n, element, components, _ ) {
	var el = wp.element.createElement;
	var InspectorControls = wp.blockEditor.InspectorControls;
	const { Fragment } = element;
	const { SelectControl, Panel, PanelBody, PanelRow } = components;
    const { serverSideRender } = wp;
    const wpvs_videos = [];
    var wpvs_video_list = wpvsvideoblock.video_list;

    jQuery(wpvs_video_list).each(function(index, video) {
        wpvs_videos.push( { label: video.video_name, value: video.video_id } );
    });
    blocks.registerBlockType( 'wpvs-blocks/video-block', {
        title: 'WPVS Video Block',
        description: 'Displays a single WPVS Video. WP Video Memberships plugin access automatically applied.',
        category: 'embed',
        icon: 'format-video',
        attributes: {
            video_id: {
                type: 'number',
                default: 0
            },
			},
			supports: {
				anchor: true,
				multiple: false
			},
        edit: function( props ) {

            return [
                el( Fragment, {},
                    el( InspectorControls, {},
                        el( PanelBody, { title: 'WPVS Video Settings', initialOpen: true },
                            el( PanelRow, {},
                                el( SelectControl,
                                    {
                                        label: 'Select A Video',
                                        value: props.attributes.video_id,
                                        options: wpvs_videos,
                                        onChange: function( value ) {
                                            props.setAttributes( { video_id: parseInt( value ) } );
                                        }
                                    }
                                )
							),
						)
					)
				),
				el( serverSideRender, {
                    block: 'wpvs-blocks/video-block',
                    attributes: props.attributes,
                } )
            ]
        },
        save: function( props ) {

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
