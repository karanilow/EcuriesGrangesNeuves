<?php

function post_captcha($user_response) {
    $fields_string = '';
    $fields = array(
        'secret' => '6LdoD44UAAAAALA4dTBz8n8A5fGFgH3cLj2Qdsrx',
        'response' => $user_response
    );
    foreach ($fields as $key => $value) {
        $fields_string .= $key . '=' . $value . '&';
    }
    $fields_string = rtrim($fields_string, '&');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
    curl_setopt($ch, CURLOPT_POST, count($fields));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

    $result = curl_exec($ch);
    curl_close($ch);

    return json_decode($result, true);
}

function sendMail() {
    /*
     *  Configuration
     */
    $recipient = 'ecuries.gn@gmail.com';
    /*
     *  Saisie des informations
     */
    $realname = $_POST['nom'];
    $mail = $_POST['email'];
    $subject = $_POST['sujet'];
    $body_txt = $_POST['body'];
    $body_html = "<html><head></head><body>" . $_POST['body'] . "</body></html>";

// Filtre pour les sauts de lignes
    if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) { // On filtre les serveurs qui rencontrent des bogues.
        $passage_ligne = "\r\n";
    } else {
        $passage_ligne = "\n";
    }

    /*
     * Verification des informations
     */
#//======= Declaration des variables
    $valid = true;
#//======= Make sure the name is not empty
    if (empty($realname)) {
        $valid = false;
        echo("Veuillez saisir un nom. Merci");
    }
#//======= Allow only reasonable email addresses
    if (!preg_match("/^[\w\+\-.~]+\@[\-\w\.\!]+$/", $mail)) {
        $valid = false;
        echo("Verifier votre adresse mail. Merci");
    }


    if ($valid) {
        /*
         * Definition du Header 
         */
// Creation du boundary
        $boundary = "-----=" . md5(rand());

        $header = "From: \"ecuries-gn.fr\"<webmaster@ecuries-gn.fr>" . $passage_ligne;
        $header .= "Reply-to: \"$realname\" <$mail>" . $passage_ligne;
        $header .= "MIME-Version: 1.0" . $passage_ligne;
        $header .= "X-Priority: 3" . $passage_ligne;
        $header .= "X-Mailer: PHP/" . phpversion() . $passage_ligne;
        $header .= "Content-Type: multipart/alternative;" . $passage_ligne . " boundary=\"$boundary\"" . $passage_ligne;

//=====Cr?ation du message.
        $message = $passage_ligne . "--" . $boundary . $passage_ligne;
//=====Ajout du message au format texte.
        $message .= "Content-Type: text/plain; charset=\"ISO-8859-1\"" . $passage_ligne;
        $message .= "Content-Transfer-Encoding: 8bit" . $passage_ligne;
        $message .= $passage_ligne . $body_txt . $passage_ligne;
//==========
        $message .= $passage_ligne . "--" . $boundary . $passage_ligne;
//=====Ajout du message au format HTML
        $message .= "Content-Type: text/html; charset=\"ISO-8859-1\"" . $passage_ligne;
        $message .= "Content-Transfer-Encoding: 8bit" . $passage_ligne;
        $message .= $passage_ligne . $body_html . $passage_ligne;
//==========
        $message .= $passage_ligne . "--" . $boundary . "--" . $passage_ligne;
        $message .= $passage_ligne . "--" . $boundary . "--" . $passage_ligne;
//==========

        /*
         * Envoi du message
         */
        mail($recipient, $subject, $message, $header);
        echo("Message envoye avec succes.");
    }
}

// Call the function post_captcha
$res = post_captcha($_POST['g-recaptcha-response']);

if (!$res['success']) {
    // What happens when the CAPTCHA wasn't checked
    echo '<p>Veuillez cocher la boite "Je ne suis pas un robot"</p><br>';
} else {
    // If CAPTCHA is successfully completed...
    sendMail();
}
?>