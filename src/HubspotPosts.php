<?php

namespace Suomato;

class HubspotPosts
{
    private $items = [];

    public function __construct($rss_feed_url)
    {
        $xml                  = simplexml_load_file($rss_feed_url);
        $hubspot_posts        = $xml->channel->item;

        foreach ($hubspot_posts as $post) {
            preg_match('/<img[^>]+>/i', $post->description, $result);
            preg_match_all('/(alt|title|src)=("[^"]*")/i', $result[0], $result2);
            array_push(
                $this->items,
                new HubspotPost(
                (string)$post->title,
                (string)$post->link,
                (array)$post->category,
                [
                    'src' => str_replace('"', '', $result2[2][0]),
                    'alt' => str_replace('"', '', $result2[2][1]),
                ]
            )
        );
        }
    }

    public function get($args = [])
    {
        $items = $this->items;

        if (isset($args['include'])) {
            $items = array_values(array_filter($items, function ($item) use ($args) {
                foreach ($args['include'] as $category) {
                    if ($item->hasCategory($category)) {
                        return true;
                    }
                }
                return false;
            }));
        }

        if (isset($args['exclude'])) {
            $items = array_values(array_filter($items, function ($item) use ($args) {
                foreach ($args['exclude'] as $category) {
                    if ($item->hasCategory($category)) {
                        return false;
                    }
                }
                return true;
            }));
        }

        if (isset($args['limit'])) {
            $items = array_slice($items, 0, $args['limit']);
        }

        return $items;
    }
}
