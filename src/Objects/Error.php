<?php declare(strict_types = 1);

/**
 * Error.php
 *
 * @license        More in license.md
 * @copyright      https://www.ipublikuj.eu
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 * @since          1.0.0
 *
 * @date           05.05.18
 */

namespace IPub\JsonAPIDocument\Objects;

use IPub\JsonAPIDocument\Exceptions;
use Neomerx\JsonApi\Contracts\Schema\DocumentInterface;
use Neomerx\JsonApi\Contracts\Schema\ErrorInterface;
use Neomerx\JsonApi\Contracts\Schema\LinkInterface;
use Neomerx\JsonApi\Schema\Link;

class Error extends StandardObject implements ErrorInterface
{

	use TMetaMember;

	/**
	 * {@inheritDoc}
	 */
	public function getId()
	{
		return $this->has(DocumentInterface::KEYWORD_ERRORS_ID) ? $this->get(DocumentInterface::KEYWORD_ERRORS_ID) : null;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getLinks(): ?iterable
	{
		$links = [];

		if ($this->has(DocumentInterface::KEYWORD_LINKS)) {
			foreach ((array) $this->get(DocumentInterface::KEYWORD_LINKS) as $key => $link) {
				if (is_string($link)) {
					$link = new Link(false, $link, true);

				} elseif ($link instanceof IStandardObject) {
					$link = new Link(false, (string) $link->get('href'), true);
				}

				if (!$link instanceof LinkInterface) {
					throw new Exceptions\InvalidArgumentException('Expecting links to contain link objects.');
				}

				$links[$key] = $link;
			}
		}

		return $links;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getTypeLinks(): ?iterable
	{
		return [];
	}

	/**
	 * {@inheritDoc}
	 */
	public function getStatus(): ?string
	{
		return $this->has(DocumentInterface::KEYWORD_ERRORS_STATUS) ? (string) $this->get(DocumentInterface::KEYWORD_ERRORS_STATUS) : null;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getCode(): ?string
	{
		return $this->has(DocumentInterface::KEYWORD_ERRORS_CODE) ? (string) $this->get(DocumentInterface::KEYWORD_ERRORS_CODE) : null;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getTitle(): ?string
	{
		return $this->has(DocumentInterface::KEYWORD_ERRORS_TITLE) ? (string) $this->get(DocumentInterface::KEYWORD_ERRORS_TITLE) : null;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getDetail(): ?string
	{
		return $this->has(DocumentInterface::KEYWORD_ERRORS_DETAIL) ? (string) $this->get(DocumentInterface::KEYWORD_ERRORS_DETAIL) : null;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getSource(): ?array
	{
		return $this->has(DocumentInterface::KEYWORD_ERRORS_SOURCE) ? (array) $this->get(DocumentInterface::KEYWORD_ERRORS_SOURCE) : null;
	}

}
