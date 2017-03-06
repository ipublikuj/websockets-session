<?php
/**
 * OnAfterIncomingMessageHandler.php
 *
 * @copyright      More in license.md
 * @license        http://www.ipublikuj.eu
 * @author         Adam Kadlec http://www.ipublikuj.eu
 * @package        iPublikuj:WebSocketSession!
 * @subpackage     Events
 * @since          1.0.0
 *
 * @date           05.03.17
 */

declare(strict_types = 1);

namespace IPub\WebSocketsSession\Events;

use Nette;

use IPub;
use IPub\WebSocketsSession\Session;

use IPub\WebSockets\Entities as WebSocketsEntities;
use IPub\WebSockets\Http as WebSocketsHttp;

/**
 * This component will allow access to session data from your Nette Framework website for each user connected
 *
 * @package        iPublikuj:WebSocketSession!
 * @subpackage     Events
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
final class OnAfterIncomingMessageHandler
{
	/**
	 * Implement nette smart magic
	 */
	use Nette\SmartObject;

	/**
	 * @var Session\SwitchableSession
	 */
	private $session;

	/**
	 * @param Session\SwitchableSession $session
	 */
	public function __construct(
		Session\SwitchableSession $session
	) {
		$this->session = $session;
	}

	/**
	 * @param WebSocketsEntities\Clients\IClient $from
	 * @param WebSocketsHttp\IRequest $httpRequest
	 *
	 * @return void
	 */
	public function __invoke(WebSocketsEntities\Clients\IClient $from, WebSocketsHttp\IRequest $httpRequest)
	{
		if ($this->session instanceof Session\SwitchableSession) {
			$this->session->detach();
		}
	}
}
