<?php
/*
	this file is user to contain the autoload 
	methods for the diffrent classes used in the project

	Michael McMahon
	11/12/2015
*/
	function autoLoadStickyNote()
	{
		require_once "StickyNote.php";
	}
	spl_autoload_register('autoLoadStickyNote');

	function autoLoadStickyNoteDao()
	{
		require_once "StickyNoteDaoImpl.php";
	}
	spl_autoload_register('autoLoadStickyNoteDao');

	function autoLoadUser()
	{
		require_once "User.php";
	}
	spl_autoload_register('autoLoadUser');

	function autoLoadUserDao()
	{
		require_once "UserDao.php";
	}
	spl_autoload_register('autoLoadUserDao');

	function autoLoadMySqlConfig()
	{
		require_once "MySQLConfig.php";
	}
	spl_autoload_register('autoLoadMySqlConfig');
?>