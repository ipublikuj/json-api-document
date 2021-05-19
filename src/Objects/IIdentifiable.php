<?php declare(strict_types = 1);

/**
 * IResourceObject.php
 *
 * @license        More in LICENSE.md
 * @copyright      https://www.ipublikuj.eu
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 * @since          0.2.0
 *
 * @date           18.05.21
 */

namespace IPub\JsonAPIDocument\Objects;

use IPub\JsonAPIDocument\Exceptions;

/**
 * Identifiable object interface
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
interface IIdentifiable extends IStandardObject
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

}
