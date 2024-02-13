<?php

define('CACHE_EXPIRED', 60);

function parseUrl($url) {
    if ($url == '') {
        return '';
    }
    if  ($urls = parse_url($url)) {
        if (!isset($urls["scheme"])) {
            $url = "https://{$url}";
        }
    }
    return $url;
}
