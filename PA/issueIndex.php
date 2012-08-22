<?php
global $engine;

// Get all years that are available in the database
$availYears = array();
$sql = sprintf("SELECT DISTINCT issueYear AS year FROM paFiles ORDER BY issueYear ASC");
$engine->openDB->sanitize = FALSE;
$sqlYears                 = $engine->openDB->query($sql);
if($sqlYears['result']) while($row = mysql_fetch_array($sqlYears['result'], MYSQL_ASSOC)){
    array_push($availYears, $row['year']);
}
?>

<div id="databaseHeader">
    <div id="databaseHeaderContnet">
    <div id="databaseImage"><img src="{snippet field="value" id="imgSource"}" alt="{snippet field="value" id="imgAlt"}" width="200"></div>
    <div id="databaseName">{snippet field="value" id="name"}</div>
    <div id="databaseYears"><?php if(sizeof($availYears)) echo sprintf('%s - %s', $availYears[0], $availYears[sizeof($availYears)-1]); else echo 'No issues yet'; ?></div>
    <div id="databaseDescription">{snippet field="value" id="description"}</div>
    <div style="clear:both;"></div>
    </div>
</div>
<div id="databaseContent">
    <?php if(defined("LOAD_ERROR")) echo sprintf('<div id="loadError">%s</div><hr width="100%%" size="3" noshade="noshade">', LOAD_ERROR); ?>
    <div id="yearMenu">
        Available Years:
        <hr>
        <?php if(sizeof($availYears)){ ?>
        <ul>
            <?php foreach($availYears as $year) echo sprintf('<li><label><input type="checkbox" name="databaseYears" id="databaseYears-%s" value="%s"> %s Issues</label></li>', $year, $year, $year ); ?>
        </ul>
        <?php }else{ ?>
            <b><i>No years available yet</i></b>
        <?php } ?>
    </div>
    <div id="databaseContentBody">
        <div id="ajaxLoading" style="display:none;"><img src="{snippet field="value" id="baseURL"}/images/ajaxLoader.gif" alt="Loading..."> Loading...</div>
        <div id="issuesRoot" style="display:none;"></div>
    </div>
    <div style="clear:both;"></div>
</div>
