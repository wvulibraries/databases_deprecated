<?php
require_once("/home/library/public_html/includes/engineHeader.php");

// Change the second argument to this function to set the page title. 
// Must be in single quotes. 
localvars::add("pageTitle",'WVU Libraries: Scifinder Scholar');
localvars::add("pageImg","http://www.libraries.wvu.edu/images/2012/facebookDefault.png");

// localvars::add("excludeToolbar","TRUE");

// Change the second argument to this function to set a different template for the page
$engine->eTemplate("load","library2012.3col");

$engine->eTemplate("include","header");
?>

<!-- Page Content Goes Below This Line -->
<header>
	<h1>SciFinder Scholar</h1>
</header>

<h2>
			      Description:
			    </h2>

			    <p class="normal">
			      SciFinder Scholar contains references and abstracts for articles in the chemical 
			      literature (Chemical Abstracts) from 1907 to the present.  Disciplines covered 
			      include chemistry, biochemistry, chemical engineering, and related sciences. 
			    </p>

			    <hr />

			    <h2>Access:</h2>

				<p class="normal">
					To access SciFinder you must first <a href="https://scifinder.cas.org/registration/index.html?corpKey=92E01248-86F3-F00A-118B-5F2F72172EFA">create an account</a>.  Then, <a href="https://scifinder.cas.org">log on</a> any time thereafter.
				</p>
				<p class="normal">
					SciFinder is set to time-out after twenty minutes of inactivity. Be sure to save your work frequently. 
				</p>

			    <hr />

			    <h2>System Availability:</h2>

			    <p class="normal">
			      The operating hours for SciFinder Scholar are - Sunday 1:00AM until Saturday 10:00PM Eastern 
			      Standard Time.  On the first Saturday of each month, SciFinder Scholar will only be available 
			      until 5:00PM, and will not be accessible again until 1:00AM Sunday.
			    </p>

			    <hr />

			    <h2>Restrictions:</h2>

			    <p class="normal">
			      SciFinder Scholar is available for use by current WVU faculty, students and staff. It may be 
			      used for individual research purposes.  All other use is prohibited.
			    </p>

				<hr />

			    <p class="normal">
			      Visit 
			      <a href="http://www.cas.org/support/scifi/index.html">
				SciFinder Scholar Resources
			      </a> 
			      for an interactive tutorial and user guides.
			    </p>

			    <hr />

			    <h2>
			      Key Contact:
			    </h2>

			    <div class="contact">
			      <p class="normal">
				Linda Blake <br />
				Downtown Library Reference Department <br />
				(304) 293-0328 <br />
				<a href="mailto:linda.blake@mail.wvu.edu">linda.blake@mail.wvu.edu</a>
			      </p>
			    </div>

<!-- Page Content Goes Above This Line -->

<?php
$engine->eTemplate("include","footer");
?>