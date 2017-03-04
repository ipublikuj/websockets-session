<?php
/**
 * SessionPhpSerializer.php
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

class SessionPhpSerializer implements ISessionSerializer
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
		$preSerialized = [];
		$serialized = '';

		if (count($data)) {
			foreach ($data as $bucket => $bucketData) {
				$preSerialized[] = $bucket . '|' . \serialize($bucketData);
			}

			$serialized = implode('', $preSerialized);
		}

		return $serialized;
	}

	/**
	 * @link http://ca2.php.net/manual/en/function.session-decode.php#108037 Code from this comment on php.net
	 *
	 * {@inheritdoc}
	 *
	 * @throws \UnexpectedValueException If there is a problem parsing the data
	 */
	public function unserialize(string $raw) : array
	{
		$returnData = [];
		$offset = 0;

		while ($offset < strlen($raw)) {
			if (!strstr(substr($raw, $offset), '|')) {
				throw new Exceptions\UnexpectedValueException(sprintf('Invalid data, remaining: %s', substr($raw, $offset)));
			}

			$pos = strpos($raw, '|', $offset);
			$num = $pos - $offset;
			$varname = substr($raw, $offset, $num);
			$offset += $num + 1;
			$data = unserialize(substr($raw, $offset));

			$returnData[$varname] = $data;
			$offset += strlen(serialize($data));
		}

		return $returnData;
	}
}
