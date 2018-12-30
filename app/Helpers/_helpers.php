<?php
function removeSpecialChar($string, $urlGenerator = false)
{
    $notAllowed = ['  ', ' ', '!', '@', '#', '$', '%', '&', '*', '(', ')', '+', ';', ':', "'", '"', '/', '\\', '?', '|', '؟', '،', ',', '-', '--'];
    $string = stripslashes($string);
    $string = trim($string);
    $s = '';
    if ($urlGenerator) {
        $s = '-';
    }
    $string = str_replace($notAllowed, $s, $string);
    return $string;
}
