jQuery(document).ready(function($) {

    $("#chatgpt-submit-button").on("click", function(event) {
        event.preventDefault();
        var prompt = $("#chatgpt-prompt-text").val();
        var temperature = $("#chatgpt-temperature-range").val();
        var language = $("#chatgpt-language-select").val();
        var prefix = $("#chatgpt-prefix").val();
        var postfix = $("#chatgpt-postfix").val();
        var role = $("#chatgpt-role").val();

        var data = {
            'action': 'chatgpt_request',
            'prompt': prompt,
            'temperature': temperature,
            'language': language,
            'prefix': prefix,
            'postfix': postfix,
            'role': role
        };

        $.post(ajaxurl, data, function(response) {
            $("#chatgpt-response").val(response);
        });
    });

    $("#chatgpt-copy-button").on("click", function() {
        var copyText = document.getElementById("chatgpt-response");
        copyText.select();
        document.execCommand("copy");
        alert("Keywords Copied!");
    });
});
