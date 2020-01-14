<?php
require 'connection.php';
if(isset($_POST['query'])){
    $output = '<ul class="list-mystyle">';
    $searchResults = $product->getDosageFormList($_POST['query']);
    foreach ($searchResults as $searchResult){
        $output .= '<li>'.$searchResult["dosageForm"].'</li>';
    }
    $output .= '</ul>';
    echo $output;
}
?>