<?php declare(strict_types = 1);

/**
 * IResourceObject.php
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

/**
 * Resource object interface
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
interface IResourceObject extends IStandardObject, IMetaMember
{

	/**
	 * Get the type member
	 *
	 * @return string
	 *
	 * @throws Exceptions\RuntimeException if no type is set, is empty or is not a string
	 */
	public function getType(): string;

	/**
	 * @return string|int
	 *
	 * @throws Exceptions\RuntimeException if no id is set, is not a string or integer, or is an empty string
	 */
	public function getId();

	/**
	 * @return bool
	 */
	public function hasId(): bool;

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
	 */
	public function getAttributes(): IStandardObject;

	/**
	 * @return bool
	 */
	public function hasAttributes(): bool;

	/**
	 * @return IRelationships
	 *
	 * @throws Exceptions\RuntimeException if the relationships member is present and is not an object
	 */
	public function getRelationships(): IRelationships;

	/**
	 * @return bool
	 */
	public function hasRelationships(): bool;

	/**
	 * Get a relationship object by its key
	 *
	 * @param string $key
	 *
	 * @return IRelationship|null the relationship object or null if it is not present
	 *
	 * @throws Exceptions\RuntimeException
	 */
	public function getRelationship(string $key): IRelationship;

}
