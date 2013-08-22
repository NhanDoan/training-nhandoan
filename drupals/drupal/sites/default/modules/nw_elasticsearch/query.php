<?php


/* Set up Elastica autoloader */
$my_dir = dirname(__FILE__) . '/';

//Or using anonymous function PHP 5.3.0>=
spl_autoload_register(function($class) use ($my_dir) {
    $class = str_replace('\\', '/', $class);

    if (file_exists($my_dir . $class . '.php')) {
        require_once($my_dir . $class . '.php');
    }
});

$client = new Elastica\Client(array(
    'host' => '173.199.132.44',
    'port' => 9200
));

$queryParams = new Elastica\Query\MultiMatch();
$queryParams->setQuery('dog');
$queryParams->setFields(array('title^1.05', 'body'));

$elasticaFacet    = new \Elastica\Facet\Terms('statusFacet');
$elasticaFacet->setField('status');
$elasticaFacet->setSize(10);
$elasticaFacet->setOrder('reverse_count');

$elasticaQuery        = new \Elastica\Query();
$elasticaQuery->setQuery($queryParams);
//$elasticaQuery->addFacet($elasticaFacet);

$elasticaQuery->setHighlight(
    array(
        'pre_tags' => array('<em class="search-highlight">'),
        'post_tags' => array('</em>'),
        'fields' => array(
            'title' => array('number_of_fragments' => 1),
            'body' => array('number_of_fragments' => 5, 'fragment_size' => 125)
        )
    )
);

$index = $client->getIndex('writerportal');

$rs = $index->search($elasticaQuery);
var_dump($rs->getFacets());

foreach ($rs as $row) {
    var_dump($row->getData());
    var_dump($row->getHighlights());
}



