#!/usr/bin/perl -w

BEGIN {
    use CGI::Carp qw(fatalsToBrowser carpout);
    open(LOG, ">>/tmp/mycgi-log") or
	die("Unable to open mycgi-log: $!\n");
    carpout(\*LOG);
}

use strict;
use CGI;
use HTML::HashTable;
use DBI;

my $dbFile = "databases.txt";

my %types = (
#    0     => "All Databases",
    1     => "Arts & Humanities",
    2     => "Business & Economics",
    4     => "Education",
    8     => "General & Reference",
    16    => "Government Information",
    32    => "Health Sciences & Medicine",
    64    => "Public Affairs & law",
#    128   => "Newspapers",
    256   => "Engineering & Technology",
    512   => "Social Sciences",
#    1024  => "Full Text",
    2048  => "Biology & Agriculture",
    4096  => "Physical Sciences & math",
#    8192  => "New Databases",
#    16384 => "Trial Databases"
);

my %shash = (
    1     => 76,
    2     => 77,
    4     => 78,
    8     => 79,
    16    => 80,
    32    => 81,
    64    => 82,
    256   => 83,
    512   => 84,
    2048  => 85,
    4096  => 86,
);

open(FILE,$dbFile) or die "Opening dbFile, $dbFile\n$!\n";
my @lines = <FILE>;
close(FILE);

my %dhash = (); #database list
my $count = 0;

my %vhash = (); #Vendor list
my %uhash = (); #updated text
my %aptHash = (); #Access, Plain Text

