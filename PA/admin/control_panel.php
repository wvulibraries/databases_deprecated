<?php
	include("/home/library/phpincludes/paConnectionFunctions.php");
    session_start();
	
	if ($_SESSION['user_logged']) {
		include("head.html");

	    print "<div id=\"content\">";
	    
	    /* Left */
		print "	<div id=\"left\">";
		print "		<table>";
	    print "			<tr>";
	    print "				<td class=\"itemTitle\">";
	    print "					Welcome ".$_SESSION['username'];
	    print "				</td>";
	    print "				<td class=\"itemDescription\">";
	    						include("logoffForm.php");
	    print "				</td>";
	    print "			</tr>";
	    print "		</table>";
	    print "		<div id=\"nav\">";
	    				include("menu.php");
	    print "		</div>";
		print "	</div>";
		
		/* Right */
		print "	<div id=\"rightScroll\">";
		print "		<h2>Petroleum Abstracts File Management</h2>\n";
					include("phpFunctions.php");

		print "		<form name=\"fileManagement\" action=\"control_panel.php\" method=\"post\" enctype=\"multipart/form-data\">";
						if (strcmp($_POST["submit"], "Upload File") == 0) {
							$targetDirectory = getTargetDirectory(basename($_FILES['fileName']['name']));

							if (strcmp($_FILES['fileName']['name'], "") == 0)
								$resultFromUpload = "3";
							else if (!isPaFileFormat(basename($_FILES['fileName']['name'])))
								$resultFromUpload = "4";
							else {
								if (isExisting($targetDirectory, basename($_FILES['fileName']['name'])))
									$resultFromUpload = "2";
								else {			
									$fileName = $_FILES['fileName']['name'];
									$tmpName  = $_FILES['fileName']['tmp_name'];
									$fileSize = $_FILES['fileName']['size'];
									$fileType = $_FILES['fileName']['type'];							
									$fp      = fopen($tmpName, 'r');
									$content = fread($fp, filesize($tmpName));
									fclose($fp);
									
									if(!get_magic_quotes_gpc()) {
										$fileName = addslashes($fileName);
									}

									$conn = connect($dbhost, $dbuser, $dbpass, $dbname);
									$today = date("Y-m-d H:i:s");
									$query = sprintf("INSERT INTO %s (year, name, size, type, content, date) ".
												"VALUES ('%s', '%s', '%s', '%s', '%s', '%s')",
												mysql_real_escape_string($dbtable),
												mysql_real_escape_string($targetDirectory),
												mysql_real_escape_string($fileName),
												mysql_real_escape_string($fileSize),
												mysql_real_escape_string($fileType),
												mysql_real_escape_string($content),
												mysql_real_escape_string($today));
									$resultFromUpload = mysql_query($query);
									
									if (!$resultFromUpload)
										print "<br><b>".mysql_errno().": ".mysql_error()."!</b>";

									disconnect($conn);
								}
							}

							/*
								if (!file_exists($targetDirectory))
									mkdir($targetDirectory, 0777);
	
								if (file_exists($targetDirectory."/".basename($_FILES['fileName']['name'])))
									$resultFromUpload = "2";
								else
									$resultFromUpload = move_uploaded_file($_FILES['fileName']['tmp_name'], $targetDirectory."/".basename($_FILES['fileName']['name']));
							*/
						}
						else if (strcmp($_POST["submit"], "Rename File") == 0) {
							$targetDirectory = getTargetDirectory($_POST['newName']);
							
							if (!isPaFileFormat($_POST['newName']))
								$resultFromUpload = "4";
							else {
								if (isExisting($targetDirectory, $_POST['newName']))
									$resultFromRename = "2";
								else if (isExisting($_POST['renameDirectory'], $_POST['renameFile'])) {
									$conn = connect($dbhost, $dbuser, $dbpass, $dbname);
									$query = sprintf("UPDATE %s SET year = '%s', name='%s' WHERE year='%s' and name='%s'",
												mysql_real_escape_string($dbtable),
												mysql_real_escape_string($targetDirectory),
												mysql_real_escape_string($_POST['newName']),
												mysql_real_escape_string($_POST['renameDirectory']),
												mysql_real_escape_string($_POST['renameFile']));
									$resultFromRename = mysql_query($query);
									disconnect($conn);
								}
							}
						}
						else if (strcmp($_POST["submit"], "Delete File") == 0) {
							if (isExisting($_POST['deleteDirectory'], $_POST['deleteFile'])) {
								$conn = connect($dbhost, $dbuser, $dbpass, $dbname);
								$query = sprintf("DELETE FROM %s WHERE year='%s' and name='%s'",
											mysql_real_escape_string($dbtable),
											mysql_real_escape_string($_POST['deleteDirectory']),
											mysql_real_escape_string($_POST['deleteFile']));
								$resultFromDelete = mysql_query($query);
								disconnect($conn);
							}
						}
						
						/*
						else if (strcmp($_POST["submit"], "Create Directory") == 0)
							$resultFromCreateDir = mkdir($_POST['createDirDirectory']."/".$_POST['dirName'], 0777);
						else if (strcmp($_POST["submit"], "Remove Directory") == 0)
							$resultFromRemoveDir = rmdir($_POST['removeDirDirectory']);
						*/
	
						include("view.php");
						
						/* Upload File */
						if (strcmp($_POST["submit"], "Upload File") == 0) {
							print "<div id='upload' style='display:block'>";

							if (strcmp($resultFromUpload, "3") == 0)
								print "<b>Error:</b> Invalid filename!<br>";
							else if (strcmp($resultFromUpload, "4") == 0)
								print "<b>Error:</b> ".basename($_FILES['fileName']['name'])." is not the filename of PA format!<br>";
							else if (strcmp($resultFromUpload, "2") == 0)
									print "<b>Error:</b> ".basename($_FILES['fileName']['name'])." was found.<br>";
							else {
								if (!$conn)
									print("<b>Error: Cannot connect to ".$dbname."!</b><br>");
								else {
									if (!$resultFromUpload)
										print "<b>Error: Cannot insert ".$fileName." to ".$dbname."!</b><br>";
									else
										print $_FILES['fileName']['name']." was uploaded.<br>";
								}	
							}
						}
						else
							print "<div id='upload' style='display:none'>";

						include("upload.php");

						/* Rename File */
						if (strcmp($_POST["submit"], "Rename File") == 0 || strcmp($_POST["submit_rename"], "List Files") == 0) {
							print "<div id='rename' style='display:block'>";
							
							if (strcmp($resultFromUpload, "4") == 0)
								print "<b>Error:</b> ".$_POST['newName']." is not the filename of PA format!<br>";
							else if (strcmp($_POST["submit"], "Rename File") == 0) {
								if (strcmp($resultFromRename, "2") == 0)
									print "<b>Error:</b> ".$targetDirectory."/".$_POST['newName']." was found.<br>";
								else if (!$resultFromRename)
									print "<b>Error:</b> ".$_POST['renameDirectory']."/".$_POST['renameFile']." couldn't be renamed as ".$targetDirectory."/".$_POST['newName']."<br>";
								else
									print $_POST['renameDirectory']."/".$_POST['renameFile']." was renamed as ".$targetDirectory."/".$_POST['newName']."<br>";
							}
						}
						else
							print "<div id='rename' style='display:none'>";

						include("rename.php");
						
						/* Delete File */
						if (strcmp($_POST["submit"], "Delete File") == 0 || strcmp($_POST["submit_delete"], "List Files") == 0) {
							print "<div id='delete' style='display:block'>";
							
							if (strcmp($_POST["submit"], "Delete File") == 0) {
								if ($resultFromDelete)
									print $_POST['deleteFile']." was deleted.<br>";
								else
									print "<b>Error:</b> ".$_POST['deleteDirectory']."/".$_POST['deleteFile']." couldn't be deleted.<br>";
							}
						}
						else
							print "<div id='delete' style='display:none'>";
						
						include("delete.php");
							
						/* Create Directory */
//						if (strcmp($_POST["submit"], "Create Directory") == 0) {
//							print "<div id='createDir' style='display:block'>";
//							
//							if (!$resultFromCreateDir)
//								print "<p><b>Error:</b> Couldn't create ".$_POST['createDirDirectory']."/".$_POST['dirName']."<BR>Please try another directory...</p>";
//							else {
//								print "<p>".$_POST['createDirDirectory']."/".$_POST['dirName']." was created successfully!<br>";
//								print "Please select the directory and enter another subdirectory name to create it:</p>";
//							}
//						}
//						else {
//							print "<div id='createDir' style='display:none'>";
//							print "<p>Please select the directory and enter a new subdirectory name to create it:</p>";
//						}
//
//						include("createDir.php");
//						
						/* Remove Directory */
//						if (strcmp($_POST["submit"], "Remove Directory") == 0) {
//							print "<div id='removeDir' style='display:block'>";
							
//							if (!$resultFromRemoveDir)
//								print "<p><b>Error:</b> Couldn't remove ".$_POST['removeDirDirectory']."<BR>Please try another directory...</p>";
//							else {
//								print "<p>".$_POST['removeDirDirectory']." was removed successfully!<br>";
//								print "Please select the directory you wish to remove and click &lt;Remove Directory&gt;:</p>";
//							}
//						}
//						else {
//							print "<div id='removeDir' style='display:none'>";
//							print "<p>Please select the directory you wish to remove and click &lt;Remove Directory&gt;:</p>";
//						}
	
//						include("removeDir.php");
		print "		</form>";
		print "	</div>";
		print "</div>";
		
		include("footer.html");
    }
	else
    	header("location:index.php");
?>
