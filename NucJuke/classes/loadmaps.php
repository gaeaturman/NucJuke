<?php
ini_set('display_errors','off');
/*
loadmaps class for loading in nuclesome map data,

functions value() and romanToDec() take in a string representing a number in roman numeral format,
and returns an int of the corresponding value

function getNucs() opens the two nuclesome map .txt files, reads through them to get an array of nucleosome positions
and NCP score:noise values for the redundant map

function returnStrictMap() returns the map of information for nuclesomes grabbed from the unique map
map[key][value] = [position][position] (don't need NCP score:noise ratio information)

function returnLenientMap() returns the map of information for nuclesomes grabbed from the parsed redundant map
map[key][value] = [position][NCP score:noise] (need NCP score:noise ratio information for re-ranking partially occ. gRNAs)
*/

class loadmaps {

	private $strictNucs = array();
	private $lenientNucs = array();


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


	function getNucs() {

		#first handle for unique Map
		$handle = fopen("read/uniqueMap.txt", "r");
		if ($handle) {
			while (($line = fgets($handle)) !== false) {

				$data = preg_split("/[\s]+/", $line, -1, PREG_SPLIT_NO_EMPTY);
				$chromTemp = $data[0];
				$chromNumOnly = str_replace("chr", "", $chromTemp);
				$chrom = strval($this->romanToDec($chromNumOnly));

				$atBasePair = strval($data[1]);
				$chromBP = $chrom . "." . $atBasePair;
				$chromBP = (float)$chromBP;
				$keyVal = strval($chromBP);

				$this->strictNucs[$keyVal] = $keyVal;
			}

			fclose($handle);
		} else {
			echo "There was a problem opening the strict nuc file - uniqueMap.txt";
		}


		#second handle for redundant map
		$handle = fopen("read/parsedRedunMap.txt", "r");
		if ($handle) {
			while (($line = fgets($handle)) !== false) {

				$data = preg_split("/[\s]+/", $line, -1, PREG_SPLIT_NO_EMPTY);
				$chromTemp = $data[0];
				$chromNumOnly = str_replace("chr", "", $chromTemp);
				$chrom = strval($this->romanToDec($chromNumOnly));

				$atBasePair = strval($data[1]);
				$chromBP = $chrom . "." . $atBasePair;
				$chromBP = (float)$chromBP;
				$keyVal = strval($chromBP);

				$rank = (float)$data[3]; //intval(data[4])

				$this->lenientNucs[$keyVal] = $rank;
			}

			fclose($handle);
		} else {
			echo "There was a problem opening the lenient nuc file - parsedRedunMap.txt";
		}
    return;
	}

	function returnStrictMap() {
		return $this->strictNucs;
	}

	function returnLenientMap() {
		return $this->lenientNucs;
	}
}

?>
