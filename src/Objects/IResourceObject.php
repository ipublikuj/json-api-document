<?php declare(strict_types = 1);

/**
 * IResourceObject.php
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
 * Resource object interface
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
interface IResourceObject extends IStandardObject, IIdentifiable, IMetaMember
{

	/**
	 * Get the type and id members as a resource identifier object
	 *
	 * @return IResourceIdentifier
	 *
	 * @throws Exceptions\RuntimeException if the type and/or id members are not valid
	 */
	public function getIdentifier(): IResourceIdentifier;

	/**
	 * @return IStandardObject
	 *
	 * @throws Exceptions\RuntimeException if the attributes member is present and is not an object
	 *
	 * @phpstan-return IStandardObject<string, mixed>
	 */
	public function getAttributes(): IStandardObject;

	/**
	 * @return bool
	 */
	public function hasAttributes(): bool;

	/**
	 * Get a relationship object by its key
	 *
	 * @param string $key
	 *
	 * @return IRelationship|null the relationship object or null if it is not present
	 *
	 * @throws Exceptions\RuntimeException
	 *
	 * @phpstan-return IRelationship<string, IStandardObject>
	 */
	public function getRelationship(string $key): ?IRelationship;

	/**
	 * @return IRelationshipCollection
	 *
	 * @throws Exceptions\RuntimeException if the relationships member is not present or is not an object
	 *
	 * @phpstan-return IRelationshipCollection<IRelationship<string, IStandardObject>>
	 */
	public function getRelationships(): IRelationshipCollection;

	/**
	 * @return bool
	 */
	public function hasRelationships(): bool;

}
