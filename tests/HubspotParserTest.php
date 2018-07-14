<?php

use PHPUnit\Framework\TestCase;
use Suomato\HubspotParser;

class HubspotParserTest extends TestCase
{
    protected $parser;

    public function setUp()
    {
        $this->parser = new HubspotParser(__DIR__ . '/dummy.xml');
    }

    public function testDataFetching()
    {
        $posts  = $this->parser->get();

        $this->assertNotEmpty($posts);
    }

    public function testLimit()
    {
        for ($i = 1; $i <= $this->parser->count(); $i++) {
            $posts = $this->parser->get([
                'limit' => $i,
            ]);
            $this->assertCount($i, $posts);
        }
    }

    public function testInclude()
    {
        $posts = $this->parser->get([
            'include' => ['Foo'],
        ]);

        foreach ($posts as $post) {
            $this->assertTrue($post->hasCategory('Foo'));
        }

        $posts = $this->parser->get([
            'include' => ['Lorem', 'Ipsum'],
        ]);

        foreach ($posts as $post) {
            $this->assertTrue($post->hasCategory('Lorem') || $post->hasCategory('Ipsum'));
        }
    }

    public function testExclude()
    {
        $posts = $this->parser->get([
            'exclude' => ['Foo'],
        ]);

        foreach ($posts as $post) {
            $this->assertFalse($post->hasCategory('Foo'));
        }

        $posts = $this->parser->get([
            'exclude' => ['Lorem', 'Ipsum'],
        ]);

        foreach ($posts as $post) {
            $this->assertFalse($post->hasCategory('Lorem') || $post->hasCategory('Ipsum'));
        }
    }

    public function testIncludeWithExclude()
    {
        $posts = $this->parser->get([
            'include' => ['Lorem'],
            'exclude' => ['Foo'],
        ]);

        foreach ($posts as $post) {
            $this->assertTrue($post->hasCategory('Lorem') && !$post->hasCategory('Foo'));
        }
    }

    public function testOffset()
    {
        $posts = $this->parser->get([
            'offset' => 2,
        ]);

        $this->assertEquals('Item3', $posts[0]->title);
    }
}
