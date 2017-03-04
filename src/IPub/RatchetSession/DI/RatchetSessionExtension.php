<?php
/**
 * WebSocketsSessionExtension.php
 *
 * @copyright      More in license.md
 * @license        http://www.ipublikuj.eu
 * @author         Adam Kadlec http://www.ipublikuj.eu
 * @package        iPublikuj:WebSocketSession!
 * @subpackage     DI
 * @since          1.0.0
 *
 * @date           01.03.17
 */

declare(strict_types = 1);

namespace IPub\WebSocketsSession\DI;

use Nette;
use Nette\DI;
use Nette\Http;

use IPub;
use IPub\WebSocketsSession;
use IPub\WebSocketsSession\Events;
use IPub\WebSocketsSession\Serializers;
use IPub\WebSocketsSession\Session;
use IPub\WebSocketsSession\Users;

/**
 * WebSockets session extension container
 *
 * @package        iPublikuj:WebSocketSession!
 * @subpackage     DI
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 *
 * @method DI\ContainerBuilder getContainerBuilder()
 * @method array getConfig(array $default)
 * @method string prefix($id)
 */
final class WebSocketsSessionExtension extends DI\CompilerExtension
{
	/**
	 * @var array
	 */
	private $defaults = [
		'enable' => TRUE,
	];

	/**
	 * {@inheritdoc}
	 */
	public function loadConfiguration()
	{
		parent::loadConfiguration();

		/** @var DI\ContainerBuilder $builder */
		$builder = $this->getContainerBuilder();
		/** @var array $configuration */
		$configuration = $this->getConfig($this->defaults);

		if ($configuration['enable']) {
			/**
			 * SESSION
			 */

			$builder->addDefinition($this->prefix('serializer.session'))
				->setClass(Serializers\ISessionSerializer::class)
				->setFactory(Serializers\SessionSerializerFactory::class . '::create');

			/**
			 * USERS
			 */

			$builder->addDefinition($this->prefix('users.repository'))
				->setClass(Users\Repository::class);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function beforeCompile()
	{
		parent::beforeCompile();

		/** @var DI\ContainerBuilder $builder */
		$builder = $this->getContainerBuilder();
		/** @var array $configuration */
		$configuration = $this->getConfig($this->defaults);

		if ($configuration['enable']) {
			// Sessions switcher
			$original = $builder->getDefinition($originalSessionServiceName = $builder->getByType(Http\Session::class) ?: 'session');

			$builder->removeDefinition($originalSessionServiceName);

			$builder->addDefinition($this->prefix('session.original'), $original)
				->setAutowired(FALSE);

			$switchableSession = $builder->addDefinition($originalSessionServiceName)
				->setClass(Http\Session::class)
				->setFactory(Session\SwitchableSession::class, [$this->prefix('@session.original')]);

			/**
			 * EVENTS
			 */

			$builder->addDefinition($this->prefix('events.onClientConnected'))
				->setClass(Events\OnClientConnectedHandler::class)
				->setArguments(['session' => $switchableSession]);

			$builder->addDefinition($this->prefix('events.onClientDisconnected'))
				->setClass(Events\OnClientDisconnectedHandler::class)
				->setArguments(['session' => $switchableSession]);

			$builder->addDefinition($this->prefix('events.onIncomingMessage'))
				->setClass(Events\OnIncomingMessageHandler::class)
				->setArguments(['session' => $switchableSession]);

			$serverWrapper = $builder->getDefinitionByType(IPub\WebSockets\Server\Wrapper::class);
			$serverWrapper->addSetup('$service->onClientConnected[] = ?', ['@' . $this->prefix('events.onClientConnected')]);
			$serverWrapper->addSetup('$service->onClientDisconnected[] = ?', ['@' . $this->prefix('events.onClientDisconnected')]);
			$serverWrapper->addSetup('$service->onIncomingMessage[] = ?', ['@' . $this->prefix('events.onIncomingMessage')]);
		}
	}

	/**
	 * @param Nette\Configurator $config
	 * @param string $extensionName
	 *
	 * @return void
	 */
	public static function register(Nette\Configurator $config, string $extensionName = 'webSocketsSession')
	{
		$config->onCompile[] = function (Nette\Configurator $config, DI\Compiler $compiler) use ($extensionName) {
			$compiler->addExtension($extensionName, new WebSocketsSessionExtension());
		};
	}
}
