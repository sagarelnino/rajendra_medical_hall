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
    $divs = $dom->getElementsByTagName('div');
    /**
     * @var $div DOMElement
     * @var $span DOMElement
     */
    foreach ($divs as $div){
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
    if(!isset($salePrice) && empty($salePrice)){
        $salePrice = 0.00;
    }
    #die('died '.'<pre>'.print_r($salePrice, true));
    $updated = date('Y-m-d H:i:s');
    $isDone = 'priceDone';
    $product->updateProductApiPriceById($salePrice,$isDone,$updated,$singleProduct['id']);
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
