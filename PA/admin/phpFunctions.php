<?php
	$dataDir = "/data";

	function getSubdirectories($dir) {
		$subDirs = array();

		if (is_dir($dir))
			if ($dh = opendir($dir)) {
				while (($file = readdir($dh)) !== false) {
					
					if (is_dir($dir."/".$file) && strcmp($file, ".") != 0 && strcmp($file, "..") != 0)
						array_push($subDirs, $file);
				}

				closedir($dh);
				sort($subDirs);
				return $subDirs;
			}
	}

	function listAllDirs($dir, $selected) {
		global $dataDir;
		$subDirs = getSubdirectories($dir);

		foreach($subDirs as $subDir) {
			/* Only list directories under ./data/ for PA site               */
			/* This 'if' condition may be removed to list all subdirectories */
			if (strcmp(dirname($dir."/".$subDir), dirname(getcwd()).$dataDir) == 0) {
				print "<option value=\"";
				print $dir."/".$subDir;
				print "\"";
	
				if (strcmp($dir."/".$subDir, $selected) == 0)
					print " selected";
	
				print ">";
				// print $dir."/".$subDir;
				print $subDir;
				print "</option>";
			}
				
			listAllDirs($dir."/".$subDir, $selected);
		}
	}
	
	function listAllYears($selected) {
		global $dbhost;
		global $dbuser;
		global $dbpass;
		global $dbname;
		global $dbtable;
		$conn = connect($dbhost, $dbuser, $dbpass, $dbname);
		$query = sprintf("SELECT year FROM %s ORDER BY year", mysql_real_escape_string($dbtable));
		$result = mysql_query($query);
		$allYears = array();
		
		for ($i = 0; $i < mysql_num_rows($result); $i++) {
			if (!mysql_data_seek($result, $i)) {
				echo "Cannot seek to row $i: " . mysql_error() . "\n";
				continue;
			}

			if (!($row = mysql_fetch_assoc($result))) {
				continue;
			}

			array_push($allYears, $row['year']);
		}

		disconnect($conn);
		$allYears = dedupe($allYears);
		
		foreach($allYears as $year) {
			print "<option value=\"";
			print $year;
			print "\"";

			if (strcmp($year, $selected) == 0)
				print " selected";

			print ">";
			print $year;
			print "</option>";
		}
	}
	
	function dedupe($array) {
		if (count($array) == 0)
			return $array;

		$newArray = array();
		array_push($newArray, $array[0]);
		$prevElement = $array[0];
		
		for ($i=1; $i<count($array); $i++) {
			if (strcmp($array[$i], $prevElement) != 0)
				array_push($newArray, $array[$i]);
			
			$prevElement = $array[$i];
		}

		return $newArray;
	}
	
	function listAllFiles($dir) {
		global $dbhost;
		global $dbuser;
		global $dbpass;
		global $dbname;
		global $dbtable;
		$conn = connect($dbhost, $dbuser, $dbpass, $dbname);
		$query = sprintf("SELECT year, name, type, size, date FROM %s ORDER BY name",
					mysql_real_escape_string($dbtable));
		$result = mysql_query($query);
		
		/* fetch rows in reverse order */
		print "<table>\n";
		$lineCount = 0;

		for ($i = 0; $i < mysql_num_rows($result); $i++) {
			if (!mysql_data_seek($result, $i)) {
				echo "Cannot seek to row $i: " . mysql_error() . "\n";
				continue;
			}

			if (!($row = mysql_fetch_assoc($result))) {
				continue;
			}

			if ($i == 0) {
				print "<tr class=\"tableTitle\">";
				print "<td>Year</td>";
				print "<td>Filename</td>";	
				print "<td>Type</td>";	
				print "<td>Size</td>";
				print "<td>Upload Date</td>";
				print "</tr>\n";
			}

			if (strcmp($dir, $row['year']) == 0) {
				print "<tr ";
				
				if ($lineCount % 2 == 0)
					print "class=\"even\">";
				else
					print "class=\"odd\">";
					
				print "<td>".$row['year']."</td>";
				print "<td>".$row['name']."</td>";	
				print "<td>".$row['type']."</td>";	
				print "<td>".$row['size']."</td>";
				print "<td>".$row['date']."</td>";
				print "</tr>\n";
				$lineCount++;
			}
		}

		print "</table>\n";
		disconnect($conn);
	}
	
	function listAllFilesAsList($dir) {
		$files = array();
		global $dbhost;
		global $dbuser;
		global $dbpass;
		global $dbname;
		global $dbtable;
		$conn = connect($dbhost, $dbuser, $dbpass, $dbname);
		$query = sprintf("SELECT year, name FROM %s ORDER BY name",
					mysql_real_escape_string($dbtable));
		$resultFromView = mysql_query($query);
		
		for ($i = 0; $i < mysql_num_rows($resultFromView); $i++) {
			if (!mysql_data_seek($resultFromView, $i)) {
				echo "Cannot seek to row $i: " . mysql_error() . "\n";
				continue;
			}

			if (!($row = mysql_fetch_assoc($resultFromView))) {
				continue;
			}
			
			if (strcmp($dir, $row['year']) == 0) {
				array_push($files, $row['name']);
			}
		}

		disconnect($conn);

		if ($files)
			foreach($files as $file)
				print "<option>".$file."</option>";
		else
			print "<option></option>";
	}
	
	function isEmpty($dir) {
		if (is_dir($dir)) {
			if ($dh = opendir($dir)) {
				while (($file = readdir($dh)) !== false)
					if (!is_dir($dir."/".$file) && strcmp($file, ".") != 0 && strcmp($file, "..") != 0)
						return 0;

				closedir($dh);
				return 1;
			}
		}
		else
			return 1;
	}
	
	function getTargetDirectory($filename) {
//		global $dataDir;
		
		/* Remove file extension if found */
		$posOfDot = strrpos($filename, ".");
		
		if ($posOfDot !== false)
			$filename = substr($filename, 0, -(strlen($filename)-$posOfDot));
	
		if (strlen(filename) < 4)
			return "0000";
		else if (strlen($filename) == 4)
			$filename = "20".$filename;

		$first4Characters = substr($filename, 0, -(strlen($filename)-4));

		if (ctype_digit($first4Characters))
			return $first4Characters;
		else
			return "0000";
	}
	
	function isPaFileFormat($filename) {
		$posOfDot = strrpos($filename, ".");

		if ($posOfDot === false)
			return 0;
		
		$filename = substr($filename, 0, -(strlen($filename)-$posOfDot));	

		if (strlen($filename) < 4)
			return 0;

		if (strlen($filename) > 4)			
			$first4Characters = substr($filename, 0, -(strlen($filename)-4));
		else
			$first4Characters = $filename;
		
		if (ctype_digit($first4Characters))
			return 1;
		else
			return 0;
	}
	
	function isExisting($year, $filename) {
		global $dbhost;
		global $dbuser;
		global $dbpass;
		global $dbname;
		global $dbtable;
		$conn = connect($dbhost, $dbuser, $dbpass, $dbname);
		$query = sprintf("SELECT year, name FROM %s", mysql_real_escape_string($dbtable));
		$result = mysql_query($query);
		
		for ($i = 0; $i < mysql_num_rows($result); $i++) {
			if (!mysql_data_seek($result, $i)) {
				echo "Cannot seek to row $i: " . mysql_error() . "\n";
				continue;
			}

			if (!($row = mysql_fetch_assoc($result))) {
				continue;
			}
	
			if (strcmp($filename, $row['name']) == 0 && strcmp($year, $row['year']) == 0) {
				include("/home/library/phpincludes/disconnected.php");
				return 1;
			}
		}

		disconnect($conn);
		return 0;
	}
?>
