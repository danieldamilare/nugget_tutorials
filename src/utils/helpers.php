<?php
function generate_token($length = 32){
    return bin2hex(random_bytes($length));
}

function send_email($to, $subject, $html_content, $text_content = '') {
    $api_key = BREVO_API_KEY;
    $sender_email = BREVO_SENDER_EMAIL;
    $url = "https://api.brevo.com/v3/smtp/email";

    $headers = [
        "Content-Type: application/json",
        "api-key: $api_key"
    ];

    $body = [
        "sender" => ["email" => $sender_email, "name" => "Nugget Tutorials"],
        "to" => [["email" => $to]],
        "subject" => $subject,
        "htmlContent" => $html_content,
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        error_log("Curl Error: " . curl_error($ch));
    }

    curl_close($ch);

    if ($http_code !== 201) {
        error_log("Brevo API Error ($http_code): " . $response);
        return false;
    }

    return true;
}

?>

