<?php

function detectAnagrams($word, $array)
{
    $result = [];

    $wordLow = strtolower($word);
    $wordLowAr = str_split($wordLow);
    sort($wordLowAr);
    
    foreach ($array as $detect) {
        $detectLow = strtolower($detect);
        $detectLowAr = str_split($detectLow);
        sort($detectLowAr);
        
        if ($detectLowAr == $wordLowAr && $wordLow != $detectLow) {
            $result[] = $detect;
        }
    }

    return $result;
}