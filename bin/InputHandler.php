<?

namespace Root\Www;

class InputHandler
{
    const PAGE_LIMIT = 100;

    private $opts;
    private $outputHandler;
    private $service;

    public function __construct(array $opts, OutputHandler $outputHandler, Service $service)
    {
        $this->opts = $opts;
        $this->outputHandler = $outputHandler;
        $this->service = $service;
    }

    public function crawl()
    {
        if (isset($this->opts["h"])) {
            $this->outputHandler->showHelp();
        }
        
        if (
            isset($this->opts["l"]) &&
            $this->opts["l"] < self::PAGE_LIMIT &&
            $this->opts["l"] > 0
        ) {
            $limit = (int)$this->opts["l"];
        }
        
        $url = "";
        if (isset($this->opts["u"])) {
            //TODO SANITIZE INPUT
            $url = $this->opts["u"];
        }

        $this->service->crawl($url, $limit);
    }
}
