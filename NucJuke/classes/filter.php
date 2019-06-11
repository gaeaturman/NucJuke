<?php
ini_set('display_errors','off');
/*
filter class for loading in nuclesome map data, takes in $gRNAInfo and $filterMethod


private $resultsTop - gRNAs that are unoccupied, will be passed out to query as element[0] in an arr
private $resultsMid - gRNAs that are partially occupied, will be passed out to query as element[1] in an arr
private $resultsBot - gRNAs that are fully occupied, will be passed out to query as element[2] in an arr
private $gRNAInfo - user input array of gRNAs passed into constructor
private $gRNAfullOcc - array of fully occupied gRNAs
private $gRNApartOcc - array of partially occupied gRNAs, re-ranked

private $partOccRanks - array of the ranks of partially occupied gRNAs used to resort them
private $partOccGRNAs - array of partially occupied gRNAs, initial

private $strictNucs - array of all strict nucleosome positions
                      [key][value] = [position][position] (don't need NCP score:noise ratio information)
private $lenientNucs - array of all lenient nucleosome positions
    				   [key][value] = [position][NCP score:noise] (need NCP score:noise ratio information for re-ranking partially occ. gRNAs)
private $filterMethod - user input $filterMethod, passed into constructor

functions filterGRNAs() uses strict and lenient nuc maps from instance of loadmaps and then filters gRNAs
using appropriate method (dynamic, lenient, strict) accordingly

function getOccRange($chrom, $location) gets the range of positions at which a nucleosome is occupying a gRNA (nucleosome span)

function getFullOcc() gets the gRNAs that are fully occupied by nucleosomes (overlap nucleosomes from the strict map)
and sticks them into the $gRNAfullOcc array

function getPartOcc() gets the gRNAs that are partially occupied by nucleosomes (overlap nucleosomes from the redundant map)
and sticks them into the $partOccGRNAs array

function partOccReRank() re-ranks the partially occupied gRNA array based on design * nucleosome rank to correctly order them

function dynamicFilter() filters nucleosome map treating nuclesomes from the unique map as rendering gRNA target site
absolutely inaccessable, and nuclesomes from the redundant map as rendering gRNA target sites partially inaccessable

function strictFilter() filters nucleosome map treating nuclesomes from both the unique map AND redundant map as
rendering gRNA target sites absolutely inaccessable

function dynamicFilter() filters nucleosome map treating nuclesomes from both the unique map AND redundant map as
rendering gRNA target sites partially inaccessable

function returnResults() returns an array of the results in order:
unoccupied gRNAs [0], part occupied gRNAs [1], full occupied gRNAs [2]
*/

include "grna.php";
include "loadmaps.php";

class filter {

	private $resultsTop;
	private $resultsMid;
	private $resultsBot;
	private $gRNAInfo;
	private $gRNAfullOcc = array();
	private $gRNApartOcc = array();

	private $partOccRanks = array();
	private $partOccGRNAs = array();

	private $strictNucs;
	private $lenientNucs;
	private $filterMethod;

	#Constructor
	function __construct($gRNAInfo, $filterMethod) {
		$this->gRNAInfo = $gRNAInfo;
		$this->filterMethod = $filterMethod;
	}

	function filterGRNAs() {
		$loadmaps = new loadmaps();
		$loadmaps->getNucs();

		$this->strictNucs = $loadmaps->returnStrictMap();
		$this->lenientNucs = $loadmaps->returnLenientMap();

		$filterMethod = $this->filterMethod;

		#filter switch based on user selected $filterMethod
		if ($filterMethod == "dynamic") {
			$this->dynamicFilter();
		} elseif ($filterMethod == "lenient") {
			$this->lenientFilter();
		} elseif ($filterMethod == "strict") {
			$this->strictFilter();
		} else {
			return null;
		}

	}

	function getOccRange($chrom, $location) {

		$strChr = strval($chrom);

		$allLocs = array();
		$curLocI = 0;
		$curChrLocS = "";
		$curChrLocD = (double)0.0;

		foreach (range($location-73, $location+73) as $nums) { //set bounds for nuclesome +/- frm center
			$curChrLocD = $strChr . "." . $nums;
			$curChrLocD = (float)$curChrLocD;
			array_push($allLocs, strval($curChrLocD));
		}
		return $allLocs;
	}


