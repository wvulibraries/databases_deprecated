<?php
$engineDir = "/home/library/phpincludes/engineAPI/engine";
include($engineDir ."/engine.php");
$engine = new EngineCMS();

// Apply ACL
recurseInsert("acl.php","php");
$engine->accessControl("build");

// Connect to the database
$engine->dbConnect("database","pa",TRUE);

// Instantiate the fileHandler class
$fManager = new fileHandler($engine);

// Instantiate the snippets class
$GLOBALS['snippetObject'] = $snippets = new Snippet($engine,'snippets','value');

// Get the list of allowed MIME types from the database
define("ALLOWED_FILE_TYPES", trim($snippets->display("allowedFileTypes","value")));

// Start form and file validation
$allowedFileTypes = explode(',', ALLOWED_FILE_TYPES);
$errors = array();

// Check the file uploaded
if(array_key_exists('issueFile', $_FILES)){
    switch($_FILES['issueFile']['error']){
        case UPLOAD_ERR_OK:
            // No upload error
            break;
        case UPLOAD_ERR_INI_SIZE:
            $errors[] = "Max filesize excesed! [PHP]";
            break;
        case UPLOAD_ERR_FORM_SIZE:
            $errors[] = "Max filesize excesed! [HTML]";
            break;
        case UPLOAD_ERR_PARTIAL:
            $errors[] = "Partial file sent!";
            break;
        case UPLOAD_ERR_NO_FILE:
            $errors[] = "No file uploaded!";
            break;
        case UPLOAD_ERR_NO_TMP_DIR:
            $errors[] = "File I/O error! [type: 1]";
            break;
        case UPLOAD_ERR_CANT_WRITE:
            $errors[] = "File I/O error! [type: 2]";
            break;
        case UPLOAD_ERR_EXTENSION:
            $errors[] = "File I/O error! [type: 3]";
            break;
        default:
            $errors[] = "Unknown error condition!";
            break;

    }
    if($_FILES['issueFile']['error'] == UPLOAD_ERR_OK and isset($allowedFileTypes[$fManager->getMimeType($_FILES['issueFile']['tmp_name'])])){
        $errors[] = "Invalid file type!";
        /*
         * We're going to be denied, the only way to allow this file is if there's no MIME checking util available, 
         * and the file extention maps to an allowed type. This is a bit of a security hole, as it effectivly is only checking
         * the file's extention which can be spoofed.
         */
        if(!class_exists('finfo') and !function_exists('mime_content_type')){
            $newName = uniqid()."_".$_FILES['issueFile']['name'];
            if(rename($_FILES['issueFile']['tmp_name'], $newName) and isset($allowedFileTypes[$fManager->getMimeType($newName)])){
                array_pop();
            }
        }
    }
}else{
    $errors[] = "No file was uploaded!";
}

// Check the remaining form
if(!$engine->cleanPost['HTML']['issueNumber']) $errors[] = "You must provide an issue number!";
if($engine->cleanPost['HTML']['issueNumber'] and !is_numeric($engine->cleanPost['HTML']['issueNumber'])) $errors[] = "Issue number must be an number!";
if(!checkdate($engine->cleanPost['HTML']['issueDate_month'], $engine->cleanPost['HTML']['issueDate_day'], $engine->cleanPost['HTML']['issueDate_year'])){
    $errors[] = "Invalid issue date!";
}

// Start the output headers
header("Content-type: text/html");
echo "<ajaxUpload>";
echo sprintf("<errorCount>%s</errorCount>\n", sizeof($errors));


// Decide what part to run based on if there were error(s)
if(!sizeof($errors)){
    // get the file extention
    $filenameParts = explode('.', $_FILES['issueFile']['name']);
    $fileExt = array_pop($filenameParts);

    $fHandle = fopen($_FILES['issueFile']['tmp_name'], 'r');
    $fContent = fread($fHandle, $_FILES['issueFile']['size']);

    $sql = sprintf("INSERT INTO `paFiles` (`name`, `issueDate`, `issueYear`, `issueNumber`, `type`, `size`, `content`, `date`) VALUES('%s','%s-%s-%s','%s','%s','%s','%s','%s',NOW())",
        $engine->openDB->escape($_FILES['issueFile']['name']),
        $engine->cleanPost['MYSQL']['issueDate_year'], $engine->cleanPost['MYSQL']['issueDate_month'], $engine->cleanPost['MYSQL']['issueDate_day'],
        $engine->cleanPost['MYSQL']['issueDate_year'],
        $engine->cleanPost['MYSQL']['issueNumber'],
        $engine->openDB->escape($_FILES['issueFile']['type']),
        $engine->openDB->escape($_FILES['issueFile']['size']),
        $engine->openDB->escape($fContent)
    );
    $engine->openDB->sanitize = FALSE;
    $sqlInsert                = $engine->openDB->query($sql);

    echo sprintf("<userAlert>%s</userAlert>\n", webHelper_successMsg("The issue has been created successfuly."));
    echo sprintf("<file>\n");
    echo sprintf("<success>%s</success>\n", (int)($_FILES['issueFile']['error'] == UPLOAD_ERR_OK));
    echo sprintf("<name>%s</name>\n", $_FILES['issueFile']['name']);
    echo sprintf("<size>%s</size>\n", $fManager->displayFileSize($_FILES['issueFile']['size']));
    echo sprintf("<mimeType>%s</mimeType>\n", $fManager->getMimeType($_FILES['issueFile']['tmp_name']));
    echo sprintf("<extention>%s</extention>\n", $fileExt);
    echo sprintf("</file>");
    echo sprintf("<issue>\n");
    echo sprintf("<issueDate>%s-%s-%s</issueDate>\n", $engine->cleanPost['MYSQL']['issueDate_year'], $engine->cleanPost['MYSQL']['issueDate_month'], $engine->cleanPost['MYSQL']['issueDate_day']);
    echo sprintf("<issueYear>%s</issueYear>\n", $engine->cleanPost['MYSQL']['issueDate_year']);
    echo sprintf("<issueNumber>%s</issueNumber>\n", $engine->cleanPost['MYSQL']['issueNumber']);
    echo sprintf("</issue>");
    echo sprintf("<db>\n");
    echo sprintf("<success>%s</success>\n", (int)($sqlInsert['affectedRows']==1));
    echo sprintf("<errorMsg>%s</errorMsg>\n", (string)$sqlInsert['error']);
    echo sprintf("<id>%s</id>\n", (int)$sqlInsert['id']);
    echo sprintf("</db>");

}else{
    // Some error(s) occurred!
    $LIs = array();
    foreach($errors as $error){
        $LIs[] = '<li>'.$error.'</li>';
    }
    echo sprintf("<userAlert>%s</userAlert>\n", webHelper_errorMsg("The following error(s) occured:<br>".implode("\n", $LIs)));
}

// close the pseudo XML/HTML document and exit
echo "</ajaxUpload>";
exit();