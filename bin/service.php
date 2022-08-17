<?

use DiDom\Document;
require_once('vendor/autoload.php');

function crawl(string $url, int $limit)
{
    showPassedArguments($url, $limit);
    $html = file_get_contents($url);
    $subpages = regexGetSubpages($html, $limit);
    $baseUrl = (getBaseUrl($url));
}

function regexGetSubpages(string $html, int $limit): array
{
    $regexPattern = '/<a\s+(?:[^>]*?\s+)?href=(["\'])(.*?)\1/';
    preg_match_all($regexPattern, $html, $out, PREG_SET_ORDER);

    $i=0;
    $subpages = [];
    while($i < $limit && isset($out[$i])) {
        array_push($subpages, $out[$i][2]);
        $subpages = array_unique($subpages, SORT_REGULAR);

        //TODO what to do when array is not unique add var that increses with each duplicate ?
                // if(sizeof($tmp) !== $i + 1) {
        //     $limit++;
        // } else {
        //     $i++;
        // }
        $i++;
    }

    showNumberOfUniqueSubpages($subpages);

    return $subpages;
}

function getBaseUrl(string $url)
{
    //TODO remove ditry hack to get base url
    $a = explode('/', $url);
    return $a[0] . "//" . $a[2];
}












// //todo private?
// function getDocument(string $url): Document
// {
//     $document = new Document($url, true);

//     //todo meh
//     if ($document->has('a')) {
//         $elements = $document->find('');
//         foreach ($elements as $element) {
//             echo $element->text();
//             echo "\n";
//         }
//     } else {
//         noFileError('asd');
//     }
//     return $document;
// }

// function getUrls(Document $dom)
// {
//     //todo get links, put to array, make sure none are duped, return
//     $head = $dom->getElementsByTagName('head')->item(0);
//     $links = $head->getElementsByTagName("link");
//     foreach($links as $l) {
//         if($l->getAttribute("rel") == "service") {
//             echo $l->getAttribute("href");
//         }
//     }
// }
