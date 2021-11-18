<?php

namespace SiteOrigin\StringSplitter\Tests;

use PHPUnit\Framework\TestCase;
use SiteOrigin\StringSplitter\StringSplitter;

class SplitterTest extends TestCase
{
    public function test_basic_string_splitting()
    {
        $splitter = new StringSplitter('expertsexchange');
        dd($splitter->words());
    }

}
