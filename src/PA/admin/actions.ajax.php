<?php
$engineDir = "/home/library/phpincludes/engineAPI/engine";
include($engineDir ."/engine.php");
$engine = new EngineCMS();

// Apply ACL
recurseInsert("acl.php","php");
$engine->accessControl("build");

// Connect to the database
require_once("/home/library/phpincludes/databaseConnectors/database.lib.wvu.edu.remote.php");
$engine->dbConnect("database","pa",TRUE);

// Instantiate the fileHandler
$fManager = new fileHandler($engine);

// What action are we doing?
switch($engine->cleanGet['HTML']['action']){
    case "edit-form":
        // This action returns HTML

        $sql = sprintf("SELECT id,UNIX_TIMESTAMP(issueDate) AS issueDateTimestamp,issueNumber FROM paFiles WHERE id='%s' LIMIT 1", $engine->cleanPost['MYSQL']['id']);
        $engine->openDB->sanitize = FALSE;
        $sqlInfo                  = $engine->openDB->query($sql);
        $issue = mysql_fetch_array($sqlInfo['result'], MYSQL_ASSOC);

        echo sprintf('<form action="" onsubmit="return editIssueAJAX(this, %s)">', $issue['id']);
        echo sprintf('<table>');
        echo sprintf('    <tr>');
        echo sprintf('        <td>Issue Date: <sup class="req">*</sup></td>');
        echo sprintf('        <td>{engine name="function" function="dateDropDown" formname="issueDate" monthdformat="month" endyear="%s" setdate="%s"}</td>', date('Y'), $issue['issueDateTimestamp']);
        echo sprintf('    </tr>');
        echo sprintf('    <tr>');
        echo sprintf('        <td>Issue Number:</td>');
        echo sprintf('        <td><input name="issueNumber" type="text" value="%s" maxlength="10"></td>', $issue['issueNumber']);
        echo sprintf('    </tr>');
        echo sprintf('    <tr>');
        echo sprintf('        <td></td>');
        echo sprintf('        <td><input name="updateButton" type="submit" value="Update issue"></td>', $issue['issueNumber']);
        echo sprintf('    </tr>');
        echo sprintf('</table>');
        echo sprintf('</form>');
        break;
    
    case "edit":
        // This action returns JSON

        $errors = array();
        if(!checkdate($engine->cleanPost['MYSQL']['issueDate-m'], $engine->cleanPost['MYSQL']['issueDate-d'], $engine->cleanPost['MYSQL']['issueDate-y'])) array_push($errors, "Invalid date format!");
        if(!is_numeric($engine->cleanPost['MYSQL']['issueNumber'])) array_push($errors, "Issue number but be a number!");

        if(!sizeof($errors)){
            $sql = sprintf("UPDATE paFiles SET issueDate='%s', issueYear='%s', issueNumber='%s' WHERE id='%s' LIMIT 1",
                sprintf('%s-%s-%s', $engine->cleanPost['MYSQL']['issueDate-y'], $engine->cleanPost['MYSQL']['issueDate-m'], $engine->cleanPost['MYSQL']['issueDate-d']),
                $engine->cleanPost['MYSQL']['issueDate-y'],
                $engine->cleanPost['MYSQL']['issueNumber'],
                $engine->cleanPost['MYSQL']['id']);
            $engine->openDB->sanitize = FALSE;
            $sqlUpdate                = $engine->openDB->query($sql);
        }

        // Generate the userAlert
        if(!sizeof($errors)){
            $userAlert = webHelper_successMsg("The issue has been updated.");
        }else{
            $LIs = array();
            foreach($errors as $error){
                $LIs[] = '<li>'.$error.'</li>';
            }
            $userAlert = webHelper_errorMsg("The following error(s) occured:<br>".implode("\n", $LIs));
        }

        // Return the JSON result
        echo json_encode(array(
            'success'     => (int)(sizeof($errors)==0),
            'userAlert'   => $userAlert,
            'sqlResult'   => (int)(sizeof($errors) or $sqlUpdate['affectedRows']),
            'issueID'     => $engine->cleanPost['MYSQL']['id'],
            'issueDate'   => date("F j, Y", strtotime(sprintf('%s-%s-%s', $engine->cleanPost['MYSQL']['issueDate-y'], $engine->cleanPost['MYSQL']['issueDate-m'], $engine->cleanPost['MYSQL']['issueDate-d']))),
            'issueYear'   => $engine->cleanPost['MYSQL']['issueDate-y'],
            'issueNumber' => $engine->cleanPost['MYSQL']['issueNumber']
        ));
        break;

    case "delete":
        // This action returns JSON

        $sql = sprintf("DELETE FROM paFiles WHERE id='%s' LIMIT 1", $engine->cleanPost['MYSQL']['id']);
        $engine->openDB->sanitize = FALSE;
        $sqlDelete                = $engine->openDB->query($sql);

        $userAlert = ($sqlDelete['affectedRows']==1) ? webHelper_successMsg("The issue has been deleted.") : webHelper_errorMsg("An error occured! [error: ".$sqlDelete['errorNumber']."]");
        echo json_encode(array(
            'success'   => (int)$sqlDelete['affectedRows'],
            'userAlert' => $userAlert,
            'id'        => $engine->cleanPost['MYSQL']['id']
        ));
        break;

    case "info":
        // This action returns HTML

        $sql = sprintf("SELECT id,UNIX_TIMESTAMP(issueDate) AS issueDateTimestamp,issueNumber,name,size,type,UNIX_TIMESTAMP(date) AS created FROM paFiles WHERE id='%s' LIMIT 1", $engine->cleanPost['MYSQL']['id']);
        $engine->openDB->sanitize = FALSE;
        $sqlInfo                  = $engine->openDB->query($sql);
        $issue = mysql_fetch_array($sqlInfo['result'], MYSQL_ASSOC);

        echo sprintf('<table>');
        echo sprintf('    <tr>');
        echo sprintf('        <td>Issue Date:</td>');
        echo sprintf('        <td>%s</td>', date('F j, Y', $issue['issueDateTimestamp']));
        echo sprintf('    </tr>');
        echo sprintf('    <tr>');
        echo sprintf('        <td>Issue Number:</td>');
        echo sprintf('        <td>%s</td>', $issue['issueNumber']);
        echo sprintf('    </tr>');
        echo sprintf('    <tr>');
        echo sprintf('        <td>Filename:</td>');
        echo sprintf('        <td>%s</td>', $issue['name']);
        echo sprintf('    </tr>');
        echo sprintf('    <tr>');
        echo sprintf('        <td>Filesize:</td>');
        echo sprintf('        <td>%s</td>', $fManager->displayFileSize($issue['size']));
        echo sprintf('    </tr>');
        echo sprintf('    <tr>');
        echo sprintf('        <td>MIME Type:</td>');
        echo sprintf('        <td>%s</td>', $issue['type']);
        echo sprintf('    </tr>');
        echo sprintf('    <tr>');
        echo sprintf('        <td>Created:</td>');
        echo sprintf('        <td>%s</td>', date('r', $issue['created']));
        echo sprintf('    </tr>');
        echo sprintf('</table>');
        break;
}
?>
