<?php
$engineDir = "/home/library/phpincludes/engineAPI/engine";
include($engineDir ."/engine.php");
$engine = new EngineCMS();

// Process ACL
recurseInsert("acl.php","php");

// Connect to the database
$engine->dbConnect("database","pa",TRUE);

// Instantiate the snippets class
$GLOBALS['snippetObject'] = $snippets = new Snippet($engine,'snippets','value');

// Get all the issues for the requested year(s)
$sql = sprintf("SELECT id,issueDate,issueNumber FROM paFiles WHERE issueYear IN (%s) ORDER BY issueDate ASC", $engine->cleanGet['MYSQL']['years']);
$engine->openDB->sanitize = FALSE;
$sqlIssues                = $engine->openDB->query($sql);

// If there are issues found, loop through them building the fieldsets
if($sqlIssues['affectedRows']){
    $yearGroups = array();
    $currentYearGroup=null;
    while($row = mysql_fetch_array($sqlIssues['result'], MYSQL_ASSOC)){
        $row['issueDate'] = strtotime($row['issueDate']);
        $issueYear        = date("Y", $row['issueDate']);

        // Close an old yearGroup?
        if($currentYearGroup != $issueYear and !is_null($currentYearGroup)){
            echo sprintf('</ul>');
            echo sprintf('</fieldset>');
        }

        // Start a new yearGroup?
        if($currentYearGroup != $issueYear){
            $currentYearGroup = $issueYear;
            echo sprintf('<fieldset><legend>%s Issues</legend>', $currentYearGroup);
            echo sprintf('<ul>');
        }

        // Print a LI for this issue
        echo sprintf('<li id="issue-%s" class="issueNode"><a href="{snippet field="value" id="baseURL"}/load.php?id=%s"><span class="issueDate">%s</span><br><span class="issueNumber">%s</span></a></li>',
            $row['id'], $row['id'], date('F j, Y', $row['issueDate']), $row['issueNumber']);
    }
}else{
    die("No issues found for given year(s)!");
}
?>
