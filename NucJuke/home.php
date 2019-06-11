<?php
$pageTitle = "Home";
error_log("NucJuke - Start of Error Log");
include("inc/header.php");
?>

<!--
Home.php

Site main page, takes user input for query.
-->

<section align='middle'>
    <div class="flex-wrapper">
    <div id="padder">
    </div>
    <form method="post" action="classes/query">
        <div align="center">
            <column2>
                <div id="padder2">
                    <h3 align='middle'>Step 1. Design your guide RNAs.</h3>
                </div>
                <div align="middle">
                    <h61 align="block">Generate a list of potential gRNA target sequences using a design tool/approach of your choosing. We currently support the output formats of CHOPCHOP, CRISPR-ERA, and E-CRISP as well as a generic tab-delimited format (columns: Rank, Target Sequence, Chromosome, Position).</h61>
                    </div>
                    <div id="padder3">
                        <h3 align='middle'><label for="siteSelection">Step 2. Select format used.</label></h3>
                    </div>
                    <div align="middle">
                        <!-- siteSelection String to be passed to query.php -->
                        <select type="text" id="siteSelection" name="siteSelection">
                            <option value="chopchop">CHOPCHOP</option>
                            <option value="crispr-era">CRISPR-ERA</option>
                            <option value="e-crisp">E-CRISP</option>
                            <option value="use_my_own">GENERIC</option>
                        </select>
                    </div>
                    <div id="padder3">
                        <h3 align='middle'><label for="filterMethod">Step 3. Select how you would like to rank your gRNAs.</label></h3>
                    </div>
                    <div align="middle">
                        <!-- filterMethod String to be passed to query.php -->
                        <select type="text" id="filterMethod" name="filterMethod">
                            <option value="dynamic">Dynamic Filter (recommended)</option>
                            <option value="strict">Strict Filter</option>
                            <option value="lenient">Lenient Filter</option>
                        </select>
                    </div>
                </column2>
                <div class="column1">
                    <div id="padder3">
                        <h3 align='middle'><label for="userInput">Step 4. Enter (copy & paste below) your gRNAs formatted according to Step 2.</label></h3>
                    </div>
                    <div align='middle'>
                        <!-- userInput (gRNAs) String to be passed to query.php -->
                        <textarea type="text" id="userInput" name="userInput"
                        placeholder="1	TGTTTTCGAACAAAAGGCCAAGG	chrI:72952	1	+	40	0	0	0	0	0	0.70                                                                   2	CTTGGAAACCAATCTTGGGGTGG	chrI:74002	1	-	50	1	0	0	0	0	0.69                                                                   3	GACGGTGTTATGGTTGCCAGAGG	chrI:72557	1	+	55	0	0	0	0	0	0.68                                                                   4	AACGTAGATGATTCTACCAGCGG	chrI:72198	1	-	40	1	0	0	0	0	0.66                                                                   5	AGCTTGTTCAGCAATGACAGCGG	chrI:72837	1	-	45	0	0	0	0	0	0.65                                                                   6	AAGGTCAAGGCTTTGAACGCCGG	chrI:72275	1	+	50	0	0	0	0	0	0.65                                                                   7	AGATTCTCTCACTTGTACAGAGG	chrI:73076	1	+	40	0	0	0	0	0	0.65                                                                   8	AGCGACAGCGGAGGCAGCGACGG	chrI:72927	1	-	70	1	0	0	0	0	0.64                                                                   9	CACCGATGACAAGTACGCTAAGG	chrI:72121	1	+	50	0	0	0	0	0	0.63                                                                   10	TCTTGGGGTGGTACCGGAAGTGG	chrI:72990	1	-	60	1	0	0	0	0	0.64                                                                   11	TTCGAAAACAGCAGCGACAGCGG	chrI:72939	1	-	50	0	0	0	0	0	0.62                                                                   12	CTTAGCGTACTTGTCATCGGTGG	chrI:72120	1	-	50	1	0	0	0	0	0.63                                                                   13	GTAGTCAACATCGTTGGTGGTGG	chrI:72066	1	-	50	1	0	0	0	0	0.63                                                                   14	GTTGTCTGGTGAAACCGCCAAGG	chrI:72775	1	+	55	0	0	0	0	0	0.61                                                                   15	TTGTCTGGTGAAACCGCCAAGGG	chrI:72776	1	+	50	0	0	0	0	0	0.61                                                                   16	AGTGTTGGAGTGACCAGCACCGG	chrI:73245	1	-	55	0	0	0	0	0	0.60                                                                   17	AAGTCCGAAGAATTGTACCCAGG	chrI:71990	1	+	45	1	0	0	0	0	0.60                                                                   18	GGTAAGATCTGTTCCCACAAGGG	chrI:72296	1	+	45	0	0	0	0	0	0.59                                                                   19	GGCAGCGACGGTTTCGGTGGTGG	chrI:72915	1	-	70	1	0	0	0	0	0.60                                                                   20	GGAATTCGGTATCTTGAAGAAGG	chrI:73189	1	+	40	0	0	0	0	0	0.58                                                                   21	CTTCGGTATTGAAAAGGCTAAGG	chrI:73168	1	+	40	0	0	0	0	0	0.58                                                                   22	GGACAAGACAATGATAGCCTTGG	chrI:72969	1	-	45	3	0	0	0	0	0.60                                                                   23	AGCTTTGTCTGAAAAGGACAAGG   	chrI:72352	1	+	40	2	0	0	0	0	0.59                                                                   24	TTGTCCTTTTCAGACAAAGCTGG 	chrI:72350	1	-	40	0	0	0	0	0	0.57                                                                   25	GTGTCCAAAGCAATGGCCAATGG	chrI:72017	1	-	50	0	0	0	0	0	0.57                                                                   26	GAAATCTTGAAGGTCACTGACGG	chrI:72539	1	+	40	0	0	0	0	0	0.57                                                                   27	GGAGGCAGCGACGGTTTCGGTGG	chrI:72918	1	-	70	1	0	0	0	0	0.57                                                                   28	CAATGGCCAATGGTCTACCTGGG	chrI:72007	1	-	50	0	0	0	0	0	0.56                                                                   29	TTGGACAGCCAAGACTTCTGGGG	chrI:72603	1	-	50	3	0	0	0	0	0.59                                                                   30	ATTGTACCCAGGTAGACCATTGG	chrI:72001	1	+	45	1	0	0	0	0	0.56"
                        ></textarea>
                    </div>
                    <div style="display:none">
                        <h3><label for="nucMap">Step 5. Select a NucMap</label></h3>
                        <!-- This is a spam honeypot, hidden field to be let unfilled -->
                        <textarea type="text" id="nucMap" name="nucMap"></textarea>
                        <p>Please this field blank.</p>
                    </div>
                    <div id="padder25">
                        <h3 align="inherit" style="display:none"><label for="submit">Step 5. Check gRNAs!</label></h3>
                        <div id="subber2">
                            <button type="submit" id="submit" name="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
</section>
<?php
include("inc/footer.php");
?>
