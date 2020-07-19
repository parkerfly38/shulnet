<?php

   
if (!empty($_POST['id'])) {

    $crit = new criteria($_POST['id']);
    // If "type" is submitted, it will show the
    // specifics of the criteria. If it isn't
    // submitted, it will show the users matching
    // the criteria.
    if (! empty($_POST['type'])) {
        echo "<h1>Previewing Criteria Details</h1>";
        echo "<div class=\"popupbody\">";
        echo $crit->readable;
        echo "</div>";
    } else {
        $prev = $crit->preview();
        echo "<h1>Previewing Users Matching Criteria</h1>";
        echo "<div class=\"popupbody\">";
        echo $prev;
        echo "</div>";
    }

} else {
    echo "Error";
}
?>