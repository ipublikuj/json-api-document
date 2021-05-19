<?php declare(strict_types = 1);

/**
 * IResourceIdentifierObject.php
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
 * Resource identifier interface
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
interface IResourceIdentifierObject
{

	/**
	 * @return string
	 */
	public function getId(): string;

	/**
	 * @return string
	 */
	public function getType(): string;

	/**
	 * @param string|string[] $typeOrTypes
	 *
	 * @return bool
	 */
	public function isType($typeOrTypes): bool;

	/**
	 * From the supplied array, return the value where the current type is the key
	 *
	 * @param string[] $types
	 *
	 * @return string
	 *
	 * @throws Exceptions\RuntimeException if the current type is not one of those in the supplied $types
	 */
	public function mapType(array $types): string;

	/**
	 * @param IResourceIdentifierObject $identifier
	 *
	 * @return bool
	 */
	public function isSame(IResourceIdentifierObject $identifier): bool;

	/**
	 * @return string
	 */
	public function toString(): string;

}
