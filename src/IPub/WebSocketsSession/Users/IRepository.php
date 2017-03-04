<?php
/**
 * IRepository.php
 *
 * @copyright      More in license.md
 * @license        http://www.ipublikuj.eu
 * @author         Adam Kadlec http://www.ipublikuj.eu
 * @package        iPublikuj:WebSocketSession!
 * @subpackage     Users
 * @since          1.0.0
 *
 * @date           24.02.17
 */

declare(strict_types = 1);

namespace IPub\WebSocketsSession\Users;

use Nette\Security as NS;

use IPub;
use IPub\WebSockets\Entities as WebSocketsEntities;

/**
 * Connected users repository interface
 *
 * @package        iPublikuj:WebSocketSession!
 * @subpackage     Users
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
interface IRepository
{
	/**
	 * @param WebSocketsEntities\Clients\IClient $client
	 *
	 * @return NS\User|NULL
	 */
	function getUser(WebSocketsEntities\Clients\IClient $client);

	/**
	 * @param string $username
	 *
	 * @return array|bool
	 */
	function findByUsername(string $username);

	/**
	 * @param mixed $userId
	 *
	 * @return array|bool
	 */
	function findById($userId);

	/**
	 * @param bool $anonymous
	 *
	 * @return array|bool
	 */
	function findAll(bool $anonymous = FALSE);

	/**
	 * @param array $roles
	 *
	 * @return array|bool
	 */
	function findByRoles(array $roles);
}
