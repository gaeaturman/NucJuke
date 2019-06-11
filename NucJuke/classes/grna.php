<?php
ini_set('display_errors','off');

/*
gRNA class for storing gRNA info,

private $designRank - original rank from external gRNA design website
private $sequence - sequence of the gRNA
private $onChrom - the chromosome the gRNA is targeting to
private $startLoc - the basepair on the chromosome the gRNA targets to
private $occupied - if the gRNA overlaps with a nucleosome on the strict map, this is true
private $nucRank - if a gRNA overlaps with a nucleosome on the redundant map,
				   this value represents the NCP Score:noise value for the nucleosome it overlaps with
private $finalRank - if a gRNA overlaps with a nucleosome on the redundant map,
				     this value represents the multiplied NCP:Score * designRank to get a score based on both
				     original design and strength of nucleosome assocaition
private $otherInfo - other info from the original design website that we don't want to manipulate, but the
					 user will still want to see in the output
*/

class grna
{
	private $designRank; //int
	private $sequence; //String
	private $onChrom; //int
	private $startLoc; //int
	private $occupied; //boolean
	private $nucRank; //int
	private $finalRank; //int
	private $otherInfo;


  #Constructor
  function __construct($designRank, $sequence, $onChrom, $startLoc) {
	  $this->designRank = $designRank;
      $this->sequence = $sequence;
      $this->onChrom = $onChrom;
      $this->startLoc = $startLoc;
      $this->occupied = false;
      $this->nucRank = -1;
      $this->finalRank = -1;
	  $this->otherInfo = "";
	}

	#Getters
	public function getDesignRank()
	{
		return $this->designRank;
	}

	public function getSequence()
	{
		return $this->sequence;
	}

	public function getChrom()
	{
		return $this->onChrom;
	}

	public function returnLoc()
	{
		return $this->startLoc;
	}

	public function isOccupied()
	{
		return $this->occupied;
	}

	public function getNucRank()
	{
		return $this->nucRank;
	}

	public function getFinalRank()
	{
		return $this->finalRank;
	}

	public function getOtherInfo()
	{
		return $this->otherInfo;
	}

	public function returnInfo()
	{
		return '\t' . $this->designRank . "\t" . $this->finalRank . "\t" . $this->sequence . "\t" . $this->onChrom . "\t" . $this->startLoc . "\t" . $this->otherInfo;
	} 

	#Setters
	public function setOccupied()
	{
		$this->occupied = true;
	}

	public function setNucRank($newNucRank)
	{
		$this->nucRank = $newNucRank;
	}

	public function setFinalRank($newFinalRank)
	{
		$this->finalRank = $newFinalRank;
	}

	public function setOtherInfo($newOtherInfo)
	{
		$this->otherInfo = $newOtherInfo;
	}


}

?>
