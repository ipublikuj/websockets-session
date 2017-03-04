<?php
/**
 * Repository.php
 *
 * @copyright      More in license.md
 * @license        http://www.ipublikuj.eu
 * @author         Adam Kadlec http://www.ipublikuj.eu
 * @package        iPublikuj:WebSocketSession!
 * @subpackage     Users
 * @since          1.0.0
 *
 * @date           14.02.17
 */

declare(strict_types = 1);

namespace IPub\WebSocketsSession\Users;

use Nette;

use IPub;
use IPub\WebSockets\Clients as WebSocketsClients;
use IPub\WebSockets\Entities as WebSocketsEntities;
use IPub\WebSockets\Exceptions as WebSocketsExceptions;

/**
 * Connected users repository
 *
 * @package        iPublikuj:WebSocketSession!
 * @subpackage     Users
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
final class Repository implements IRepository
{
	/**
	 * Implement nette smart magic
	 */
	use Nette\SmartObject;

	/**
	 * @var WebSocketsClients\IStorage
	 */
	private $storage;

	/**
	 * @param WebSocketsClients\IStorage $storage
	 */
	public function __construct(WebSocketsClients\IStorage $storage)
	{
		$this->storage = $storage;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getUser(WebSocketsEntities\Clients\IClient $client)
	{
		try {
			return $client->getUser();

		} catch (WebSocketsExceptions\ClientNotFoundException $ex) {
			return NULL;
		}
	}

	/**
	 * @param string $username
	 *
	 * @return array|bool
	 */
	public function findByUsername(string $username)
	{
		/** @var WebSocketsEntities\Clients\IClient $client */
		foreach ($this->storage as $client) {
			$user = $client->getUser();

			if (!$user || !$user->isLoggedIn()) {
				continue;
			}

			if (method_exists($user, 'getUsername') && $user->getUsername() === $username) {
				return [
					'user'   => $client,
					'client' => $client
				];
			}
		}

		return FALSE;
	}

	/**
	 * @param mixed $userId
	 *
	 * @return array|bool
	 */
	public function findById($userId)
	{
		/** @var WebSocketsEntities\Clients\IClient $client */
		foreach ($this->storage as $client) {
			$user = $client->getUser();

			if (!$user || !$user->isLoggedIn()) {
				continue;
			}

			if ($user->getId() === $userId) {
				return [
					'user'   => $client,
					'client' => $client
				];
			}
		}

		return FALSE;
	}

	/**
	 * @param bool $anonymous
	 *
	 * @return array|bool
	 */
	public function findAll(bool $anonymous = FALSE)
	{
		$results = [];

		/** @var WebSocketsEntities\Clients\IClient $client */
		foreach ($this->storage as $client) {
			$user = $client->getUser();

			if ($anonymous !== TRUE && (!$user->isLoggedIn() || $user === NULL)) {
				continue;
			}

			$results[] = [
				'user'   => $user,
				'client' => $client,
			];
		}

		return empty($results) ? FALSE : $results;
	}

	/**
	 * @param array $roles
	 *
	 * @return array|bool
	 */
	public function findByRoles(array $roles)
	{
		$results = [];

		/** @var WebSocketsEntities\Clients\IClient $client */
		foreach ($this->storage as $client) {
			$user = $client->getUser();

			foreach ($user->getRoles() as $role) {
				if (in_array($role, $roles)) {
					$results[] = [
						'user'   => $user,
						'client' => $client,
					];

					continue 1;
				}
			}
		}

		return empty($results) ? FALSE : $results;
	}
}
