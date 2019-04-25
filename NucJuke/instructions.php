<?php
$pageTitle = "Instructions";
include("inc/header.php");
?>

<section id="instructions">
    <div id="padder" align="middle">
        <h1>Need more help or want additional documentation?</h1>
        <h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;See our github repo <a href="https://github.com/gaeaturman/NucJuke" class="plain">here</a>.</h1>
    </div>
    <div id="padder" align="middle">
        <h4 class="bigger"><b>Basic Usage Instructions:</b><br/>1. Get gRNAs from desired design website in the correct format</h4>
        <h6><b>FOR CHOPCHOP: </b> Navigate to the <a href="http://chopchop.cbu.uib.no/#" class="plain2">CHOPCHOP</a>  gRNA design website and follow the instructions to get your gRNAs.
            <br/>Copy the contents of the gRNA results table (without the header) and paste them into the input field on the home page.
            <br/>If using gRNAs designed via a fasta sequence on chopchop, please enter the chromosome number being targeted on the
            <br/>first line of the input box, with the results table information on the lines that follow.<h6>
        <h6><b>FOR CRISPR-ERA: </b> Navigate to the <a href="http://crispr-era.stanford.edu/" class="plain2">CRISPR-ERA</a> gRNA design website and follow the instructions to get your gRNAs.
            <br/>Copy the contents of the gRNA results table (without the header) and paste them into the input field on the home page.<h6>
        <h6><b>FOR E-CRISP: </b> Navigate to the <a href="http://www.e-crisp.org/E-CRISP/designcrispr.html" class="plain2">E-CRISP</a> gRNA design website and follow the instructions to get your gRNAs. Click "Download
            <br/> a tabular report" and paste <i>all</i> the contents of the file into the gRNA entry box. We'll get rid of the header for this one.<h6>
        <h6><b>FOR USE MY OWN: </b> Enter information in tab separated format with columns "Rank"     "Sequence"    "Chromosome" "BasePair".
            <br/> Then paste into gRNA input box and query.<h6>
    </div>
    <div id="padder" align="middle">
        <h4 class="bigger">2. Select your gRNA filtering method</h4>
            <h6>There are three routes for filtering your gRNAs based on nucleosome occupancy utilizing two nucleosome maps (see <b><a href="about.php" class="plain">ABOUT</a></b> for more information):
                <br/> <b>1. </b> filtering dynamically (recommended), which combines novel nucleosome data from two maps (unique and redundant) to re-rank nucleosomes based
                <br/> on both degree of nucleosome occupancy and spatial constraints. <b>2. </b> doing a strict filter, which re-ranks gRNAs systematically based solely on overlap
                <br/>with nucleosomes disregarding occupancy score. <b>3. </b> doing a lenient filter which only utilizes the unique nucleosome map to filter gRNAs.<h6>
    </div>
    <div id="padder" align="middle">
        <h4 class="bigger">3. Get your re-ranked gRNAs and get to experimenting!</h4>
    </div>
    <div id="padder">
        </div>
</section>
</html>

<?php
include("inc/footer.php");
?>
