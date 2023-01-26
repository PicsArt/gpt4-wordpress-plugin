// Document ready function
jQuery(document).ready(function($){
    // Handle click event on submit button
    $('#gpt3-submit-btn').on('click', function(){
        // Get input values from form
        var promptText = $('#prompt-text').val();
        var model = $('#model-select').val();
        var max_tokens = 1000;
        // Create data object for request
        var data = {
            action: 'gpt3_request',
            prompt: promptText, // retrieve the user prompt
            model: model, // retrieve the selected model
            max_tokens: max_tokens, // retrieve the max number of tokens
            _ajax_nonce: gpt3_ajax_obj.nonce 
        };
        // Send AJAX request to Wordpress backend
        $.post(gpt3_ajax_obj.ajax_url, data, function(response) {
            // Set response text to response text area
            $('#response').val(response);
        });
    });
});
