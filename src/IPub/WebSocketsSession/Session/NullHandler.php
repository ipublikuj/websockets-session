<?php
/**
 * NullHandler.php
 *
 * @copyright      More in license.md
 * @license        http://www.ipublikuj.eu
 * @author         Adam Kadlec http://www.ipublikuj.eu
 * @package        iPublikuj:WebSocketSession!
 * @subpackage     Session
 * @since          1.0.0
 *
 * @date           19.02.17
 */

declare(strict_types = 1);

namespace IPub\WebSocketsSession\Session;

use Nette;

/**
 * Null session handler can be used in unit testing or in a situations where persisted sessions are not desired
 *
 * @package        iPublikuj:WebSocketSession!
 * @subpackage     Session
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
class NullHandler implements \SessionHandlerInterface
{
	/**
	 * Implement nette smart magic
	 */
	use Nette\SmartObject;

	/**
	 * {@inheritdoc}
	 */
	public function open($savePath, $sessionName)
	{
		return TRUE;
	}

	/**
	 * {@inheritdoc}
	 */
	public function close()
	{
		return TRUE;
	}

	/**
	 * {@inheritdoc}
	 */
	public function read($sessionId)
	{
		return '';
	}

	/**
	 * {@inheritdoc}
	 */
	public function write($sessionId, $data)
	{
		return TRUE;
	}

	/**
	 * {@inheritdoc}
	 */
	public function destroy($sessionId)
	{
		return TRUE;
	}

	/**
	 * {@inheritdoc}
	 */
	public function gc($maxLifetime)
	{
		return TRUE;
	}
}
