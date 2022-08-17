<?

namespace Root\Www;

class Service
{
    const CRAWLED_HTML_DIR = 'bin/html/';

    private $outputHandler;

    public function __construct(OutputHandler $outputHandler)
    {
        $this->outputHandler = $outputHandler;
    }

    public function crawl(string $url, int $limit)
    {
        $this->clearSavedHtml();

        $this->outputHandler->showPassedArguments($url, $limit);

        $baseUrl = $this->getBaseUrl($url);
        $html = file_get_contents($url);
        $this->saveFile($this->getBasePageName($url), $html);

        $subpages = $this->regexGetSubpages($html, $limit);
        $this->crawlSubpages($subpages, $baseUrl);
    }

    public function clearSavedHtml()
    {
        $files = glob(self::CRAWLED_HTML_DIR . '*');
        foreach($files as $file){
            if(is_file($file)) {
                unlink($file);
            }
        }
    }

    public function regexGetSubpages(string $html, int $limit): array
    {
        //todo if not enough pages then try and get more urls from subpages
        $regexPattern = '/<a\s+(?:[^>]*?\s+)?href=(["\'])(.*?)\1/';
        preg_match_all($regexPattern, $html, $out, PREG_SET_ORDER);

        $i=0;
        $subpages = [];
        while(sizeof($subpages) < $limit && isset($out[$i])) {
            array_push($subpages, $out[$i][2]);
            $subpages = array_unique($subpages, SORT_REGULAR);

            //TODO links to pictures ?

            $i++;
        }

        $this->outputHandler->showNumberOfUniqueSubpages($subpages);

        return $subpages;
    }

    private function getBaseUrl(string $url)
    {
        $a = explode('/', $url);
        return $a[0] . "//" . $a[2];
    }

    private function getBasePageName(string $url)
    {
        $a = explode('/', $url);
        return $a[2];
    }

    public function saveFile(string $fileName, string $html)
    {
        $file = fopen(self::CRAWLED_HTML_DIR . $fileName . ".html", "w");
        fwrite($file, $html);
        fclose($file);
    }

    public function crawlSubpages(array $subpages, string $baseUrl)
    {
        $i=0;
        foreach($subpages as $subpage) {
            $subpageUrl = $baseUrl . $subpage;
            $html = file_get_contents($subpageUrl);
            $this->saveFile($this->getBasePageName($baseUrl) . $i, $html);

            echo "\n" . $subpageUrl . "\n";
            $i++;
        }
    }

}
