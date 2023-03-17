<?php
/*
Plugin Name: GPT3 Plugin
Description: A plugin that uses the GPT-3 API to generate text
Version: 1.1
*/

require_once 'openai.php';
// Function to display the form on the front-end

function gpt3_form() {
    ?>
    <div class="gpt3-api-plugin-container">
        <div class="prompt-container" style="margin-bottom: 1em;">
            <textarea id="prompt-text" placeholder="Enter your prompt here" style="width: 100%;"></textarea>
        </div>
        <div class="options-container" style="display: flex; align-items: center;">
            <div class="model-container" style="margin-right: 1em;">
                <label for="model-select">Model:</label>
                <select id="model-select">
                    <option value="text-davinci-003">Davinci</option>
                    <option value="text-curie-001">Curie</option>
                    <option value="text-babbage-001">Babbage</option>
                    <option value="text-ada-001">Ada</option>
                </select>
            </div>
            <div class="submit-container">
                <input type="button" value="Submit" id="gpt3-submit-btn">
            </div>
        </div>
        <div class="response-container" style="margin-top: 1em;">
            <textarea id="response" readonly style="width: 100%; height: 12em;"></textarea>
        </div>
    </div>
    <?php
}

function gpt3_request(){
// Check the nonce for security
    check_ajax_referer( 'gpt3_ajax_nonce', '_ajax_nonce' );
// Sanitize user input
    $prompt = sanitize_text_field($_POST['prompt']);
    $model = sanitize_text_field($_POST['model']);
    $max_tokens = intval($_POST['max_tokens']);
    $openai = new Openai();
    // Send request to GPT-3 API
    $response = $openai->request($model, $prompt, $max_tokens);
    $response_obj = json_decode($response);
    // Get response text from json
    $resp=$response_obj->choices[0]->text;
    echo $resp;
    wp_die();
}

// Enqueue script that handles the form submission

add_action( 'wp_enqueue_scripts', 'gpt3_enqueue_script' );
function gpt3_enqueue_script() {
    wp_enqueue_script( 'gpt3-ajax-script', plugin_dir_url( __FILE__ ) . 'gpt3-ajax.js', array('jquery'), '1.0.0', true );
    // Localize ajax url and nonce for security
    wp_localize_script( 'gpt3-ajax-script', 'gpt3_ajax_obj', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'gpt3_ajax_nonce' )
) );
}

// Register gpt3_request action for logged in users
add_action( 'wp_ajax_gpt3_request', 'gpt3_request' );
// Register gpt3_request action for non-logged in users
add_action( 'wp_ajax_nopriv_gpt3_request', 'gpt3_request' );
// Register the gpt3_form shortcode
add_shortcode( 'gpt3_form', 'gpt3_form' );
