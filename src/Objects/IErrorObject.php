<?php declare(strict_types = 1);

/**
 * IErrorObject.php
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
 * Error object interface
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
interface IErrorObject
{

	/**
	 * @return string|null
	 */
	public function getId(): ?string;

	/**
	 * @return bool
	 */
	public function hasLinks(): bool;

	/**
	 * @return ILinkObjectCollection
	 */
	public function getLinks(): ILinkObjectCollection;

	/**
	 * @return int|null
	 */
	public function getStatus(): ?int;

	/**
	 * @return string|null
	 */
	public function getCode(): ?string;

	/**
	 * @return string|null
	 */
	public function getTitle(): ?string;

	/**
	 * @return string|null
	 */
	public function getDetail(): ?string;

	/**
	 * @return ISourceObject|null
	 */
	public function getSource(): ?ISourceObject;

	/**
	 * @return bool
	 */
	public function hasMeta(): bool;

	/**
	 * @return IMetaObjectCollection
	 */
	public function getMeta(): IMetaObjectCollection;

}
