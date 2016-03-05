<?php $localvars  = localvars::getInstance(); ?>
<!DOCTYPE html>
<html lang="en" class="no-js">
    <head>
        <title>Databases | WVU Libraries</title>

        <!-- Meta Information -->
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="HandheldFriendly" content="True">
        <meta name="MobileOptimized" content="320">
        <meta http-equiv="cleartype" content="on">

        <!-- Author, Description, Favicon, and Keywords -->
        <meta name="author" content="WVU Libraries">
        <meta name="description" content="Browse articles by resource, subject, title, and type of Database, view popular academic Databases as suggested by WVU Librarians, and facet/filter your Database search.">
        <meta name="keywords" content="Database, Databases, Articles, subject databases, subject, title, type of databses, popular databses, facet, filter, search">
        <link rel="shortcut icon" href="https://wvrhc.lib.wvu.edu/favicon.ico">

        <!-- CSS -->
        <link type="text/css" rel="stylesheet" href="{local var="databaseHome"}/stylesheets/variables.css"></link>
        <link type="text/css" rel="stylesheet" href="{local var="databaseHome"}/stylesheets/wvu.css"></link>
        <link type="text/css" rel="stylesheet" href="{local var="databaseHome"}/stylesheets/styles.css"></link>

        <!-- JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="{local var="databaseHome"}/javascript/masonry.pkgd.js"></script>
        <script src="{local var="databaseHome"}/javascript/layout.js"></script>

        <!-- External CSS: Helvetica & Font Awesome -->
        <link type="text/css" rel="stylesheet" href="https://fast.fonts.net/cssapi/36d8cd92-7cc7-499b-b169-0eed9d670283.css"></link>
        <link href="https://netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.css" type="text/css" rel="stylesheet">

        <!-- ShareThis Code (used as you want to implement)
        <script type="text/javascript">var switchTo5x=true;</script>
        <script type="text/javascript" src="https://ws.sharethis.com/button/buttons.js"></script>
        <script type="text/javascript">stLight.options({publisher: "5d559dae-aaf3-4cce-bb7b-a7c904df0cf4", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script> -->

        <?php recurseInsert("headerIncludes.php","php") ?>
    </head>
    <body>
        <!-- Ask A Librarian  -->
        <div class="ask"><a href="http://westvirginia.libanswers.com/"><img title="Ask A Librarian" alt="Ask A Librarian" src="https://lib.wvu.edu/images/2014/ask.png"></a></div>

        <!-- WVU Header -->
        <div class="wvu-header mobile wvubottom">
            <a href="#" id="wvutoggle" class="wvu-masthead__logo wvu-masthead__logo--w-signature">
                <img src="{local var="databaseHome"}/images/wvulogo.svg" alt="WVU Libraries">
                <i class="fa fa-chevron-down"></i>
                <i class="fa fa-chevron-up"></i>
            </a>
            <ul class="list">
                <li><a class="links" href="https://lib.wvu.edu/about/">About</a></li>
                <li><a class="links" href="https://lib.wvu.edu/collections/">Collections</a></li>
                <li><a class="links" href="https://lib.wvu.edu/instruction">Instruction</a></li>
                <li><a class="links" href="https://lib.wvu.edu/about/news/">News</a></li>
                <li><a class="links" href="https://lib.wvu.edu/services/">Services</a></li>
                <li><a class="links" href="https://lib.wvu.edu/about/contactus/">Contact</a></li>
                <li><a class="links" href="https://lib.wvu.edu/about/giving/">Give</a></li>
                <li><a class="links" href="https://lib.wvu.edu/">Library Home</a></li>
            </ul>
        </div>
        <div class="wvu-header tablet wvubottom">
            <div class="wrap">
                <a href="https://lib.wvu.edu" class="wvu-header-logo wvu-masthead__logo wvu-masthead__logo--w-signature">
                    <span class="wvu-masthead-title wvu-masthead__title--w-signature">Libraries</span>
                </a>
                <ul class="wvu-header-mobile-list">
                    <li><a href="https://lib.wvu.edu/about/">About</a></li>
                    <li><a href="https://lib.wvu.edu/collections/">Collections</a></li>
                    <li><a href="https://lib.wvu.edu/instruction">Instruction</a></li>
                    <li><a href="https://lib.wvu.edu/about/news/">News</a></li>
                    <li><a href="https://lib.wvu.edu/services/">Services</a></li>
                    <li><a href="https://lib.wvu.edu/about/contactus/">Contact</a></li>
                    <li><a href="https://lib.wvu.edu/about/giving/">Give</a></li>
                </ul>
            </div>
        </div>

        <!-- WebApp Header -->
        <div class="webapp-header">
            <div class="wrap">
                <h1><a href="{local var="databaseHome"}">Databases</a></h1>
            </div>
        </div>

        <!-- Tab Bar -->

        <div class="sticky-header">
            <div class="tbwrap">
                <div class="sticky-header-nav tabBar">
                    <a id="menu-toggle" href="{local var="databaseHome"}/subjects/">
                        <img src="{local var="databaseHome"}/images/subject.svg" alt="Sort by Subject" id="menu-toggle1">
                        <img src="{local var="databaseHome"}/images/subjectx.svg" alt="Sort by Subject" id="menu-toggle2">
                    </a>
                </div>
                <div class="sticky-header-top tabBar">
                    <a id="top-toggle" href="{local var="databaseHome"}/AtoZ/">
                        <img src="{local var="databaseHome"}/images/title.svg" alt="Sort by Title" id="top-toggle1">
                        <img src="{local var="databaseHome"}/images/titlex.svg" alt="Sort by Title" id="top-toggle2">
                    </a>
                </div>
                <div class="sticky-header-filter tabBar">
                    <a id="facet-toggle">
                        <img src="{local var="databaseHome"}/images/search.svg" alt="Search" id="filter-toggle1">
                        <img src="{local var="databaseHome"}/images/x.svg" alt="Search" id="filter-toggle2">
                    </a>
                    <?php recurseInsert("includes/searchBox.php","php") ?>
                </div>
                <div class="sticky-header-search tabBar">
                    <ul class="sticky-header-desktop-links">
                        <li><a href="{local var="databaseHome"}/subjects/"><i class="fa fa-sort-amount-asc"></i>Database Subjects</a></li>
                        <li><a href="{local var="databaseHome"}/AtoZ/"><i class="fa fa-sort-alpha-asc"></i>Database Titles</a></li>

                        <li><a href="#help"><i class="fa fa-question-circle"></i>Database Help</a></li>
                    </ul>
                    <a id="search-toggle">
                        <img src="{local var="databaseHome"}/images/help.svg" alt="Search" id="search-toggle1">
                        <img src="{local var="databaseHome"}/images/x.svg" alt="Search" id="search-toggle2">
                    </a>

                    <!-- Help Information -->
                    <div class="search-query-form">
                        <div class="search-query-form-message">
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
                            <div class="search-query-form-message-box">
                                <p><a href="mailto:Barbara.Hengemihle@mail.wvu.edu">Barbara Hengemihle</a><br />
                                Evansdale Library<br />
                                <span class="phoneNumber">(304) 293-9748</span><br /><br />
                                Evansdale Library Reference Desk<br />
                                <span class="phoneNumber">(304) 293-4695</span></p>
                            </div>
                            <div class="search-query-form-message-box">
                                <p><a href="mailto:Susan.Arnold@mail.wvu.edu">Susan Arnold</a><br />
                                Health Sciences Library<br />
                                <span class="phoneNumber">(304) 293-2105</span><br /><br />
                                Health Sciences Library Reference Desk<br />
                                <span class="phoneNumber">(304) 293-6810</span></p>
                            </div>
                            <div class="search-query-form-message-box">
                                <p><a href="mailto:ppugh@wvu.edu">Penny Pugh</a><br />
                                    Downtown Campus Library<br />
                                    <span class="phoneNumber">(304) 293-0334</span><br /><br />
                                    Downtown Campus Library Reference Desk<br />
                                    <span class="phoneNumber">(304) 293-3640</span>
                                </p>
                            </div>
                            <div class="search-query-form-message-box">
                                <p><a href="http://westvirginia.libanswers.com/">Ask a Librarian</a><br />
                                    <em>Chat/Text/Email Reference Service</em><br><br>
                                    <em>If you are having a problem with a database or online resource, please submit an <a href="/databases/report/">eResource Error Report</a>.</em></p>
                                    <!-- <br><br><strong>For technical problems call</strong> the WVU Library Systems Office at <span class="phoneNumber">(304) 293-0340</span> Monday-Friday, 8 a.m. to 4:00 p.m. or send e-mail to <a href="mailto:libsys@mail.wvu.edu">libsys@mail.wvu.edu</a>. -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Container -->
        <div id="main-container">
            <div class="wrap">

                <div class="database-content">

                    <!-- Bread Crumbs -->
                    <?php recurseInsert("includes/breadcrumbs.php","php"); ?>


                    <div style="clear:both;"></div>
                    <hr class="tophr" />
                    <div style="clear:both;"></div>

                    <!-- Database Results Title & Sorting -->
                    <div class="database-content-title" style="{local var="adminDisplay"}">
                        <h2><span class="database-content-title-results">{local var="databaseHeading"} {local var="database_heading_middle"} {local var="databaseHeadingByTitle"}</span></h2>
                        <!-- Impliment blocks versus lists later
                        <i class="fa fa-list"></i>
                        <i class="fa fa-th-large"></i>
                        -->
                    </div>
                    <div style="clear:both;"></div>
