<?php declare(strict_types = 1);

/**
 * ResourceObject.php
 *
 * @license        More in LICENSE.md
 * @copyright      https://www.ipublikuj.eu
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 * @since          0.0.1
 *
 * @date           05.05.18
 */

namespace IPub\JsonAPIDocument\Objects;

use IPub\JsonAPIDocument;
use IPub\JsonAPIDocument\Exceptions;

/**
 * Resource object
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
class ResourceObject extends StandardObject implements IResourceObject
{

	use TIdentifiable;
	use TMetaMember;

	/**
	 * {@inheritDoc}
	 */
	public function getIdentifier(): IResourceIdentifier
	{
		return ResourceIdentifier::create($this->getType(), $this->getId());
	}

	/**
	 * {@inheritDoc}
	 */
	public function getAttributes(): IStandardObject
	{
		$attributes = $this->hasAttributes() ? $this->get(JsonAPIDocument\IDocument::KEYWORD_ATTRIBUTES) : new StandardObject();

		if (!$attributes instanceof IStandardObject) {
			throw new Exceptions\RuntimeException('Attributes member is not an object.');
		}

		return $attributes;
	}

	/**
	 * {@inheritDoc}
	 */
	public function hasAttributes(): bool
	{
		return $this->has(JsonAPIDocument\IDocument::KEYWORD_ATTRIBUTES);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getRelationship(string $key): ?IRelationship
	{
		$relationships = $this->getRelationships();

		return $relationships->has($key) ? $relationships->getRelationship($key) : null;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getRelationships(): IRelationshipCollection
	{
		if (!$this->hasRelationships()) {
			throw new Exceptions\RuntimeException('Relationships member is not present.');
		}

		$relationships = $this->get(JsonAPIDocument\IDocument::KEYWORD_RELATIONSHIPS);

		if (!$relationships instanceof IStandardObject) {
			throw new Exceptions\RuntimeException('Relationships member is not an array.');
		}

		return RelationshipCollection::create($relationships);
	}

	/**
	 * {@inheritDoc}
	 */
	public function hasRelationships(): bool
	{
		return $this->has(JsonAPIDocument\IDocument::KEYWORD_RELATIONSHIPS);
	}

}
