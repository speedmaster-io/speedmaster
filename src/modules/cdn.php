<?php
if ($smconfig->get('cdn', 'enabled')) {
	add_filter('speedmaster_buffer', 'speedmaster_cdn', 100);
}

function speedmaster_cdn($buffer) {
  $dom = new DOMDocument;

  //Parse the HTML. The @ is used to suppress any parsing errors
  //that will be thrown if the $html string isn't valid XHTML.
  @$dom->loadHTML($buffer);

  $matches = [];
  $matches = array_merge($matches, speedmaster_array_matches($dom->getElementsByTagName('img'), 'src'));
  $matches = array_merge($matches, speedmaster_array_matches($dom->getElementsByTagName('link'), 'href'));
  $matches = array_merge($matches, speedmaster_array_matches($dom->getElementsByTagName('script'), 'src'));

  // Perform array and replace items.
  foreach ($matches as $match) {
    $buffer = str_replace('"'.$match['find'].'"', '"'.$match['replace'].'"', $buffer);
    $buffer = str_replace("'".$match['find']."'", "'".$match['replace']."'", $buffer);
  }

  return $buffer;
}

function speedmaster_replace_host($url) {
	global $smconfig;

  $hosts = $smconfig->get('cdn', 'hosts', []);
  $cdn_url = $smconfig->get('cdn', 'url', '');

  if ($url[0] == '/' && $url[1] != '/') {
    $url = "//" . $cdn_url . $url;
    return $url;
  }

  foreach($hosts as $host) {
    $url = str_replace($host, $cdn_url, $url);
  }

  return $url;
}

function speedmaster_array_matches($links, $attr = 'src') {
	global $smconfig;

  $include = $smconfig->get('cdn', 'include', []);
  $exclude = $smconfig->get('cdn', 'exclude', []);
  $hosts = $smconfig->get('cdn', 'hosts', []);

  $matches = [];

  foreach ($links as $link){
    $url = $link->getAttribute($attr);

    if (!speedmaster_array_match($include, $url)) {
      continue;
    }

    if (speedmaster_array_match($exclude, $url)) {
      continue;
    }

    if (!$url)
    	continue;

    if ($url[0] != '/' && !speedmaster_array_match($hosts, $url)) {
      continue;
    }

    $matches[] = [
      'find' => $url,
      'replace' => speedmaster_replace_host($url)
    ];
  }

  return $matches;
}
