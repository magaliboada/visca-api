<?php

$url = 'https://sportsinteraction.com/specials/us-elections-betting/';
$json = file_get_contents($url);
$json = get_string_between($json, '<div data-component="Games" data-props="', '"></div>');
$json = str_replace('&quot;', "\"", $json);
$json = '['.$json.']';
$json =  json_decode($json, true);

$temp_bet = $json[0]['games'];
$game_names = [];

foreach ($temp_bet as $key => $value) {
    
    $bet_options = $value['betTypeGroups'][0]['betTypes'][0]['events'][0]['runners'];
    $game_item = [];
    $game_item['BetName'] = $value['gameName'];
    
    foreach ($bet_options as $key => $bet_option) {

        $options = [];
        $options['outcome'] =  $bet_option['runner'];
        $options['odds'] =   number_format($bet_option['currentPrice']+1, 2, '.', '');
        $game_item['betOptions'][] = $options;

    }

    $game_names[] = $game_item;
}

$json =  json_encode($game_names);
echo var_export($json, true);



function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}