<?php
/**
 * OnClientConnectedHandler.php
 *
 * @copyright      More in license.md
 * @license        http://www.ipublikuj.eu
 * @author         Adam Kadlec http://www.ipublikuj.eu
 * @package        iPublikuj:WebSocketSession!
 * @subpackage     Events
 * @since          1.0.0
 *
 * @date           19.02.17
 */

declare(strict_types = 1);

namespace IPub\WebSocketsSession\Events;

use Nette;
use Nette\Security as NS;

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
final class OnClientConnectedHandler
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
	 * @var NS\User
	 */
	private $user;

	/**
	 * @param Session\SwitchableSession $session
	 * @param NS\User $user
	 */
	public function __construct(
		Session\SwitchableSession $session,
		NS\User $user
	) {
		$this->session = $session;
		$this->user = $user;
	}

	/**
	 * @param WebSocketsEntities\Clients\IClient $client
	 * @param WebSocketsHttp\IRequest $httpRequest
	 *
	 * @return void
	 */
	public function __invoke(WebSocketsEntities\Clients\IClient $client, WebSocketsHttp\IRequest $httpRequest)
	{
		$client->setUser(clone $this->user);
	}
}
