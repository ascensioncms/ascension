<?php
use Radium\Routing\Router;

Router::map(function($r){
    // Shortcut to prepend Ascension namespace.
    $c = function($controller) {
        return "Ascension\\Controllers\\{$controller}";
    };

    $r->addToken('slug', "(?P<slug>[\w\d\-_]+)");

    $r->root($c('Articles::index'));
    $r->route('404')->to('Errors::notFound');

    $r->resources('Article', $c('Articles'), [
        'token' => "{slug}\.{id}"
    ]);
});
