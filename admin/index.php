<?php

$engineDir = "/home/library/phpincludes/engineCMS/engine";

/* Page Variables
/*
/* Variable that are local to the page are defined in the array $localVars
/* The variables can then be accessed using {local var="variableName"}
/*
/* All Page variables are optional, but "pageTitle" is highly recommened
*/
$localVars = array(); //Do not delete this line

$localVars['pageTitle']       = "Database Managemet";
$localVars['openDB_Database'] = "databases";

// Used to change the template set that is called to display the page
//$localVars['engineTemplate'] = "";

/* Access Control
/* 
/* If no accessControl is defined, the page is publically viewable by all 
/* (assuming no .htaccess or other server magics).
/*
/* Access Controls are added together. If you define "IP" and a Login type, both
/* will be required
/*
/* The allow rules are processed BEFORE the deny rules. 
/* So if you allow something but it is also denied, it will be denied. 
/* 
/* 
*/
$accessControl = array(); //Do not delete this line

/* If defined, this is the page that the user will be redirected to on an access denied
/* otherwise, the default will be used. */
//$accessControl['reDirect'] = "http://google.com"; 

/* IP Based Authentication
/* 
/* ['IP']['Range or Single Numbers']
*/
//$accessControl['IP']['157.182.207.203'] = 1; 
//$accessControl['IP']['157.182.207.203'] = 0; 
//$accessControl['IP']['157.182.207.*'] = 0; 
//$accessControl['IP']['157.182.206-207.*'] = 1;
//$accessControl['IP']['155-160.100-200.206-207.200-220'] = 1;

/* Active Directory Authentication 
/*
/* ['AD']['Usernames']['%Username%'] = 0|1
/* ['AD']['Groups']['%groupNames%'] = 0|1
/* ['AD']['OU']['%ouNames%'] = 0|1
/* ['AD']['Domain']
/* ['AD']['Authenticate'] = 0|1

/* OU or Group is most broadly defined
/* Refined by username
/*
/* Example: Deny "Library Systems" Allow "mbond" would deny everyone but mbond
/*          Allow "Library Systems" Deny "mbond" would allow everyone but mbond

*/

/*
$accessControl['AD']['Usernames']['cmstest1'] = 1;

$accessControl['AD']['Groups']['cmsSG'] = 1;

$accessControl['AD']['OU']['Library Systems'] = 1;
*/

$accessControl['AD']['Groups']['webDatabaseAdmin'] = 1;

// Fire up the Engine
include($engineDir ."/engineHeader.php");
?>

<!-- Page Content Goes Below This Line -->


<!-- Page Content Goes Above This Line -->

<?php
include($engineDir ."/engineFooter.php");
?>