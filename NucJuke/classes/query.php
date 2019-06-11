<?php
ini_set('display_errors','off');
/*
query.php
intermediate for home and results, takes user input gRNAs and site/sorting information, checks gRNA positions
against positions of known nuclesomes from redundant and unique maps, and subsequently re-ranks them.
*/


session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	#sanitize user inputs for any PHP, HTML, other bad string data from home.php
	$siteSelection = trim(filter_input(INPUT_POST, "siteSelection", FILTER_SANITIZE_STRING));
	$filterMethod = trim(filter_input(INPUT_POST, "filterMethod", FILTER_SANITIZE_STRING));
	$userInput = trim(filter_input(INPUT_POST, "userInput", FILTER_SANITIZE_STRING));
	$nucMap = trim(filter_input(INPUT_POST, "nucMap", FILTER_SANITIZE_STRING));

	#set local vars to Session variables
	$_SESSION['siteSelection']=$siteSelection;
	$_SESSION['filterMethod']=$filterMethod;
	$_SESSION['userInput']=$userInput;


	#check user input
	#if siteSelection NOT one of the specified options, redirect to oops.php
	if ($siteSelection != 'chopchop' AND $siteSelection != 'crispr-era'
	AND $siteSelection != 'e-crisp' AND $siteSelection != 'use_my_own') {
		header("location:../oops.php");
		exit;
	}

	#if filterMethod NOT one of the specified options, redirect to oops.php
	if ($filterMethod != 'dynamic' AND $filterMethod != 'lenient' AND $filterMethod != 'strict') {
		header("location:../oops.php");
		exit;
	}

	#if userInput includes bad char (incase of filter missing something), redirect to oops.php
	if (strpos($userInput, '<') !== false OR strpos($userInput, '>') !== false
	OR strpos($userInput, 'href') !== false OR strpos($userInput, 'link') !== false) {
		header("location:../oops.php");
		exit;
	}

	#if spam honeypot filled don't even bother redirecting, echo bad input, probably a bot.
	if (!$nucMap == "") {
		echo "Bad form input";
		exit;
	}

	#if any required fields empty, redirect to oops.php
	if ($userInput == "" OR $siteSelection == "" OR $filterMethod == "") {
		header("location:../oops.php");
		exit;
	}

	include "processgivengrnas.php";

	#process user given grnas, filter, and return results
	$process = new processgivengrnas($siteSelection, $userInput, $filterMethod);
	$process->parseGRNAs();

	$results = $process->returnAllResults();

	#if results from processgivengrnas is null, redirect to oops.php
	if ($results === null) {
		header("location:../oops.php");
		exit;
	}

	$_SESSION['results']=$results;


	header("location:../results");
	exit;
}

?>
