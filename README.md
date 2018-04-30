# StructuredDataExtractor 0.1
Structured Data Extractor / Rich Snippets Data Extractor

Dependency : composer require simple-html-dom/simple-html-dom
--------------------------------------------------------------
composer require simple-html-dom/simple-html-dom


Example
--------

    $url = 'http://www.himalayanwonders.com/nepal/everest-base-camp.html';
    $dataExtractor = new StructuredDataExtractor();
    $dataExtractor->setUrl($url);
    $dataExtractor->getContents();
    $dataExtractor->extractData();

    echo '<pre>';
    print_r($dataExtractor->data);