foreach my $line (@lines) {
	
	chomp($line);

	#Short Title, Title, Location, Years, Vendor, Vendor URL, Proxy, URL,
	#CD URL, Fulltext, Citations, Abstracts, Updated, Access (Plain Text),
	#Access (Proxy), Help, $related resources, Oneliner, Abstract

	my($short_title, $title,    $sort_type, $location, $years,    $vendor, 
	   $vendor_url,  $proxy,    $journal,   $book,     $pamphlet, $source, 
	   $newdb,       $trialdb,  $url,       $cd_url, $fulltext, $citation,
	   $abstracts,   $updates,  $access_pt, $access_proxy, $help, $help_url,
	   $resources,   $oneline,  $abstract) = split(/\|/,$line);
	
	next if !$short_title;
	
	$updates =~ s/([\w']+)/\u\L$1/;
	
	if (lc($updates) eq "continuously" || lc($updates) eq "continually" || lc($updates) eq "constantly" || lc($updates) eq "regularly" || lc($updates) eq "frequently") {
		$updates = "Regularly";
	}
	
	if (lc($updates) eq "as content becomes available" || lc($updates) eq "as articles are published" || lc($updates) eq "updated with most recent handbooks") {
		$updates = "As content becomes available";
	}
	
	if (lc($updates) eq "varies by database" || lc($updates) eq "varies" || $updates =~ m/FREIDA/) {
		$updates = "Varies by database";
	}
	
	if (lc($updates) eq "1st and 3rd monday of the month" || lc($updates) eq "bimonthly" || lc($updates) eq "twice monthly") {
		$updates = "Bi-monthly";
	}
	
	if (lc($updates) eq "quarterly" || lc($updates) eq "at least quarterly" || lc($updates) eq "3 or 4 times a year") {
		$updates = "Quarterly";
	}
	
	if ($updates eq "20040916") {
		$updates = "";
	}
	
	###
	
	if($vendor eq "Proquest") {
		$vendor = "ProQuest";
	}
	
	if ($vendor eq "Oxford") {
		$vendor = "Oxford Online";
	}
	
	if (lc($vendor) eq "ebsco" || lc($vendor) eq "ebscohost") {
		$vendor = "EBSCO Host";
	}
	
	if ($vendor eq "Cambridge Scienctific") {
		$vendor = "Cambridge Scientific Abstracts";
	}
	
	if ($vendor eq "Readex ") {
		$vendor = "Readex";
	}
	
	if (lc($vendor) eq "gale") {
		$vendor = "Gale";
	}
	
	####
	
	if ($access_pt eq "Access for everyone." || $access_pt eq "Free to everyone." || $access_pt eq "Unrestricted" || $access_pt eq "Unlimited access" || $access_pt eq "free to the public on the Internet" || lc($access_pt) eq "free from internet" || $access_pt eq "free access from Internet at www.pubmed.gov" || $access_pt eq "free access from Internet at http://toxnet.nlm.nih.gov/" || $access_pt eq "free access from Internet" || $access_pt eq "Free access to anyone using the Internet.  ") {
		$access_pt = "Unrestricted";
	}
	
	$access_pt =~ s/&amp;/&/g;
	
	if ($access_pt eq "WVU faculty, staff and students; campus and remote." || $access_pt eq "WVU faculty, staff and students; campus and remote " || $access_pt eq "WVU faculty, staff and students; campus and remote" || $access_pt eq "WVU faculty, staff and students; campus & remote." || $access_pt eq "WVU faculty, staff and students; campus & remote " || $access_pt eq "WVU faculty, staff and students; campus & remote" || $access_pt eq "WVU students, faculty and staff; on-campus and remote access" || $access_pt eq "WVU students, faculty and staff. Campus and remote access." || $access_pt eq "WVU students, faculty, and staff; campus and remote" || $access_pt eq "WVU faculty, students and staff; campus and remote." || $access_pt eq "WVU students, faculty and staff. Campus and remote access." || $access_pt eq "WVU faculty, students and staff; on-campus and remote." || $access_pt eq "WVU students, faculty and staff. Campus and remote access." || $access_pt eq "WVU students, faculty and staff. Campus and remote access." || $access_pt eq "WVU students, faculty and staff. Campus and remote access." || $access_pt eq "WVU faculty, staff and students; compus and remote" || $access_pt eq "WVU faculty, staff and students; campus & remote." || $access_pt eq "WVU faculty, staff and students; campus & remote " || $access_pt eq "WVU faculty, staff and students; campus & remote" || $access_pt eq "Available for campus and remote access by WVU students, faculty, and staff." || $access_pt eq "Available for use by WVU students, faculty and staff, on-campus and remote." || $access_pt eq "Available for on-campus and remote access to WVU faculty, students, and staff." || $access_pt eq "Available for on-campus and remote access for WVU students, faculty, and staff."|| $access_pt eq "Available for campus and remote access by WVU students, faculty and staff."|| $access_pt eq "Available for campus and remote access by WVU faculty, students and staff."|| $access_pt eq "Available for WVU students, faculty, and staff; campus and remote access."|| $access_pt eq "Available for WVU faculty, staff and students, on-campus and remote access."|| $access_pt eq "Available to WVU faculty and students from campus and remote locations."|| $access_pt eq "Available to WVU faculty, students, and staff for campus and remote access"|| $access_pt eq "Available to WVU faculty, students, and staff. Remote access requires authentication." || $access_pt eq "Available to WVU faculty, students, and staff. Campus and remote access." || $access_pt eq "Available only to WVU faculty, students, and staff. Researchers must register and supply an official WVU email address to access the data." || $access_pt eq "Available to WVU faculty, students, and staff. Remote access requires authentication." || $access_pt eq "Available to WVU students, faculty and staff for campus and remote access." || $access_pt eq "Available to WVU students, faculty and staff from campus and remote locations." || $access_pt eq "Available to WVU students, faculty and staff, on-campus and remote." || $access_pt eq "Available to WVU students, faculty, and staff from campus and remote locations." || $access_pt eq "Available to WVU students, faculty, and staff with on-campus and remote access." || $access_pt eq "Available to WVU students, faculty, and staff. Authentication is necessary for off-campus access." || $access_pt eq "Available to WVU students, faculty, and staff. On-campus and remote access." || $access_pt eq "Available to WVU students, faculty, and staff. Remote access is available." || $access_pt eq "Available to WVU students, faculty, and staff; campus and remote" || $access_pt eq "Available to WVU students, faculty, and staff; campus and remote access." || $access_pt eq "Campus and Remote" || $access_pt eq "WVU faculty & students; campus & remote" || $access_pt eq "Available to WVU students, faculty, and staff.  Authentication is necessary for off-campus access." || $access_pt eq "Available to WVU faculty, students, and staff.  Remote access requires authentication." || $access_pt eq "on campus and remote; faculty, staff and students" || $access_pt eq "faculty & students; on campus & remote; unlimited number of users" || $access_pt eq "faculty & students; campus and remote" || $access_pt eq "faculty & students; campus & remote" || $access_pt eq "WVU students, faculty and staff.  Campus and remote access." || $access_pt eq "WVU faculty, staff and students;  campus &amp; remote" || $access_pt eq "WVU faculty and students; unlimited users; campus &amp; remote" || $access_pt eq "WVU faculty and students; campus and remote" || $access_pt eq "Campus and remote access for WVU students, faculty, and staff." || $access_pt eq "Campus and remote access for WVU students, faculty and staff." || $access_pt eq "Campus and remote access for WVU faculty, students and staff." || $access_pt eq "Available to WVU students, faculty, and staff.  Remote access is available." || $access_pt eq "Available to WVU students, faculty, and staff.  On-campus and remote access." || $access_pt eq "WVU faculty and students; unlimited users; campus &amp; remote" || $access_pt eq "WVU faculty and students; campus &amp; remote" || $access_pt =~ m/^WVU faculty and students; campus/) {
		
		$access_pt = "WVU Faculty, Staff, and Students; Campus & Remote.";
		
	}
	
	if ($access_pt =~ m/^10 simultaneous users/ || $access_pt eq "10 simultaneous users.  WVU faculty, staff and students; campus and remote. " || $access_pt eq "10 simultaneous users.  WVU faculty, staff and students; campus and remote." || $access_pt eq "10 simultaneous users.  WVU faculty, staff and students; campus and remote " || $access_pt eq "WVU faculty and students; 10 simultaneous users; campus & remote") {
		$access_pt = "10 simultaneous users. WVU Faculty, Staff, and Students; Campus & Remote.";
	}
	
	$vendor_url = "" if $vendor_url eq "http://";
	
	#########
	$abstract =~ s/%linebreak%/\n/g;
	$abstract =~ s/<(?:[^>'"]*|(['"]).*?\1)*>//gs;
	$access_pt =~ s/<(?:[^>'"]*|(['"]).*?\1)*>//gs;
	$access_pt =~ s/%linebreak%/\n/g;
	$updates =~ s/<(?:[^>'"]*|(['"]).*?\1)*>//gs;
	
	$dhash{$short_title}{Short_Title}       = $short_title; #in script, use unix time.
	$dhash{$short_title}{Title}             = $title; #
	$dhash{$short_title}{Sort_Type}         = $sort_type;#
	$dhash{$short_title}{Location}          = $location; #determined in scrip, set to 0
	$dhash{$short_title}{Years}             = $years; #
	$dhash{$short_title}{Vendor}            = $vendor;#
	$dhash{$short_title}{Vendor_URL}        = $vendor_url;#
	$dhash{$short_title}{Proxy}             = $proxy;
	$dhash{$short_title}{URL}               = $url;#
	$dhash{$short_title}{CD_URL}            = $cd_url;
	$dhash{$short_title}{Full_Text}         = $fulltext; #
	$dhash{$short_title}{Citation}          = $citation; #
	$dhash{$short_title}{Abstracts}         = $abstracts; # 
	$dhash{$short_title}{Updates}           = $updates;#
	$dhash{$short_title}{Access_Plain_Text} = $access_pt;#
	$dhash{$short_title}{Access_Proxy}      = $access_proxy;#
	$dhash{$short_title}{Resources}         = $resources;#leave blank
	$dhash{$short_title}{Oneline}           = $oneline; #leave blank
	$dhash{$short_title}{Abstract}          = $abstract;#
	$dhash{$short_title}{New_DB}            = $newdb;
	$dhash{$short_title}{Trial_DB}          = $trialdb;
	
	my @helps    = split("!!",$help);
	my @helpURLs = split("!!",$help_url);	
	
	$dhash{$short_title}{Help}     = join("\n",@helps);
	$dhash{$short_title}{Help_URL} = join("\n",@helpURLs);
	
	foreach my $subject (keys %types) {
		if(&is_in_category($sort_type,$subject)) {
			$dhash{$short_title}{Subjects}{$subject} = $shash{$subject};
		}
	}
	
	if(&is_in_category($sort_type, 128)) {
		$dhash{$short_title}{newspaper} = 1;
	}
	else {
		$dhash{$short_title}{newspaper} = 0;
	}
	
	$count++;
	
	if ($vendor ne "unknown") {
		$vhash{$vendor}{Vendor} = $vendor;
		$vhash{$vendor}{URL}    = $vendor_url;
		$vhash{$vendor}{count}++;
	}
	
	if ($updates ne "") { 
		$uhash{$updates}{text} = $updates;
		$uhash{$updates}{count}++;
	}
	
	if ($access_pt ne "") {
		$aptHash{$access_pt}{text} = $access_pt;
		$aptHash{$access_pt}{count}++;
	}
}

my $dbh = DBI->connect("DBI:mysql:databases:localhost","systems","Te\$t1234");
my $sql = "";
my $sth = undef;

$sql = "truncate table dbList";
$sth = $dbh->prepare($sql);
$sth->execute();

$sql = "truncate table updateText";
$sth = $dbh->prepare($sql);
$sth->execute();

$sql = "truncate table vendors";
$sth = $dbh->prepare($sql);
$sth->execute();

$sql = "truncate table accessPlainText";
$sth = $dbh->prepare($sql);
$sth->execute();

$sql = "truncate table databases_subjects";
$sth = $dbh->prepare($sql);
$sth->execute();

$sql = "truncate table databases_resourceTypes";
$sth = $dbh->prepare($sql);
$sth->execute();

foreach my $vendor (keys %vhash) {

	my $v = $vhash{$vendor}{Vendor};
	my $u = $vhash{$vendor}{URL};

	$sql = "INSERT INTO vendors(name, url) values('$v','$u')";
	$sth = $dbh->prepare($sql);

	$sth->execute();
	
	$vhash{$vendor}{ID} = $dbh->{ q{mysql_insertid} };
	
}

foreach my $update (keys %uhash) {
	
	$sql = "INSERT INTO updateText(name) values('$update')";
	$sth = $dbh->prepare($sql);

	$sth->execute();
	
	$uhash{$update}{ID} = $dbh->{ q{mysql_insertid} };
	
}

foreach my $apt (keys %aptHash) {
	
	$sql = "INSERT INTO accessPlainText(name) values('$apt')";
	$sth = $dbh->prepare($sql);

	$sth->execute();
	
	$aptHash{$apt}{ID} = $dbh->{ q{mysql_insertid} };
	
}

my $count2 = 0;

foreach my $db (keys %dhash) {
	
	$count2++;
	
	#not used in old system
	my $offCampusURL = "";  
	my $status       = "1";
	my $popular      = "0"; 
	
	#Set these to current time
	my $createDate = time();
	my $updateDate = time();
	
	my $name            = escapeChars($dhash{$db}{Title});
	my $yearsOfCoverage = escapeChars($dhash{$db}{Years});
	my $vendor          = $vhash{$dhash{$db}{Vendor}}{ID};
	my $url             = $dhash{$db}{URL};
	my $updated         = $uhash{$dhash{$db}{Updates}}{ID};
	my $fullTextDB      = ($dhash{$db}{Full_Text} eq "No")?"0":"1";
	my $newDatabase     = $dhash{$db}{New_DB};
	my $trialDatabase   = $dhash{$db}{Trial_DB};
	my $access          = $aptHash{$dhash{$db}{Access_Plain_Text}}{ID}; #plain text
	my $help            = escapeChars($dhash{$db}{Help});
	my $helpURL         = $dhash{$db}{Help_URL};
	my $description     = escapeChars($dhash{$db}{Abstract});
	my $URLID           = $dhash{$db}{Short_Title};
	
	my $accessType = 1;
	if ($dhash{$db}{Access_Proxy} == 3) {
		$accessType = 1;
	}
	elsif ($dhash{$db}{Access_Proxy} == 2) {
		$accessType = 2;
	}
	elsif ($dhash{$db}{Access_Proxy} == 1) {
		$accessType = 3;
	}
	
	my $trialExpireDate = "";
	if ($trialDatabase == 1) {
		$trialExpireDate = time()+5259486; #add 2 months from now
	}
	
	$sql = "INSERT INTO dbList(name,status,yearsOfCoverage,vendor,url,offCampusURL,updated,accessType,fullTextDB,newDatabase,trialDatabase,access,help,helpURL,description,createDate,updateDate,URLID,popular,trialExpireDate) values('$name','$status','$yearsOfCoverage','$vendor','$url','$offCampusURL','$updated','$accessType','$fullTextDB','$newDatabase','$trialDatabase','$access','$help','$helpURL','$description','$createDate','$updateDate','$URLID','$popular','$trialExpireDate')";
	$sth = $dbh->prepare($sql);

	$sth->execute() or die "Inserting Database Error: $! : $DBI::errstr";
	
	$dhash{$db}{ID} = $dbh->{ q{mysql_insertid} };
	
	foreach my $subject (keys %{$dhash{$db}{Subjects}}) {
		$sql = "INSERT INTO databases_subjects(dbID,subjectID) values('$dhash{$db}{ID}','$dhash{$db}{Subjects}{$subject}')";
		$sth = $dbh->prepare($sql);
		$sth->execute();
	}
	
	if ($dhash{$db}{newspaper} == 1) {
		$sql = "INSERT INTO databases_resourceTypes(dbID,resourceID) values('$dhash{$db}{ID}','5')";
		$sth = $dbh->prepare($sql);
		$sth->execute();
	}
	
}

$sth->finish();
$dbh->disconnect();

my $cgi = CGI::new();
print $cgi->header(-type => "text/html");

print "<h1>Database List -- Found: $count -- Uploaded: $count2</h1>";
print tablify({BORDER      => 1, DATA        => \%dhash, SORTBY      => 'key', ORDER       => 'desc'});

print "<h1>Vendor List</h1>";
print tablify({BORDER      => 1, DATA        => \%vhash, SORTBY      => 'key', ORDER       => 'desc'});

print "<h1>Update List</h1>";
print tablify({BORDER      => 1, DATA        => \%uhash, SORTBY      => 'key', ORDER       => 'desc'});

print "<h1>Access Plain Text List</h1>";
print tablify({BORDER      => 1, DATA        => \%aptHash, SORTBY      => 'key', ORDER       => 'desc'});

###############################################################################

sub is_in_category {

    my($num,$cat) = @_;

    my @num_list = (0,   1,   2,   4,    8,    16, 32, 64, 
		    128, 256, 512, 1024, 2048, 4096);

    for (my $I = @num_list - 1;$I >= 0; $I--) {

	return(0) if $cat > $num;
	
	if ($num >= $num_list[$I]) {
	    return(1) if $num_list[$I] == $cat;
	    
	    $num -= $num_list[$I];
	    next;
	}
    }

    return(0);

}

sub escapeChars {
	my($string) = @_;

	$string =~ s/<br>/<br \/>/gi;
	$string =~ s/<b>/<strong>/gi;
	$string =~ s/<\/b>/<\/strong>/gi;
	$string =~ s/<i>/<em>/gi;
	$string =~ s/<\/i>/<\/em>/gi;

	my %specialChars = (
		'\''	 => '\\\'',
		'&(?!.+{1 .. 6}\;)' => '&amp;',
		'"'     => '&quot;',
		'\xA1'  => '&iexcl;',
		'\xA2'  => '&cent;',
		'\xA3'  => '&pound;',
		'\xA4'  => '&curren;',
		'\xA5'  => '&yen;',
		'\xA6'  => '&brvbar;',
		'\xA7'  => '&sect;',
		'\xA8'  => '&uml;',
		'\xA9'  => '&copy;',
		'\xAA'  => '&ordf;',
		'\xAB'  => '&laquo;',
		'\xAC'  => '&not;',
		'\xAE'  => '&reg;',
		'\xAF'  => '&macr;',
		'\xB0'  => '&deg;',
		'\xB1'  => '&plusmn;',
		'\xB2'  => '&sup2;',
		'\xB3'  => '&sup3;',
		'\xB4'  => '&acute;',
		'\xB5'  => '&micro;',
		'\xB6'  => '&para;',
		'\xB7'  => '&middot;',
		'\xB8'  => '&cedil;',
		'\xB9'  => '&supl;',
		'\xBA'  => '&ordm;',
		'\xBB'  => '&raquo;',
		'\xBC'  => '&frac14;',
		'\xBD'  => '&frac12;',
		'\xBE'  => '&frac34;',
		'\xBF'  => '&iquest;',
		'\x00'  => '',
		'\x01'  => '',
		'\x02'  => '',
		'\x03'  => '',
		'\x04'  => '',
		'\x05'  => '',
		'\x06'  => '',
		'\x07'  => '',
		'\x08'  => '',
		'\x0B'  => '',
		'\x0C'  => '',
		'\x0E'  => '',
		'\x0F'  => '',
		'\x10'  => '',
		'\x11'  => '',
		'\x12'  => '',
		'\x13'  => '',
		'\x14'  => '',
		'\x15'  => '',
		'\x16'  => '',
		'\x17'  => '',
		'\x18'  => '',
		'\x19'  => '',
		'\x1A'  => '',
		'\x1B'  => '',
		'\x1C'  => '',
		'\x1D'  => '',
		'\x1E'  => '',
		'\x1F'  => '',
		'\x7F'  => '',
		'\x80' => '&#x20AC;',
		'\x81' => '',
		'\x82' => '&#x201A;',
		'\x83' => '&#x192;',
		'\x84' => '&#x201E;',
		'\x85' => '&#x2026;',
		'\x86' => '&#x2020;',
		'\x87' => '&#x2021;',
		'\x88' => '&#x2C6;',
		'\x89' => '&#x2030;',
		'\x8A' => '&#x160;',
		'\x8B' => '&#x2039;',
		'\x8C' => '&#x152;',
		'\x8D' => '',
		'\x8E' => '&#x17D;',
		'\x8F' => '',
		'\x90' => '',
		'\x91' => '&#x2018;',
		'\x92' => '&#x2019;',
		'\x93' => '&#x201C;',
		'\x94' => '&#x201D;',
		'\x95' => '&#x2022;',
		'\x96' => '&#x2013;',
		'\x97' => '&#x2014;',
		'\x98' => '&#x2DC;',
		'\x99' => '&#x2122;',
		'\x9A' => '&#x161;',
		'\x9B' => '&#x203A;',
		'\x9C' => '&#x153;',
		'\x9D' => '',
		'\x9E' => '&#x17E;',
		'\x9F' => '&#x178;'
		);

		foreach my $char (keys %specialChars ) {
			$string =~ s/$char/$specialChars{$char}/g;
		}

		return($string);
}
