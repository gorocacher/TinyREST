<?php
/**
 * RestPresenter.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    05.02.13
 */

namespace Flame\Rest\Application\UI;

use Nette\Application\UI\Presenter;
use Flame\Rest\Response\Statuses;
use Nette\Utils\Strings;
use Flame\Rest\Response\IResponse;
use Nette\Application\ForbiddenRequestException;
use Flame\Rest\IResource;

abstract class RestPresenter extends Presenter
{

	/**
	 * @inject
	 * @var \Flame\Rest\ResourceFactory
	 */
	public $resourceFactory;

	/** @var  IResource */
	protected $resource;

	/** @var  string */
	protected $resourceType = IResource::JSON;

	/**
	 * @return mixed
	 */
	public function getPostData()
	{
		return $this->getHttpRequest()->getPost();
	}

	/**
	 * @param $element
	 */
	public function checkRequirements($element)
	{

		try {
			parent::checkRequirements($element);
			$this->checkRequestMethod($element);
		} catch (ForbiddenRequestException $ex) {
			$this->returnException($ex);
		}
	}

	/**
	 * @param \Exception $ex
	 */
	public function sendErrorResource(\Exception $ex)
	{
		$code = 500;

		if ($ex->getCode()) {
			$code = $ex->getCode();
		}

		$this->resource->message = $ex->getMessage();
		$this->sendResource($code);
	}

	/**
	 * @param int $code
	 */
	public function sendResource($code = IResponse::S200_OK)
	{

		if($code && $code < 400) {
			$this->resource->status = Statuses::SUCCESS;
		}else{
			$this->resource->status = Statuses::ERROR;
		}

		$this->resource->code = $code;
		$this->getHttpResponse()->setCode($code);
		$this->sendJson($this->resource->getData());
	}

	/**
	 * @param $element
	 * @throws \Nette\Application\ForbiddenRequestException
	 */
	protected function checkRequestMethod($element)
	{
		if($method = $element->getAnnotation('method')) {
			if (Strings::upper($method) !== $this->getHttpRequest()->getMethod()) {
				throw new ForbiddenRequestException('Bad HTTP method for the request.');
			}
		}
	}

	/**
	 * On before render
	 */
	protected function beforeRender()
	{
		parent::beforeRender();
		$this->sendResource();
	}

	/**
	 * @return void
	 */
	protected function startup()
	{
		parent::startup();

		$this->resource = $this->resourceFactory->create();
	}
}
