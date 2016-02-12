<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2015, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	http://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

// ------------------------------------------------------------------------

if ( ! function_exists('querydb'))
{
	/**
	 * Element
	 *
	 * Lets you determine whether an array index is set and whether it has a value.
	 * If the element is empty it returns NULL (or whatever you specify as the default value.)
	 *
	 * @param	string
	 * @param	array
	 * @param	mixed
	 * @return	mixed	depends on what the array contains
	 */
	 
	function querydb($query, $reply = 1, $CALLED_FUNCTION = "_common") {
	/*
	Get function My sql query
	*/
		global $mysql,$MySQLi;
		//$query = @mysql_escape_string($query); 'not efective while using id_xx='xxxxx'.. will esacepe 'xxxxx' to \'xxxxx\'
		
		global $time_start,$pre_src,$pre_rpc,$pre_src2,$pre_rpc2;
		//mysql_set_charset('utf8');
		$MySQLi -> query('SET NAMES utf8');
		$MySQLi -> query('SET CHARACTER SET utf8');
	
		//HTML format for query
		//$print_query = preg_replace($pre_src2,$pre_rpc2,$query);
		$print_query = preg_replace($pre_src,$pre_rpc,$query);
			
		if (GLOBAL_DISPLAY_MYSQL_QUERY==1) { // MENCETAL waktu eksekusi erserta eksekusi scriptnya
			//global $_SERVER;
			//$self = $_SERVER['PHP_SELF'];
			$time_end = getmicrotime();
			$time_query =  $time_end - $time_start ;
			print "<div class=\"php_note\">".sprintf ("%6.5f",$time_query)." (s)&emsp; > MySQL Query <b>$CALLED_FUNCTION</b> : <icode class='fsi'>{$print_query};</icode></div>";
		}
		if ($result = $MySQLi -> query($query)) { //-> WARNING! this function is DEPRECATED, see PHP Manual.chm
			return $result;
		}
		else {
			if ($reply == 1 && GLOBAL_DISPLAY_ERRORS == 1) {
				print "<div class=\"php_on_error\">Failed For Operand a Query = ".$print_query.", <b>".$MySQLi -> error."</b></div>";
			}
		}
	}
}

if ( ! function_exists('mysqli_max_value'))
{
	/**
	 * Element
	 *
	 * Lets you determine whether an array index is set and whether it has a value.
	 * If the element is empty it returns NULL (or whatever you specify as the default value.)
	 *
	 * @param	string
	 * @param	array
	 * @param	mixed
	 * @return	mixed	depends on what the array contains
	 */
	 
	function mysqli_max_value($table,$field)
	{
		$query = $this->db->select_max($field)->get_where($table);
		$data = $query->result_array();
		$data_value = $data[0][$field];
			
		if($data_value != null)
			return $data_value;
		else
			return 0;
	}
}

if ( ! function_exists('getoneVal'))
{
	function getoneVal($val,$table,$wh) {
	/*
	for get one value of field on one record
	this functon return 1 value or more on 1 record or more
	*/
		if ($reply = @mysqli_fetch_row(querydb("SELECT $val FROM ".$table." WHERE $wh",0,"<span style=\"color:#4455ff;\">_getOneVal()</span>"))) {
			return $reply[0];
		}
	}
}

if ( ! function_exists('getoneRecord'))
{
	function getoneRecord($table,$wh,$field="*",$method=MYSQL_BOTH) {
	/*
	get one record
	this function return you one or more recor with specific pefix condition
	*/
		$Q_SELECT = querydb("SELECT {$field} FROM ".$table." WHERE $wh LIMIT 1",0,"<span style=\"color:#4455ff;\">_getOneRecord()</span>");
		if ($reply = @mysqli_fetch_array($Q_SELECT,$method)) {
			return $reply;
		}
	}
}

