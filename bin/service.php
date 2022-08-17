<?

use DiDom\Document;
require_once('vendor/autoload.php');

function crawl(string $url, int $limit)
{
    clearSavedHtml();

    showPassedArguments($url, $limit);

    $baseUrl = (getBaseUrl($url));
    $html = file_get_contents($url);
    saveFile(getBasePageName($url), $html);

    $subpages = regexGetSubpages($html, $limit);
    crawlSubpages($subpages, $baseUrl);
}

function clearSavedHtml()
{
    //TODO move path to var
    $files = glob('bin/html/*');
    foreach($files as $file){
        if(is_file($file)) {
            unlink($file);
        }
    }
}

function regexGetSubpages(string $html, int $limit): array
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

    showNumberOfUniqueSubpages($subpages);

    return $subpages;
}

function getBaseUrl(string $url)
{
    $a = explode('/', $url);
    return $a[0] . "//" . $a[2];
}

function getBasePageName(string $url)
{
    $a = explode('/', $url);
    return $a[2];
}

function saveFile(string $fileName, string $html)
{
    $file = fopen("bin/html/" . $fileName . ".html", "w");
    fwrite($file, $html);
    fclose($file);
}

function crawlSubpages(array $subpages, string $baseUrl)
{
    $i=0;
    foreach($subpages as $subpage) {
        $subpageUrl = $baseUrl . $subpage;
        $html = file_get_contents($subpageUrl);
        saveFile(getBasePageName($baseUrl) . $i, $html);

        echo "\n" . $subpageUrl . "\n";
        $i++;
    }
}
