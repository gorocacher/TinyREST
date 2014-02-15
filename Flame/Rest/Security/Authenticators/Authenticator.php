<?php
/**
 * Class Authenticator
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 26.10.13
 */
namespace Flame\Rest\Security\Authenticators;

use Flame\Rest\Security\IAuthenticator;
use Flame\Rest\Security\UnauthorizedRequestException;
use Nette\Object;

abstract class Authenticator extends Object implements IAuthenticator
{

	/**
	 * @return void
	 * @throws \Flame\Rest\Security\UnauthorizedRequestException
	 */
	public function authenticate()
	{
		if(!$this->authRequestData() || !$this->authRequestTimeout()) {
			throw new UnauthorizedRequestException('Unauthorized request.');
		}
	}

	/**
	 * @return bool
	 */
	abstract public function authRequestData();

	/**
	 * @return bool
	 */
	abstract public function authRequestTimeout();
} 