<?php declare(strict_types = 1);

namespace Tests\Cases;

use IPub\JsonAPIDocument;
use IPub\JsonAPIDocument\Objects;
use Ninjify\Nunjuck\TestCase\BaseMockeryTestCase;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
class TestCreateDocument extends BaseMockeryTestCase
{

	public function testReadSingleDataDocument(): void
	{
		$document = new JsonAPIDocument\Document(json_decode(file_get_contents(__DIR__ . '/../../fixtures/valid.single.data.json')));

		$resource = $document->getResource();

		Assert::type(Objects\IResourceObject::class, $resource);

		// Resource attributes
		Assert::same('1', $resource->getId());
		Assert::same('articles', $resource->getType());

		Assert::same(['title' => 'JSON:API paints my bikeshed!'], $resource->getAttributes()->toArray());

		// Resource Links
		Assert::same('http://example.com/articles/1', $resource->getLinks()->get(JsonAPIDocument\IDocument::KEYWORD_SELF));

		// Relationships
		Assert::type(Objects\RelationshipObjectCollection::class, $resource->getRelationships());
		Assert::same(2, $resource->getRelationships()->count());

		// Links
		Assert::same('http://example.com/articles', $document->getLinks()->get(JsonAPIDocument\IDocument::KEYWORD_SELF));
		Assert::false($document->getLinks()->has(JsonAPIDocument\IDocument::KEYWORD_PREV));
		Assert::same('http://example.com/articles?page[offset]=2', $document->getLinks()->get(JsonAPIDocument\IDocument::KEYWORD_NEXT));
		Assert::false($document->getLinks()->has(JsonAPIDocument\IDocument::KEYWORD_FIRST));
		Assert::same('http://example.com/articles?page[offset]=10', $document->getLinks()->get(JsonAPIDocument\IDocument::KEYWORD_LAST));

		// Included
		$included = $document->getIncluded();

		Assert::same(3, $included->count());

		foreach ($included as $item) {
			Assert::type(Objects\IResourceObject::class, $item);
		}
	}

	public function testReadMultipleDataDocument(): void
	{
		$document = new JsonAPIDocument\Document(json_decode(file_get_contents(__DIR__ . '/../../fixtures/valid.multiple.data.json')));

		$resources = $document->getResources();

		Assert::type(Objects\IResourceObjectCollection::class, $resources);

		Assert::same(1, $resources->count());

		foreach ($resources as $resource) {
			Assert::type(Objects\IResourceObject::class, $resource);
		}
	}

	public function testReadErrorDocument(): void
	{
		$document = new JsonAPIDocument\Document(json_decode(file_get_contents(__DIR__ . '/../../fixtures/error.json')));

		$errors = $document->getErrors();

		Assert::type(Objects\IErrorObjectCollection::class, $errors);

		Assert::same(1, $errors->count());

		foreach ($errors as $error) {
			Assert::type(Objects\IErrorObject::class, $error);
		}
	}

}

$test_case = new TestCreateDocument();
$test_case->run();
