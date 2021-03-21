<?php
    $rows = explode(';',$_POST["data"]);
?>
<h1>Print Yahrzeit Letters for <?php echo $_POST["englishname"]; ?></h1>
<div class="popupbody">
<table cellspacing="0" cellpadding="0" border="0" width="100%" class="generic" id="menu">
    <thead>
        <tr>
            <th>Bereaved Name</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach ($rows as $row)
            {
                $cells = explode(",",$row);
                echo "<tr><td>".$cells[2]."</td><td><a href=\"#\" onclick=\"printLetter('".$cells[2]."','".$cells[3]."','".$cells[4]."','".$cells[5]."','".$cells[6]."','".$cells[7]."','".$_POST["hebrewdate"]."','".$_POST["englishdate"]."','".$_POST["englishname"]."'); return false;\">Print Letter</a></td></tr>";
            }
        ?>
    </tbody>
</table>
</div>
<div id="printableArea" style="display:none;"></div>
<script type="text/javascript">
    function printLetter(name, addr1, addr2, city, state, zip, hebrewDate, englishDate, englishName)
    {
        let rawHtml = "<div id='printableArea2'><table border='0' width='100%'><tr><td style='text-align:center;'>CONGREGATION BETH ISRAEL<br />1888<br /><img src='imgs/beth-israel.png' border='0' /></td><td style='text-align:right;'><p>BILL SIEMERS, Rabbi</p><p>BRIAN KRESGE, President</p><p>NORI KAZDOY, Vice President</p><p>PENNY LAMHUT, Treasurer</p><p>NANCI MILLER, Secretary</p></td></tr></table>";
        rawHtml += "<p>"+addr1+"<br />";
        if (addr2.length > 0)
        {
            rawHtml += addr2+"<br />";
        }
        rawHtml += city+", "+state+" "+zip+"</p>";
        rawHtml += "<p>Dear "+name+",</p>";
        rawHtml += "<p>On "+englishDate+" / "+hebrewDate+" you have Yahrzeit for "+englishName+".  We hope that you will be able to attend services.  If we don't have services that coincide with this date, we will be happy to convene one with notice to the Office or the Rabbi.</p>";
        rawHtml += "<p>Many people who honor the memory of a departed relative do so not only at attending Yahrzeit, but also by making a charitable gift.  We hope that you will consider perpetuating that tradition by making a donation to the synagogue.  Your contribution and the name of the person being remembered will be in our next bulletin.</p>";
        rawHtml += "<p>In addition to the Yahrzeit Fund for special projects, Congregation Beth Israel maintains a Book Fund to maintain and replenish our prayer books, the Rabbi's Discretionary Fund for projects of the Rabbi's choice, and the General Fund for the general maintenance of our synagogue. You can send a check to the office (with a memo for the fund), or donate via the link at www.cbisrael.org.</p>";
        rawHtml += "<p>Thank you very much for considering a special gift to Congregation Beth Israel.</p>";
        rawHtml += "<p>Sincerely,</p>";
        rawHtml += "<p><img src='imgs/signature-bk.png' style='width:200px;heigh:auto;' border='0' /></p>";
        rawHtml += "<p>Brian Kresge<br />President</p>";
        rawHtml += "<p>&nbsp;</p><p style='font-weight:bold;text-align:center;'>144 York St, Bangor, ME 04401&nbsp;&nbsp;(207) 945-3433 Fax (207) 945-3840&nbsp;&nbsp;office@cbisrael.org&nbsp;&nbsp;www.cbisrael.org</p></div>";
        $("#printableArea").html(rawHtml);
        printJS({ type: "html", printable: 'printableArea2'});
    }
</script>