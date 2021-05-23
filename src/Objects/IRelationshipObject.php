<?php declare(strict_types = 1);

/**
 * IRelationshipObject.php
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

/**
 * Relationship object interface
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
interface IRelationshipObject
{

	/**
	 * @return bool
	 */
	public function hasLinks(): bool;

	/**
	 * @phpstan-return ILinkObjectCollection
	 *
	 * @return ILinkObjectCollection<string, ILinkObject|string>
	 */
	public function getLinks(): ILinkObjectCollection;

	/**
	 * @return bool
	 */
	public function hasData(): bool;

	/**
	 * @return IResourceIdentifierCollection
	 *
	 * @phpstan-return IResourceIdentifierCollection<int, IResourceIdentifierObject>|IResourceIdentifierObject|null
	 */
	public function getData();

	/**
	 * @return bool
	 */
	public function hasMeta(): bool;

	/**
	 * @return IMetaObjectCollection
	 *
	 * @phpstan-return IMetaObjectCollection<string, IMetaObject>
	 */
	public function getMeta(): IMetaObjectCollection;

	/**
	 * @return bool
	 */
	public function isHasMany(): bool;

	/**
	 * @return bool
	 */
	public function isHasOne(): bool;

	/**
	 * @return IResourceIdentifierCollection
	 *
	 * @phpstan-return IResourceIdentifierCollection<int, IResourceIdentifierObject>
	 */
	public function getIdentifiers(): IResourceIdentifierCollection;

	/**
	 * @return bool
	 */
	public function hasIdentifier(): bool;

	/**
	 * @return IResourceIdentifierObject
	 */
	public function getIdentifier(): IResourceIdentifierObject;

}
