# StructuredDataExtractor 0.1
Structured Data Extractor / Rich Snippets Data Extractor
Still have lots to add

##How to use

    $url = 'https://www.bookmundi.com/kathmandu/everest-base-camp-trek-3841';
    $dataExtractor = new StructuredDataExtractor();
    $dataExtractor->setUrl($url);
    $dataExtractor->getContents();
    $dataExtractor->extractData();

    echo '<pre>';
    print_r($dataExtractor->data);
