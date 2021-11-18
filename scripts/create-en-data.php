<?php

use Illuminate\Support\LazyCollection;

include __DIR__ . '/../vendor/autoload.php';

$c = new LazyCollection(function () {
    $fp = fopen(__DIR__ . '/../tmp/unigram_freq.csv', 'r');
    $head = fgetcsv($fp);

    while ($l = fgetcsv($fp)) {
        yield array_combine($head, $l);
    }
});

$c = $c
    ->mapWithKeys(fn ($word) => [$word['word'] => round($word['count'] / 12711)])
    ->toArray();

file_put_contents(__DIR__ . '/../data/words.json', json_encode($c));
