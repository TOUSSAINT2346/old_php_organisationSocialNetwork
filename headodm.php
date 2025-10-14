<tr>
<td width="5%">&nbsp;</td>
<td align="center"><p><a href="odmpri.php"><img src="img/diariomafioso.png"></a></p>
<table border="0">
<tr>
<td>
<font color="#6b6b6b">
<?php
    $hoje_formata = new DateTime();
    $dayzu = $hoje_formata->format('w');
    include ('dias.php');
    echo ', ' . $hoje_formata->format('d') . ' de ';
    $mezu = $hoje_formata->format('m');
    include('meses.php');
    echo ' de ' . $hoje_formata->format('Y');
?>
 | </font></td><td><font color="#6b6b6b">
    <?php
        // The original code used Yahoo's weather API, which has been discontinued.
        // This could be replaced with a different weather API service.
        // For example, OpenWeatherMap API.

        
        //$xml = simplexml_load_file('http://weather.yahooapis.com/forecastrss?p=BRXX0128&u=c');
        //foreach( $xml->xpath( '//yweather:condition ') as $el){
        //    $attributes = $el->attributes();
        //    $children = $el->children(); // OR: $el->xpath('title'); if children vary
        //    $codigo = $attributes['code'];
        //    $temperatura = $attributes['temp'];
        //    $foriz = $attributes['code'];
        //    include ('conds.php');
        //}
    ?>
<!--<table border="0">
<tr>
<td>
Cidade Universitária:
</td>
<td>
<img src="http://l.yimg.com/a/i/us/we/52/<?=$codigo?>.gif" title="<?=$condizon?>"/></td>
<td> - <?=$condizon?> ~ <?=$temperatura?> &deg;C</td>
</tr>
</table>-->
</font>
</td></tr></table>
<hr color="#000000" />
<b><a href="odmareas.php?a=nn">Notícias Nacionais</a> | <a href="odmareas.php?a=ni">Notícias Internacionais</a> | <a href="odmareas.php?a=c">Cursos</a> | <a href="odmareas.php?a=co">Concursos</a> | <a href="odmareas.php?a=uu">Utilidade Universitária</a> | <a href="odmareas.php?a=a">Anúncios</a> | <a href="odmareas.php?a=p">Política</a> | <a href="odmareas.php?a=hi">Humor Instrutivo</a> | <a href="odmareas.php?a=ri">RI</a> | <a href="odmareas.php?a=m">Notícias Mafiosas</a></b>
<hr color="#CCCCCC" /></td>
<td width="5%">&nbsp;</td>
      </tr>