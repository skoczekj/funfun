<?

function lineBreak()
{
    fprintf(STDERR, "\n");
}

function showHelp()
{
    fprintf(
        STDERR,
        "Here is some help!\n\n" . 
        "-u pass url to crawl\n\n" . 
        "-l limit max urls crawled\n\n"
    );
    exit;
}

function showPassedArguments(string $url, int $limit)
{
    fprintf(
        STDERR,
        "url to crawl is: $url\n" . 
        "max urls limit is: $limit\n\n"
    );
}

function noFileError(string $url)
{
    fprintf(
        STDERR,
        "can not access: $url\n"
    );
}

function showNumberOfUniqueSubpages(array $subpages)
{
    fprintf(
        STDERR,
        "found " . sizeof($subpages) . " unique subpages"
    );
}
