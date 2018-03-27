<?php
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2011 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @category	PHPExcel
 * @package		PHPExcel_Calculation
 * @copyright	Copyright (c) 2006 - 2011 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license		http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version		1.7.6, 2011-02-27
 */


/** PHPExcel root directory */
if (!defined('PHPEXCEL_ROOT')) {
	/**
	 * @ignore
	 */
	define('PHPEXCEL_ROOT', dirname(__FILE__) . '/../../');
	require(PHPEXCEL_ROOT . 'PHPExcel/Autoloader.php');
}


/**
 * PHPExcel_Calculation_MathTrig
 *
 * @category	PHPExcel
 * @package		PHPExcel_Calculation
 * @copyright	Copyright (c) 2006 - 2011 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_Calculation_MathTrig {

	//
	//	Private method to return an array of the factors of the input value
	//
	private static function _factors($value) {
		$startVal = floor(sqrt($value));

		$factorArray = array();
		for ($i = $startVal; $i > 1; --$i) {
			if (($value % $i) == 0) {
				$factorArray = array_merge($factorArray,self::_factors($value / $i));
				$factorArray = array_merge($factorArray,self::_factors($i));
				if ($i <= sqrt($value)) {
					break;
				}
			}
		}
		if (count($factorArray) > 0) {
			rsort($factorArray);
			return $factorArray;
		} else {
			return array((integer) $value);
		}
	}	//	function _factors()


	private static function _romanCut($num, $n) {
		return ($num - ($num % $n ) ) / $n;
	}	//	function _romanCut()


	/**
	 *	ATAN2
	 *
	 *	This function calculates the arc tangent of the two variables x and y. It is similar to
