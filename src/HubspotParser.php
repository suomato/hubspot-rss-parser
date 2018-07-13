<?php

namespace Suomato;

class HubspotParser
{
    private $posts = [];

    public function __construct($rss_feed_url)
    {
        $xml                  = simplexml_load_file($rss_feed_url);
        $hubspot_posts        = $xml->channel->item;

        foreach ($hubspot_posts as $hubspot_post) {
            preg_match('/<img[^>]+>/i', $hubspot_post->description, $result);
            preg_match_all('/(alt|title|src)=("[^"]*")/i', $result[0], $result2);
            array_push(
                $this->posts,
                new HubspotPost(
                (string)$hubspot_post->title,
                (string)$hubspot_post->link,
                (array)$hubspot_post->category,
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
        $posts = $this->posts;

        if (isset($args['include'])) {
            $posts = array_values(array_filter($posts, function ($post) use ($args) {
                foreach ($args['include'] as $category) {
                    if ($post->hasCategory($category)) {
                        return true;
                    }
                }
                return false;
            }));
        }

        if (isset($args['exclude'])) {
            $posts = array_values(array_filter($posts, function ($post) use ($args) {
                foreach ($args['exclude'] as $category) {
                    if ($post->hasCategory($category)) {
                        return false;
                    }
                }
                return true;
            }));
        }

        if (isset($args['limit'])) {
            $posts = array_slice($posts, 0, $args['limit']);
        }

        return $posts;
    }
}
