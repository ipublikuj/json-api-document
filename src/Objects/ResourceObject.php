<?php declare(strict_types = 1);

/**
 * ResourceObject.php
 *
 * @license        More in license.md
 * @copyright      https://www.ipublikuj.eu
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 * @since          1.0.0
 *
 * @date           05.05.18
 */

namespace IPub\JsonAPIDocument\Objects;

use IPub\JsonAPIDocument\Exceptions;
use Neomerx\JsonApi\Contracts\Schema\DocumentInterface;

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
		$attributes = $this->hasAttributes() ? $this->get(DocumentInterface::KEYWORD_ATTRIBUTES) : new StandardObject();

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
		return $this->has(DocumentInterface::KEYWORD_ATTRIBUTES);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getRelationships(): IRelationships
	{
		$relationships = $this->hasRelationships() ? $this->{DocumentInterface::KEYWORD_RELATIONSHIPS} : null;

		if (!is_null($relationships) && !is_object($relationships)) {
			throw new Exceptions\RuntimeException('Relationships member is not an object.');
		}

		return new Relationships($relationships);
	}

	/**
	 * {@inheritDoc}
	 */
	public function hasRelationships(): bool
	{
		return $this->has(DocumentInterface::KEYWORD_RELATIONSHIPS);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getRelationship(string $key): IRelationship
	{
		$relationships = $this->getRelationships();

		return $relationships->has($key) ? $relationships->getRelationship($key) : null;
	}

}
