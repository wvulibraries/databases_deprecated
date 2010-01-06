<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<!-- Copyright 2007 WVU Libraries            -->
<!-- Michael Bond                            -->

<?php
	include("/home/library/phpincludes/paConnectionFunctions.php");
	$conn = connect($dbhost, $dbuser, $dbpass, $dbname);
	$query = sprintf("SELECT year, name FROM %s ORDER BY year, name", mysql_real_escape_string($dbtable));
	$result = mysql_query($query);
	disconnect($conn);
	
	function listAllYears() {
		global $result;
		$allYears = array();
		$prevYear = "";
		
		for ($i = 0; $i < mysql_num_rows($result); $i++) {
			if (!mysql_data_seek($result, $i)) {
				echo "Cannot seek to row $i: " . mysql_error() . "\n";
				continue;
			}

			if (!($row = mysql_fetch_assoc($result))) {
				continue;
			}

			if (strcmp($prevYear, $row['year']) != 0) {
				array_push($allYears, $row['year']);
			}
				
			$prevYear = $row['year'];
		}

		return $allYears;
	}

	function list_files($dir) {
		global $result;
		$allFiles = array();
		
		for ($i = 0; $i < mysql_num_rows($result); $i++) {
			if (!mysql_data_seek($result, $i)) {
				echo "Cannot seek to row $i: " . mysql_error() . "\n";
				continue;
			}

			if (!($row = mysql_fetch_assoc($result))) {
				continue;
			}

			if (strcmp($dir, $row['year']) == 0)
				array_push($allFiles, $row['name']);
		}

		return $allFiles;
	}
?>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<title>WVU Libraries: Petroleum Abstracts</title>

	<!-- importStyles.css HAS to be linked using import. This is for     -->
	<!-- legacy web browsers. DO NOT CHANGE                              -->
	<style type="text/css" media="all">
	@import url(http://www.libraries.wvu.edu/css/importStyles.css);
	</style>

	<!-- we don't support older browsers anymore, this styles the content -->
	<!-- that the older browsers see (content in .skipLink)               -->
	<link rel="stylesheet" href="http://www.libraries.wvu.edu/css/oldBrowsers.css" type="text/css" media="screen" />

	<!-- Dropdown Menu style sheet                                     -->
	<!-- Broke this out since it was almost identical to the menus on  -->
	<!-- on the interior pages. interior.css handles the differences   -->
	<link rel="stylesheet" href="http://www.libraries.wvu.edu/css/dropdownMenus.css" type="text/css" media="screen" />

	<!-- Main style sheet for the interior pages -->
	<link rel="stylesheet" href="http://www.libraries.wvu.edu/css/interior.css" type="text/css" media="screen" />
	
	<!-- Handles the links in the header image -->
	<link rel="stylesheet" href="http://www.libraries.wvu.edu/css/interiorHeader.css" type="text/css" media="screen" />

	<!-- Standard 'functions'; Bold, Italic, etc ... -->
	<link rel="stylesheet" href="http://www.libraries.wvu.edu/css/standard.css" type="text/css" media="screen" />

	<!-- Defines the header image for the current page                       -->
	<!-- I like the idea of using ./images/banner.gif for all interior pages -->
	<!-- and symlinks to handle not duplicating ... but I think that might   -->
	<!-- be too  difficult to manage                                         -->
	<style type="text/css" media="all">
	#headerImageMap {
		background-image: url("http://www.libraries.wvu.edu/images/banners/petroleumabs.gif");
	}
	</style>

	<!-- Internet Explorer 6 Style Sheet                               -->
	<!-- Style sheet to handle bugs specific to IE6                    -->
	<!--[if IE 6]>
	<link rel="stylesheet" href="http://www.libraries.wvu.edu/css/ie6.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="http://www.libraries.wvu.edu/css/ie6int.css" type="text/css" media="screen" />
	<script src="http://www.libraries.wvu.edu/javascript/iehover.js" type="text/javascript"></script>
	<![endif]-->

	<!-- Internet Explorer 7 Style Sheet                               -->
	<!-- Style sheet to handle bugs specific to IE7                    -->
	<!--[if IE 7]>
	<link rel="stylesheet" href="http://www.libraries.wvu.edu/css/ie7.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="http://www.libraries.wvu.edu/css/ie7int.css" type="text/css" media="screen" />
	<![endif]-->

	<!-- Internet Explorer Style Sheet                                  -->
	<!-- This style sheet is used to fix bugs commont o all IE versions -->
	<!-- iehover.js is a work around to IEs :hover bug                  -->
	<!--[if IE]>
	<link rel="stylesheet" href="http://www.libraries.wvu.edu/css/ieint.css" type="text/css" media="screen" />
	<![endif]-->

	<!-- Dirty Hack to fix a windows font size problem with the menu bar -->
	<!-- Not applied to Safari 3 beta on Windows                         -->
	<script src="http://www.libraries.wvu.edu/javascript/winfont.js" type="text/javascript"></script>
	<script src="http://www.libraries.wvu.edu/javascript/winFox.js" type="text/javascript"></script>

	<!-- Couple of fixes for Safari 2                                   -->
	<!-- (not worrying about safari 3 until its out of beta, not gonna  -->
	<!-- chase bugs till they are done)                                 -->
	<script src="http://www.libraries.wvu.edu/javascript/safari.js" type="text/javascript"></script>

	<!-- Javascript that handles the 'toggle' features on this page -->
	<script type="text/javascript" src="http://www.libraries.wvu.edu/javascript/toggle.js"></script>

	<!-- PA defined CSS -->
    <link rel="stylesheet" type="text/css" href="css/main.css" media="screen" />
	
