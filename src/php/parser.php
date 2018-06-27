<?php

require_once 'phpQuery 2/phpQuery/phpQuery.php';


class Parser{

    private $url;
    private $ch;

    public function __construct($print = false){
        $this->ch = curl_init();
        if(!$print){
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_HEADER, 1);
        }
    }

    public function set($name, $value){
       curl_setopt($this->ch, $name, $value);
       return $this;
    }

    public function exec($url){
       $this->url = $url;
       curl_setopt($this->ch, CURLOPT_URL, $url);
       return curl_exec($this->ch);
    }

    public function __destruct(){
       curl_close($this->ch);
    }

}

class Page_document {

    public $url;
    public $doc;
    private $parser;
    private $data;

    public function __construct($url_new){

        $this->url=$url_new;
        $this->parser = new Parser();
        $this->parser->set(CURLOPT_HEADER,1)->set(CURLOPT_POST, true)->set(CURLOPT_COOKIEJAR, __DIR__ . '/cookies/cookie_'.$url_new.'.txt')->set(CURLOPT_COOKIEFILE, __DIR__ . '/cookies/cookie_'.$url_new.'.txt');
        $data = $this->parser->exec($url_new);
        $this->doc= phpQuery::newDocument($data);
        $this->parser=null;
        $this->data=null;
    }
    public function __destruct(){
        $this->url=null;
        $this->doc=null;
    }

}

class Selector {
    public $selector_id;
    public $options_list = array();
}

function all_pages ($page_doc) {

  global $href;
  global $url_root;
  global $full_link_list;


  $links = $page_doc->doc->find('a');
  $count_link = 1;
  foreach ($links as $link) {

  $pqLink = pq($link); //pq делает объект phpQuery

  $attr_href = mb_strtolower($pqLink->attr('href'));
  $attr_rel = mb_strtolower($pqLink->attr('rel'));
  $limit_links=0;

   if (( substr_count($attr_href, $url_root) == 1) && (substr_count($attr_href,"/")<4)  && (array_key_exists($attr_href,$href) == null) && (array_key_exists($attr_href,$full_link_list) == FALSE) && $count_link<=$limit_links) {

    $href[$attr_href] = new Page_document($attr_href);

       echo "<lo>" . $attr_href . "  [" . count($href) . "] / on the ".$page_doc->url." </lo>\r\n";
       $count_link++;

   } elseif (( substr_count($attr_rel, $url_root) == 1) && (substr_count($attr_rel,"/")<4)  && (array_key_exists($attr_rel,$href) == null) && (array_key_exists($attr_rel,$full_link_list) == FALSE) && $count_link<=$limit_links) {

       $href[$attr_rel] = new Page_document($attr_rel);

       echo "<lo>" . $attr_rel . "  [" . count($href) . "] / on the ".$page_doc->url." </lo>\r\n";
       $count_link++;
   }

  }
  return ;
}

?>


<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="utf8">
    <title>парсер</title>
    <script type="text/javascript" src="./http_code.jquery.com_jquery-2.0.0.js"></script>
    <script type="text/javascript" src="./http_ajax.googleapis.com_ajax_libs_jqueryui_1.10.2_jquery-ui.js">
        $.widget.bridge('uitooltip', $.ui.tooltip);
        $.widget.bridge('uibutton', $.ui.button);
    </script>
</head>

<body>
<div>
<ul>
<?php

ini_set('max_execution_time', 60000);

$url_root = "sitemap.xml";

$xml = simplexml_load_file($url_root);

foreach ($xml as $url){
    $link = $url->loc;
    $llink = json_decode(json_encode($link), true)[0];
    $href[$llink]= new Page_document($llink);
    echo "<lo>" . $llink . "  from sitemap </lo>\r\n";
}



$counter=0;

$full_link_list=[];
$selector_list=[];

while (count($href)>0) {
    foreach ($href as $link) {
        if ($link != null) {

            all_pages($link);

                if (in_array($link, $full_link_list) == FALSE) {

                    $full_link_list[$link->url] =  $link;
                    $counter++;
                    $text=$link->url;
                    $text = "$counter.'     '.$text.";
                    echo "<lo>" . $text . "  [" . count($href) . "] / [" . count($full_link_list) . "] </lo>\r\n";
                    $index = array_search($link,$href);
                    unset($href[$index]);

                } else $index = array_search($link,$href); unset($href[$index]);
        }
    }
}

foreach ($full_link_list as $link) {

    if ($link->doc->find('#product-addtocart-button')==null) {$index = array_search($link,$full_link_list); unset($full_link_list[$index]);}
    else {
        $selectors = $link->doc->find('select');

        foreach ($selectors as $selector) {

            $pqselector = pq($selector);

            $new_selector = new Selector();
            $new_selector->selector_id = $pqselector->attr('id');

            pq($selector)->click();

            $find="select#".$new_selector->selector_id."> option";
            $options = $link->doc->find($find);



            array_push($selector_list,$new_selector);
        }
    }
}



?>
</ul>
</div>
</body>
</html>
