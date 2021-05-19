<?php declare(strict_types = 1);

/**
 * ResourceObject.php
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
 * Resource
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
class ResourceObject implements IResourceObject
{

	/** @var Objects\IStandardObject */
	private Objects\IStandardObject $data;

	/** @var IResourceIdentifierObject */
	private IResourceIdentifierObject $identifier;

	public function __construct(Objects\IStandardObject $data)
	{
		if (
			!$data->has(JsonAPIDocument\IDocument::KEYWORD_ID)
			|| !is_string($data->get(JsonAPIDocument\IDocument::KEYWORD_ID))
			|| !$data->has(JsonAPIDocument\IDocument::KEYWORD_TYPE)
			|| !is_string($data->get(JsonAPIDocument\IDocument::KEYWORD_TYPE))
		) {
			throw new Exceptions\InvalidArgumentException('Provided data object is not valid resource');
		}

		$this->data = $data;
		$this->identifier = new ResourceIdentifierObject($data);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getId(): string
	{
		return $this->identifier->getId();
	}

	/**
	 * {@inheritDoc}
	 */
	public function getType(): string
	{
		return $this->identifier->getType();
	}

	/**
	 * {@inheritDoc}
	 */
	public function hasAttributes(): bool
	{
		return $this->data->has(JsonAPIDocument\IDocument::KEYWORD_ATTRIBUTES);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getAttributes(): Objects\IStandardObject
	{
		$data = $this->data->get(JsonAPIDocument\IDocument::KEYWORD_ATTRIBUTES);

		if (!$data instanceof Objects\IStandardObject) {
			throw new Exceptions\RuntimeException('Data member is not an object.');
		}

		return $data;
	}

	/**
	 * {@inheritDoc}
	 */
	public function hasRelationships(): bool
	{
		return $this->data->has(JsonAPIDocument\IDocument::KEYWORD_RELATIONSHIPS);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getRelationships(): IRelationshipObjectCollection
	{
		$raw = $this->data->get(JsonAPIDocument\IDocument::KEYWORD_RELATIONSHIPS);

		if (!$raw instanceof Objects\IStandardObject && $raw !== null) {
			throw new Exceptions\RuntimeException('Relationships member is not an object.');
		}

		return RelationshipObjectCollection::create($raw);
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
