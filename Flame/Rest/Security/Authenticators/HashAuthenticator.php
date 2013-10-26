<?php
/**
 * Class HashAuthenticator
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 26.10.13
 */
namespace Flame\Rest\Security\Authenticators;

use Flame\Rest\Request\Parameters;
use Flame\Rest\Security\IUserHash;
use Flame\Rest\Security\Storage\IAuthStorage;
use Flame\Rest\Security\IUser;
use Flame\Rest\Security\UnauthorizedRequestException;
use Nette\InvalidStateException;

class HashAuthenticator extends Authenticator
{

	/** @var  IUser */
	private $user;

	/** @var \Flame\Rest\Security\Storage\IAuthStorage  */
	private $authStorage;

	/** @var \Flame\Rest\Security\IUserHash  */
	private $userHash;

	/**
	 * @param IAuthStorage $authStorage
	 * @param IUserHash $userHash
	 */
	function __construct(IAuthStorage $authStorage, IUserHash $userHash)
	{
		$this->authStorage = $authStorage;
		$this->userHash = $userHash;
	}

	/**
	 * @return IUser
	 * @throws \Nette\InvalidStateException
	 */
	protected function getUser()
	{
		if($this->user === null) {
			$this->user = $this->authStorage->findUserByHash($this->userHash->getHash());
			if($this->user !== null && !$this->user instanceof IUser) {
				throw new InvalidStateException('User object must be instance of Flame\Rest\Security\IUser');
			}
		}

		return $this->user;
	}

	/**
	 * @param Parameters $params
	 * @return bool|void
	 * @throws \Flame\Rest\Security\UnauthorizedRequestException
	 */
	public function authRequestData(Parameters $params)
	{
		if($this->isUserLogged() !== true) {
			throw new UnauthorizedRequestException('User is not logged.');
		}
	}

	/**
	 * @param Parameters $params
	 * @return bool
	 */
	public function authRequestTimeout(Parameters $params)
	{
		// TODO: Implement authRequestTimeout() method.
	}

	/**
	 * @return bool
	 */
	protected function isUserLogged()
	{
		return (bool) $this->getUser();
	}
}