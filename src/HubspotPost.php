<?php

namespace Suomato;

class HubspotPost
{
    public $title;
    public $link;
    public $categories;
    public $image;

    public function __construct($title, $link, $categories, $image)
    {
        $this->title       = $title;
        $this->link        = $link;
        $this->categories  = $categories;
        $this->image       = $image;
    }

    public function hasCategory($category)
    {
        return in_array($category, $this->categories);
    }
}
