# {JSON:API} document

[![Latest Stable Version](https://img.shields.io/packagist/v/ipub/json-api-document.svg?style=flat-square)](https://packagist.org/packages/ipub/json-api-document)
[![Composer Downloads](https://img.shields.io/packagist/dt/ipub/json-api-document.svg?style=flat-square)](https://packagist.org/packages/ipub/json-api-document)
[![License](https://img.shields.io/packagist/l/ipub/json-api-document.svg?style=flat-square)](https://packagist.org/packages/ipub/json-api-document)

Small library for creating [json:api](http://jsonapi.org) document from object.

## Installation

The best way to install ipub/json-api-document is using  [Composer](http://getcomposer.org/):

```sh
$ composer require ipub/json-api-document
```

## Create document

```php
$content = $response->getContent();

$document = new \IPub\JsonAPIDocument\Document(json_encode($content));
```

### Get data type

```json
{
  "links": {
    "self": "http://example.com/articles/1"
  },
  "data": {
    "type": "articles",
    "id": "1",
    "attributes": {
      "title": "JSON:API paints my bikeshed!"
    },
    "relationships": {
      "author": {
        "links": {
          "related": "http://example.com/articles/1/author"
        }
      }
    }
  }
}
```

```php
$type = $document->getResource()->getType(); // articles
```

etc.

***
Homepage [https://www.ipublikuj.eu](https://www.ipublikuj.eu) and repository [http://github.com/iPublikuj/json-api-document](http://github.com/iPublikuj/json-api-document).
