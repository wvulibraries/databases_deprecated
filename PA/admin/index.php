<?php
$engineDir = "/home/library/phpincludes/engineAPI/engine";
include($engineDir ."/engine.php");
$engine = new EngineCMS();

// Apply ACL
recurseInsert("acl.php","php");
$engine->accessControl("build");

// Connect to the database
$engine->dbConnect("database","pa",TRUE);

// Get all years that are available in the database
$sql = sprintf("SELECT DISTINCT issueYear AS `year` FROM paFiles ORDER BY issueYear ASC");
$engine->openDB->sanitize = FALSE;
$sqlYears                 = $engine->openDB->query($sql);

// Instantiate the snippets class
$GLOBALS['snippetObject'] = $snippets = new Snippet($engine,'snippets','value');

// Fire up the Template Enging
$engine->localVars("pageTitle", $snippets->display("pageTitle","value")." Administration");
$engine->localVars("baseURL", $snippets->display("baseURL","value"));
$engine->eTemplate("load","database");
$engine->eTemplate("include","header");
//recurseInsert("headerNav.php","php");
?>
{engine name="insertCSRF"}
<div id="userAlert">Test Message!</div>
<div id="adminHeader">
    <h1>{snippet field="value" id="name"} Administration</h1>
    <div id="adminMenu">
        <span><a href="{snippet field="value" id="baseURL"}/admin/">Home</a></span>
        <span><a href="#browser" onclick="issueBrowser('open');">Browse collection</a></span>
        <span><a href="#new" onclick="newIssue('open');">Create new issue</a></span>
        <span><a href="#snippets" onclick="snippetEditor('open');">Snippets</a></span>
        <span><a href="{engine var="logoutPage"}?csrf={engine name="csrfGet"}">Logout</a></span>
    </div><hr width="60%" size="1" noshade>
</div>
<div id="issueBrowser" style="display:none;">
    <div id="browse-yearMenu">
        <h2>Available years:</h2>
        <hr>
        <?php if($sqlYears['result']){ ?>
        <ul>
            <?php
            while($row = mysql_fetch_array($sqlYears['result'], MYSQL_ASSOC)){
                echo sprintf('<li class="yearMenuNode" id="yearMenuNode-%s"><a href="javascript:loadYear(%s);" class="yearMenuLink">%s</a><img src="../images/ajaxLoader.gif" alt="Loading..." class="yearMenuWait" style="display:none;"></li>',
                    $row['year'],$row['year'],$row['year']
                );
            }
            ?>
        </ul>
        <br>
        <?php }else{ ?>
            <b><i>No years available yet</i></b>
        <?php } ?>
    </div>
    <div id="browse-issueList"></div>
</div>
<div id="newIssue" style="display:none;">
    <form id="newIssueForm" method="post" enctype="multipart/form-data" action="upload.ajax.php" target="uploadAJAX" onsubmit="newIssueAJAX()">
        {engine name="insertCSRF"}       
        <table align="center">
            <tr>
                <td valign="top">File: <sup class="req">*</sup></td>
                <td>
                    <input type="file" name="issueFile">
                    <br>
                    <a href="javascript:" onclick="$('#allowedFileTypes').slideToggle(); this.blur();">View allowed file types</a>
                    <ul id="allowedFileTypes" style="display:none;">
                        <?php
                        $allowedTypes = explode(',', $snippets->display('allowedFileTypes','value'));
                        foreach($allowedTypes as $allowedType){
                            echo "<li>$allowedType</li>";
                        }
                        ?>
                    </ul>
                </td>
            </tr>
            <tr>
                <td>Issue date: <sup class="req">*</sup></td>
                <td>{engine name="function" function="dateDropDown" formname="issueDate" monthdformat="month" endyear="<?php echo date('Y') ?>"}</td>
            </tr>
            <tr>
                <td>Issue number: <sup class="req">*</sup></td>
                <td><input type="text" name="issueNumber"></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" value="Create issue"><br><br>
                    <img src="../images/ajaxLoaderBig.gif" alt="Loading..." id="newIssueWait" style="display:none;">
                </td>
            </tr>
        </table>
        <iframe style="display:none;" id="uploadAJAX" name="uploadAJAX" onload="if(uploadAJAX.location.href != 'about:blank') newIssueAJAX_finish()"></iframe>
    </form>
</div>
<div id="snippetEditor" style="display:none;">
    <div id="snippetMenu">
    <?php
    $listObj = new listManagement($engine, 'snippets');
    $listObj->whereClause = (checkGroup('libraryDept_dlc_systems')) ? '' : " WHERE `systems`='0'";
    $listObj->orderBy = "ORDER BY `ID` ASC";
    $listObj->noSubmit=true;
    $listObj->deleteBox=false;
    $listObj->addField(array(
        'field' => "ID",
        'label' => "ID",
        'size' => "15",
        'readonly' => true
    ));
    $listObj->addField(array(
        'field' => "name",
        'label' => "Name",
        'readonly' => true,
        'size' => "30"
    ));
    $listObj->addField(array(
        'label' => "",
        'type' => "plainText",
        'field' => sprintf('<a href="javascript:editSnippet(\'{ID}\');" id="snippetEditLink-{ID}">Edit</a><img src="../images/ajaxLoader.gif" alt="Loading..." id="snippetEditWait-{ID}" style="display:none;">')
    ));
    echo $listObj->displayEditTable();
    ?>
    </div>
    <div id="snippetEditorArea"></div>
</div>
<?php $engine->eTemplate("include","footer"); ?>