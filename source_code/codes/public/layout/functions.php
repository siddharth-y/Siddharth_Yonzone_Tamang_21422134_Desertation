<?php
// Function to shorten text and add "..." if it exceeds a specified length
function shortenText($text, $maxLength)
{
    if (strlen($text) > $maxLength) {
        return substr($text, 0, $maxLength) . "...";
    } else {
        return $text;
    }
}