	function getFullOcc() {
		$filterMethod = $this->filterMethod;

		if ($filterMethod == "dynamic") {
			for ($i = 0; $i < count($this->gRNAInfo); $i++) {
				$curr = clone $this->gRNAInfo[$i];
				$onChr = $curr->getChrom();
				$locBP = $curr->returnLoc();

				$possOccSites = $this->getOccRange($onChr, $locBP);

				for ($j = 0; $j < 147; $j++) { //toggle, 21 or 147

					if (array_key_exists($possOccSites[$j],$this->strictNucs)){

						$setKey = array_search($curr, $this->gRNAInfo);

						unset($this->gRNAInfo[$setKey]);
						$this->gRNAInfo = array_values($this->gRNAInfo);
						$curr->setOccupied();
						array_push($this->gRNAfullOcc, $curr);
						break;

					}
				}
			}
		} elseif ($filterMethod == "strict") {

			for ($i = 0; $i < count($this->gRNAInfo); $i++) {
				$curr = clone $this->gRNAInfo[$i];
				$designRank = $curr->getDesignRank();
				$onChr = $curr->getChrom();
				$locBP = $curr->returnLoc();

				$possOccSites = $this->getOccRange($onChr, $locBP);

				for ($j = 0; $j < 147; $j++) { //toggle, 21 or 147

					if (array_key_exists($possOccSites[$j],$this->strictNucs)){

						$setKey = array_search($curr, $this->gRNAInfo);

						unset($this->gRNAInfo[$setKey]);
						$this->gRNAInfo = array_values($this->gRNAInfo);
						$curr->setOccupied();
						$this->gRNAfullOcc[$designRank] = $curr;
						//array_push($this->gRNAfullOcc[$designRank], $curr);
						break;

					}
				}
			}
		}
	}

	function getOtherFullOcc() {
		for ($i = 0; $i < count($this->gRNAInfo); $i++) {
			$curr = clone $this->gRNAInfo[$i];
			$designRank = $curr->getDesignRank();
			$onChr = $curr->getChrom();
			$locBP = $curr->returnLoc();

			$possOccSites = $this->getOccRange($onChr, $locBP);

			for ($j = 0; $j < 147; $j++) { //toggle, 21 or 147

				if (array_key_exists($possOccSites[$j],$this->lenientNucs)){

					$setKey = array_search($curr, $this->gRNAInfo);

					unset($this->gRNAInfo[$setKey]);
					$this->gRNAInfo = array_values($this->gRNAInfo);
					$curr->setOccupied();
					$this->gRNAfullOcc[$designRank] = $curr;
					break;
				}
			}
		}
		ksort($this->gRNAfullOcc);
		$this->gRNAfullOcc = array_values($this->gRNAfullOcc);
	}

	function getPartOcc() {
		$filterMethod = $this->filterMethod;

		if ($filterMethod == "lenient") {
			for ($k = 0; $k < count($this->gRNAInfo); $k++) {

				$curr = clone $this->gRNAInfo[$k];
				$onChr = $curr->getChrom();
				$locBP = $curr->returnLoc();

				$possOccSites = $this->getOccRange($onChr, $locBP);


				for ($l = 0; $l < 147; $l++) {

					if (array_key_exists($possOccSites[$l],$this->strictNucs)) {

						$setKey = array_search($curr, $this->gRNAInfo);

						unset($this->gRNAInfo[$setKey]);
						$this->gRNAInfo = array_values($this->gRNAInfo);

						$currRank = $this->strictNucs[$possOccSites[$l]];

						$curr->setNucRank($currRank);
						$designRank = $curr->getDesignRank();
						$finalRank = intval($currRank * $designRank);
						$curr->setFinalRank($finalRank);

						$dubString = strval($finalRank) . "." . strval($designRank);
						$ranks = strval($dubString);
						array_push($this->partOccRanks, $ranks);

						$this->partOccGRNAs[$ranks] = $curr;
						break;
					}
				}
			}

		} elseif ($filterMethod == "dynamic") {

			for ($k = 0; $k < count($this->gRNAInfo); $k++) {

				$curr = clone $this->gRNAInfo[$k];
				$onChr = $curr->getChrom();
				$locBP = $curr->returnLoc();

				$possOccSites = $this->getOccRange($onChr, $locBP);


				for ($l = 0; $l < 147; $l++) { //toggle, 21 or 147


					if (array_key_exists($possOccSites[$l],$this->lenientNucs)){

						$setKey = array_search($curr, $this->gRNAInfo);

						unset($this->gRNAInfo[$setKey]);
						$this->gRNAInfo = array_values($this->gRNAInfo);

						$currRank = $this->lenientNucs[$possOccSites[$l]];
						$curr->setNucRank($currRank);
						$designRank = $curr->getDesignRank();
						$finalRank = (float)($currRank * $designRank);
						$curr->setFinalRank($finalRank);

						array_push($this->partOccRanks[(string)$finalRank]=$designRank);

						$this->partOccGRNAs[$designRank] = $curr;
						break;
					}
				}
			}
		}
	}


