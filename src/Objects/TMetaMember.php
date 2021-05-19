<?php declare(strict_types = 1);

/**
 * TMetaMember.php
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
 * Meta member trait
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
trait TMetaMember
{

	/**
	 * Get the meta member of the document.
	 *
	 * @return IStandardObject<mixed>
	 *
	 * @throws Exceptions\RuntimeException if the meta member is present and is not an object or null
	 */
	public function getMeta(): IStandardObject
	{
		$meta = $this->hasMeta() ? $this->get(JsonAPIDocument\IDocument::KEYWORD_META) : new StandardObject();

		if ($meta === null || !$meta instanceof IStandardObject) {
			throw new Exceptions\RuntimeException('Data member is not an object.');
		}

		return $meta;
	}

	/**
	 * @return bool
	 */
	public function hasMeta(): bool
	{
		return $this->has(JsonAPIDocument\IDocument::KEYWORD_META);
	}

}
