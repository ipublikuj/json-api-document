<?php declare(strict_types = 1);

/**
 * LinkObject.php
 *
 * @license        More in LICENSE.md
 * @copyright      https://www.ipublikuj.eu
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 * @since          0.2.0
 *
 * @date           19.05.21
 */

namespace IPub\JsonAPIDocument\Objects;

use IPub\JsonAPIDocument;
use IPub\JsonAPIDocument\Exceptions;
use IPub\JsonAPIDocument\Objects;

/**
 * Link object
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
class LinkObject implements ILinkObject
{

	/** @var Objects\IStandardObject */
	private Objects\IStandardObject $data;

	/**
	 * @param Objects\IStandardObject $data
	 */
	public function __construct(Objects\IStandardObject $data)
	{
		if (!$data->has(JsonAPIDocument\IDocument::KEYWORD_HREF)) {
			throw new Exceptions\InvalidArgumentException('Provided link object has missing required attribute');
		}

		$this->data = $data;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getHref(): string
	{
		$href = $this->data->get(JsonAPIDocument\IDocument::KEYWORD_HREF);

		if (!is_string($href)) {
			throw new Exceptions\RuntimeException('Value of href attribute of link object has invalid value.');
		}

		return $href;
	}

	/**
	 * {@inheritDoc}
	 */
	public function hasMeta(): bool
	{
		return $this->data->has(JsonAPIDocument\IDocument::KEYWORD_META);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getMeta(): IMetaObjectCollection
	{
		$raw = $this->data->get(JsonAPIDocument\IDocument::KEYWORD_META);

		if (!$raw instanceof Objects\IStandardObject && $raw !== null) {
			throw new Exceptions\RuntimeException('Meta member is not an object.');
		}

		return MetaObjectCollection::create($raw);
	}

}
