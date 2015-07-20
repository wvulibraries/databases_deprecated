<?php 
require 'engineHeader.php'; 
$session = 'a:7:{s:4:"page";s:32:"/about/directory/admin/index.php";s:2:"qs";s:0:"";s:6:"groups";a:1:{i:0;s:20:"libraryWeb_databases";}s:2:"ou";s:4:"Main";s:8:"username";s:7:"vagrant";s:8:"authtype";s:4:"ldap";s:9:"auth_ldap";a:3:{s:6:"groups";a:1:{i:0;s:48:"CN=Domain Users,CN=Users,DC=wvu-ad,DC=wvu,DC=edu";}s:6:"userDN";s:93:"CN=vagrant box,OU=systemsGeneratedCourtesyAccounts,OU=Library,OU=Main,DC=wvu-ad,DC=wvu,DC=edu";s:8:"username";s:7:"vagrant";}}'; 
session::import(unserialize($session)); 
print "done"; 
?>