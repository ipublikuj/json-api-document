<?php declare(strict_types = 1);

/**
 * IDocument.php
 *
 * @license        More in license.md
 * @copyright      https://www.ipublikuj.eu
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     common
 * @since          1.0.0
 *
 * @date           05.05.18
 */

namespace IPub\JsonAPIDocument;

use IPub\JsonAPIDocument\Exceptions;
use IPub\JsonAPIDocument\Objects;
use Neomerx\JsonApi\Schema\ErrorCollection;

/**
 * Response document interface
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
interface IDocument extends Objects\IStandardObject, Objects\IMetaMember
{

	/**
	 * Get the data member of the document as a standard object or array
	 *
	 * @return Objects\IStandardObject|array|null
	 *
	 * @throws Exceptions\RuntimeException if the data member is not present, or is not an object, array or null
	 */
	public function getData();

	/**
	 * Get the data member as a resource object
	 *
	 * @return Objects\IResourceObject
	 *
	 * @throws Exceptions\RuntimeException if the data member is not an object or is not present
	 */
	public function getResource(): Objects\IResourceObject;

	/**
	 * Get the data member as a resource object collection
	 *
	 * @return Objects\IResourceObjectCollection
	 *
	 * @throws Exceptions\RuntimeException if the data member is not an array or is not present
	 */
	public function getResources(): Objects\IResourceObjectCollection;

	/**
	 * Get the document as a relationship
	 *
	 * @return Objects\IRelationship
	 */
	public function getRelationship(): Objects\IRelationship;

	/**
	 * Get the included member as a resource object collection
	 *
	 * @return Objects\IResourceObjectCollection|null the resources or null if the included member is not present
	 */
	public function getIncluded(): ?Objects\IResourceObjectCollection;

	/**
	 * Get the errors member as an error collection.
	 *
	 * @return ErrorCollection|null the errors or null if the error member is not present
	 */
	public function getErrors(): ?ErrorCollection;

}
