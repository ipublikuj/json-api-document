<?php declare(strict_types = 1);

/**
 * Relationship.php
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
 * Relationship
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
class Relationship extends StandardObject implements IRelationship
{

	use TMetaMember;

	/**
	 * {@inheritDoc}
	 */
	public function getData()
	{
		if ($this->isHasMany()) {
			return $this->getIdentifiers();

		} elseif (!$this->isHasOne()) {
			throw new Exceptions\RuntimeException('No data member or data member is not a valid relationship.');
		}

		return $this->hasIdentifier() ? $this->getIdentifier() : null;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getIdentifier(): ?IResourceIdentifier
	{
		if (!$this->isHasOne()) {
			throw new Exceptions\RuntimeException('No data member or data member is not a valid has-one relationship.');
		}

		$data = $this->{DocumentInterface::KEYWORD_DATA};

		if (!$data) {
			throw new Exceptions\RuntimeException('No resource identifier - relationship is empty.');
		}

		return new ResourceIdentifier($data);
	}

	/**
	 * {@inheritDoc}
	 */
	public function hasIdentifier(): bool
	{
		return is_object($this->{DocumentInterface::KEYWORD_DATA});
	}

	/**
	 * {@inheritDoc}
	 */
	public function isHasOne(): bool
	{
		if (!$this->has(DocumentInterface::KEYWORD_DATA)) {
			return false;
		}

		$data = $this->{DocumentInterface::KEYWORD_DATA};

		return is_null($data) || is_object($data);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getIdentifiers(): IResourceIdentifierCollection
	{
		if (!$this->isHasMany()) {
			throw new Exceptions\RuntimeException('No data member of data member is not a valid has-many relationship.');
		}

		return ResourceIdentifierCollection::create($this->{DocumentInterface::KEYWORD_DATA});
	}

	/**
	 * {@inheritDoc}
	 */
	public function isHasMany(): bool
	{
		return is_array($this->{DocumentInterface::KEYWORD_DATA});
	}

}
