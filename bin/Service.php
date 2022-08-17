<?

namespace Root\Www;

class Service
{
    const CRAWLED_HTML_DIR = 'bin/html/';

    private OutputHandler $outputHandler;
    private string $url;
    private int $limit;
    private string $baseUrl;
    private string $basePageName;

    public function __construct(OutputHandler $outputHandler, OptsTransferObject $optsTransferObject)
    {
        $this->outputHandler = $outputHandler;
        $this->url = $optsTransferObject->url;
        $this->limit = $optsTransferObject->limit;

        $this->clearSavedHtml();

        $this->getBaseUrl();
        $this->getBasePageName();
    }

    public function crawl()
    {
        $this->outputHandler->showPassedArguments($this->url, $this->limit);
        
        $html = file_get_contents($this->url);
        $this->saveFile($this->basePageName, $html);

        $subpages = $this->regexGetSubpages($html, $this->limit);
        $this->crawlSubpages($subpages);

        $this->outputHandler->done();
    }

    private function clearSavedHtml()
    {
        $files = glob(self::CRAWLED_HTML_DIR . '*');
        foreach($files as $file){
            if(is_file($file)) {
                unlink($file);
            }
        }
    }

    private function regexGetSubpages(string $html, int $limit): array
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

    private function getBaseUrl()
    {
        $tmp = explode('/', $this->url);
        $this->baseUrl = $tmp[0] . "//" . $tmp[2];
    }

    private function getBasePageName()
    {
        $tmp = explode('/', $this->url);
        $this->basePageName = $tmp[2];
    }

    public function saveFile(string $fileName, string $html)
    {
        $file = fopen(self::CRAWLED_HTML_DIR . $fileName . ".html", "w");
        fwrite($file, $html);
        fclose($file);
    }

    public function crawlSubpages(array $subpages)
    {
        $i=0;
        foreach($subpages as $subpage) {
            $subpageUrl = $this->baseUrl . $subpage;
            $html = file_get_contents($subpageUrl);
            $this->saveFile($this->basePageName . $i, $html);
            $i++;
        }
    }

}
