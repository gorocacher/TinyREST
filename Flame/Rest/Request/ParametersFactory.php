<?php
/**
 * Class ParametersFactory
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 26.10.13
 */
namespace Flame\Rest\Request;

use Nette\Http\Request;
use Nette\Object;

class ParametersFactory extends Object implements IParametersFactory
{

	/** @var \Nette\Http\Request  */
	private $httpRequest;

	/**
	 * @param Request $httpRequest
	 */
	function __construct(Request $httpRequest)
	{
		$this->httpRequest = $httpRequest;
	}

	/**
	 * @param array $params
	 * @return Parameters
	 */
	public function create(array $params = array())
	{
		return new Parameters($this->createData($params));
	}

	/**
	 * @param array $default
	 * @return array
	 */
	public function createData(array $default)
	{
		return array_merge(array(
			'data' => $this->httpRequest->getPost(),
			'query' => $this->httpRequest->getQuery()
		), $default);
	}

} 