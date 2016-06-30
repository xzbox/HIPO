<?php
/*****************************************************************************
 *         In the name of God the Most Beneficent the Most Merciful          *
 *___________________________________________________________________________*
 *   This program is free software: you can redistribute it and/or modify    *
 *   it under the terms of the GNU General Public License as published by    *
 *   the Free Software Foundation, either version 3 of the License, or       *
 *   (at your option) any later version.                                     *
 *___________________________________________________________________________*
 *   This program is distributed in the hope that it will be useful,         *
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of          *
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           *
 *   GNU General Public License for more details.                            *
 *___________________________________________________________________________*
 *   You should have received a copy of the GNU General Public License       *
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.   *
 *___________________________________________________________________________*
 *                             Created by  Qti3e                             *
 *        <http://Qti3e.Github.io>    LO-VE    <Qti3eQti3e@Gmail.com>        *
 *****************************************************************************/
namespace lib\helper;

/**
 * Class SimpleCurl
 * @package lib\helper
 */
class SimpleCurl
{
	/**
	 * Performs a get request on the chosen link and the chosen parameters
	 * in the array.
	 *
	 * @param string $url
	 * @param array  $params
	 *
	 * @return string returns the content of the given url
	 */
	public static function get($url, $params = [])
	{
		if (is_array($params) && count($params) > 0) {
			$url = $url.'?'.http_build_query($params, '', '&');
		}
		$ch = curl_init();

		$options = [
			CURLOPT_URL            => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CONNECTTIMEOUT => 10,
			CURLOPT_SSL_VERIFYPEER => false,
		];
		curl_setopt_array($ch, $options);

		$response = curl_exec($ch);
		curl_close($ch);

		return $response;
	}

	/**
	 * Performs a post request on the chosen link and the chosen parameters
	 * in the array.
	 *
	 * @param string $url
	 * @param array  $fields
	 *
	 * @return string returns the content of the given url after post
	 */
	public static function post($url, $fields = [])
	{
		if (is_array($fields) && count($fields) > 0) {
			$postFieldsString = http_build_query($fields, '', '&');
		} else {
			$postFieldsString = '';
		}

		$ch = curl_init();

		$options = [
			CURLOPT_URL            => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CONNECTTIMEOUT => 10,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_POSTFIELDS     => $postFieldsString,
			CURLOPT_POST           => true,
			CURLOPT_USERAGENT      => 'SMVC Agent',
		];
		curl_setopt_array($ch, $options);

		$response = curl_exec($ch);
		curl_close($ch);

		return $response;
	}

	/**
	 * Performs a put request on the chosen link and the chosen parameters
	 * in the array.
	 *
	 * @param string $url
	 * @param array  $fields
	 *
	 * @return string with the contents of the site
	 */
	public static function put($url, $fields = [])
	{
		if (is_array($fields) && count($fields) > 0) {
			$postFieldsString = http_build_query($fields, '', '&');
		} else {
			$postFieldsString = '';
		}
		$ch = curl_init($url);

		$options = [
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CONNECTTIMEOUT => 10,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_CUSTOMREQUEST  => 'PUT',
			CURLOPT_POSTFIELDS     => $postFieldsString,
		];
		curl_setopt_array($ch, $options);

		$response = curl_exec($ch);
		curl_close($ch);

		return $response;
	}
}
