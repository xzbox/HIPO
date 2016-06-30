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
 * Class Number
 * @package lib\helper
 */
class Number
{
	/**
	 * Formats a number to start with 0 useful for mobile numbers.
	 *
	 * @param int|float $number the number
	 * @param int|float|string $prefix the number should start with
	 *
	 * @return string the formatted number
	 */
	public static function format($number, $prefix = '4')
	{
		//remove any spaces in the number
		$number = str_replace(' ', '', $number);
		$number = trim($number);

		//make sure the number is actually a number
		if (is_numeric($number)) {
			//if number doesn't start with a 0 or a $prefix add a 0 to the start.
			if ($number[0] != 0 && $number[0] != $prefix) {
				$number = '0'.$number;
			}

			//if number starts with a 0 replace with $prefix
			if ($number[0] == 0) {
				$number[0] = str_replace('0', $prefix, $number[0]);
				$number = $prefix.$number;
			}

			//return the number
			return $number;

			//number is not a number
		} else {
			//return nothing
			return false;
		}
	}

	/**
	 * Returns the percentage.
	 *
	 * @param int|float $val1 start number
	 * @param int|float $val2 end number
	 *
	 * @return string returns the percentage
	 */
	public static function percentage($val1, $val2)
	{
		if ($val1 > 0 && $val2 > 0) {
			$division = $val1 / $val2;
			$res = $division * 100;

			return round($res).'%';
		} else {
			return '0%';
		}
	}
}