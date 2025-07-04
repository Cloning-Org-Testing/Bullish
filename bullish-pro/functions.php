<?php

if( !function_exists('bullish_pro_get_template_plugin_part') ) {
    function bullish_pro_get_template_plugin_part( $file_path, $module, $template, $slug ) {

        $html             = '';
        $template_path    = BULLISH_PRO_DIR_PATH . 'modules/' . esc_attr($module);
        $temp_path        = $template_path . '/' . esc_attr($template);
        $plugin_file_path = '';

        if ( ! empty( $temp_path ) ) {
            if ( ! empty( $slug ) ) {
                $plugin_file_path = "{$temp_path}-{$slug}.php";
                if ( ! file_exists( $plugin_file_path ) ) {
                    $plugin_file_path = $temp_path . '.php';
                }
            } else {
                $plugin_file_path = $temp_path . '.php';
            }
        }

        if ( $plugin_file_path && file_exists( $plugin_file_path ) ) {
            return $plugin_file_path;
        }

        return $file_path;

    }
    add_filter( 'bullish_get_template_plugin_part', 'bullish_pro_get_template_plugin_part', 20, 4 );
}

if( !function_exists('bullish_pro_before_after_widget') ) {
    function bullish_pro_before_after_widget ( $content ) {
        $allowed_html = array(
            'aside' => array(
                'id'    => array(),
                'class' => array()
            ),
            'div' => array(
                'id'    => array(),
                'class' => array(),
            )
        );

        $data = wp_kses( $content, $allowed_html );

        return $data;
    }
}

if( !function_exists('bullish_pro_widget_title') ) {
    function bullish_pro_widget_title( $content ) {

        $allowed_html = array(
            'div' => array(
                'id'    => array(),
                'class' => array()
            ),
            'h2' => array(
                'class' => array()
            ),
            'h3' => array(
                'class' => array()
            ),
            'h4' => array(
                'class' => array()
            ),
            'h5' => array(
                'class' => array()
            ),
            'h6' => array(
                'class' => array()
            ),
            'span' => array(
                'id'    => array(),
                'class' => array()
            ),
            'p' => array(
                'id'    => array(),
                'class' => array()
            ),
        );

        $data = wp_kses( $content, $allowed_html );

        return $data;
    }
}

/** Function for Enabling Header and Footer Options in Elementor -> Settings */
if( !function_exists('bullish_custom_post_type_elementor_support') ) {
    function bullish_custom_post_type_elementor_support() {
      
        $custom_post_types = array('wdt_headers', 'wdt_footers');
     
        $elementor_supported_post_types = get_option('elementor_cpt_support', array('page', 'post'));
        
        $supported_post_types = array_merge($elementor_supported_post_types, $custom_post_types);
        $supported_post_types = array_unique($supported_post_types);
        
        update_option('elementor_cpt_support', $supported_post_types);
    }
}
add_action('init', 'bullish_custom_post_type_elementor_support');

# Filter HTML Output
if(!function_exists('bullish_html_output')) {
	function bullish_html_output( $html ) {
		return apply_filters( 'bullish_html_output', $html );
	}
}


/**
 * Returns string for time duration.
 */
if ( ! function_exists( 'bullish_pro_duration_to_string' ) ) {
	
    function bullish_pro_duration_to_string( $duration ) {
        
        if ( !is_numeric( $duration ) || $duration < 0 ) {
            return ''; 
        }

        $hours   = (int)( $duration / 3600 );
        $minutes = (int)( ( $duration % 3600 ) / 60 );
        $result  = '';

        if ( $hours > 0 ) {
            $result = ( $hours == 1 ) ? sprintf( esc_html__( '%d hr', 'bullish-pro' ), $hours ) : sprintf( esc_html__( '%d hrs', 'bullish-pro' ), $hours );
            if ( $minutes > 0 ) {
                $result .= ' ';
            }
        }

        if ( $minutes > 0 ) {
            $result .= sprintf( esc_html__( '%d mins', 'bullish-pro' ), $minutes );
        }

        return $result;
    }
}

if (!function_exists('render_service_icon')) {
    function render_service_icon($icon) {
        
        $output = '';

        if (!empty($icon)) {
            if (strpos($icon, '.svg') !== false) {
                $svg_path = ABSPATH . str_replace(site_url('/'), '', $icon);
                if (file_exists($svg_path)) {
                    $svg_content = file_get_contents($svg_path);
                    if ($svg_content !== false) {
                        $output .= '<div class="wdt-service-type-icon svg-icon">' . $svg_content . '</div>';
                    }
                }
            } else {
                $output .= '<div class="wdt-service-type-icon"><img src="' . esc_url($icon) . '" alt="Service Icon" title="Service Icon"/></div>';
            }
        }

        return $output;
    }
}

function wdt_comment_form_button_arrow($defaults) {
    $defaults['submit_field'] = 
        '<p class="form-submit">%1$s<i class="comment-btn-arrow"></i>%2$s</p>';
    return $defaults;
}

add_filter('comment_form_defaults', 'wdt_comment_form_button_arrow');