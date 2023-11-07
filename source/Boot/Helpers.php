<?php
function is_email(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function is_passwd(string $pass): bool
{

    if(password_get_info($pass)['algo']){
        return true;
    }

    if(mb_strlen($pass) >= CONF_PASSWD_MIN_LEN && mb_strlen($pass) <= CONF_PASSWD_MAX_LEN)
    {
        return true;
    }
    return false;
}

function formata_celular($number){
    $number="(".substr($number,0,2).")".substr($number,2,-4)."-".substr($number,-4);
    return $number;
}

function date_fmt_back(?string $date): ?string
{
    if (!$date) {
        return null;
    }

    if (strpos($date, " ")) {
        $date = explode(" ", $date);
        return implode("-", array_reverse(explode("/", $date[0]))) . " " . $date[1];
    }

    return implode("-", array_reverse(explode("/", $date)));
}

function redirect(string $url): void
{
    header("HTTP/1.1 302 Redirect");
        $location = CONF_URL_BASE.$url;
        header("Location: {$location}");
        exit;
}