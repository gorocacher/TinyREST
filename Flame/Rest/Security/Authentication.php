<?php
/**
 * Class Authentication
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 26.10.13
 */
namespace Flame\Rest\Security;

use Flame\Rest\Request\Parameters;
use Nette\InvalidStateException;
use Nette\Object;

class Authentication extends Object
{

	/** @var  IAuthenticator */
	private $authenticator;

	/**
	 * @param IAuthenticator $authenticator
	 * @return $this
	 */
	public function setAuthenticator(IAuthenticator $authenticator)
	{
		$this->authenticator = $authenticator;
		return $this;
	}

	/**
	 * @param Parameters $params
	 * @return bool
	 * @throws \Nette\InvalidStateException
	 */
	public function authenticate(Parameters $params)
	{
		if($this->authenticator === null) {
			throw new InvalidStateException('No IAuthenticator found in class "' . __CLASS__ . '". Please set one first.');
		}

		return $this->authenticator->authenticate($params);
	}

} 