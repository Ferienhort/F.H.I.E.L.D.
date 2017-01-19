<?php

//doofes Skript, nur für Testzwecke 
//kopiert von http://www.ineedtutorials.com/code/php/export-mysql-data-to-csv-php-tutorial

function exportMysqlToCsv($table,$filename = 'export.csv')
{
    $csv_terminated = "\n";
    $csv_separator = ",";
    $csv_enclosed = '"';
    $csv_escaped = "\\";
    $sql_query = "select * from $table";
 
    // Gets the data from the database
    $result = mysql_query($sql_query);
    $fields_cnt = mysql_num_fields($result);
 
 
    $schema_insert = '';
 
    for ($i = 0; $i < $fields_cnt; $i++)
    {
        $l = $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed,
            stripslashes(mysql_field_name($result, $i))) . $csv_enclosed;
        $schema_insert .= $l;
        $schema_insert .= $csv_separator;
    } // end for
 
    $out = trim(substr($schema_insert, 0, -1));
    $out .= $csv_terminated;
 
    // Format the data
    while ($row = mysql_fetch_array($result))
    {
        $schema_insert = '';
        for ($j = 0; $j < $fields_cnt; $j++)
        {
            if ($row[$j] == '0' || $row[$j] != '')
            {
 
                if ($csv_enclosed == '')
                {
                    $schema_insert .= $row[$j];
                } else
                {
                    $schema_insert .= $csv_enclosed . 
					str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $row[$j]) . $csv_enclosed;
                }
            } else
            {
                $schema_insert .= '';
            }
 
            if ($j < $fields_cnt - 1)
            {
                $schema_insert .= $csv_separator;
            }
        } // end for
 
        $out .= $schema_insert;
        $out .= $csv_terminated;
    } // end while
 
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Length: " . strlen($out));
    // Output to browser with appropriate mime type, you choose ;)
    header("Content-type: text/x-csv");
    //header("Content-type: text/csv");
    //header("Content-type: application/csv");
    header("Content-Disposition: attachment; filename=$filename");
    echo $out;
    exit;
 
}

$server = "dd29920.kasserver.com";
$username = "d0220110";
$password = "V7ntpLuc9HeKVYRw";
$database = "d0220110";

$host = 'dd29920.kasserver.com'; // MYSQL database host adress
$db = 'd0220110'; // MYSQL database name
$user = 'd0220110'; // Mysql Datbase user
$pass = 'V7ntpLuc9HeKVYRw'; // Mysql Datbase password
 
// Connect to the database
$link = mysql_connect($host, $user, $pass);
mysql_select_db($db);
 
$table="download_actions"; // this is the tablename that you want to export to csv from mysql.
 
exportMysqlToCsv($table);