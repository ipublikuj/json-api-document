<?php declare(strict_types = 1);

/**
 * Error.php
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

use IPub\JsonAPIDocument;

/**
 * Error object
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
class Error extends StandardObject implements IError
{

	/**
	 * {@inheritDoc}
	 */
	public function getId(): ?string
	{
		return $this->has(JsonAPIDocument\IDocument::KEYWORD_ERRORS_ID) ? (string) $this->get(JsonAPIDocument\IDocument::KEYWORD_ERRORS_ID) : null;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getLinks(): ?array
	{
		if ($this->has(JsonAPIDocument\IDocument::KEYWORD_LINKS)) {
			$links = $this->get(JsonAPIDocument\IDocument::KEYWORD_LINKS);

			if ($links instanceof IStandardObject && $links->has(JsonAPIDocument\IDocument::KEYWORD_ERRORS_ABOUT)) {
				return [
					JsonAPIDocument\IDocument::KEYWORD_ERRORS_ABOUT => (string) $links->get(JsonAPIDocument\IDocument::KEYWORD_ERRORS_ABOUT),
				];
			}
		}

		return null;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getStatus(): ?int
	{
		return $this->has(JsonAPIDocument\IDocument::KEYWORD_ERRORS_STATUS) ? (int) $this->get(JsonAPIDocument\IDocument::KEYWORD_ERRORS_STATUS) : null;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getCode(): ?string
	{
		return $this->has(JsonAPIDocument\IDocument::KEYWORD_ERRORS_CODE) ? (string) $this->get(JsonAPIDocument\IDocument::KEYWORD_ERRORS_CODE) : null;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getTitle(): ?string
	{
		return $this->has(JsonAPIDocument\IDocument::KEYWORD_ERRORS_TITLE) ? (string) $this->get(JsonAPIDocument\IDocument::KEYWORD_ERRORS_TITLE) : null;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getDetail(): ?string
	{
		return $this->has(JsonAPIDocument\IDocument::KEYWORD_ERRORS_DETAIL) ? (string) $this->get(JsonAPIDocument\IDocument::KEYWORD_ERRORS_DETAIL) : null;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getSource(): ?array
	{
		return $this->has(JsonAPIDocument\IDocument::KEYWORD_ERRORS_SOURCE) ? (array) $this->get(JsonAPIDocument\IDocument::KEYWORD_ERRORS_SOURCE) : null;
	}

}