</head>
<body>

	<div class="skipLink">
		<p>
			<br />
			<strong>
				This site will work and look better in a modern Web browser that supports Web
				Standards such as XHTML and CSS. Please visit the 
				<a href="/browserupgrade/"> WVU Libraries Web Browser Upgrade page for more information </a>
				on upgrading your web browser. 
				<br /><br />
				WVU Libraries strongly recommends upgrading your web browser, but will continue 
				to provide a site that will be functional in all web browsers. 
			</strong>
			<br />

		</p>
	</div>

	<div id="mainDiv">
		<div id="header">
			<div id="headerImageMap">
				<a href="http://www.wvu.edu" title="WVU Homepage" id="headerWVULogo"></a>

				<ul id="headerImageMapList">
					<li id="headSiteMap">
						<a href="http://www.wvu.edu/siteindex/" title="WVU Sitemap">A-Z Site Index</a> 
						&nbsp;&middot;&nbsp;			
					</li>
					<li id="headCampusMap">
						<a href="http://www.wvu.edu/CampusMap/" title="Campus Map">Campus Map</a>
						&nbsp;&middot;&nbsp;
					</li>
					<li id="headDirectory">
						<a href="http://directory.wvu.edu" title="Campus Map">Directory</a>
						&nbsp;&middot;&nbsp;
					</li>
					<li id="headerContactUs">
						<a href="http://www.libraries.wvu.edu/contactus" title="Contact WVU Libraries">Contact Us</a>
						&nbsp;&middot;&nbsp;
					</li>
					<li id="headerHours">
						<a href="http://www.libraries.wvu.edu/hours" title="WVU Library Hours">Hours</a> 
						&nbsp;&middot;&nbsp;
					</li>
					<li id="headerWVUHome">
						<a href="http://www.wvu.edu" title="WVU Homepage">WVU Home</a>
					</li>
				</ul> <!-- headerImageMap -->
				
				<a href="/" id="headerLibaryHome" title="WVU Libraries Home"></a>
				
			</div>
			<ul id="dropMenuList" class="Font12px boldText">
				<li id="dmlFirst"><a href="/find/" title="Find" class="links">Find</a>
					<ul id="ieHack0">
						<li><a href="/find/articles.html">Articles</a></li>
						<li><a href="/find/books.html">Books</a></li>
						<li><a href="/digitalcollections/websearch/images.htm">Images</a></li>
						<li><a href="/find/movies.html">Movies</a></li>
						<li><a href="/digitalcollections/websearch/audiovideo.htm">Sound &amp; Video</a></li>
                        <li><a href="/web/">Web Sites</a></li>
					</ul>
				</li>
				<li><a href="/services/" title="Services" class="links">Services</a>
					<ul id="ieHack1">
						<li><a href="/borrowing/">Borrowing</a></li>
						<li><a href="/copies/">Copying</a></li>
						<li><a href="http://requests.lib.wvu.edu/">Depository Journals</a></li>
						<li><a href="/disability/">Disabilities</a></li>
						<li><a href="/distance/">Distance Education</a></li>
						<li><a href="/reserves/">eReserves &amp; Reserves</a></li>
						<li><a href="http://illiad.lib.wvu.edu/">Interlibrary Loan</a></li>
							<li><a href="/borrowing/renew.htm">Renew Books Online</a></li>
                            <li><a href="/services/suggestions/">Suggest a Purchase</a></li>
					</ul>
				</li>					       
				<li><a href="/collections/" title="Libraries and Collections" class="links">Libraries &amp; Collections</a>
					<ul id="ieHack2">
						<li><a href="/collections/">All Libraries &amp; Collections</a></li>
						<li><a href="/appalachian/">Appalachian Collection</a></li>
						<li><a href="/digitalcollections/collections/">Digital Collections</a></li>
						<li><a href="/government/">Government Information</a></li>
						<li><a href="/downtown/maps.htm">Map Room</a></li>
						<li><a href="/media/">Media Services</a></li>
						<li><a href="/patents/">Patents &amp; Trademarks</a></li>
						<li><a href="/etds/">Theses &amp; Dissertations</a></li>
					</ul>
				</li>
				<li><a href="/instruction/" title="Help and Instruction" class="links">Help &amp; Instruction</a>
					<ul id="ieHack3">
						<li><a href="/ask/">Ask a Librarian</a></li>
						<li><a href="/instruction/classes.htm">Classes</a></li>
						<li><a href="/computers/">Computing</a></li>
						<li><a href="/faculty/tools.html">Faculty Information</a></li>
						<li><a href="/instruction/guides.htm">Guides &amp; Tutorials</a></li>
						<li><a href="/reference/">Reference Online</a></li>
						<li><a href="/instruction/clinic.htm">Term Paper Clinic</a></li>
					</ul>
				</li>
				<li id="dmlLast">
					<a href="/information/" title="Hours and Information" class="links">Hours &amp; Information</a>
					<ul id="ieHack4">
						<li><a href="/directions/">Driving Directions</a></li>
						<li><a href="/hours/">Hours</a></li>
						<li><a href="/friends/">Library Friends &amp; News</a></li>
						<li><a href="/history/">Library History</a></li>
                        <li><a href="/maps/">Library Maps</a></li>
						<li><a href="/policies/">Library Policies</a></li>
						<li><a href="/policies/strategicplan.pdf">Strategic Plan</a></li>
						<li><a href="/virtualtour/">Virtual Tour</a></li>
					</ul>
				</li>
			</ul> <!-- dropMenuList -->

		</div> <!-- header -->

		<div id="content">
			<div id="left">

				<ul>
					<li class="noBorder">Available Years
						<ul>			
							<?php
								foreach (listAllYears() as $publicationYear) {
									print "<li>";
									print "<input type=\"checkbox\" name=\"";
									print $publicationYear;
									print "\" onclick=\"toggle(this)\" /> ";
									print $publicationYear;
									print " Issues";
									print "</li>\n";
								}
							?>
						</ul>
					</li>
				</ul>
			</div>

			<div id="rightScroll">
				<h2>Petroleum Abstracts</h2>
				
				<p>Select the year(s) on the left to see the issues of Petroleum Abstracts available for that year.</p>

				<?php
					foreach (listAllYears() as $publicationYear) {
						print "<div class=\"hide ";
						print $publicationYear;
						print "\" style=\"display:none;\">\n";
						print "<h3>".$publicationYear." Issues</h3>\n";
						print "<ul>\n";

						foreach (list_files($publicationYear) as $paFile) {
							/* Remove file extension */
							$posOfDot = strrpos($paFile, ".");
							$issueNumber = substr($paFile, 0, -(strlen($paFile)-$posOfDot));
							
							/* Only keep the last 3 digits */	
							$issueNumber = substr($issueNumber, -3);
					
							print "<li><a href=\"content.php?filename=".$paFile."\">Issue ".$issueNumber."</a></li>\n";
						}

						print "</ul>\n";
						print "</div>\n";
					}
				?>
			</div>
		</div>

		<div id="footer" class="Font8pt">
			<p id="footerLeft">
				West Virginia University Libraries <br />
				P.O. Box 6069 WVU <br />
				1549 University Ave <br />
				Morgantown, WV 26506-6069
			</p>
			<p id="footerRight">
				<span class="bold">Phone</span>: 304.293.4040 <br />
				<span class="bold">Fax</span>: 304.293.6638 <br />
				<span class="bold">Email</span>: <a href="/contactus">ask_a_librarian@mail.wvu.edu</a> <br />
				<span class="boldText"><a href="/copyright/" title="WVU Libraries Copyright Statement">&copy; WVU Libraries</a></span>
			</p> 
		</div>

	</div>

</body>

</html>