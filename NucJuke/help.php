<?php
$pageTitle = "HELP!";
include("inc/header.php");
?>

<section id="help">
    <div div id="padder" align="middle">
        <h1>Need more help or want additional documentation?</h1>
        <h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;See our github repo <a href="https://github.com/gaeaturman/NucJuke" class="plain">here</a>.</h1>
    </div>
    <div id="padder" align="middle">
        <h4 class="bigger">I don't know which kind of ranking I should choose</h4>
        <h6>As of <?php date_default_timezone_set('America/Los_Angeles'); echo date("F j Y"); ?>, this tool is still being validated, so while we cannot definitively say which filtering method is best, we currently recommend you
            <br/> stick to the dynamic re-ranking method. By doing this you allow for a more encapsulating filtration of your gRNAs since you're allowing them
            <br/> to be evaluated on two parameters. We'll be sure to keep this page updated in the event of any changes though. <h6>
            </div>
            <div id="padder" align="middle">
                <h4 class="bigger">Why can't I filter my gRNAs from _______ site?</h4>
                <h6>While we hope to integrate gRNA checking for all the sites one might use in the future, we've currently kept to implementing it
                    <br/> for those sites we have used most often. You can always feel free to email us though and we would be more than happy to add
                    <br/> support for your favorite gRNA design site! Otherwise, you can also organize your own gRNAs into a tab separated file
                    <br/> with the following format: Rank   Sequence    Chromosome  Location(bp). We do this mainly because it allows us to be fairly
                    <br/> certain your gRNAs will get properly formatted. There are many, many different possible ways to organize gRNA information
                    <br/> in a file. Having this information and sticking to specificed sites allows us to be certain of the format of your gRNA
                    <br/> information. Without this it's very hard for us to filter your gRNAs appropriately.
                </div>
                <div id="padder" align="middle">
                    <h4 class="bigger">I'm interested in using this tool for research, how can I cite this tool?</h4>
                    <h6>While there is currently no paper associated with this tool, you can cite it as:
                        <br/>   Turman, Gaea, and Daniel Pollard, “NucJuke - A gRNA re-evaluation tool for CRISPR-Cas9 experiments in yeast”,
                        <br/>   Ver. 1.0.0, April 2019, www.wwu.nucjuke.com.</h6>
                        <h6><u>You should additionally cite the paper/authors of the tool you used to originally design your gRNAs.</u></h6>
                    </div>
                    <div id="padder">
                </div>
                </section>

                <?php
                include("inc/footer.php");
                ?>
