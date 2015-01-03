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

if(!sizeof($engine->cleanGet)) exit();
switch($engine->cleanGet['HTML']['mode']){
    case "form":
        // This mode returns HTML

        $sql = sprintf("SELECT * FROM snippets WHERE ID='%s' LIMIT 1", $engine->cleanPost['MYSQL']['id']);
        $engine->openDB->sanitize = FALSE;
        $sqlSnippet                  = $engine->openDB->query($sql);
        $snippet = mysql_fetch_array($sqlSnippet['result'], MYSQL_ASSOC);

        // Check that the use can, in fact, view this snippet
        if($snippet['systems'] and !checkGroup('libraryDept_dlc_systems')) die("Access Denied!");

        if($sqlSnippet['result']){
            $listObj = new listManagement($engine, 'snippets');
            $listObj->insertButtonText = "Save changes";
            $listObj->noSubmit = true;

            $listObj->addField(array(
                'field' => "ID",
                'label' => "ID",
                'size' => "15",
                'readonly' => true,
                'value' => $snippet['ID']
            ));
            $listObj->addField(array(
                'field' => "name",
                'label' => "Name",
                'size' => "30",
                'value' => $snippet['name']
            ));
            if(checkGroup('libraryDept_dlc_systems')) $listObj->addField(array(
                'field' => "systems",
                'label' => "Systems",
                'type' => "select",
                'options' => array(
                    array(
                        'label' => 'Yes',
                        'value' => '1',
                        'selected' => ($snippet['systems']) ? true : false
                    ),
                    array(
                        'label' => 'No',
                        'value' => '0',
                        'selected' => (!$snippet['systems']) ? true : false
                    )
                )
            ));
            $listObj->addField(array(
                'field' => "value",
                'label' => "Value",
                'type' => "wysiwyg",
                'blank' => true,
                'dupes' => true,
                 'value' => $snippet['value']
            ));
            
            echo "<hr>";
            echo $listObj->displayInsertForm();
            echo "<input type='button' onclick='updateSnippet()' value='Save changes'>";
            
        }else{
            die("No snippet found!");
        }
        break;

    case "update":
        // This mode returns JSON

        // clean input
        $engine->cleanPost['MYSQL']['name'] = trim(strip_tags($engine->cleanPost['MYSQL']['name']));
        $engine->cleanPost['MYSQL']['systems'] = (int)($engine->cleanPost['MYSQL']['systems']);
        $engine->cleanPost['MYSQL']['value'] = trim(strip_tags($engine->cleanPost['MYSQL']['value']));

        // We need to know if this is a systems snippet, so we can know what restrictions apply
        $sql = sprintf("SELECT * FROM snippets WHERE ID='%s' LIMIT 1", $engine->cleanPost['MYSQL']['id']);
        $engine->openDB->sanitize = FALSE;
        $sqlSnippet                  = $engine->openDB->query($sql);
        $snippet = mysql_fetch_array($sqlSnippet['result'], MYSQL_ASSOC);

        // Check that the use can, in fact, view this snippet
        if($snippet['systems'] and !checkGroup('libraryDept_dlc_systems')) die("Access Denied!");

        $errors=array();
        if(!array_key_exists('name', $engine->cleanPost['MYSQL']) or !$engine->cleanPost['MYSQL']['name']) array_push($errors, 'Missing snippet "name"');
        if(!array_key_exists('value', $engine->cleanPost['MYSQL']) or !$engine->cleanPost['MYSQL']['value']) array_push($errors, 'Missing snippet "value"');
        if(checkGroup('libraryDept_dlc_systems') and !array_key_exists('systems', $engine->cleanPost['MYSQL'])) array_push($errors, 'Missing snippet "systems"');

        if(!sizeof($errors)){
            $sql = (checkGroup('libraryDept_dlc_systems'))
                    ? sprintf("UPDATE snippets SET name='%s', systems='%s', value='%s' WHERE ID='%s' LIMIT 1", $engine->cleanPost['MYSQL']['name'], (int)$engine->cleanPost['MYSQL']['systems'], $engine->cleanPost['MYSQL']['value'], $engine->cleanPost['MYSQL']['id'])
                    : sprintf("UPDATE snippets SET name='%s', value='%s' WHERE ID='%s' LIMIT 1",               $engine->cleanPost['MYSQL']['name'],                                              $engine->cleanPost['MYSQL']['value'], $engine->cleanPost['MYSQL']['id']);
            $engine->openDB->sanitize = FALSE;
            $sqlUpdate                = $engine->openDB->query($sql);

            echo json_encode(array(
                'success'   => (int)$sqlUpdate['result'],
                'errorMsg'  => $sqlUpdate['error'],
                'id'        => $engine->cleanPost['MYSQL']['id'],
                'userAlert' => webHelper_successMsg("Snippet saved successfuly."), 
                'snippet'   => array(
                    'id'      => $engine->cleanPost['MYSQL']['id'],
                    'name'    => $engine->cleanPost['MYSQL']['name']
                )
            ));
        }else{
            // Generate the userAlert
            $LIs = array();
            foreach($errors as $error){ $LIs[] = '<li>'.$error.'</li>'; }

            echo json_encode(array(
                'success'  => 0,
                'errorMsg' => $errors,
                'id'       => $engine->cleanPost['MYSQL']['id'],
                'userAlert' => webHelper_errorMsg("The following error(s) occured:<br>".implode("\n", $LIs))
            ));
        }
        break;
}