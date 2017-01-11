<?php

/**
*  Used to  configure a mysql database connection.
*/
	
class MySQLConfig
{
	
	private $m_host;
	private $m_dbName;
	private $m_userName;
	private $m_password;

	/*
	 * Creates a new mysql configuration file.
	 * @param $host -  the host name
	 * @param $dbName - the name of the database
	 * @param $userName - the user's username
	 * @param $password -  the user's password
	*/
	public function __construct($host, $dbName, $userName, $password)
	{
		$this->m_host = $host;
		$this->m_dbName = $dbName;
		$this->m_userName = $userName;
		$this->m_password = $password;
	}
	/*
	 * Get the hostname
	 * @return the host name
	*/
	public function GetHostName()
	{
		return $this->m_host;
	}
	/*
	 * Get the database name
	 * @return the name of the database
	*/
	public function GetdbName()
	{
		return $this->m_dbName;
	}
	/*
	 * Get the user name
	 * @return he user's username
	*/
	public function GetUserName()
	{
		return $this->m_userName;
	}
	/*
	 * Get the password
	 * @return the user's password
	*/
	public function GetPassword()
	{
		return $this->m_password;
	}
	/*
	 * Set the hostname
	 * @param $host -  the host name
	*/
	public function SetHostName($hostName)
	{
		 $this->m_host = $hostName;
	}
	/*
	 * Set the user name
	 * @param $userName - the user's username
	*/
	public function SetdbName($dbName)
	{
		 $this->m_dbName = $dbName;
	}
	/*
	 * Set the user name
	 * @param $userName - the user's username
	*/
	public function SetUserName($userName)
	{
		 $this->m_userName = $userName;
	}
	/*
	 * Set the password
	 * @param $password -  the user's password
	*/
	public function SetPassword($password)
	{
		$this->m_password = $password;
	}

}

?>