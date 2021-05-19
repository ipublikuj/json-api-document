# Quickstart

This [{JSON:API}](http://jsonapi.org) document factory is easy to use. Just fetch data and pass it to the document factory.

```php
use IPub\JsonAPIDocument;

$content = $response->getContent();

$document = new JsonAPIDocument\Document::create($content);
```

You could pass plain string or \stdClass object.

And now you have access to all [{JSON:API}](http://jsonapi.org) document fields.

#### Get single resource type:

```php
$type = $document->getResource()->getType(); // articles
```

#### Get single resource id:

```php
$id = $document->getResource()->getId(); // 1
```

#### Get single resource attributes:

```php
$attributes = $document->getResource()->getAttributes();
```

And for case when in your document is multiple resources:

```php
$resources = $document->getResources();
```

Returned value is iterable collection of basic resources.
