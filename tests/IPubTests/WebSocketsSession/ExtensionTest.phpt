<?php
/**
 * Test: IPub\WebSocketsSession\Extension
 * @testCase
 *
 * @copyright      More in license.md
 * @license        http://www.ipublikuj.eu
 * @author         Adam Kadlec http://www.ipublikuj.eu
 * @package        iPublikuj:WebSocketsSession!
 * @subpackage     Tests
 * @since          1.0.0
 *
 * @date           02.03.17
 */

declare(strict_types = 1);

namespace IPubTests\WebSocketsSession;

use Nette;

use Tester;
use Tester\Assert;

use IPub;
use IPub\WebSocketsSession;

require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'bootstrap.php';
require __DIR__ . DS . 'libraries' . DS . 'Application.php';

/**
 * WebSockets session extension container test case
 *
 * @package        iPublikuj:WebSocketsSession!
 * @subpackage     Tests
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
class ExtensionTest extends Tester\TestCase
{
	public function testCompilersServices()
	{
		$dic = $this->createContainer();

		Assert::true($dic->getService('webSocketsSession.serializer.session') instanceof IPub\WebSocketsSession\Serializers\ISessionSerializer);

		Assert::true($dic->getService('webSocketsSession.users.repository') instanceof IPub\WebSocketsSession\Users\IRepository);

		Assert::true($dic->getService('session') instanceof IPub\WebSocketsSession\Session\SwitchableSession);

		Assert::true($dic->getService('webSocketsSession.events.onClientConnected') instanceof IPub\WebSocketsSession\Events\OnClientConnectedHandler);
		Assert::true($dic->getService('webSocketsSession.events.onClientDisconnected') instanceof IPub\WebSocketsSession\Events\OnClientDisconnectedHandler);
		Assert::true($dic->getService('webSocketsSession.events.onIncomingMessage') instanceof IPub\WebSocketsSession\Events\OnIncomingMessageHandler);
	}

	/**
	 * @return Nette\DI\Container
	 */
	protected function createContainer() : Nette\DI\Container
	{
		$config = new Nette\Configurator();
		$config->setTempDirectory(TEMP_DIR);

		$config->addConfig(__DIR__ . DS . 'files' . DS . 'config.neon');

		return $config->createContainer();
	}
}

\run(new ExtensionTest());
