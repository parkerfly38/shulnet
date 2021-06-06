/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

// Register a templates definition set named "default".
CKEDITOR.addTemplates( 'default', {
    // The name of sub folder which hold the shortcut preview images of the
    // templates.
    imagesPath: CKEDITOR.getUrl( CKEDITOR.plugins.getPath( 'templates' ) + 'templates/images/' ),

    // The templates definitions.
    templates: [
        {
            title: 'Two Columns: 50-50',
            image: 'two_col_5050.png',
            description: 'Two columns: left 50%, right 50%',
            html: '<table cellspacing="0" cellpadding="0" style="width:100%" border="0">' +
                '<tr>' +
                '<td style="width:50%" valign="top">' +
                'Column 1' +
                '</td>' +
                '<td style="width:50%" valign="top">' +
                'Column 2' +
                '</td>' +
                '</tr></table>'
        },
        {
            title: 'Two Columns: 66-34',
            image: 'two_col_6634.png',
            description: 'Two columns: left 66%, right 34%',
            html: '<table cellspacing="0" cellpadding="0" style="width:100%" border="0">' +
                '<tr>' +
                '<td style="width:66%" valign="top">' +
                'Column 1' +
                '</td>' +
                '<td style="width:34%" valign="top">' +
                'Column 2' +
                '</td>' +
                '</tr></table>'
        },
        {
            title: 'Two Columns: 34-66',
            image: 'two_col_3466.png',
            description: 'Two columns: left 34%, right 66%',
            html: '<table cellspacing="0" cellpadding="0" style="width:100%" border="0">' +
                '<tr>' +
                '<td style="width:34%" valign="top">' +
                'Column 1' +
                '</td>' +
                '<td style="width:66%" valign="top">' +
                'Column 2' +
                '</td>' +
                '</tr></table>'
        },
        {
            title: 'Three Columns: 33-34-33',
            image: 'two_col_333333.png',
            description: 'Two columns: left 33%, middle 34%, right 33%',
            html: '<table cellspacing="0" cellpadding="0" style="width:100%" border="0">' +
                '<tr>' +
                '<td style="width:33%" valign="top">' +
                'Column 1' +
                '</td>' +
                '<td style="width:34%" valign="top">' +
                'Column 2' +
                '</td>' +
                '<td style="width:33%" valign="top">' +
                'Column 3' +
                '</td>' +
                '</tr></table>'
        },
        {
            title: 'Image and Title',
            image: 'template1.gif',
            description: 'One main image with a title and text that surround the image.',
            html: '<h3>' +
                '<img style="margin-right: 10px" height="100" width="100" align="left"/>' +
                'Type the title here' +
                '</h3>' +
                '<p>' +
                'Type the text here' +
                '</p>'
        },
        {
            title: 'NAACOS Newsletter',
            image: 'template1.gif',
            description: 'NAACOS Newsletter for Members and Partners',
            html: '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'+
                '<html xmlns="http://www.w3.org/1999/xhtml">' +
                '<head>' +
                '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />' +

                '<title>NAACOS Newsletter for Members and Partners XXX Date</title>' +

                '<style>' +
                'a {color: #26aae2;font:Arial, sans-serif;font-size: 14px;text-decoration: underline;}' +
                'a:hover {color: #8cc63f; font-family: arial, sans-serif;  font-size: 14px;  text-decoration: underline;}' +
                'a:visited {color: #25aae2;font:Arial, sans-serif;font-size: 14px;text-decoration: underline;}' +
                '.a_btm {color: #ffffff;font:Arial, sans-serif;font-size: 18px;text-decoration: underline;}' +
                '.a_btm:hover {color: #25aae2; font-family: arial, sans-serif;  font-size: 18px;  text-decoration: underline;}' +
                '.a_btm:visited {color: #ffffff;font:Arial, sans-serif;font-size: 16px;text-decoration: underline;}' +
                '.a_text {color: #0099FF;font:Arial, sans-serif;font-size: 14px;text-decoration: underline;}' +
                '.a_text:hover {color: #25aae1; font-family: arial, sans-serif;  font-size: 14px;  text-decoration: underline;}' +
                '.a_text:visited {color: #000000;font:Arial, sans-serif;font-size: 14px;text-decoration: underline;}' +
                '.a_toc {color: #26aae2; font:Arial, sans-serif; font-size: 14px; text-decoration: underline;line-height: 2;}' +
                '.a_toc:hover {color: #8cc63f; font-family: arial, sans-serif;  font-size: 14px;  text-decoration: underline;line-height: 2;}' +
                '.a_toc:visited {color: #26aae2;font:Arial, sans-serif;font-size: 14px;text-decoration: underline; line-height: 2;}' +
                '.a_white {color: #ffffff;font:Arial, sans-serif;font-size: 14px;font-weight: bold;text-decoration: underline;}' +
                '.a_white:hover {color: #25aae1; font-family: arial, sans-serif;  font-size: 14px;  text-decoration: underline;}' +
                '.a_white:visited {color: #ffffff;font:Arial, sans-serif;font-size: 14px;text-decoration: underline;}' +
                '.atitle {font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-weight: bold; color:#8cc63f; line-height: 18px;}' +
                'body {font-family: Arial, Helvetica, sans-serif;}' +
                '.bold {font-family: Arial, Helvetica, sans-serif;font-size:18px;font-weight:bold;}' +
                '#border {border: 2px solid #25aae2;}' +
                '.footer {color: #ffffff;font:Arial, sans-serif;font-size: 16px;text-decoration: none;}' +
                '.date {font:Arial, Helvetica, sans-serif;font-size: 16px;font-weight: bold;color: #ffffff;text-align: right;}' +
                'li {font-family: Arial, Helvetica, sans-serif;font-size: 14px;color:#000000;}' +
                '#news {font:Arial, Helvetica, sans-serif;font-size: 30px;color: #ffffff;font-weight: bold;}' +
                '#news_head_text {font:Arial, Helvetica, sans-serif;font-size: 20px;color: #ffffff;}' +
                '.news_heading {font:Arial, Helvetica, sans-serif;font-size: 18px;color: #ffffff;font-weight: bold;text-decoration: none;}' +
                '.news_subheading {font:Arial, Helvetica, sans-serif;font-size: 16px;color: #ffffff;font-weight: bold;text-decoration: none;}' +
                '#rcorners {border-radius: 15px 50px;background: #8cc63f;padding: 20px;width: 830px;height: 100px;}' +
                '.sub_header {font:Arial, sans-serif;color: #25aae2;font-size: 14px;font-weight: bold;}	' +
                '.member {font-family: Arial, Helvetica, sans-serif; font-size: 28px; font-weight: bold; color:#ffffff; 	text-decoration:none;}' +
                'td {font-family: Arial, Helvetica, sans-serif;font-size: 14px;color:#000000;}' +
                '.td_head { font - family: Arial, Helvetica, sans - serif; font - size: 14px; font - weight: bold; color:#8cc63f; line - height: 18px; text - decoration: underline; } '+
                '.td_head2 {font-family: Arial, Helvetica, sans-serif;font-size: 16px;font-weight: bold;color:#26aae2;line-height: 18px;}' +
                '.td_head_sm { font - family: Arial, Helvetica, sans - serif; font - size: 14px; font - weight: bold; color:#26aae2; line - height: 18px; text - decoration: none; } '+
                'th {font-family: Arial, Helvetica, sans-serif;}' +
                '.toc {color: #000000;font:Arial, sans-serif;font-size: 16px;font-weight:bold;line-height:25px;}' +
                '.welcome_header {font:Arial, Helvetica, sans-serif;font-size: 18px;color: #26aae2;font-weight: bold;text-decoration: none;}' +
                 '.welcome_header24 {font:Arial, Helvetica, sans-serif;font-size: 24pt;color: #26aae2;font-weight: bold;text-decoration: none;}' +
                '</style>' +
                '</head > '+

                '<body>' +
                    '<table width="650px" div id="border" align="center">' +
                    '<tr>' +
                    '<td valign="top">' +
                    '<table border="0" width="100%">' +
                    '<tr>' +
                    ' <td align="center" style="border-radius: 20px 50px; background: #8cc63f; padding: 20px; height: 100px;" valign="top" colspan="2">		' +
                    '<table cellpadding="6">' +
                    '<tr>' +
                    '<td width="225px" valign="middle"><img src="https://banners.naacos.com/imx/white_logo.png" width="200" height="152" alt="NAACOS Logo" /></td>' +
                    '<td align="center">       ' +
                    '<span style="font:Arial, Helvetica, sans-serif; font-size: 18pt; color: #ffffff; font-weight: bold; text-decoration: none;">Newsletter for Members<br />and Partners</span>' +
                    '</td>	' +
                    '</tr>' +
                    '<tr>' +
                    '<td class="date" colspan="2" align="right">' +
                    '<span style="font:Arial, Helvetica, sans-serif; font-size: 16pt; color: #ffffff; font-weight: bold; text-decoration: none;">XXX Date</span>' +
                    '</td>' +
                    '</tr>	' +
                    '</table>	' +
                    '</td>	' +
                    '</tr>  ' +
                    '</table>' +
                    '<table width="100%" cellpadding="6" border="0">' +
                    '<tr>	' +
                    '<td align="center">' +
                    '<table border="0" width="100%">' +
                    '<tr>' +
                    '<td valign="top" align="left" colspan="2">' +
                    '<span style="color: #000000; font:Arial, sans-serif; font-size: 16px;' +
                    'font-weight:bold; line-height:25px;">Table of Contents</span>' +
                    '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td valign="top" align="left">' +
                    '<a class="a_toc" href="#xxx">XXX</a><br>' +
                    '<a class="a_toc" href="#xxx">XXX</a><br>' +
                    '<a class="a_toc" href="#xxx">XXX</a><br>' +
                    '<a class="a_toc" href="#xxx">XXX</a><br>' +
                    '<a class="a_toc" href="#xxx">XXX</a><br>' +
                    '<a class="a_toc" href="#xxx">XXX</a><br>' +
                    '</tr>      ' +
                    '</table>' +
                    '</td>' +
                    '</tr>' +
                    '</table>' +
                    '<table width="100%" cellpadding="3" border="0">' +
                    '<tr>' +
                    '<td valign="top"><hr align="center" width="300px" /></td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>' +
                    '<a name="xxx"></a><span class ="atitle">XXX</span><br />' +

                    '<br><br>' +
                    '<a name="xxx"></a><span class ="atitle">XXX</span><br />' +

                    '<br><br>' +
                    '<a name="xxx"></a><span class ="atitle">XXX</span><br />' +

                    '<br><br>' +
                    '<a name="xxx"></a><span class ="atitle">XXX</span><br />' +

                    '<br><br>' +
                    '<center>' +
                    '<a href="https://banners.naacos.com/newsletter/2020/newsletter081320_lnd.htm" target="_blank">' +
                    '<img src="https://banners.naacos.com/newsletter/imx/banners/covid19.png" alt="COVID Banner">' +
                    '</a>' +
                    '</center>' +
                    '<br><br>	' +
                    '<a name="xxx"></a><span class ="atitle">XXX</span><br />' +

                    '<br><br>' +
                    '<a name="xxx"></a><span class ="atitle">XXX</span><br />' +

                    '<br><br>' +
                    '<a name="xxx"></a><span class ="atitle">XXX</span><br />' +

                    '<br><br>' +
                    '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>' +
                    '<table width="100%">' +
                    '<tr>' +
                    '<td bgcolor="#8cc63f" colspan="3" align="center">' +
                    '<table width="650px" align="center">' +
                    '<tr>' +
                    '<td align="center">	' +
                    ' <a class="footer" href="https://twitter.com/@NAACOSnews" target="_blank" border="0">' +
                    '<img src="https://banners.naacos.com/imx/twit.png" border="0" width="48" height="48" alt="twitter logo" />' +
                    '</a>' +
                    '&nbsp;' +
                    '<a class="footer" href="https://www.linkedin.com/company/national-association-of-acos" target="_blank" border="0">' +
                    '<img src="https://banners.naacos.com/imx/in.png" border="0" width="48" height="48" alt="linkedin logo" />' +
                    '</a>' +
                    '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td align="center" div id="news_head_text">' +
                    '601 13th Street, NW, Suite 900 South, Washington, DC 20005 <br />' +
                    '202-640-1985 &nbsp; &#8226; &nbsp;' +
                    '<a div class="a_btm" href="mailto:info@naacos.com">info@naacos.com</a>' +
                    '</td>' +
                    '</tr>' +
                    '</table>' +
                    '</td>' +
                    '</tr>  ' +
                    '</table>' +
                    '</td>' +
                    '</tr>' +
                    '</table>' +
                    '</td>' +
                    '</tr>  ' +
                    '</table>' +
                '</body>'+
                '</html>'
        }
    ]
});
