<?php
namespace PornTerminal;

use Commando;
use Exception;
use Pixeler;
use stdClass;

/**
 * parent class for the core
 *
 * @since 2.0.0
 *
 * @package PornTerminal
 * @category Core
 * @author Henry Ruhs
 */

class Core
{
	/**
	 * instance of the api class
	 *
	 * @var Api
	 */

	protected $_api;

	/**
	 * instance of the wording class
	 *
	 * @var Wording
	 */

	protected $_wording;

	/**
	 * constructor of the class
	 *
	 * @since 2.0.0
	 *
	 * @param Api $api instance of the api class
	 * @param Wording $wording instance of the wording class
	 */

	public function __construct(Api $api = null, Wording $wording = null)
	{
		$this->_api = $api;
		$this->_wording = $wording;
	}

	/**
	 * run
	 *
	 * @since 2.0.0
	 *
	 * @param Commando\Command $command
	 *
	 * @return string
	 */

	public function run(Commando\Command $command = null) : string
	{
		$result = $this->_getResult($command);

		/* collect output */

		$output = (string)$this->_drawImage($command, $result);
		if ($command['m'])
		{
			$metaArray = $this->_getMetadataArray($result);
			if ($metaArray)
			{
				$output .= implode(PHP_EOL, $metaArray) . PHP_EOL;
			}
		}

		/* open browser */

		if ($command['o'])
		{
			$this->_openBrowser($result);
		}
		return $output;
	}

	/**
	 * get the result
	 *
	 * @since 2.0.0
	 *
	 * @param Commando\Command $command
	 *
	 * @return stdClass
	 */

	protected function _getResult(Commando\Command $command = null) : stdClass
	{
		$url = $this->_buildUrl($command);
		$content = file_get_contents($url);
		$result = json_decode($content);
		if (!$result)
		{
			$command->error(new Exception($this->_wording->get('no_result')));
		}

		/* map result */

		if ($result->result)
		{
			$result = $result->result;
		}
		if ($result->videos)
		{
			$result = $result->videos;
		}
		if ($result->video)
		{
			$result = $result->video;
		}

		/* randomize result */

		$total = count($result);
		$result = $result{mt_rand(0, $total)};

		/* map result */

		if ($result->video)
		{
			$result = $result->video;
		}
		if ($result->default_thumb)
		{
			$result->thumb = $result->default_thumb;
		}
		return $result;
	}

	/**
	 * build the url
	 *
	 * @since 2.0.0
	 *
	 * @param Commando\Command $command
	 *
	 * @return string
	 */

	public function _buildUrl(Commando\Command $command = null) : string
	{
		$providerKey = $command['p'];
		$endpointKey = $command['e'];
		$providerArray = $this->_api->getProviderArray();
		$providerValue = $providerArray[$providerKey];
		$endpointValue = $providerValue['endpoint'][$endpointKey];
		$queryValue = $command['q'] ? $command['q'] : $providerValue['query'];
		if (!$endpointValue)
		{
			$command->error(new Exception($this->_wording->get('no_endpoint')));
		}
		return $providerValue['url'] . $endpointValue . '&' . $queryValue;
	}

	/**
	 * draw the image
	 *
	 * @since 2.0.0
	 *
	 * @param Commando\Command $command
	 * @param stdClass $result
	 *
	 * @return Pixeler\Image
	 */

	protected function _drawImage(Commando\Command $command = null, stdClass $result = null) : Pixeler\Image
	{
		$image = Pixeler\Pixeler::image($result->thumb, $command['r'], $command['i'], $command['w'], $command['d']);
		if ($command['g'])
		{
			$image->clearColors();
		}
		return $image;
	}

	/**
	 * get the metadata array
	 *
	 * @since 2.0.0
	 *
	 * @param stdClass $result
	 *
	 * @return array
	 */

	protected function _getMetadataArray(stdClass $result = null) : array
	{
		return array_filter(
		[
			$result->title ? $this->_wording->get('title') . $this->_wording->get('colon') . ' ' . $result->title : null,
			$result->name ? $this->_wording->get('name') . $this->_wording->get('colon') . ' ' . $result->name : null,
			$result->url ? $this->_wording->get('url') . $this->_wording->get('colon') . ' ' . $result->url : null,
			$result->rating ? $this->_wording->get('rating') . $this->_wording->get('colon') . ' ' . $result->rating : null,
			$result->views ? $this->_wording->get('total') . $this->_wording->get('colon') . ' ' . $result->views : null,
			$result->duration ? $this->_wording->get('duration') . $this->_wording->get('colon') . ' ' . $result->duration : null
		]);
	}

	/**
	 * open the browser
	 *
	 * @since 2.0.0
	 *
	 * @param stdClass $result
	 *
	 * @return string
	 */

	protected function _openBrowser(stdClass $result = null) : string
	{
		if (PHP_OS === 'Linux')
		{
			return exec('xdg-open ' . $result->url);
		}
		else
		{
			return exec('open ' . $result->url);
		}
	}
}