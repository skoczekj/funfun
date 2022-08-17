<?

namespace Root\Www;

class OutputHandler
{
    public function lineBreak()
    {
        fprintf(STDERR, "\n");
    }

    public function showHelp()
    {
        fprintf(
            STDERR,
            "Here is some help!\n\n" . 
            "-u pass url to crawl\n\n" . 
            "-l limit max urls crawled\n\n"
        );
        exit;
    }

    public function showPassedArguments(string $url, int $limit)
    {
        fprintf(
            STDERR,
            "url to crawl is: $url\n" . 
            "max urls limit is: $limit\n\n"
        );
    }

    public function noFileError(string $url)
    {
        fprintf(
            STDERR,
            "can not access: $url\n"
        );
    }

    public function showNumberOfUniqueSubpages(array $subpages)
    {
        fprintf(
            STDERR,
            "found " . sizeof($subpages) . " unique subpages"
        );
    }
}
