<?php
ini_set('display_errors','off');
/*
processgivengrnas class for loading in nuclesome map data, takes in user given
$siteSelection, $userInput, and $filterMethod


private $siteSelection - user input $siteSelection taken in by constructor
private $userInput - user input $userInpur (gRNAs) taken in by constructor
private $filterMethod - user input $filterMethod taken in by constructor

private $resultsFullOcc - array of full occupied gRNAs
private $resultsPrtOcc -  array of partially occupied gRNAs
private $resultsUnOcc -  array of unoccupied gRNAs

functions value() and romanToDec() take in a string representing a number in roman numeral format,
and returns an int of the corresponding value

function parsegrnas() takes user input strings and performs various splits to get gRNA information,
splits dependent on $siteSelection. Calls filter.php to filter given gRNAs and puts them into result arrs
$resultsFullOcc, $resultsPrtOcc, and $resultsUnOcc

function returnAllResults() returns an array of the results in the order:
unoccupied gRNAs [0], part occupied gRNAs [1], full occupied gRNAs [2]
*/

include "filter.php";

class processgivengrnas {

	private $siteSelection;
	private $userInput;
	private $filterMethod;

	private $resultsFullOcc;
	private $resultsPrtOcc;
	private $resultsUnOcc;

	#Constructor
	function __construct($siteSelection, $userInput, $filterMethod) {
		$this->siteSelection = $siteSelection;
		$this->userInput = $userInput;
		$this->filterMethod = $filterMethod;
	}


	// This function returns
	// value of a Roman symbol
	function value($r)
	{
		if ($r == 'I')
		return 1;
		if ($r == 'V')
		return 5;
		if ($r == 'X')
		return 10;
		if ($r == 'L')
		return 50;
		if ($r == 'C')
		return 100;
		if ($r == 'D')
		return 500;
		if ($r == 'M')
		return 1000;

		return -1;
	}

	// Returns decimal value
	// of roman numeral
	function romanToDec($str) {
		// Initialize result
		$res = 0;

		// Traverse given input
		for ($i = 0; $i < strlen($str); $i++)
		{
			// Getting value of
			// symbol s[i]
			$s1 = $this->value($str[$i]);

			if ($i+1 < strlen($str))
			{
				// Getting value of
				// symbol s[i+1]
				$s2 = $this->value($str[$i + 1]);

				// Comparing both values
				if ($s1 >= $s2)
				{
					// Value of current symbol
					// is greater or equal to
					// the next symbol
					$res = $res + $s1;
				}
				else
				{
					$res = $res + $s2 - $s1;
					$i++; // Value of current symbol is
					// less than the next symbol
				}
			}
			else
			{
				$res = $res + $s1;
				$i++;
			}
		}
		return $res;
	}

	function parsegrnas() {

		$gRNAInfo = array();
		$InfoLines = preg_split("/\\r\\n|\\r|\\n/", $this->userInput);

		$chromSet = 0;
		for ($i = 0; $i < count($InfoLines); $i++) {

			$InfoParts = $InfoLines[$i];
			$InfoParts = preg_split('/\s+/', $InfoParts, -1, PREG_SPLIT_NO_EMPTY);

			if ($this->siteSelection == 'chopchop') {

				# means used fasta
				if (count($InfoParts) == 1) {
					$chromSet = $InfoParts[0];
				} else {

				$chromDataAr = preg_split("/:/", $InfoParts[2], -1, PREG_SPLIT_NO_EMPTY);

				$onChrom = 0;
				if ($chromSet != 0) {
					$onChrom = $chromSet;
				} else {
					$onChrom = str_replace("chr", "", $chromDataAr[0]);
					$onChrom = $this->romanToDec($onChrom);
				}

				$startLoc = intval($chromDataAr[1]);

				$rank = intval($InfoParts[0]);
				$sequence = $InfoParts[1];
				$startLoc = intval($chromDataAr[1]);

				$otherInfo = "";

				for ($a = 3; $a < 12; $a++) {
					$otherInfo = ($otherInfo . "\t" . $InfoParts[$a]);
				}
				trim($otherInfo);

				$tempGRNA = new grna($rank, $sequence, $onChrom, $startLoc);
				$tempGRNA->setOtherInfo($otherInfo);
				array_push($gRNAInfo, $tempGRNA);
			}

			} elseif ($this->siteSelection == 'crispr-era') {

				$InfoParts = $InfoLines[$i];
				$InfoParts = preg_split('/\s+/', $InfoParts, -1, PREG_SPLIT_NO_EMPTY);


				$rank = intval($InfoParts[0]);
				$sequence = $InfoParts[1];


				$otherInfo = "";

				#means transcript ID here
				if (preg_match("/[a-zA-Z]+/", $InfoParts[3])) {
					$onChrom = intval($InfoParts[5]);
					$startLoc = intval($InfoParts[6]);

					for ($a = 7; $a < 11; $a++) {
						$otherInfo = ($otherInfo . "\t" . $InfoParts[$a]);
					}
					trim($otherInfo);
				} else {

					$onChrom = $InfoParts[2];
					$startLoc = $InfoParts[3];
					for ($a = 4; $a < 8; $a++) {
						$otherInfo = ($otherInfo . "\t" . $InfoParts[$a]);
					}
					trim($otherInfo);
				}

				$tempGRNA = new grna($rank, $sequence, $onChrom, $startLoc);
				$tempGRNA->setOtherInfo($otherInfo);
				array_push($gRNAInfo, $tempGRNA);
			} elseif ($this->siteSelection == 'e-crisp') {

				if ($i != 0) { //clear header out
					$rank = $i;
					$sequence = $InfoParts[5];
					if (preg_match("/[a-zA-Z]+/", $InfoParts[25])) {
						$onChrom = $InfoParts[24];
					} elseif ($InfoParts[24] == 0) {
						$onChrom = $InfoParts[25];
					}
					$startLoc = $InfoParts[2];

					$otherInfo = $InfoParts[4];

					trim($otherInfo);

					$tempGRNA = new grna($rank, $sequence, $onChrom, $startLoc);
					$tempGRNA->setOtherInfo($otherInfo);
					array_push($gRNAInfo, $tempGRNA);
				}
			} elseif ($this->siteSelection == 'use_my_own') { #e.g. use_my_own

				#tab delim input of rank, sequence, chrom, startbp

				$InfoParts = $InfoLines[$i];
				$InfoParts = preg_split('/[\t]/', $InfoParts, -1, PREG_SPLIT_NO_EMPTY);

				$rank = intval($InfoParts[0]);
				$onChrom = intval($InfoParts[2]);
				$startLoc = intval($InfoParts[3]);
				$sequence = $InfoParts[1];

				$tempGRNA = new grna($rank, $sequence, $onChrom, $startLoc);
				array_push($gRNAInfo, $tempGRNA);
			} else {
				return null;
			}

		}

		$filter = new filter($gRNAInfo, $this->filterMethod);
		$filter->filterGRNAs();

		$resultsArr = $filter->returnResults();

		$this->resultsFullOcc = $resultsArr[0];
		$this->resultsPrtOcc = $resultsArr[1];
		$this->resultsUnOcc = $resultsArr[2];

	}

	function returnAllResults() {
		$resultsArr = array($this->resultsFullOcc, $this->resultsPrtOcc, $this->resultsUnOcc);
		return $resultsArr;
	}
}

?>
