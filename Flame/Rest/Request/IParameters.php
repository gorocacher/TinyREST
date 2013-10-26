<?php
/**
 * Class IParameters
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 26.10.13
 */
namespace Flame\Rest\Request;

interface IParameters
{
	/**
	 * @return string
	 */
	public function getId();

	/**
	 * @return string
	 */
	public function getAction();

	/**
	 * @return string
	 */
	public function getFormat();

	/**
	 * @param null|string $name
	 * @param null $default
	 * @return mixed
	 */
	public function getAssociations($name = null, $default = null);

	/**
	 * @param bool $invalidate
	 * @return mixed
	 */
	public function getData($invalidate = true);

	/**
	 * @param null|string $query
	 * @param null $default
	 * @return mixed
	 */
	public function getQuery($query = null, $default = null);
} 