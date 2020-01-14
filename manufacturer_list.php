<?php
require 'connection.php';
if(isset($_POST['query'])){
    $output = '<ul class="list-mystyle">';
    $searchResults = $product->getManufacturerList($_POST['query']);
    foreach ($searchResults as $searchResult){
        $output .= '<li>'.$searchResult["manufacturer"].'</li>';
    }
    $output .= '</ul>';
    echo $output;
}
?>