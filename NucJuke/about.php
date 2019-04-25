<?php
$pageTitle = "About";
include("inc/header.php")
?>

<section id="about">
    <div id="padder" align="middle">
        <h4 class="bigger">In the last decade</h4>
        <h6>...there have been a variety of papers published that suggested nucleosome presence lessens Cas9's ability to
            <br/> make a double stranded break at a specific target site, especially in yeast. In light of this information, few if
            <br/> any gRNA design tools have been modified to account for this. This gRNA design tool helper for the eukaryotic
            <br/> model organism <i>S. cerevisiae</i> is meant to help researchers evaluate potential gRNA targets more completely
            <br/> and contribute to an increased efficiency in CRISPR-Cas9 experiments. Please note that at this time our tool is
            <br/> still being validated. As such there may be some bugs we've yet to work out. If you run into some kind of issue
            <br/> while using this tool that you believe is bug-related, please contact us.</h6>
        </div>
        <div id="padder" align="middle">
            <h4 class="bigger" align="middle">The Nucleosome Maps & Filtering Methods</h4>
            <h6>The two nucleosome maps used in creating this tool are taken from <a href="https://www.nature.com/articles/nature11142" class="plain">this</a> publication by Kristin Brogaard, Liqun Xi,
                <br/> Ji-Ping Wang and Jonathan Widom. They are:
                <br/>
                <br/> (1) a unique map in which nucleosome domains are not allowed to overlap by more than a specified number of base pairs
                <br/>
                <br/>(2) redundant map in which nucleosomes may arbitrarily overlap each other.
                <br/>
                <br/>In all of our filtering methods, the returned gRNAs are treated categorically, designated full or partially occupied, or
                <br/> unoccupied. In the dynamic sort fully occupied gRNAs are returned in order of their original ranks while partially
                <br/> occupied gRNAs are re-ordered based on the NCP Score:Noise ratio and original rank. In the strict sort, all nucleosomes
                <br/>from both maps are treated as having absolute inaccessibility. As such any gRNA overlapping with any nucleosome via this
                <br/> method is designated fully occupied, and rank is maintained among occupied gRNAs based on original ordering of gRNAs.
                <br/> In the lenient sort method, only the information from the unique nucleosome map is used and all gRNAs overlapping with
                <br/> nucleosomes are considered only partially occupied. gRNAs filtered via this method are re-ranked basked on the NCP
                <br/> Score:Noise Ratio and original rank. For more information regarding our filtering methods,
                <br/> please see documentation in our github repo <a href="https://github.com/gaeaturman/NucJuke" class='plain'>here</a>.</h6>
            </div>
            <div id="padder" align="middle">
                <h4 class="bigger" align="middle">Tool Validation</h4>
                <h6 align="middle" >Nothing to see here! Please check back later for updates.<h6>
                </div>
                <div id="padder">
        </div>
            </section>

<?php
include("inc/footer.php");
?>
