@ECHO OFF
ECHO ***********************************************************************
ECHO *                                                                     *
ECHO *         ManiaLib - Lightweight PHP framework for Manialinks         *
ECHO *                                                                     *
ECHO *                              ---------                              *
ECHO *                                                                     *
ECHO *         This source file is subject to the LGPL License 3           *
ECHO *         It is available through the world-wide-web                  *
ECHO *         at this URL:  http://www.gnu.org/licenses/lgpl.html         *
ECHO *                                                                     *
ECHO *         Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)        *
ECHO *                                                                     *
ECHO *         Usage:                                                      *
ECHO *         Rename the file to "script_name.bat" and run it             *
ECHO *         It will try to execute "php script_name.php"                *
ECHO *                                                                     *
ECHO ***********************************************************************

SET filename=%0
FOR %%F IN (%filename%) DO SET dirname=%%~dpF
SET filename=%~nx0
SET filename=%filename:.bat=%
php.exe %dirname%%filename%.php

PAUSE