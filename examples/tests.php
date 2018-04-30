<?php

include __DIR__ . '/../lib/StructuredDataExtractor.php';

$url = 'https://www.bookmundi.com/kathmandu/everest-base-camp-trek-3841';

$dataExtractor = new StructuredDataExtractor();
$dataExtractor->setUrl($url);
$dataExtractor->getContents();
$dataExtractor->extractData();

echo '<pre>';
print_r($dataExtractor->data);
