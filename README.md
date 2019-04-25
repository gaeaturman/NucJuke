# NucJuke

@author gaeaturman, WWU academic tools 2019
NucJuke is a lightweight web tool for re-ranking gRNAs to be used in CRISPR-Cas9 experiments in yeast.

**Files
- Page files, in main directory: home, instructions, help, contact, about, oops, results, and index.php
	> index.php redirects to home.php
	> .php extention for all files hidden for site safety purposes 

- .htaccess
- img/
	> directory has images for site, nucleosome img, logo img
- inc/
	> header.php
	> footer.php
- classes/ filter, grna, loadmaps, processgivengrnas, and query .php
	> .phps for processing

	- read/ parsedRedunMap, uniqueMap .txt
		> .txt files for getting nucleosome information

- css/style.css
	> .css for styling HTML
	> edited from normalize.css, link to gethub for normalize in style.css
	> normalize is open source and standardizes style across browsers

- php.ini
	> error print toggle, error logging toggle, currently set to DEBUG = false !
	> Since web version, error logging but NO error printing!

**Code Information

File Tree for Processing Query (assuming good input):
<pre>
   Home >>> query.php >>> results.php
  ($userInput)     ^	($results //frm. processed user input)
	           ^
	           ^
       processgivengrnas.php <<< filter.php <<< grna.php
    				    ^
				    ^
				    ^
			          loadMaps.php <<< read/  parsedRedunMap.txt  uniqueMap.txt

</pre>
- if bad input, query passes to oops.php

- basic functionality: to re-rank gRNAs by checking location against location of known nucleosomes in two nuc maps

