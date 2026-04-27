<?php

// 🔤 CESAR
function cesar($text, $shift, $decrypt=false) {
    $result = "";
    if ($decrypt) $shift = -$shift;

    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];

        if (ctype_alpha($char)) {
            $base = ctype_upper($char) ? 65 : 97;
            $result .= chr((ord($char) - $base + $shift + 26) % 26 + $base);
        } else {
            $result .= $char;
        }
    }
    return $result;
}

// 🔐 VIGENERE
function vigenere($text, $key, $decrypt=false) {
    $result = "";
    $key = strtoupper($key);
    $j = 0;

    for ($i = 0; $i < strlen($text); $i++) {
        $char = strtoupper($text[$i]);

        if (ctype_alpha($char)) {
            $shift = ord($key[$j % strlen($key)]) - 65;
            if ($decrypt) $shift = -$shift;

            $result .= chr((ord($char) - 65 + $shift + 26) % 26 + 65);
            $j++;
        } else {
            $result .= $char;
        }
    }
    return $result;
}

// 🧠 AUTOKEY
function autokey($text, $key, $decrypt=false) {
    $key = strtoupper($key);
    $text = strtoupper($text);
    $result = "";

    if (!$decrypt) {
        $fullKey = $key . $text;
        for ($i = 0; $i < strlen($text); $i++) {
            $shift = ord($fullKey[$i]) - 65;
            $result .= chr((ord($text[$i]) - 65 + $shift) % 26 + 65);
        }
    } else {
        $fullKey = $key;
        for ($i = 0; $i < strlen($text); $i++) {
            $shift = ord($fullKey[$i]) - 65;
            $char = chr((ord($text[$i]) - 65 - $shift + 26) % 26 + 65);
            $result .= $char;
            $fullKey .= $char;
        }
    }

    return $result;
}

// 🔐 PLAYFAIR

function generateMatrix($key) {
    $key = strtoupper($key);
    $key = str_replace("J", "I", $key);

    $alphabet = "ABCDEFGHIKLMNOPQRSTUVWXYZ";
    $used = [];

    for ($i = 0; $i < strlen($key); $i++) {
        $char = $key[$i];
        if (!in_array($char, $used) && ctype_alpha($char)) {
            $used[] = $char;
        }
    }

    for ($i = 0; $i < strlen($alphabet); $i++) {
        if (!in_array($alphabet[$i], $used)) {
            $used[] = $alphabet[$i];
        }
    }

    return array_chunk($used, 5);
}

function findPos($matrix, $char) {
    for ($i = 0; $i < 5; $i++) {
        for ($j = 0; $j < 5; $j++) {
            if ($matrix[$i][$j] == $char) {
                return [$i, $j];
            }
        }
    }
}

function prepareText($text) {
    $text = strtoupper($text);
    $text = str_replace("J", "I", $text);
    $text = preg_replace("/[^A-Z]/", "", $text);

    $result = "";

    for ($i = 0; $i < strlen($text); $i++) {
        $a = $text[$i];
        $b = ($i + 1 < strlen($text)) ? $text[$i + 1] : "X";

        if ($a == $b) {
            $result .= $a . "X";
        } else {
            $result .= $a . $b;
            $i++;
        }
    }

    if (strlen($result) % 2 != 0) {
        $result .= "X";
    }

    return $result;
}

function playfairEncrypt($text, $key) {
    $matrix = generateMatrix($key);
    $text = prepareText($text);
    $result = "";

    for ($i = 0; $i < strlen($text); $i += 2) {
        list($r1,$c1) = findPos($matrix, $text[$i]);
        list($r2,$c2) = findPos($matrix, $text[$i+1]);

        if ($r1 == $r2) {
            $result .= $matrix[$r1][($c1+1)%5];
            $result .= $matrix[$r2][($c2+1)%5];
        } elseif ($c1 == $c2) {
            $result .= $matrix[($r1+1)%5][$c1];
            $result .= $matrix[($r2+1)%5][$c2];
        } else {
            $result .= $matrix[$r1][$c2];
            $result .= $matrix[$r2][$c1];
        }
    }

    return $result;
}

function playfairDecrypt($text, $key) {
    $matrix = generateMatrix($key);
    $text = strtoupper($text);
    $result = "";

    for ($i = 0; $i < strlen($text); $i += 2) {
        list($r1,$c1) = findPos($matrix, $text[$i]);
        list($r2,$c2) = findPos($matrix, $text[$i+1]);

        if ($r1 == $r2) {
            $result .= $matrix[$r1][($c1+4)%5];
            $result .= $matrix[$r2][($c2+4)%5];
        } elseif ($c1 == $c2) {
            $result .= $matrix[($r1+4)%5][$c1];
            $result .= $matrix[($r2+4)%5][$c2];
        } else {
            $result .= $matrix[$r1][$c2];
            $result .= $matrix[$r2][$c1];
        }
    }

    return $result;
}

// 🚀 TRAITEMENT GLOBAL
if (isset($_POST['action'])) {

    $message = $_POST['message'];
    $key = $_POST['key'];
    $algo = $_POST['algo'];
    $action = $_POST['action'];

    switch ($algo) {
        case "cesar":
            $result = cesar($message, intval($key), $action=="decrypt");
            break;

        case "vigenere":
            $result = vigenere($message, $key, $action=="decrypt");
            break;

        case "autokey":
            $result = autokey($message, $key, $action=="decrypt");
            break;

        case "playfair":
            $result = ($action=="encrypt")
                ? playfairEncrypt($message, $key)
                : playfairDecrypt($message, $key);
            break;
    }
}
?>