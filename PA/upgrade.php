<?php
$engineDir = "/home/library/phpincludes/engineAPI/engine";
include($engineDir ."/engine.php");
$engine = new EngineCMS();

// Connect to the database
$engine->dbConnect("database","pa",TRUE);

// Get all years that are available in the database
$sql = sprintf("SELECT id,name,CONVERT(content USING utf8) AS `data` FROM paFiles");
$engine->openDB->sanitize = FALSE;
$sqlFiles                 = $engine->openDB->query($sql);

echo '<pre><tt>';
while($row = mysql_fetch_array($sqlFiles['result'], MYSQL_ASSOC)){
    // Default values
    $issueDate = null;
    $issueNumber = null;

    // update issueDate
    try{
        if(!preg_match('|([a-zA-Z]{1,})\.?([0-9]{1,2}),(\d{2,4})|', $row['data'], $matches))
            throw new Exception('No string date found!');
        if(!$issueDate = strtotime(sprintf('%s %s, %s', $matches[1],$matches[2],$matches[3])))
            throw new Exception('Invalid date!');
    }catch(Exception $e){
        try{
            if(!preg_match('|(\d{1,2})/(\d{1,2})/(\d{2,4})|', $row['data'], $matches))
                throw new Exception('No numeric date found!');
            if(!$issueDate = strtotime(sprintf('%s/%s/%s', $matches[1],$matches[2],$matches[3])))
                throw new Exception('Invalid date!');
        }catch(Exception $e){
            $issueDate = null;
            if(isset($matches[0]))
                echo sprintf("[%s] %s => Malformed date! (%s) %s\n", $row['id'], $row['name'], $matches[0], $e->getMessage());
            else
                echo sprintf("[%s] %s => Malformed date! (?) %s\n", $row['id'], $row['name'], $e->getMessage());
        }
    }
        // update issueNumber
    if(preg_match('|Issue\s(\d+)|', $row['data'], $matches)){
        $issueNumber = $matches[1];
    }

    echo sprintf("[%s] Issue %s => %s\n", $row['id'], $issueNumber, date('F d, Y', $issueDate));
    $sql = sprintf("UPDATE paFiles SET `issueDate` = FROM_UNIXTIME(%s), `issueYear` = '%s', `issueNumber` = '%s' WHERE id = '%s'",
        $issueDate, date('Y', $issueDate), $issueNumber, $row['id']
    );
    $engine->openDB->sanitize = FALSE;
    $engine->openDB->query($sql);
}
