<?php


//set headers
header('Content-type: text/xml; charset=UTF-8');
//header('Content-Disposition: attachment; filename="data.xml"');

define('MAGENTO_ROOT', getcwd());
$compilerConfig = MAGENTO_ROOT . '/includes/config.php';
if (file_exists($compilerConfig)) {
    include $compilerConfig;
}
$mageFilename = MAGENTO_ROOT . '/app/Mage.php';
require_once $mageFilename;
Mage::app(); 
$storeId = 1; //the store id for the export
Mage::app()->setCurrentStore(Mage::getModel('core/store')->load($storeId));
$collection = Mage::getModel('catalog/product')->getCollection();
$collection->addAttributeToSelect('*');
$collection->addAttributeToFilter('status', 1);//only active products

$doc = new DOMDocument('1.0', 'UTF-8');
// Format output
$doc->formatOutput = true;

// Create global product tag
  $root = $doc->createElement('Products');
  $root = $doc->appendChild($root);
foreach ($collection as $product) {
    // Create product tag for each product 
    $product_tag= $doc->createElement('Product');
    $product_tag = $root->appendChild($product_tag);
    
    // Product Id
    $id = $product->getId();
    $id_element = $doc->createElement('id');
    $id_element = $product_tag->appendChild($id_element);
    $text = $doc->createTextNode($id);
    $text = $id_element ->appendChild($text);
    
    // Product Categories(with sub categories)
    $categoryIds = $product->getCategoryIds();
    $cats = array();
    foreach($categoryIds as $categoryId) {
         $category = Mage::getModel('catalog/category')->load($categoryId);
         $cats[] = $category->getName(); 
    }
    $categories = implode(' > ', $cats);   
    $category_element = $doc->createElement('category');
    $category_element = $product_tag->appendChild($category_element);
    $text = $doc->createTextNode($categories);
    $text = $category_element ->appendChild($text);
    
    
    // Product Title
    $title =$product->getName();
    $title_element = $doc->createElement('title');
    $title_element = $product_tag->appendChild($title_element);
    $text = $doc->createTextNode($title);
    $text = $title_element->appendChild($text);
    
    
    // Product Description
    $description = (strlen($product->getDescription() > 6 ))? $product->getDescription : $product->getShortDescription();    
    $description_element = $doc->createElement('description');
    $description_element = $product_tag->appendChild($description_element);
    $text = $doc->createTextNode($description);
    $text = $description_element->appendChild($text);
    

    // Product Price
    $price = $product->getData('special_price');
    if(strlen($price) > 0 ){
        $price_element = $doc->createElement('price');
        $price_element = $product_tag->appendChild($price_element);
        $text = $doc->createTextNode(number_format($price,2));
        $text = $price_element->appendChild($text);    
    }
    
    // Product Old price
    $old_price = number_format($product->getPrice(),2);
    $old_price_element = $doc->createElement('price_old');
    $old_price_element = $product_tag->appendChild($old_price_element);
    $text = $doc->createTextNode($old_price);
    $text = $old_price_element->appendChild($text);
    
    // Product Image url 
    $image_url = Mage::helper('catalog/image')->init($product, 'image')->__toString();
    $image_url_element = $doc->createElement('url_image');
    $image_url_element = $product_tag->appendChild($image_url_element);
    $text = $doc->createTextNode($image_url);
    $text = $image_url_element->appendChild($text);
    
    
    // Product url 
    $product_url = $product->getProductUrl();
    $product_url_element = $doc->createElement('url_product');
    $product_url_element = $product_tag->appendChild($product_url_element);
    $text = $doc->createTextNode($product_url);
    $text = $product_url_element->appendChild($text);
  
}
$doc->saveXML() ;
$file = 'product-export.xml';
if(!file_exists("product_data/$file")){
    mkdir('product_data', 0777, true);       
    $doc->save("product_data/$file");
}

