<?php
function translate_to_static_url($url) {
    $static_url = ''; 
    if(substr($url, -5, 5) == '.html') {
        $static_url = $url;
    } elseif(substr($url, -1, 1) == '/') {
        $static_url = $url . 'index.html';
    } else {
        $static_url = $url . '.html';
    }

    return $static_url;
}

$config = array(
    'database' => 'webhtml',
    'username' => 'webclip',
    'password' => '123456',
    'qiniu_domain' => '',
    'proxy' =>  ' -e "http_proxy=http://127.0.0.1:8087/"   ',
    'timeout' => 5,
    'exclude_domain' => array(
        'www.facebook.com',
        'twitter.com',
        'linkedin.com',
        'apis.google.com',
        'ajax.googleapis.com',
        'www.gravatar.com',
    )
);

$db = new PDO('mysql:host=localhost;dbname=' . $config['database'] , $config['username'], $config['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
