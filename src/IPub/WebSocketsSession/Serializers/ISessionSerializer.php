<?php
/**
 * ISessionSerializer.php
 *
 * @copyright      More in license.md
 * @license        http://www.ipublikuj.eu
 * @author         Adam Kadlec http://www.ipublikuj.eu
 * @package        iPublikuj:WebSocketSession!
 * @subpackage     Serializers
 * @since          1.0.0
 *
 * @date           02.03.17
 */

declare(strict_types = 1);

namespace IPub\WebSocketsSession\Serializers;

interface ISessionSerializer
{
	/**
	 * @param array
	 *
	 * @return string
	 */
	function serialize(array $data) : string;

	/**
	 * @param string
	 *
	 * @return array
	 */
	function unserialize(string $raw) : array;
}
