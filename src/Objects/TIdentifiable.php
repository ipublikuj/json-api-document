<?php declare(strict_types = 1);

/**
 * TIdentifiable.php
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
use IPub\JsonAPIDocument\Exceptions;

/**
 * Identifiable trait
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
trait TIdentifiable
{

	/**
	 * @return string
	 *
	 * @throws Exceptions\RuntimeException if the type member is not present, or is not a string, or is an empty string
	 */
	public function getType(): string
	{
		if (!$this->has(JsonAPIDocument\IDocument::KEYWORD_TYPE)) {
			throw new Exceptions\RuntimeException('Type member not present.');
		}

		$type = $this->get(JsonAPIDocument\IDocument::KEYWORD_TYPE);

		if (!is_string($type) || $type === '') {
			throw new Exceptions\RuntimeException('Type member is not a string, or is empty.');
		}

		return $type;
	}

	/**
	 * @return bool
	 */
	public function hasType(): bool
	{
		return $this->has(JsonAPIDocument\IDocument::KEYWORD_TYPE);
	}

	/**
	 * @return string
	 *
	 * @throws Exceptions\RuntimeException if the id member is not present, or is not a string/int, or is an empty string
	 */
	public function getId(): string
	{
		if (!$this->has(JsonAPIDocument\IDocument::KEYWORD_ID)) {
			throw new Exceptions\RuntimeException('Id member not present.');
		}

		$id = $this->get(JsonAPIDocument\IDocument::KEYWORD_ID);

		if (!is_string($id)) {
			throw new Exceptions\RuntimeException('Id member is not a string.');
		}

		if ($id === '') {
			throw new Exceptions\RuntimeException('Id member is an empty string.');
		}

		return $id;
	}

	/**
	 * @return bool
	 */
	public function hasId(): bool
	{
		return $this->has(JsonAPIDocument\IDocument::KEYWORD_ID);
	}

}
