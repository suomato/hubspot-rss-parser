# HubSpot rss-feed Parser

> This library is for parsing HubSpot rss-feed to PHP Object.

## Installation

```
composer require suomato/hubspot-rss-parser
```

## Example

```
// HubSpot blog RSS feed URL
$rss_feed = 'path/to/rss.xml'

$parser = new Suomato\HubspotParser($rss_feed);

// Array of HubspotPost objects
$posts = $parser->get();

// The First Post Title
$posts[0]->title;

// The First Post link
$posts[0]->link;

// The First Post Image Source
$posts[0]->image['src'];

// The First Post Image alt text
$posts[0]->image['alt'];

// Array of Categories of the First Post
$posts[0]->categories;

```

## Filtering Posts

### Include
```
// Only get posts with categories 'foo' OR 'bar'
$posts = $parser->get([
  'include' => ['foo', 'bar']
]);
```

### Exclude
```
// Only get posts without categories 'foo' OR 'bar'
$posts = $parser->get([
  'exclude' => ['foo', 'bar']
]);
```

### Limit
```
// Only get first three posts
$posts = $parser->get([
  'limit' => 3
]);
```


