<?php

require_once __DIR__ . '/../vendor/simple-html-dom/simple-html-dom/simple_html_dom.php';

/**
 * A simple php class file to extract structured data from a web url
 */
class StructuredDataExtractor
{
    public $url;
    public $html;
    public $data = array();

    public function __construct()
    {
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getContents()
    {
        $html = self::getDataa($this->url);
        $this->html = str_get_html($html);
        //$this->html = file_get_html($this->url);
    }

    public function extractData()
    {
        self::getTitle();
        self::getDesctiption();
        self::getKeywords();
        self::getImage();
        self::getH1();
        self::getBreadCumbs();
        self::getPrice();
        self::getRating();
    }

    public function getTitle()
    {
        $this->data['title'] = self::getInnerText('title');
    }

    public function getKeywords()
    {
        $this->data['keywords'] = self::getMetaContent('meta[name=keywords]');
    }

    public function getDesctiption()
    {
        $this->data['description'] = self::getMetaContent('meta[name=description]');
    }

    public function getImage()
    {
        $this->data['image'] = self::getMetaContent('meta[property=og:image]');
        if ($this->data['image'] == '') {
            $this->data['image'] = self::getMetaContent('meta[name=twitter:image]');
        }
    }

    public function getH1()
    {
        $this->data['heading'] = self::getInnerText('h1');

        if ($this->data['heading'] == '') {
            $this->data['heading'] = self::getInnerText('h2');
        }

        $this->data['heading'] = self::removeStyles($this->data['heading']);
    }

    public function getBreadCumbs()
    {
        $this->data['breadcumbs'] = self::removeStyles(self::getInnerText('ul[itemprop=breadcrumb]'));
    }

    public function getRating()
    {
        $this->data['rating']['ratingValue'] = self::getInnerText('span[itemprop=ratingValue]');
        $this->data['rating']['reviewCount'] = self::getInnerText('span[itemprop=reviewCount]');
    }

    public function getPrice()
    {
        $this->data['price'] = self::removeStyles(self::getInnerText('div[itemprop=price]'));
    }

    private function getMetaContent($type)
    {
        $el = $this->html->find($type, 0);
        if ($el && $el->content != '') {
            return $el->content;
        } else {
            return;
        }

    }

    private function getInnerText($type)
    {
        $el = $this->html->find($type, 0);
        if ($el) {
            return $el->innertext;
        } else {
            return;
        }

    }

    private function removeStyles($input)
    {
        return preg_replace('/(<[^>]+) style=".*?"/i', '$1', $input);
    }

    private function getDataa($url)
    {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

}
