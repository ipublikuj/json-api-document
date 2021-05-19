<?php declare(strict_types = 1);

/**
 * RelationshipObject.php
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
 * Relationship object
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
class RelationshipObject implements IRelationshipObject
{

	/** @var Objects\IStandardObject */
	private Objects\IStandardObject $data;

	public function __construct(Objects\IStandardObject $data)
	{
		if (
			!$data->has(JsonAPIDocument\IDocument::KEYWORD_LINKS)
			&& !$data->has(JsonAPIDocument\IDocument::KEYWORD_DATA)
			&& !$data->has(JsonAPIDocument\IDocument::KEYWORD_META)
		) {
			throw new Exceptions\InvalidArgumentException('Provided data object is not valid relationship object');
		}

		$this->data = $data;
	}

	/**
	 * {@inheritDoc}
	 */
	public function hasLinks(): bool
	{
		return $this->data->has(JsonAPIDocument\IDocument::KEYWORD_LINKS);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getLinks(): ILinkObjectCollection
	{
		$raw = $this->data->get(JsonAPIDocument\IDocument::KEYWORD_LINKS);

		if (!$raw instanceof Objects\IStandardObject && $raw !== null) {
			throw new Exceptions\RuntimeException('Links member is not an object.');
		}

		return LinkObjectCollection::create($raw);
	}

	/**
	 * {@inheritDoc}
	 */
	public function hasData(): bool
	{
		return $this->data->has(JsonAPIDocument\IDocument::KEYWORD_DATA);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getData()
	{
		if ($this->isHasMany()) {
			return $this->getIdentifiers();

		} elseif ($this->isHasOne()) {
			return $this->hasIdentifier() ? $this->getIdentifier() : null;
		}

		throw new Exceptions\RuntimeException('No data member or data member is not a valid relationship.');
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

	/**
	 * {@inheritDoc}
	 */
	public function isHasMany(): bool
	{
		return is_array($this->data->get(JsonAPIDocument\IDocument::KEYWORD_DATA));
	}

	/**
	 * {@inheritDoc}
	 */
	public function isHasOne(): bool
	{
		if (!$this->data->has(JsonAPIDocument\IDocument::KEYWORD_DATA)) {
			return false;
		}

		$data = $this->data->get(JsonAPIDocument\IDocument::KEYWORD_DATA);

		return $data === null || $data instanceof Objects\IStandardObject;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getIdentifiers(): IResourceIdentifierCollection
	{
		if (!$this->isHasMany()) {
			throw new Exceptions\RuntimeException('No data member or data member is not a valid has-many relationship.');
		}

		$data = $this->data->get(JsonAPIDocument\IDocument::KEYWORD_DATA);

		if (!is_array($data)) {
			throw new Exceptions\RuntimeException('Data member has invalid format');
		}

		return ResourceIdentifierCollection::create($data);
	}

	/**
	 * {@inheritDoc}
	 */
	public function hasIdentifier(): bool
	{
		$data = $this->data->get(JsonAPIDocument\IDocument::KEYWORD_DATA);

		return $data instanceof Objects\IStandardObject
			&& $data->has(JsonAPIDocument\IDocument::KEYWORD_TYPE)
			&& $data->has(JsonAPIDocument\IDocument::KEYWORD_ID);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getIdentifier(): IResourceIdentifierObject
	{
		if (!$this->isHasOne()) {
			throw new Exceptions\RuntimeException('No data member or data member is not a valid has-one relationship.');
		}

		if (!$this->hasIdentifier()) {
			throw new Exceptions\RuntimeException('No resource identifier - relationship is empty.');
		}

		$data = $this->data->get(JsonAPIDocument\IDocument::KEYWORD_DATA);

		if (!$data instanceof Objects\IStandardObject) {
			throw new Exceptions\RuntimeException('Data member has invalid format');
		}

		$type = $data->get(JsonAPIDocument\IDocument::KEYWORD_TYPE);
		$id = $data->get(JsonAPIDocument\IDocument::KEYWORD_ID);

		if (!is_string($type) || !is_string($id)) {
			throw new Exceptions\RuntimeException('Data member has invalid format');
		}

		return new ResourceIdentifierObject($data);
	}

}
