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
        <script src="{local var="databaseHome"}/javascript/scripts.js"></script>

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
                <h1><a href="https://lib.wvu.edu/databases/">Databases</a></h1>
            </div>
        </div>

        <!-- Tab Bar -->
        <div class="sticky-header">
            <div class="tbwrap"> 
                <div class="sticky-header-nav tabBar">
                    <a id="menu-toggle">
                        <img src="{local var="databaseHome"}/images/subject.svg" alt="Sort by Subject" id="menu-toggle1">
                        <img src="{local var="databaseHome"}/images/subjectx.svg" alt="Sort by Subject" id="menu-toggle2">
                    </a>
                </div>
                <div class="sticky-header-top tabBar">
                    <a id="top-toggle">
                        <img src="{local var="databaseHome"}/images/title.svg" alt="Sort by Title" id="top-toggle1">
                        <img src="{local var="databaseHome"}/images/titlex.svg" alt="Sort by Title" id="top-toggle2">
                    </a>
                </div>
                <div class="sticky-header-filter tabBar">
                    <a id="facet-toggle">
                        <img src="{local var="databaseHome"}/images/filter.svg" alt="Search" id=                        "filter-toggle1">
                        <img src="{local var="databaseHome"}/images/x.svg" alt="Search" id=                        "filter-toggle2">
                    </a>
                    <div class="sticky-header-filter-sidebar">
                    </div>
                </div>
                <div class="sticky-header-search tabBar">
                    <ul class="sticky-header-desktop-links">
                        <li><a href="#"><i class="fa fa-sort-amount-asc"></i>Database Subjects</a></li>
                        <li><a href="#"><i class="fa fa-sort-alpha-asc"></i>Database Titles</a></li>
                        <li><a href="#help"><i class="fa fa-question-circle"></i>Help</a></li>
                    </ul>
                    <a id="search-toggle">
                        <img src="{local var="databaseHome"}/images/help.svg" alt="Search" id="search-toggle1">
                        <img src="{local var="databaseHome"}/images/x.svg" alt="Search" id=                        "search-toggle2">
                    </a>

                    <!-- Help Information -->
                    <div class="search-query-form">
                        <div class="search-query-form-message">
                            <h2>Help with Databases</h2>
                            <p>Most databases are available off-campus to current WVU-Morgantown students, faculty and staff. Licensing restrictions prevent WVU Libraries from providing off-campus access to others. Your affiliation with WVU is verified through use of WVU MyID. You will be prompted to enter this when you choose a database from the menu. For assistance with MyID, please go to the Office of Information Technology (OIT) website at: <a href="https://myid.wvu.edu/">https://myid.wvu.edu/</a>. There you can activate your account or change your password. Alternatively, you may call the OIT Help Desk at <span class="phoneNumber">(304) 293-4444</span>. If you need assistance with database selection or searching please contact:</p>
                            <div class="search-query-form-message-box">
                                <p><strong>Barbara Lagodna</strong><br />
                                Evansdale Library<br />
                                <a href="mailto:blagodna@wvu.edu">blagodna@wvu.edu</a><br />
                                <span class="phoneNumber">(304) 293-9748</span><br />
                                or the<br />
                                Evansdale Library<br />
                                Reference Desk<br />
                                <span class="phoneNumber">(304) 293-4695</span></p>
                            </div>
                            <div class="search-query-form-message-box">
                                <p><strong>Susan Arnold</strong><br />
                                Health Sciences Library<br />
                                <a href="mailto:Susan.Arnold@mail.wvu.edu">Susan.Arnold@mail.wvu.edu </a><br />
                                <span class="phoneNumber">(304) 293-2105</span><br />
                                or the<br />
                                Health Sciences Library<br />
                                Reference Desk<br />
                                <span class="phoneNumber">(304) 293-6810</span></p>
                            </div>
                            <div class="search-query-form-message-box">
                                <p><strong>Penny Pugh</strong><br />
                                    Downtown Campus Library<br />
                                    <a href="mailto:ppugh@wvu.edu">ppugh@wvu.edu</a><br />
                                    <span class="phoneNumber">(304) 293-0334</span><br />
                                    or the<br />
                                    Downtown Campus Library<br />
                                    Reference Desk<br />
                                    <span class="phoneNumber">(304) 293-3640</span><br />
                                    or the<br />
                                    <a href="/services/ask/">Ask a Librarian</a> - Chat/Text/E-Mail reference service.
                                </p>
                            </div>
                            <div class="search-query-form-message-box">
                                <p><strong>For technical problems call:</strong></p>
                                <p>WVU Library Systems Office at <span class="phoneNumber">(304) 293-0340</span> Monday-Friday, 8 a.m. to 4:00 p.m. or send e-mail to <a href="mailto:libsys@mail.wvu.edu">libsys@mail.wvu.edu</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Container -->
        <div id="main-container">
            <div class="wrap">

                <!-- Left Subcontainer -->
                <?php recurseInsert("leftnav.php","php") ?>

                <!-- Right Subcontainer -->
                <div class="database-content">

                    <!-- Faceted Bread Crumbs -->
                    <div class="database-content-facets">
                        <ul class="database-content-facets-ul">
                            <li><i class="fa fa-home"></i><a href="https://lib.wvu.edu">Home</a></li>
                            <li><a href="https://lib.wvu.edu/datbases">Databases</a></li>
                            <li><span class="facetLi"><a href="#">All Results</a></span></li>
                            <li><span class="facetLi"><a href="#">Full Text</a></span></li>
                            <li><span class="facetLi"><a href="#">Encyclopedia<i class="fa fa-times"></i></a></span></li>
                        </ul>
                    </div>

                    <!-- Top Paging -->
                    <div class="database-content-paging right">
                        <a href="#">« Previous</a> | <span class="database-content-paging-pages">1 - 10 of 200</span> | <a href="#">Next »</a>
                    </div>

                    <div style="clear:both;"></div>
                    <hr />
                    <div style="clear:both;"></div>
                    
                    <!-- Database Results Title & Sorting -->
                    <div class="database-content-title">
                        <h2><span class="database-content-title-results">Database Results:</span></h2>
                        <i class="fa fa-list"></i>
                        <i class="fa fa-th-large"></i>
                    </div>
                    <div style="clear:both;"></div>

                    <!-- Databases -->
<!--                     <div class="database">
                        <div class="database-box">
                            <div class="database-box-top database-resize">
                                <h3>AccessScience: McGraw-Hill Encyclopedia of Science and Technology</h3>
                                <p>A science and technology encyclopedia containing more than 8,000 articles written by the leading figures in their fields, including 30 Nobel Prize winners, and edited and illustrated with the non-specialist in mind.... <span class="moreLink">[ <a href="#">More Information</a> ]</span></p>
                            </div>
                            <div class="database-box-bottom database-res">
                                <ul class="database-box-bottom-tags">
                                    <li><a href="#">Full Text</a></li>
                                    <li><a href="#">New</a></li>
                                    <li><a href="#">Encyclopedia</a></li>
                                </ul>
                            </div>
                        </div>
                    </div> -->