	function partOccReRank() {

		ksort($this->partOccRanks);

		$this->gRNApartOcc = array();
		$values = array_values($this->partOccRanks);

		for ($i = 0; $i < count($values); $i++) {
			$index = (array_values($this->partOccRanks))[$i];
			$curr = $this->partOccGRNAs[$index];
			array_push($this->gRNApartOcc, $curr);
		}
	}


	function dynamicFilter() {


		$this->getFullOcc();
		$this->getPartOcc();
		$this->partOccReRank();


		$lastunOcc = count($this->gRNAInfo);
		for ($i = 0; $i < count($this->gRNAInfo); $i++) {
			$curr = $this->gRNAInfo[$i];
			$rankVal = $i + 1;
			$curr->setFinalRank($rankVal);
			$this->resultsTop = $this->resultsTop . ($curr->returnInfo() . "\n");
		}

		$lastPartOcc = count($this->gRNApartOcc) + $lastunOcc;
		for ($j = 0; $j < count($this->gRNApartOcc); $j++) {
			$curr = $this->gRNApartOcc[$j];
			$rankSet = $j + $lastunOcc + 1;
			$curr->setFinalRank($rankSet);
			$this->resultsMid = $this->resultsMid . ($curr->returnInfo() .  "\n");
		}

		for ($k = 0; $k < count($this->gRNAfullOcc); $k++) {
			$curr = $this->gRNAfullOcc[$k];
			$rankSet = $k + $lastPartOcc + 1;
			$curr->setFinalRank($rankSet);
			$this->resultsBot = $this->resultsBot . ($curr->returnInfo() .  "\n");
		}

	}


	function strictFilter() {

		$this->getFullOcc();
		$this->getOtherFullOcc();

		$lastunOcc = count($this->gRNAInfo);
		for ($i = 0; $i < count($this->gRNAInfo); $i++) {
			$curr = $this->gRNAInfo[$i];
			$rankSet = $i + 1;
			$curr->setFinalRank($rankSet);
			$this->resultsTop = $this->resultsTop . ($curr->returnInfo() .  "\n");
		}

		for ($j = 0; $j < count($this->gRNAfullOcc); $j++) {
			$curr = $this->gRNAfullOcc[$j];
			$rankSet = $j + $lastunOcc +1;
			$curr->setFinalRank($rankSet);
			$this->resultsBot = $this->resultsBot . ($curr->returnInfo() .  "\n");
		}
	}


	function lenientFilter() {

		$this->getPartOcc();
		$this->partOccReRank();

		$lastunOcc = count($this->gRNAInfo);
		for ($i = 0; $i < count($this->gRNAInfo); $i++) {
			$curr = $this->gRNAInfo[$i];
			$rankSet = $i + 1;
			$curr->setFinalRank($rankSet);
			$this->resultsTop = $this->resultsTop . ($curr->returnInfo() .  "\n");
		}

		for ($j = 0; $j < count($this->gRNApartOcc); $j++) {
			$curr = $this->gRNApartOcc[$j];
			$rankSet = $j + $lastunOcc + 1;
			$curr->setFinalRank($rankSet);
			$this->resultsMid = $this->resultsMid . ($curr->returnInfo() .  "\n");

		}
	}

	#RETURN RESULTS AS ARRAY OF FORMATTED TEXT - ARRAY ORDER == resUnOc, resPrtOc, resFullOc
	function returnResults() {
		$resUnOc = $this->resultsTop;
		$resPrtOc = $this->resultsMid;
		$resFullOc = $this->resultsBot;
		$allResults = array($resUnOc, $resPrtOc, $resFullOc);
		//exit(); //err check - toggle exit(); on/off
		return $allResults;
	}

}

?>
