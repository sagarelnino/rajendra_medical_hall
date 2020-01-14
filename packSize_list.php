<?php
require 'connection.php';
if(isset($_POST['query'])){
    $output = '<ul class="list-mystyle">';
    $searchResults = $product->getPackSizeList($_POST['query']);
    foreach ($searchResults as $searchResult){
        $output .= '<li>'.$searchResult["packSize"].'</li>';
    }
    $output .= '</ul>';
    echo $output;
}
?>