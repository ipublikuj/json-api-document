<?php declare(strict_types = 1);

/**
 * IDocument.php
 *
 * @license        More in LICENSE.md
 * @copyright      https://www.ipublikuj.eu
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     common
 * @since          0.0.1
 *
 * @date           05.05.18
 */

namespace IPub\JsonAPIDocument;

/**
 * Response document interface
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
interface IDocument extends Objects\IStandardObject
{

	// Reserved keyword
	public const KEYWORD_LINKS = 'links';

	// Reserved keyword
	public const KEYWORD_HREF = 'href';

	// Reserved keyword
	public const KEYWORD_RELATIONSHIPS = 'relationships';

	// Reserved keyword
	public const KEYWORD_SELF = 'self';

	// Reserved keyword
	public const KEYWORD_FIRST = 'first';

	// Reserved keyword
	public const KEYWORD_LAST = 'last';

	// Reserved keyword
	public const KEYWORD_NEXT = 'next';

	// Reserved keyword
	public const KEYWORD_PREV = 'prev';

	// Reserved keyword
	public const KEYWORD_RELATED = 'related';

	// Reserved keyword
	public const KEYWORD_TYPE = 'type';

	// Reserved keyword
	public const KEYWORD_ID = 'id';

	// Reserved keyword
	public const KEYWORD_ATTRIBUTES = 'attributes';

	// Reserved keyword
	public const KEYWORD_META = 'meta';

	// Reserved keyword
	public const KEYWORD_ALIASES = 'aliases';

	// Reserved keyword
	public const KEYWORD_PROFILE = 'profile';

	// Reserved keyword
	public const KEYWORD_DATA = 'data';

	// Reserved keyword
	public const KEYWORD_INCLUDED = 'included';

	// Reserved keyword
	public const KEYWORD_JSON_API = 'jsonapi';

	// Reserved keyword
	public const KEYWORD_VERSION = 'version';

	// Reserved keyword
	public const KEYWORD_ERRORS = 'errors';

	// Reserved keyword
	public const KEYWORD_ERRORS_ID = 'id';

	// Reserved keyword
	public const KEYWORD_ERRORS_TYPE = 'type';

	// Reserved keyword
	public const KEYWORD_ERRORS_STATUS = 'status';

	// Reserved keyword
	public const KEYWORD_ERRORS_CODE = 'code';

	// Reserved keyword
	public const KEYWORD_ERRORS_TITLE = 'title';

	// Reserved keyword
	public const KEYWORD_ERRORS_DETAIL = 'detail';

	// Reserved keyword
	public const KEYWORD_ERRORS_META = 'meta';

	// Reserved keyword
	public const KEYWORD_ERRORS_SOURCE = 'source';

	// Reserved keyword
	public const KEYWORD_ERRORS_ABOUT = 'about';

	// Include path separator
	public const PATH_SEPARATOR = '.';

	/**
	 * Get the data member of the document as a standard object or array
	 *
	 * @return Objects\IStandardObject|Objects\IStandardObjectCollection|null
	 *
	 * @throws Exceptions\RuntimeException if the data member is not present, or is not an object, array or null
	 */
	public function getData();

	/**
	 * Get the data single member of the document as a resource object
	 *
	 * @return Objects\IResourceObject|null
	 *
	 * @throws Exceptions\RuntimeException if the data member is not present, or is not an object or null
	 */
	public function getResource(): ?Objects\IResourceObject;

	/**
	 * Get the data members of the document as a resource object collection
	 *
	 * @return Objects\IResourceObjectCollection
	 *
	 * @throws Exceptions\RuntimeException if the data member is not present, or is not an array
	 */
	public function getResources(): Objects\IResourceObjectCollection;

	/**
	 * Get the links member of the document as a standard object
	 *
	 * @return Objects\IStandardObject|null
	 *
	 * @throws Exceptions\RuntimeException if the links member is not an object or null
	 */
	public function getLinks(): ?Objects\IStandardObject;

	/**
	 * Get the meta member of the document as a standard object
	 *
	 * @return Objects\IStandardObject|null
	 *
	 * @throws Exceptions\RuntimeException if the meta member is not an object or null
	 */
	public function getMeta(): ?Objects\IStandardObject;

	/**
	 * Get the included member as a resource object collection
	 *
	 * @return Objects\IResourceObjectCollection|null the resources or null if the included member is not present
	 *
	 * @throws Exceptions\RuntimeException if the included member is not an array
	 */
	public function getIncluded(): ?Objects\IResourceObjectCollection;

	/**
	 * Get the errors member as an error collection.
	 *
	 * @return Objects\IErrorCollection|null the errors or null if the error member is not present
	 */
	public function getErrors(): ?Objects\IErrorCollection;

}
