<?php declare(strict_types = 1);

/**
 * SourceObject.php
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
 * Source object
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
class SourceObject implements ISourceObject
{

	/** @var Objects\IStandardObject */
	private Objects\IStandardObject $data;

	/**
	 * @param Objects\IStandardObject $data
	 */
	public function __construct(Objects\IStandardObject $data)
	{
		if (
			!$data->has(JsonAPIDocument\IDocument::KEYWORD_POINTER)
			&& !$data->has(JsonAPIDocument\IDocument::KEYWORD_PARAMETER)
		) {
			throw new Exceptions\InvalidArgumentException('Provided source object has missing required attribute');
		}

		$this->data = $data;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getPointer(): ?string
	{
		$pointer = $this->data->get(JsonAPIDocument\IDocument::KEYWORD_POINTER);

		if (!is_string($pointer)) {
			throw new Exceptions\RuntimeException('Value of pointer attribute of source object has invalid value.');
		}

		return $pointer;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getParameter(): ?string
	{
		$parameter = $this->data->get(JsonAPIDocument\IDocument::KEYWORD_PARAMETER);

		if (!is_string($parameter)) {
			throw new Exceptions\RuntimeException('Value of parameter attribute of source object has invalid value.');
		}

		return $parameter;
	}

}
