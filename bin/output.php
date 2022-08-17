<?

function lineBreak()
{
    fprintf(STDERR, "\n");
}

function showHelp() {
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


if (isset($opts["l"])) {
    fprintf(
        STDERR,
        "max urls limit is: $limit\n\n"
    );
}

if (isset($opts["u"])) {
    fprintf(
        STDERR,
        "url to crawl is: $url\n\n"
    );
}
