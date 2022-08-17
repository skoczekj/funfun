<?

namespace Root\Www;

class OptsTransferObject
{
    public string $url;
    public int $limit;

    public function __construct(string $url, int $limit)
    {
        $this->url = $url;
        $this->limit = $limit;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }
}
