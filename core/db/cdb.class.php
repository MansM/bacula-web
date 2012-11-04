<?php

/*
  +-------------------------------------------------------------------------+
  | Copyright 2010-2012, Davide Franco			                          |
  |                                                                         |
  | This program is free software; you can redistribute it and/or           |
  | modify it under the terms of the GNU General Public License             |
  | as published by the Free Software Foundation; either version 2          |
  | of the License, or (at your option) any later version.                  |
  |                                                                         |
  | This program is distributed in the hope that it will be useful,         |
  | but WITHOUT ANY WARRANTY; without even the implied warranty of          |
  | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           |
  | GNU General Public License for more details.                            |
  +-------------------------------------------------------------------------+
 */

class CDB {
    private static $connection;
    private $options;
    private $result;

    private function __construct() {
    }

    public static function connect( $dsn, $user = null, $password = null, $options = array() ) {
		try {
            if ( is_null( self::$connection ) ) {
				self::$connection = new PDO($dsn, $user, $password);				
			}
        }catch (PDOException $e) {
            CErrorHandler::displayError($e);
        }
		
		return self::$connection;
    }

    private function setOptions() {
		// Set connection options
		$this->options = array(	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
								PDO::ATTR_CASE => PDO::CASE_LOWER,
								PDO::ATTR_STATEMENT_CLASS => array('CDBResult', array($this)) );

		if ($this->getDriver() == 'mysql')
			$this->options[] = array( PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
	
		foreach ($this->options as $option => $value)
            self::$connection->setAttribute($option, $value);
    }
}
?>
