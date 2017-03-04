<?php
/**
 * SessionPhpBinarySerializer.php
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

use Nette;

use IPub;
use IPub\WebSocketsSession\Exceptions;

class SessionPhpBinarySerializer implements ISessionSerializer
{
	/**
	 * Implement nette smart magic
	 */
	use Nette\SmartObject;

	/**
	 * {@inheritdoc}
	 */
	public function serialize(array $data) : string
	{
		throw new Exceptions\RuntimeException('Serialize PhpHandler:serialize code not written yet, write me!');
	}

	/**
	 * {@inheritdoc}
	 *
	 * @link http://ca2.php.net/manual/en/function.session-decode.php#108037 Code from this comment on php.net
	 */
	public function unserialize(string $raw) : array
	{
		$returnData = [];
		$offset = 0;

		while ($offset < strlen($raw)) {
			$num = ord($raw[$offset]);
			$offset += 1;
			$varname = substr($raw, $offset, $num);
			$offset += $num;
			$data = unserialize(substr($raw, $offset));

			$returnData[$varname] = $data;
			$offset += strlen(serialize($data));
		}

		return $returnData;
	}
}
