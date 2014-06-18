<?php
$engineDir = "/home/library/phpincludes/engineAPI/engine";
include($engineDir ."/engine.php");
$engine = new EngineCMS();

// Apply ACL
recurseInsert("acl.php","php");
$engine->accessControl("build");

// Connect to the database
$engine->dbConnect("database","pa",TRUE);

// Instantiate the snippets class
$GLOBALS['snippetObject'] = $snippets = new Snippet($engine,'snippets','value');

// Get all the issues for the requested year(s)
$sql = sprintf("SELECT id,issueDate,issueNumber,name,size,type,date FROM paFiles WHERE issueYear='%s' ORDER BY issueDate ASC", $engine->cleanGet['MYSQL']['year']);
$engine->openDB->sanitize = FALSE;
$sqlIssues                = $engine->openDB->query($sql);

$issues = array();
if($sqlIssues['affectedRows'])
    while($row = mysql_fetch_array($sqlIssues['result'], MYSQL_ASSOC)){
        $row['issueDateTimestamp'] = strtotime($row['issueDate']);
        $row['created'] = strtotime($row['date']);
        array_push($issues, $row);
    }
?>
<table cellspacing="0">
    <thead>
    <tr>
        <th style="width:50px;"></th>
        <th style="width:40px;"></th>
        <th style="width:40px;"></th>
        <th style="width:55px;"></th>
        <th style="width:160px;">Issue Date</th>
        <th style="width:125px;">Issue Number</th>
        <th style="width:100px;">Filename</th>
        <th style="width:100px;">MIME Type</th>
    </tr>
    <tr><td colspan="8" style="background-color:#666;"></td></tr>
    </thead>
    <tbody>
    <?php if(sizeof($issues)){ foreach($issues as $issue){ ?>
    <tr id="issueRow-<?php echo $issue['id'] ?>" class="issueRow">
        <td><a href="{snippet field="value" id="baseURL"}/load.php?id=<?php echo $issue['id'] ?>" target="_blank">View</a></td>
        <td><a href="javascript:viewIssue(<?php echo $issue['id'] ?>);" class="infoLink">Info</a><img src="../images/ajaxLoader.gif" alt="Loading..." class="infoWait" style="display:none;"></td>
        <td><a href="javascript:editIssue(<?php echo $issue['id'] ?>);" class="editLink">Edit</a><img src="../images/ajaxLoader.gif" alt="Loading..." class="editWait" style="display:none;"></td>
        <td><a href="javascript:deleteIssue(<?php echo $issue['id'] ?>);">Delete</a></td>
        <td class="issueDate"><?php echo date('F j, Y', strtotime($issue['issueDate'])) ?></td>
        <td class="issueNumber"><?php echo $issue['issueNumber'] ?></td>
        <td class="filename"><?php echo $issue['name'] ?></td>
        <td class="mimeType"><?php echo $issue['type'] ?></td>
    </tr>
    <tr id="issueDetailsRow-<?php echo $issue['id'] ?>" class="issueDetailsRow">
        <td colspan="4"></td>
        <td colspan="4">
            <div class="issueDetails" style="display:none;"></div>
            <div class="issueEdit" style="display:none;"></div>
        </td>
    </tr>
    <tr id="issueHrRow-<?php echo $issue['id'] ?>"><td colspan="8" style="background-color:#CCC;"></td></tr>
    <?php }}else{ ?>
    <tr>
        <td colspan="2"></td>
        <td colspan="4">No issues found!</td>
    </tr>
    <?php } ?>
    </tbody>
</table>
