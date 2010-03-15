<?php
/**
 * This file is part of ManiaLib.
 *  
 * ManiaLib  is free software: you can redistribute it and/or modify it under
 * the terms of the GNU Lesser General Public License as published by the Free
 * Software Foundation, either version 3 of the License, or (at your option) any
 * later version.
 * 
 * ManiaLib is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public License
 * along with ManiaLib.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * @author Maxime Raoust
 * 
 */
  
require_once("core.inc.php");

$request = RequestEngine::getInstance();
$request->registerReferer();

require_once("header.php");

require_once("navigation.php");

require_once("footer.php");


?>