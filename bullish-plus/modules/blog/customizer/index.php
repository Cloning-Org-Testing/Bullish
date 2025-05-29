<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'BullishPlusCustomizerSiteBlog' ) ) {
    class BullishPlusCustomizerSiteBlog {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'customize_register', array( $this, 'register' ), 15 );
            add_filter( 'bullish_plus_customizer_default', array( $this, 'default' ) );
        }

        function default( $option ) {

            $blog_defaults = array();
            if( function_exists('bullish_archive_blog_post_defaults') ) {
                $blog_defaults = bullish_archive_blog_post_defaults();
            }
            $option['blog-post-layout']          = $blog_defaults['post-layout'];
            $option['blog-post-grid-list-style'] = 'wdt-simple';
            $option['blog-list-thumb']           = $blog_defaults['list-type'];
            $option['blog-image-hover-style']    = $blog_defaults['hover-style'];
            $option['blog-image-overlay-style']  = $blog_defaults['overlay-style'];
            $option['blog-alignment']            = $blog_defaults['post-align'];
            $option['blog-post-columns']         = $blog_defaults['post-column'];

            $blog_misc_defaults = array();
            if( function_exists('bullish_archive_blog_post_misc_defaults') ) {
                $blog_misc_defaults = bullish_archive_blog_post_misc_defaults();
            }

            $option['enable-equal-height']       = $blog_misc_defaults['enable-equal-height'];
            $option['enable-no-space']           = $blog_misc_defaults['enable-no-space'];

            $blog_params = array();
            if( function_exists('bullish_archive_blog_post_params_default') ) {
                $blog_params = bullish_archive_blog_post_params_default();
            }

            $option['enable-video-audio']        = $blog_params['enable_video_audio'];
            $option['enable-gallery-slider']     = $blog_params['enable_gallery_slider'];
            $option['blog-media-group']          = $blog_params['archive_media_elements'];
            $option['blog-elements-position']    = $blog_params['archive_post_elements'];
            $option['blog-meta-position']        = $blog_params['archive_meta_elements'];
            $option['blog-readmore-text']        = $blog_params['archive_readmore_text'];
            $option['enable-excerpt-text']       = $blog_params['enable_excerpt_text'];
            $option['blog-excerpt-length']       = $blog_params['archive_excerpt_length'];
            $option['blog-pagination']           = $blog_params['archive_blog_pagination'];


            return $option;

        }

        function register( $wp_customize ) {

            /**
             * Panel
             */
            $wp_customize->add_panel(
                new Bullish_Customize_Panel(
                    $wp_customize,
                    'site-blog-main-panel',
                    array(
                        'title'    => esc_html__('Blog Settings', 'bullish-plus'),
                        'priority' => bullish_customizer_panel_priority( 'blog' )
                    )
                )
            );

            $wp_customize->add_section(
                new Bullish_Customize_Section(
                    $wp_customize,
                    'site-blog-archive-section',
                    array(
                        'title'    => esc_html__('Blog Archives', 'bullish-plus'),
                        'panel'    => 'site-blog-main-panel',
                        'priority' => 10,
                    )
                )
            );


            /**
             * Option : Archive Post Layout
             */
            $wp_customize->add_setting(
                BULLISH_CUSTOMISER_VAL . '[blog-post-layout]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Bullish_Customize_Control_Radio_Image(
                $wp_customize, BULLISH_CUSTOMISER_VAL . '[blog-post-layout]', array(
                    'type' => 'wdt-radio-image',
                    'label' => esc_html__( 'Post Layout', 'bullish-plus'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'bullish_blog_archive_layout_options', array(
                        'entry-grid' => array(
                            'label' => esc_html__( 'Grid', 'bullish-plus' ),
                            'path' => BULLISH_PLUS_DIR_URL . 'modules/blog/customizer/images/entry-grid.png'
                        ),
                        'entry-list' => array(
                            'label' => esc_html__( 'List', 'bullish-plus' ),
                            'path' => BULLISH_PLUS_DIR_URL . 'modules/blog/customizer/images/entry-list.png'
                        )
                    ))
                )
            ));

            /**
             * Option : Post Columns
             */
            $wp_customize->add_setting(
                BULLISH_CUSTOMISER_VAL . '[blog-post-columns]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Bullish_Customize_Control_Radio_Image(
                $wp_customize, BULLISH_CUSTOMISER_VAL . '[blog-post-columns]', array(
                    'type' => 'wdt-radio-image',
                    'label' => esc_html__( 'Columns', 'bullish-plus'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'bullish_blog_archive_columns_options', array(
                        'one-column' => array(
                            'label' => esc_html__( 'One Column', 'bullish-plus' ),
                            'path' => BULLISH_PLUS_DIR_URL . 'modules/blog/customizer/images/one-column.png'
                        ),
                        'one-half-column' => array(
                            'label' => esc_html__( 'One Half Column', 'bullish-plus' ),
                            'path' => BULLISH_PLUS_DIR_URL . 'modules/blog/customizer/images/one-half-column.png'
                        ),
                        'one-third-column' => array(
                            'label' => esc_html__( 'One Third Column', 'bullish-plus' ),
                            'path' => BULLISH_PLUS_DIR_URL . 'modules/blog/customizer/images/one-third-column.png'
                        ),
                    )),
                    'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-list' ))
            ));

            /**
             * Option : List Thumb
             */
            $wp_customize->add_setting(
                BULLISH_CUSTOMISER_VAL . '[blog-list-thumb]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Bullish_Customize_Control_Radio_Image(
                $wp_customize, BULLISH_CUSTOMISER_VAL . '[blog-list-thumb]', array(
                    'type' => 'wdt-radio-image',
                    'label' => esc_html__( 'List Type', 'bullish-plus'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'bullish_blog_archive_list_thumb_options', array(
                        'entry-left-thumb' => array(
                            'label' => esc_html__( 'Left Thumb', 'bullish-plus' ),
                            'path' => BULLISH_PLUS_DIR_URL . 'modules/blog/customizer/images/entry-left-thumb.png'
                        ),
                        'entry-right-thumb' => array(
                            'label' => esc_html__( 'Right Thumb', 'bullish-plus' ),
                            'path' => BULLISH_PLUS_DIR_URL . 'modules/blog/customizer/images/entry-right-thumb.png'
                        ),
                    )),
                    'dependency' => array( 'blog-post-layout', '==', 'entry-list' ),
                )
            ));

            /**
             * Option : Post Alignment
             */
            $wp_customize->add_setting(
                BULLISH_CUSTOMISER_VAL . '[blog-alignment]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Bullish_Customize_Control(
                $wp_customize, BULLISH_CUSTOMISER_VAL . '[blog-alignment]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Elements Alignment', 'bullish-plus' ),
                    'choices' => array(
                      'alignnone'   => esc_html__('None', 'bullish-plus'),
                      'alignleft'   => esc_html__('Align Left', 'bullish-plus'),
                      'aligncenter' => esc_html__('Align Center', 'bullish-plus'),
                      'alignright'  => esc_html__('Align Right', 'bullish-plus'),
                    ),
                    'dependency'   => array( 'blog-post-layout', 'any', 'entry-grid'),
                )
            ));

            /**
             * Option : Equal Height
             */
            $wp_customize->add_setting(
                BULLISH_CUSTOMISER_VAL . '[enable-equal-height]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Bullish_Customize_Control_Switch(
                    $wp_customize, BULLISH_CUSTOMISER_VAL . '[enable-equal-height]', array(
                        'type'    => 'wdt-switch',
                        'label'   => esc_html__( 'Enable Equal Height', 'bullish-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'bullish-plus' ),
                            'off' => esc_attr__( 'No', 'bullish-plus' )
                        ),
                        'dependency' => array( 'blog-post-layout', 'any', 'entry-grid' ),
                    )
                )
            );

            /**
             * Option : No Space
             */
            $wp_customize->add_setting(
                BULLISH_CUSTOMISER_VAL . '[enable-no-space]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Bullish_Customize_Control_Switch(
                    $wp_customize, BULLISH_CUSTOMISER_VAL . '[enable-no-space]', array(
                        'type'    => 'wdt-switch',
                        'label'   => esc_html__( 'Enable No Space', 'bullish-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'bullish-plus' ),
                            'off' => esc_attr__( 'No', 'bullish-plus' )
                        ),
                        'dependency' => array( 'blog-post-layout', 'any', 'entry-grid' ),
                    )
                )
            );

            /**
             * Option : Gallery Slider
             */
            $wp_customize->add_setting(
                BULLISH_CUSTOMISER_VAL . '[enable-gallery-slider]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Bullish_Customize_Control_Switch(
                    $wp_customize, BULLISH_CUSTOMISER_VAL . '[enable-gallery-slider]', array(
                        'type'    => 'wdt-switch',
                        'label'   => esc_html__( 'Display Gallery Slider', 'bullish-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'bullish-plus' ),
                            'off' => esc_attr__( 'No', 'bullish-plus' )
                        ),
                        'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-list' ),
                    )
                )
            );

            /**
             * Divider : Blog Gallery Slider Bottom
             */
            $wp_customize->add_control(
                new Bullish_Customize_Control_Separator(
                    $wp_customize, BULLISH_CUSTOMISER_VAL . '[blog-gallery-slider-bottom-separator]', array(
                        'type'     => 'wdt-separator',
                        'section'  => 'site-blog-archive-section',
                        'settings' => array(),
                    )
                )
            );
            /**
             * Option : Blog Media Group
             */
            $wp_customize->add_setting(
                BULLISH_CUSTOMISER_VAL . '[blog-media-group]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Bullish_Customize_Control_Sortable(
                $wp_customize, BULLISH_CUSTOMISER_VAL . '[blog-media-group]', array(
                    'type' => 'wdt-sortable',
                    'label' => esc_html__( 'Media Group Positioning', 'bullish-plus'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'bullish_archive_media_elements_options', array(
                        'feature_image' => esc_html__('Feature Image', 'bullish-plus'),
                        'title'         => esc_html__('Title', 'bullish-plus'),
                        'content'       => esc_html__('Content', 'bullish-plus'),
                        'read_more'     => esc_html__('Read More', 'bullish-plus'),
                        'meta_group'    => esc_html__('Meta Group', 'bullish-plus'),
                        'author'        => esc_html__('Author', 'bullish-plus'),
                        'date'          => esc_html__('Date', 'bullish-plus'),
                        'comment'       => esc_html__('Comments', 'bullish-plus'),
                        'category'      => esc_html__('Categories', 'bullish-plus'),
                        'tag'           => esc_html__('Tags', 'bullish-plus'),
                        'social'        => esc_html__('Social Share', 'bullish-plus'),
                        'likes_views'   => esc_html__('Likes & Views', 'bullish-plus')
                    )),
                    'description' => esc_html__('Arrange the media elements for better display.', 'bullish-plus'),
                )
            ));
            /**
             * Option : Blog Elements
             */
            $wp_customize->add_setting(
                BULLISH_CUSTOMISER_VAL . '[blog-elements-position]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Bullish_Customize_Control_Sortable(
                $wp_customize, BULLISH_CUSTOMISER_VAL . '[blog-elements-position]', array(
                    'type' => 'wdt-sortable',
                    'label' => esc_html__( 'Elements Positioning', 'bullish-plus'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'bullish_archive_post_elements_options', array(
                        'title'         => esc_html__('Title', 'bullish-plus'),
                        'content'       => esc_html__('Content', 'bullish-plus'),
                        'read_more'     => esc_html__('Read More', 'bullish-plus'),
                        'meta_group'    => esc_html__('Meta Group', 'bullish-plus'),
                        'author'        => esc_html__('Author', 'bullish-plus'),
                        'date'          => esc_html__('Date', 'bullish-plus'),
                        'comment'       => esc_html__('Comments', 'bullish-plus'),
                        'category'      => esc_html__('Categories', 'bullish-plus'),
                        'tag'           => esc_html__('Tags', 'bullish-plus'),
                        'social'        => esc_html__('Social Share', 'bullish-plus'),
                        'likes_views'   => esc_html__('Likes & Views', 'bullish-plus'),
                    )),
                )
            ));

            /**
             * Option : Blog Meta Elements
             */
            $wp_customize->add_setting(
                BULLISH_CUSTOMISER_VAL . '[blog-meta-position]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Bullish_Customize_Control_Sortable(
                $wp_customize, BULLISH_CUSTOMISER_VAL . '[blog-meta-position]', array(
                    'type' => 'wdt-sortable',
                    'label' => esc_html__( 'Meta Group Positioning', 'bullish-plus'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'bullish_blog_archive_meta_elements_options', array(
                        'author'        => esc_html__('Author', 'bullish-plus'),
                        'date'          => esc_html__('Date', 'bullish-plus'),
                        'comment'       => esc_html__('Comments', 'bullish-plus'),
                        'category'      => esc_html__('Categories', 'bullish-plus'),
                        'tag'           => esc_html__('Tags', 'bullish-plus'),
                        'social'        => esc_html__('Social Share', 'bullish-plus'),
                        'likes_views'   => esc_html__('Likes & Views', 'bullish-plus'),
                    )),
                    'description' => esc_html__('Note: Use max 3 items for better results.', 'bullish-plus'),
                )
            ));

            /**
             * Divider : Blog Meta Elements Bottom
             */
            $wp_customize->add_control(
                new Bullish_Customize_Control_Separator(
                    $wp_customize, BULLISH_CUSTOMISER_VAL . '[blog-meta-elements-bottom-separator]', array(
                        'type'     => 'wdt-separator',
                        'section'  => 'site-blog-archive-section',
                        'settings' => array(),
                    )
                )
            );
            /**
             * Option : Enable Excerpt
             */
            $wp_customize->add_setting(
                BULLISH_CUSTOMISER_VAL . '[enable-excerpt-text]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Bullish_Customize_Control_Switch(
                    $wp_customize, BULLISH_CUSTOMISER_VAL . '[enable-excerpt-text]', array(
                        'type'    => 'wdt-switch',
                        'label'   => esc_html__( 'Enable Excerpt Text', 'bullish-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'bullish-plus' ),
                            'off' => esc_attr__( 'No', 'bullish-plus' )
                        )
                    )
                )
            );

            /**
             * Option : Excerpt Text
             */
            $wp_customize->add_setting(
                BULLISH_CUSTOMISER_VAL . '[blog-excerpt-length]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Bullish_Customize_Control(
                    $wp_customize, BULLISH_CUSTOMISER_VAL . '[blog-excerpt-length]', array(
                        'type'        => 'text',
                        'section'     => 'site-blog-archive-section',
                        'label'       => esc_html__( 'Excerpt Length', 'bullish-plus' ),
                        'description' => esc_html__('Put Excerpt Length', 'bullish-plus'),
                        'input_attrs' => array(
                            'value' => 25,
                        ),
                        'dependency'  => array( 'enable-excerpt-text', '==', 'true' ),
                    )
                )
            );

            /**
             * Option : Enable Video Audio
             */
            $wp_customize->add_setting(
                BULLISH_CUSTOMISER_VAL . '[enable-video-audio]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Bullish_Customize_Control_Switch(
                    $wp_customize, BULLISH_CUSTOMISER_VAL . '[enable-video-audio]', array(
                        'type'    => 'wdt-switch',
                        'label'   => esc_html__( 'Display Video & Audio for Posts', 'bullish-plus'),
                        'description' => esc_html__('YES! to display video & audio, instead of feature image for posts', 'bullish-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'bullish-plus' ),
                            'off' => esc_attr__( 'No', 'bullish-plus' )
                        ),
                        'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-list' ),
                    )
                )
            );

            /**
             * Option : Readmore Text
             */
            $wp_customize->add_setting(
                BULLISH_CUSTOMISER_VAL . '[blog-readmore-text]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Bullish_Customize_Control(
                    $wp_customize, BULLISH_CUSTOMISER_VAL . '[blog-readmore-text]', array(
                        'type'        => 'text',
                        'section'     => 'site-blog-archive-section',
                        'label'       => esc_html__( 'Read More Text', 'bullish-plus' ),
                        'description' => esc_html__('Put the read more text here', 'bullish-plus'),
                        'input_attrs' => array(
                            'value' => esc_html__('Read More', 'bullish-plus'),
                        )
                    )
                )
            );

            /**
             * Option : Image Hover Style
             */
            $wp_customize->add_setting(
                BULLISH_CUSTOMISER_VAL . '[blog-image-hover-style]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Bullish_Customize_Control(
                $wp_customize, BULLISH_CUSTOMISER_VAL . '[blog-image-hover-style]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Image Hover Style', 'bullish-plus' ),
                    'choices' => array(
                      'wdt-default'     => esc_html__('Default', 'bullish-plus'),
                      'wdt-fadeinleft'  => esc_html__('Fade InLeft', 'bullish-plus'),
                      'wdt-fadeinright' => esc_html__('Fade InRight', 'bullish-plus'),
                      'wdt-rotate'      => esc_html__('Rotate', 'bullish-plus'),
                      'wdt-rotate-alt'  => esc_html__('Rotate Alt', 'bullish-plus'),
                      'wdt-scalein'     => esc_html__('Scale In', 'bullish-plus'),
                      'wdt-scaleout'    => esc_html__('Scale Out', 'bullish-plus')
                    ),
                    'description' => esc_html__('Choose image hover style to display archives pages.', 'bullish-plus'),
                )
            ));

            /**
             * Option : Image Hover Style
             */
            $wp_customize->add_setting(
                BULLISH_CUSTOMISER_VAL . '[blog-image-overlay-style]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Bullish_Customize_Control(
                $wp_customize, BULLISH_CUSTOMISER_VAL . '[blog-image-overlay-style]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Image Overlay Style', 'bullish-plus' ),
                    'choices' => array(
                      'wdt-default'           => esc_html__('None', 'bullish-plus'),
                      'wdt-fixed'             => esc_html__('Fixed', 'bullish-plus'),
                      'wdt-middle'            => esc_html__('Middle', 'bullish-plus'),
                      'wdt-bt-gradient'       => esc_html__('Gradient - Bottom to Top', 'bullish-plus'),
                      'wdt-flash'             => esc_html__('Flash', 'bullish-plus')
                    ),
                    'description' => esc_html__('Choose image overlay style to display archives pages.', 'bullish-plus'),
                    'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-list' ),
                )
            ));

            /**
             * Option : Pagination
             */
            $wp_customize->add_setting(
                BULLISH_CUSTOMISER_VAL . '[blog-pagination]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Bullish_Customize_Control(
                $wp_customize, BULLISH_CUSTOMISER_VAL . '[blog-pagination]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Pagination Style', 'bullish-plus' ),
                    'choices' => array(
                      'pagination-default'        => esc_html__('Older & Newer', 'bullish-plus'),
                      'pagination-numbered'       => esc_html__('Numbered', 'bullish-plus'),
                      'pagination-loadmore'       => esc_html__('Load More', 'bullish-plus'),
                      'pagination-infinite-scroll'=> esc_html__('Infinite Scroll', 'bullish-plus'),
                    ),
                    'description' => esc_html__('Choose pagination style to display archives pages.', 'bullish-plus')
                )
            ));

        }
    }
}

BullishPlusCustomizerSiteBlog::instance();