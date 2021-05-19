<?php declare(strict_types = 1);

/**
 * ErrorObject.php
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

use IPub\JsonAPIDocument;
use IPub\JsonAPIDocument\Exceptions;
use IPub\JsonAPIDocument\Objects;

/**
 * Error object
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
class ErrorObject implements IErrorObject
{

	/** @var Objects\IStandardObject */
	private Objects\IStandardObject $data;

	public function __construct(Objects\IStandardObject $data)
	{
		$this->data = $data;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getId(): ?string
	{
		$raw = $this->data->get(JsonAPIDocument\IDocument::KEYWORD_ERRORS_ID);

		if (!is_string($raw) && $raw !== null) {
			throw new Exceptions\RuntimeException('Value of id attribute of error object has invalid value.');
		}

		return $raw;
	}

	/**
	 * {@inheritDoc}
	 */
	public function hasLinks(): bool
	{
		return $this->data->has(JsonAPIDocument\IDocument::KEYWORD_LINKS);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getLinks(): ILinkObjectCollection
	{
		$raw = $this->data->get(JsonAPIDocument\IDocument::KEYWORD_LINKS);

		if (!$raw instanceof Objects\IStandardObject && $raw !== null) {
			throw new Exceptions\RuntimeException('Links member is not an object.');
		}

		return LinkObjectCollection::create($raw);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getStatus(): ?int
	{
		$raw = $this->data->get(JsonAPIDocument\IDocument::KEYWORD_ERRORS_STATUS);

		if (!is_numeric($raw) && $raw !== null) {
			throw new Exceptions\RuntimeException('Value of status attribute of error object has invalid value.');
		}

		return $raw !== null ? (int) $raw : null;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getCode(): ?string
	{
		$raw = $this->data->get(JsonAPIDocument\IDocument::KEYWORD_ERRORS_CODE);

		if (!is_string($raw) && $raw !== null) {
			throw new Exceptions\RuntimeException('Value of code attribute of error object has invalid value.');
		}

		return $raw;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getTitle(): ?string
	{
		$raw = $this->data->get(JsonAPIDocument\IDocument::KEYWORD_ERRORS_TITLE);

		if (!is_string($raw) && $raw !== null) {
			throw new Exceptions\RuntimeException('Value of title attribute of error object has invalid value.');
		}

		return $raw;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getDetail(): ?string
	{
		$raw = $this->data->get(JsonAPIDocument\IDocument::KEYWORD_ERRORS_DETAIL);

		if (!is_string($raw) && $raw !== null) {
			throw new Exceptions\RuntimeException('Value of detail attribute of error object has invalid value.');
		}

		return $raw;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getSource(): ?ISourceObject
	{
		$raw = $this->data->get(JsonAPIDocument\IDocument::KEYWORD_ERRORS_SOURCE);

		if (!$raw instanceof Objects\IStandardObject && $raw !== null) {
			throw new Exceptions\RuntimeException('Meta member is not an object.');
		}

		return $raw !== null ? new SourceObject($raw) : null;
	}

	/**
	 * {@inheritDoc}
	 */
	public function hasMeta(): bool
	{
		return $this->data->has(JsonAPIDocument\IDocument::KEYWORD_META);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getMeta(): IMetaObjectCollection
	{
		$raw = $this->data->get(JsonAPIDocument\IDocument::KEYWORD_META);

		if (!$raw instanceof Objects\IStandardObject && $raw !== null) {
			throw new Exceptions\RuntimeException('Meta member is not an object.');
		}

		return MetaObjectCollection::create($raw);
	}

}
