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
 * @date           19.05.21
 */

namespace IPub\JsonAPIDocument\Objects;

use IPub\JsonAPIDocument\Objects;

/**
 * Resource interface
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
interface IResourceObject
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
	 * @return bool
	 */
	public function hasAttributes(): bool;

	/**
	 * @return Objects\IStandardObject
	 */
	public function getAttributes(): Objects\IStandardObject;

	/**
	 * @return bool
	 */
	public function hasRelationships(): bool;

	/**
	 * @return IRelationshipObjectCollection
	 */
	public function getRelationships(): IRelationshipObjectCollection;

	/**
	 * @return bool
	 */
	public function hasLinks(): bool;

	/**
	 * @return ILinkObjectCollection
	 */
	public function getLinks(): ILinkObjectCollection;

	/**
	 * @return bool
	 */
	public function hasMeta(): bool;

	/**
	 * @return IMetaObjectCollection
	 */
	public function getMeta(): IMetaObjectCollection;

}
