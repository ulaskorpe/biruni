<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class PageCssExtractor
{
    public function processPage($url)
    {
        // 1. Sayfayı ziyaret ederek HTML'i al
        $html = $this->fetchPageHtml($url);

        // 2. HTML'deki tüm class'ları bul
        $classes = $this->extractClassesFromHtml($html);

        // 3. Ana CSS dosyasından bu class'ların değerlerini al
        $cssContents = $this->getCssForClasses($classes);

        return $cssContents;
    }

    protected function fetchPageHtml($url)
    {
        try {
            $response = Http::withoutVerifying()->withOptions(["verify" => false])->get($url);
            return $response->body();
        } catch (\Exception $e) {
            throw new \Exception("Sayfa alınamadı: " . $e->getMessage());
        }
    }

    protected function extractClassesFromHtml($html)
    {
        preg_match_all('/class=["\']([^"\']+)["\']/', $html, $matches);

        if (empty($matches[1])) {
            return [];
        }

        // Tüm class'ları birleştir ve unique hale getir
        $allClasses = [];
        foreach ($matches[1] as $classGroup) {
            $classes = preg_split('/\s+/', trim($classGroup));
            $allClasses = array_merge($allClasses, $classes);
        }

        return array_unique(array_filter($allClasses));
    }

    protected function getCssForClasses(array $classes)
    {
        if (empty($classes)) {
            return '';
        }

        $parser = new \Sabberworm\CSS\Parser(file_get_contents(public_path('fe/css/main_full.css')));
        $cssDocument = $parser->parse();

        $extractedCss = '';
    
    foreach ($cssDocument->getAllDeclarationBlocks() as $ruleSet) {
        foreach ($ruleSet->getSelectors() as $selector) {
            $selectorString = $selector->getSelector();
            
            // Sadece class selectorlerini kontrol et
            if (strpos($selectorString, '.') === 0) {
                $class = substr($selectorString, 1);
                
                if (in_array($class, $classes)) {
                    $extractedCss .= (string)$ruleSet;
                }
            }
        }
    }

        return $extractedCss;
    }
}
