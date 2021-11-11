<?php

namespace App\Services\Utils;
libxml_use_internal_errors(true);

use DOMDocument;
use DOMNodeList;
use DOMXPath;

class YahooFinanceScrapping
{
    private array $variationClasses = [
        './/span[@class="Trsdu(0.3s) Fw(500) Pstart(10px) Fz(24px) C($negativeColor)"]',
        './/span[@class="Trsdu(0.3s) Fw(500) Pstart(10px) Fz(24px) C($positiveColor)"]',
        './/span[@class="Trsdu(0.3s) Fw(500) Pstart(10px) Fz(24px)"]'
    ];

    public function getStockInfo(string $stock): array
    {
        $document = $this->getYahooPage($stock);

        return $this->getStockPrices($document);
    }

    private function getStockPrices(DOMDocument $document): array
    {
        $xPath = new DOMXPath($document);
        $stockPrice = $xPath->query('.//span[@class="Trsdu(0.3s) Fw(b) Fz(36px) Mb(-4px) D(ib)"]');
        $stockVariation = $xPath->query('.//span[starts-with(@class, "Trsdu(0.3s) Fw(500) Pstart(10px) Fz(24px)")]');

        $stockPrice = $this->replaceQuotes($stockPrice->item(0)->textContent);
        [$variationValue, $variationPerc] = $this->getFormatedVariation($stockVariation);

        return [(float) $stockPrice, (float) $variationValue, (float) $variationPerc];
    }

    private function getFormatedVariation(DOMNodeList $stockVariation): array
    {
        $stockVariation = explode(' ', $stockVariation->item(0)->textContent);
        $variation = $stockVariation[0];
        $percVariation = $stockVariation[1];
        $percVariation = preg_replace("/[^a-zA-Z0-9.-]+/", "", $percVariation);

        return [$this->replaceQuotes($variation), $this->replaceQuotes($percVariation)];
    }

    private function getYahooPage(string $stock): DOMDocument
    {
        $content = file_get_contents("https://finance.yahoo.com/quote/$stock.SA");
        $document = new DOMDocument();
        $document->loadHTML($content);

        return $document;
    }

    private function replaceQuotes(string $value)
    {
        return str_replace(',', "", $value);
    }

}
