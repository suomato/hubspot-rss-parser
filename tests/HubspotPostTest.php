<?php

use PHPUnit\Framework\TestCase;
use Suomato\HubspotPost;

class HubspotPostTest extends TestCase
{
    public function testHasCategory()
    {
        $post = new HubspotPost('Title', 'link', [
            'Foo',
            'Bar',
        ], null);

        $this->assertTrue($post->hasCategory('Foo'));
        $this->assertFalse($post->hasCategory('Lorem'));
    }
}
