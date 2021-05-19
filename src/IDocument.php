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
interface IDocument
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

	// Reserved keyword
	public const KEYWORD_POINTER = 'pointer';

	// Reserved keyword
	public const KEYWORD_PARAMETER = 'parameter';

	// Include path separator
	public const PATH_SEPARATOR = '.';

	/**
	 * @return Objects\IResourceObject|null
	 */
	public function getResource(): ?Objects\IResourceObject;

	/**
	 * @return Objects\IResourceObjectCollection<int, Objects\IResourceObject>
	 */
	public function getResources(): Objects\IResourceObjectCollection;

	/**
	 * @return Objects\IStandardObject|Objects\IStandardObjectCollection<int, Objects\IStandardObject>|null
	 */
	public function getData();

	/**
	 * @return bool
	 */
	public function hasLinks(): bool;

	/**
	 * @return Objects\ILinkObjectCollection<string, Objects\ILinkObject|string>
	 */
	public function getLinks(): Objects\ILinkObjectCollection;

	/**
	 * @return bool
	 */
	public function hasMeta(): bool;

	/**
	 * @return Objects\IMetaObjectCollection<string, Objects\IMetaObject>
	 */
	public function getMeta(): Objects\IMetaObjectCollection;

	/**
	 * @return bool
	 */
	public function hasIncluded(): bool;

	/**
	 * @return Objects\IResourceObjectCollection<int, Objects\IResourceObject>
	 */
	public function getIncluded(): Objects\IResourceObjectCollection;

	/**
	 * @return bool
	 */
	public function hasErrors(): bool;

	/**
	 * @return Objects\IErrorObjectCollection<int, Objects\IErrorObject>
	 */
	public function getErrors(): Objects\IErrorObjectCollection;

}
