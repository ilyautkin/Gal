<?php
$properties  = implode("-", $scriptProperties);
$cache_key = "gal".$properties;
$output = $modx->cacheManager->get($cache_key);

if ($output) return $output;

!$w ? $w = 170 : $w=$w;
!$h ? $h = 90 : $h=$h;
if (!$href) {
    $each_href = '';
    $onclick = "return hs.expand(this, { slideshowGroup: 1 } )";
} else {
    $each_href = $href;
    $onclick = "return hs.htmlExpand(this, { outlineType: 'rounded-white', wrapperClassName: 'draggable-header', objectType: 'ajax', align: 'center', width: '600', headingText: '".$alt."', dimmingOpacity: 0.8 } )";
}

$class = 'class="highslide"';
if ($linkType == 'normal') {
    $onclick = $class = '';
}

$files = scandir($galdir, 0);

// если директории не существует
if (!$files) return false;

// удаляем . и .. (я думаю редко кто использует)
if ($sort == 0) unset($files[0],$files[1]);
else unset($files[count($files)-1], $files[count($files)-1]);

switch ($type) {
    case "li": $style = ""; $before = "<li>"; $after = "</li>"; break;
    default: $style = ' style="margin-bottom: 7px;"';break;
}

if ($r) $radius = "&f=png&fltr[]=ric|$r|$r";

foreach ($files as $file) {
  if (!$each_href) {$href = $modx->runSnippet('phpthumbof', array("input" => "/$galdir/$file", "options" => "w=1100&h=1100"));} else {$href = $each_href;}
  $output .= $before.'<a id="thumb1" href="'.$href.'" '.$class.' onclick="'.$onclick.'" title="'.$alt.'">
  <img src="'.$modx->runSnippet('phpthumbof', array("input" => "/$galdir/$file", "options" => "w=$w&h=$h&zc=1".$radius)).'" alt="'.$alt.'" title="Нажмите для увеличения"'.$style.'>
  </a>'.$after."\n";
}
$modx->cacheManager->set($cache_key,$output);
return $output;
