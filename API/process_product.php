<?php
    require '../connection.php';
    require 'curl.php';
    $productAll = $product->getSpeialProducts();
    //total number of pages 844
    /**
     * @var $singleProduct Product
     */
    foreach ($productAll as $singleProduct){
        $curl = new Curl();
        $dom = new \DOMDocument('1.0');
        $response = $curl->getData($singleProduct['url']);
        #$response = $curl->getData('https://medex.com.bd/brands/20928/abdopen');
        @$dom->loadHTML($response);
        $smalls = $dom->getElementsByTagName('small');
        foreach ($smalls as $small){
            $dosageForm = filter($small->nodeValue);
        }
        $h1s = $dom->getElementsByTagName('h1');
        foreach ($h1s as $h1){
            $brandName = $h1->nodeValue;
            $brandName = filter(str_replace($dosageForm,'',$brandName));
        }
        $divs = $dom->getElementsByTagName('div');
        /**
         * @var $div DOMElement
         * @var $span DOMElement
         */
        foreach ($divs as $div){
            if($div->getAttribute('class') == 'col-xs-12 brand-header'){
                $anchor = $div->getElementsByTagName('a');
                $genericName = filter($anchor[0]->nodeValue);
                $innerDivs = $div->getElementsByTagName('div');
                $packSize = filter($innerDivs[1]->nodeValue);
                $manufacturer = filter($innerDivs[2]->nodeValue);
            }
            if($div->getAttribute('class') == 'col-xs-12 packages-wrapper'){
                $spans = $div->getElementsByTagName('span');
                foreach ($spans as $span){
                    if($span->getAttribute('class') == 'package-pricing'){
                        $salePrice = filter($span->nodeValue);
                        $salePrice = filter(str_replace('৳','',$salePrice));
                    }
                }
            }
        }
        /*if(!isset($salePrice) && empty($salePrice)){
            $salePrice = 0.00;
        }*/
        #die('died '.'<pre>'.print_r($salePrice, true));
        $created = date('Y-m-d H:i:s');
        $isDone = 'done';
        $product->updateProductApiById($brandName,$genericName,$manufacturer,$packSize,$dosageForm,$salePrice,$isDone,$created,$singleProduct['id']);
    }
    echo 'Successfully Done All';
    echo '<br>';
    function filter($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>
<!DOCTYPE html>
<html>
<head><title>API</title></head>
<body>
    <a href="process_product.php">Re Load</a>
</body>
</html>
