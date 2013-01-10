<?php
error_reporting(-1);
set_time_limit(0);
include 'common.php';
include 'simple_html_dom.php';

$origin_url = trim($_POST['url']);


$agent = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:11.0) Gecko/20100101 Firefox/11.0';


if(isset($_POST['proxy']) && $_POST['proxy'] == 1) {
    $proxy = $config['proxy'];
} else {
    $proxy = '';
}

$cmd = sprintf('wget %s --exclude-domains %s -t 2 --timeout=%d --user-agent="%s" -E -H -k -K -p -P %s %s',
    $proxy, implode(',', $config['exclude_domain']), $config['timeout'], $agent, dirname(__FILE__), $origin_url 
);

system($cmd);

$static_url = translate_to_static_url(substr($origin_url, 7));

function html_is_gb2312($static_url) {
    $html = file_get_html($static_url);

    // check <meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
    $el = $html->find('meta[http-equiv=Content-Type]', 0);
    if($el) {
        preg_match('/charset=(.+)/', $el->content, $matches);
        if(isset($matches[1]) && $matches[1] == 'gb2312') {
            return true;
        }
    }

    // check <meta charset="gb2312"/> 
    $el = $html->find('head', 0)->find('meta');
    if($el) {
        foreach($el as $e) {
            if($e->charset == 'gb2312')
                return true;
        }
    }

    return false;
}

$content = file_get_contents($static_url);

if(html_is_gb2312($static_url)) {
    $content = mb_convert_encoding($content, 'UTF-8','CP936'); 
}

preg_match('!<title>(.*)</title>!s', $content, $matches);

if($matches[1]) {
    $title = $matches[1];
} else {
    $title = 'no title';
}

$stm = $db->prepare('insert urls set url = :url , title = :title ');
$stm->bindValue(':url', $static_url, PDO::PARAM_STR);
$stm->bindValue(':title', $title, PDO::PARAM_STR);
$stm->execute();

header('Location: index.php');

?>
