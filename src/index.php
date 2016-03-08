<?php

require "engineHeader.php";

$localvars->set("subjects",lists::subjects());

$localvars = localvars::getInstance();
$localvars->set("adminDisplay","display:none;");
$localvars->set("letters",lists::letters());

$dbObject  = new databases;
$databases = $dbObject->getByType(array("trialDatabase")); //"newDatabase",

$localvars->set("highlighted_databases",lists::databases($databases,false));

$localvars->set("homepage","true");

templates::display('header');
recurseInsert("stylesheets/homepage.css");

?>

<!-- Homepage Content -->
<span class="hp">
	<span class="hpl">
		<h2>Database Search</h2>

		<?php recurseInsert("includes/searchBox.php","php") ?>
		<div style="clear:both;"></div>

		<h2>Databases by Title</h2>
		{local var="letters"}

		<div style="clear:both;"></div>

		<h2>Databases by Subject</h2>
		{local var="subjects"}
	</span>

	<?php if(!is_empty($localvars->get("highlighted_databases"))) {?>
	<span class="hpr">
		<span class="hprwrap">
			<h2>Trial Databases</h2>
			{local var="highlighted_databases"}
	</span></span>

	<style>
		.hpl {
			width: 100%;
			display: block;
			float: left;
		}
		.hpr {
			width: 100%;
			display: block;
			float: left;
		}
		.hprwrap {
			display: block;
			float: left;
			border: none;
			padding: 40px 0px;
		}
		.hprwrap h2 {
			margin-top: 0 !important;
		}
		@media screen and (min-width: 1024px) {
			.hpl {
				width: 66%;
			}
			.hpr {
				width: 34%;
			}
			.hprwrap {
				border: 1px solid #EAAA00;
				padding: 20px;
			}
		}
	</style>
		<?php } ?>
</span>

<div style="clear:both;"></div>

<div class="hphelp">
    <h2>Help with Databases</h2>
    <p>
        Most databases are available off-campus to current WVU-Morgantown students, faculty and
        staff. Licensing restrictions prevent WVU Libraries from providing off-campus access to
        others. Your affiliation with WVU is verified through use of WVU Login. You will be
        prompted to enter this when you choose a database from the menu. For assistance with
        WVU Login, please go to the Information Technology Services (ITS) website at:
        <a href="https://login.wvu.edu/">https://login.wvu.edu/</a>. There you can activate your
        account or change your password. Alternatively, you may call the ITS Help Desk at
        <span class="phoneNumber">(304) 293-4444</span>. If you need assistance with database
        selection or searching please contact:
    </p>
    <div class="hphelp-messagebox">
        <p><a href="mailto:Barbara.Hengemihle@mail.wvu.edu">Barbara Hengemihle</a><br />
        Evansdale Library<br />
        <span class="phoneNumber">(304) 293-9748</span><br /><br />
        Evansdale Library Reference Desk<br />
        <span class="phoneNumber">(304) 293-4695</span></p>
    </div>
    <div class="hphelp-messagebox">
        <p><a href="mailto:Susan.Arnold@mail.wvu.edu">Susan Arnold</a><br />
        Health Sciences Library<br />
        <span class="phoneNumber">(304) 293-2105</span><br /><br />
        Health Sciences Library Reference Desk<br />
        <span class="phoneNumber">(304) 293-6810</span></p>
    </div>
    <div class="hphelp-messagebox">
        <p><a href="mailto:ppugh@wvu.edu">Penny Pugh</a><br />
            Downtown Campus Library<br />
            <span class="phoneNumber">(304) 293-0334</span><br /><br />
            Downtown Campus Library Reference Desk<br />
            <span class="phoneNumber">(304) 293-3640</span>
        </p>
    </div>
    <div>
        <p><a href="http://westvirginia.libanswers.com/">Ask a Librarian</a><br />
            <em>Chat/Text/Email Reference Service</em><br><br>
            <em>If you are having a problem with a database or online resource, please submit an <a href="/databases/report/">eResource Error Report</a>.</em></p>
            <!-- <br><br><strong>For technical problems call</strong> the WVU Library Systems Office at <span class="phoneNumber">(304) 293-0340</span> Monday-Friday, 8 a.m. to 4:00 p.m. or send e-mail to <a href="mailto:libsys@mail.wvu.edu">libsys@mail.wvu.edu</a>. -->
    </div>
</div>

<?php
templates::display('footer');
?>
