<?php
require 'connection.php';
if(isset($_POST['query'])){
    $output = '<ul class="list-mystyle">';
    $searchResults = $product->getSearchedResults($_POST['query']);
    foreach ($searchResults as $searchResult){
        $id=$searchResult['id']."@".$searchResult["stockQuantity"];
        if($searchResult['stockQuantity']<1)
        {
            $output .= '<li id="'.$id.'" style="color:red;">'.$searchResult["brandName"].'|'.$searchResult["packSize"].'|'.$searchResult["dosageForm"].'|'.$searchResult["salePrice"].'|'.$searchResult["manufacturer"].'</li>';
        }
        else{
            $output .= '<li id="'.$id.'">'.$searchResult["brandName"].'|'.$searchResult["packSize"].'|'.$searchResult["dosageForm"].'|'.$searchResult["salePrice"].'|'.$searchResult["manufacturer"].'</li>';
        }
    }
    $output .= '</ul>';
    echo $output;
}
?>