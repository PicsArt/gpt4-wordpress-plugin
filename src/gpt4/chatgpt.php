<?php
/*
* Plugin Name: ChatGPT
* Description: A plugin that uses GPT-4 to generate chatbot responses
* Version: 2.0
* Author: Picsart
*/


function chatgpt_enqueue_script() {
    wp_enqueue_script( 'chatgpt-script', plugin_dir_url( __FILE__ ) . 'chatgpt.js', array( 'jquery' ), '20.0', true );
    wp_localize_script( 'chatgpt-script', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
}

add_action( 'wp_enqueue_scripts', 'chatgpt_enqueue_script' );

add_shortcode( 'chatgpt', 'chatgpt_shortcode' );
add_action( 'wp_ajax_chatgpt_request', 'chatgpt_request' );
add_action( 'wp_ajax_nopriv_chatgpt_request', 'chatgpt_request' );


function chatgpt_shortcode( $atts ) {

  global $global_atts;
 
   

    $atts = shortcode_atts( array(
        'prefix' => '',
        'postfix' => ' ',
        'system_role' => 'You are AI assistant.'
    ), $atts );

    ob_start(); 


     // Add hidden input fields for the shortcode attributes
    echo '<input type="hidden" id="chatgpt-prefix" value="' . esc_attr( $atts['prefix'] ) . '">';
    echo '<input type="hidden" id="chatgpt-postfix" value="' . esc_attr( $atts['postfix'] ) . '">';
    echo '<input type="hidden" id="chatgpt-role" value="' . esc_attr( $atts['system_role'] ) . '">';

 

 
    include 'chatgpt.html';
    return ob_get_clean();
}


function chatgpt_request() {

    $prompt_text = sanitize_text_field( $_POST['prompt'] );
    $temperature = sanitize_text_field( $_POST['temperature'] );
    $language = sanitize_text_field( $_POST['language'] );
    $prefix = sanitize_text_field( $_POST['prefix'] );
    $postfix = sanitize_text_field( $_POST['postfix'] );
    $role = sanitize_text_field( $_POST['role'] );

    $prompt_text = $prefix . ' ' . $prompt_text . ' ' . $postfix;

    if ( $language !== 'en' ) {
        $prompt_text .= ' using ' . $language . ' language';
    }

    $postfields = json_encode( [
        'model'      =>  'gpt-4', //'gpt-3.5-turbo',
        'temperature' => (float) $temperature,
        'messages'   => [
            [ 'role' => 'system', 'content' => $role ],
            [ 'role' => 'user', 'content' => $prompt_text ],
        ],
    ] );

    $curl = curl_init();
    curl_setopt_array( $curl, [
        CURLOPT_URL            => 'https://api.openai.com/v1/chat/completions',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING       => '',
        CURLOPT_MAXREDIRS      => 10,
        CURLOPT_TIMEOUT        => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST  => 'POST',
        CURLOPT_POSTFIELDS     => $postfields,
        CURLOPT_HTTPHEADER     => [
            'Content-Type: application/json',
            'Authorization: Bearer API-KEY',
        ],
    ] );

    $response = curl_exec( $curl );
    curl_close( $curl );
    $content = json_decode( $response )->choices[0]->message->content;
    echo trim( $content );

    wp_die();
}

