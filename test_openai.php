<?php
$apiKey = "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"; // Replace with your actual API Key

$data = [
    "model" => "gpt-3.5-turbo",
    "messages" => [["role" => "user", "content" => "Hello, how are you?"]]
];

$options = [
    "http" => [
        "header" => "Content-Type: application/json\r\nAuthorization: Bearer " . $apiKey,
        "method" => "POST",
        "content" => json_encode($data),
        "ignore_errors" => true
    ]
];

$context = stream_context_create($options);
$response = file_get_contents("https://api.openai.com/v1/chat/completions", false, $context);
echo $response;
?>
