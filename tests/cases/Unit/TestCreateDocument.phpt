<?php declare(strict_types = 1);

namespace Tests\Cases;

use IPub\JsonAPIDocument;
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

		Assert::notNull($resource);
		Assert::same(['title' => 'JSON:API paints my bikeshed!'], $resource->getAttributes()->toArray());
	}

}

$test_case = new TestCreateDocument();
$test_case->run();
