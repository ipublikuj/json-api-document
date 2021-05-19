<?php declare(strict_types = 1);

/**
 * IRelationship.php
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

use IPub\JsonAPIDocument\Exceptions;

/**
 * Relationship interface
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
interface IRelationship extends IStandardObject, IMetaMember
{

	/**
	 * Get the data member as a correctly casted object
	 *
	 * If this is a has-one relationship, a ResourceIdentifierInterface object or null will be returned. If it is
	 * a has-many relationship, a ResourceIdentifierCollectionInterface will be returned
	 *
	 * @return IResourceIdentifier|IResourceIdentifierCollection|null
	 *
	 * @throws Exceptions\RuntimeException if the value for the data member is not a valid relationship value
	 */
	public function getData();

	/**
	 * Is this a has-many relationship?
	 *
	 * @return bool
	 */
	public function isHasMany(): bool;

	/**
	 * Is this a has-one relationship?
	 *
	 * @return bool
	 */
	public function isHasOne(): bool;

	/**
	 * Get the data member as a has-many relationship
	 *
	 * @return IResourceIdentifierCollection
	 *
	 * @throws Exceptions\RuntimeException if the data member is not an array
	 */
	public function getIdentifiers(): IResourceIdentifierCollection;

	/**
	 * Get the data member as a resource identifier (has-one relationship)
	 *
	 * @return IResourceIdentifier
	 *
	 * @throws Exceptions\RuntimeException if the data member is not a resource identifier
	 */
	public function getIdentifier(): ?IResourceIdentifier;

	/**
	 * Is the data member a resource identifier?
	 *
	 * @return bool
	 */
	public function hasIdentifier(): bool;

}
