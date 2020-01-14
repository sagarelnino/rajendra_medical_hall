<?php
	require '../connection.php';
	require 'curl.php';
    $mainUrl = 'https://medex.com.bd/brands';
    //total number of pages 844
    for($i=821;$i<=844;$i++){
        $curl = new Curl();
        $dom = new \DOMDocument('1.0');
        $pageUrl = $mainUrl.'?page='.$i;
        $response = $curl->getData($pageUrl);
        @$dom->loadHTML($response);
        $links = $dom->getElementsByTagName('a');
        /*die('died'.'<pre>'.print_r($links,true));*/
        /**
         * @var $link DOMElement
         */
        foreach ($links as $link){
            if($link->getAttribute('class') == 'hoverable-block'){
                $productUrl = $link->getAttribute('href');
                if(!($product->isExistProductByUrl($productUrl))){
                    $product->addProductUrl($productUrl);
                }
            }
        }
        echo "Page ".$i." done";
    }
    echo "<br>";
    die('died after '.$i);
?>