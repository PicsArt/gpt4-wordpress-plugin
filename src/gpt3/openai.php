<?php

/*

This helper class encapsulates the functionality of interacting with the OpenAI API and handles making a POST request to the API using CURL. The request function takes three parameters, engine, prompt, and max_tokens, which are passed from the gpt3_request function in the main plugin file. 
It also has the secret_key function that returns the secret key that is used to authenticate the API request.
It's important to validate and sanitize user input on both server and client side, and use a secure method to store your API key.

*/

class Openai{
// function to retrieve secret key
    private function secret_key(){
        return $secret_key = 'Bearer Your-API-Key';
    }

// request function that handle the requests to GPT-3 API
 public function request($engine, $prompt, $max_tokens){ 

        $request_body = [
        "prompt" => $prompt,   // user prompt
        "max_tokens" => $max_tokens,  // max number of tokens
        "temperature" => 0.7,
        "top_p" => 1,
        "presence_penalty" => 0.75,
        "frequency_penalty"=> 0.75,
        "best_of"=> 1,
        "stream" => false,
        ];

        $postfields = json_encode($request_body);
        $curl = curl_init();
        curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.openai.com/v1/engines/" . $engine . "/completions",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $postfields,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: ' . $this->secret_key()
        ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            Return "Error #:" . $err;  //return the error if there is one
        } else {
            return $response;  // return the response 
        }

    }

}
