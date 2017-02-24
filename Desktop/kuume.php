<?php


include_once '../func.inc.php';
checkordie();

if($_POST[time]=="TEST"){
    $_POST[egal]="TRUE";
}


echo "<div style='";
echo primary_color($_SESSION[ADMIN]);
echo "' class=menu>";


echo "<span id=links>  <b>F.H.I.E.L.D.</b>  ";
if(count($_SESSION[OWNER])==1){
    echo $groups[$_SESSION[NOW]-1];
    }
else{
    echo "<form method=post action=switch.php id=switchthis name=wechsel><select name=wechsel>";
        foreach($_SESSION[OWNER] as $i){
            echo "<option value=".$i." ";
                if($i==$_SESSION[NOW]){
                    echo "selected";
                }
            echo ">".$groups[$i-1]."</option>";
        }
    echo "</select>";
    echo "<input type=submit value=Wechsel></form>";
}
    echo "  V.:$version ";
    if(checkthis(15)){
   echo "<span class=backup>";
    if(!$dir=scandir("../Backup/Backups/Data",1)){
        echo "Kein Backup gefunden!";
    }
    else{
         $dir=  explode("-", $dir[0]);
    echo "<b>Letztes DB Backup:</b> $dir[4].$dir[3].$dir[2] um $dir[5]:".substr($dir[6],0,2);
    }
    echo "</span>";
}
echo "</span>";
echo '<form action="omini.php" method="POST" target="thatframeyo" id="quick" name=Omni>Suche: <input required type="text" size="10" name="IID"><input type="submit" value="Go!">
           Scan<input type="checkbox" name="Check" value="1"> inkl. Kommentare<input type="checkbox" name="kom" value="1"> </form>';
echo "<span id=usermenu>";
if(checkthis(22)){
    echo "<span id=alert><a href=alert.php target=thatframeyo>";
    echo mysqli_num_rows(mysqli_query(connect(),"SELECT * FROM kuume_alerts WHERE LEVEL > 3 AND DATETIME_IT_HAPPENED > NOW() - INTERVAL 72 HOUR ORDER BY DATETIME_IT_HAPPENED DESC "));
    echo " Alerts</a> - </span>";
}
if(checkthis(21)){
    echo "<span id=hash><a href=hashtag.php target=thatframeyo># ";
    echo mysqli_num_rows(mysqli_query(connect(),"SELECT IID FROM  `kuume_comments` WHERE `COMMENT` LIKE  '%#%' AND IID IN(SELECT IID FROM kuume_inventory WHERE OWNER=$_SESSION[NOW])"));
    echo "</a> - </span>";
}
echo "<a href=cockpit.php target='thatframeyo'> $_SESSION[NAME]'s &Uuml;bersicht </a>- ";
if(checkthis(23)){
}

if(checkthis(20)){
    echo "<a href=scann.php target='thatframeyo'>Multiscan</a> - ";
}
if(checkthis(7)){
    echo "<a href=spy.php target='thatframeyo'>Log</a> - ";
}
if(checkthis(2)){
    echo "<a href=users.php target='thatframeyo'>Benutzer</a> - ";
}
echo '<a href=logout.php>Log Out</a></span></div>';

if(isset($_POST[ichbinfaul])){
    $i=0;
    foreach($category as $cat){
        $temp="cat".$i;
        $select_category[$i]=$_POST[$temp];
        $i++;
    }
    $i=0;
    foreach($status as $stat){
        $temp="status".$i;
        $select_status[$i]=$_POST[$temp];
        $i++;
    }
    $i=0;
    foreach($time as $cat){
        $temp="time".$i;
            if($_POST[time]==$i){
                $select_time[$i]=1;
            }
            else{
                $select_time[$i]=0;
            }
        $i++;
    }
    $i=0;
    foreach($label as $cat){
        $temp="label".$i;
        $select_label[$i]=$_POST[$temp];
        $i++;
    }
}
?>

<div id="leftcontainer">
<div id="top">
    <form action="index.php" method="post" name="suchfilter">
        <input type="hidden" name="ichbinfaul" value="TRUE" >
    <table class="filter">
    <tr> 
        <td>
            <span class="headline">
                Kategorie
            </span> <br>
            <?php
            $i=0;
            foreach($category as $cat){
                echo "<input type=checkbox name=cat".$i." value=1 ";
                    if($select_category[$i]==1){
                        echo "checked";
                }
                echo "> $cat<br>";
                $i++;
            }
            ?>
        </td>
        <td>
            <span class="headline">
                Status
            </span> <br>
            <?php
            $i=0;
            foreach($status as $stat){
                echo "<input type=checkbox name=status".$i." value=1 ";
                    if($select_status[$i]==1){
                        echo "checked";
                }
                echo "> <img src=img/".drawstatus($i)." class= klein>$stat<br>";
                $i++;
            }
            ?>
        </td>
        <td>
            <span class="headline">
                Inventur
            </span><br>
            <?php 
           echo "<input type=radio name=not value=FAUL ";
                if($_POST[not]=="FAUL"){
                    echo "checked";
                }
                 if(!isset($_POST[not])){
                    echo "checked";
                }
                echo "> ignorieren<br>";
            echo "<input type=radio name=not value=TRUE ";
                if($_POST[not]=="TRUE"){
                    echo "checked";
                }
                echo "> hat gefehlt<br>";
            echo "<input type=radio name=not value=FALSE ";
                if($_POST[not]=="FALSE"){
                    echo "checked";
                }
                echo "> war da";
            echo "<br> bei der Inventur von <br>";
            echo "<select name=date>";
            echo "<option ";
                if(isset($_POST[date]) && $_POST[date]==0){
                    echo "selected";
                }
            echo " value=0> Heute </option> ";
            $result=mysqli_query(connect(), "SELECT COUNT(DISTINCT kuume_actions.IID) AS SCANNS, DATE_FORMAT(kuume_actions.TIME + INTERVAL 24 HOUR,'%Y-%m-%d') AS INVENTUR_ZEIT FROM kuume_actions WHERE kuume_actions.IID IN(SELECT kuume_inventory.IID FROM kuume_inventory WHERE OWNER= $_SESSION[NOW]) AND kuume_actions.TEXT LIKE '%Scannt%' GROUP BY DATE_FORMAT(kuume_actions.TIME,'%Y%m%d') ORDER BY INVENTUR_ZEIT DESC");
            while($row=  mysqli_fetch_array($result)){
                if($row[SCANNS]>=$inventory_minimum){
                    echo "<option value=$row[INVENTUR_ZEIT] ";
                        if(isset($_POST[date]) && $_POST[date]==$row[INVENTUR_ZEIT]){
                            echo "selected";
                        }
                    echo " >$row[INVENTUR_ZEIT] ($row[SCANNS])</option>";
                }
            }
            echo "</select>";
            ?>
        </td>
        <td><span class="headline">
                Weitere Optionen
            </span><br>
             <input type=checkbox name=verliehen value=TRUE <?php
    if($_POST[verliehen]==TRUE){
    echo "checked";
}
    echo "> Verliehen<br>";
             $i=0;
        if(checkthis(11)){
            foreach($label as $cat){
                echo "<input type=checkbox name=label".$i." value=1 ";
                    if($select_label[$i]==1){
                        echo "checked";
                }
                echo "> $cat<br>";
                $i++;
        }
        }
         if(checkthis(9)){
        echo "<input type=checkbox name=export value=TRUE> Export<br>";
        }
        if(checkthis(29)){
        echo "<input type=checkbox name=detail value=TRUE";
            if(isset($_POST[detail]) && $_POST[detail]=="TRUE"){
                echo " checked";
            }
        echo "> Details<br>";
        }
        
        ?><br>
          
        </td>
    </tr>
    <tr>
        <td>
            
        </td>
        
        <td>
            
        </td>
        <td>
        </td>
        <td>
            Filter:  <input type="submit" value="Aktivieren">
        </td>
        
    </tr>
</table>
   
    </form>

</div>
<div id="query">
<?php

$conn=connect();

$buildingquery ="SELECT * FROM `kuume_inventory` WHERE";

if($_POST[verliehen]==TRUE){
    $buildingquery.=" LENDER != 0 AND ";
}

$buildingquery.= " CATEGORY IN(";
        
    $i=0;
    foreach($select_category as $cat){
        if($cat==1){
           $buildingquery.=$i.","; 
        }
        $i++;
    }
    $buildingquery.="2500000) AND";
    
$buildingquery.= " LABEL IN(";
    
    $i=0;
    $a=0;
    foreach($select_label as $cat){
        if($cat==1){
           $buildingquery.=($i+1).","; 
           $a++;
        }
        $i++;
    }
    $i=0;
    if($a==0){
        $buildingquery.="$i,";
        $i++;
           foreach($label as $cat){
                 $buildingquery.="$i,";
                 $i++;
           } 
        }
    $buildingquery.="2500000) AND STATUS IN(";
    
    $i=0;
    foreach($select_status as $cat){
        if($cat==1){
           $buildingquery.=$i.","; 
        }
        $i++;
    }
    
    $buildingquery.="2500000)";
    
    if($_POST[not]!="FAUL" && isset($_POST[not])){
        $buildingquery.=" AND IID ";
        if($_POST[not]!="FALSE"){
            $buildingquery.=" NOT ";
        }
        $buildingquery.=" IN (SELECT IID FROM `kuume_actions` WHERE TEXT LIKE '%Scannt%' AND TIME";
        $i=0;
        $temp=36;
    $buildingquery.=" <= ";
     
    if($_POST[date]==0 || !isset($_POST[date])){
        $buildingquery.=" NOW() + INTERVAL 24 HOUR AND TIME >= NOW() - INTERVAL 36 HOUR )"; 
     }
     else
     {
        $buildingquery.=" str_to_date('$_POST[date]','%Y-%m-%d') + INTERVAL 48 HOUR AND TIME >= str_to_date('$_POST[date]','%Y-%m-%d') - INTERVAL 36 HOUR) ";   
     }
       
     
            
    }

$buildingquery.=" AND DATETIME_CATALOGED < ";

     if($_POST[date]==0 || !isset($_POST[date])){
        $buildingquery.=" NOW()"; 
     }
     else
     {
        $buildingquery.=" str_to_date('$_POST[date]','%Y-%m-%d') + INTERVAL 24 HOUR";   
     }
          
$buildingquery  .= " AND OWNER=$_SESSION[NOW] ORDER BY `kuume_inventory`.`CATEGORY` ASC, `kuume_inventory`.`STATUS` ASC, `kuume_inventory`.`NAME` ASC";
    
$query=$buildingquery;
message($query);
document($conn, $_SESSION[UID],0,"Schnuppert: ".$groups[$_SESSION[NOW]-1],0,0);
$temp=mysqli_query($conn,  $query);

echo "<div id=list>";
if($temp==FALSE){
    die("Kein Inventar gefunden");
}
$oldrow=-1;
while ($row = mysqli_fetch_array($temp)) {
    if($oldrow!=$row[CATEGORY]){
        $oldrow=$row[CATEGORY];
        echo "<p class=cattitle> ".$category[$row[CATEGORY]]."</p>";
    }
        echo"<p class=item><img src=img/".drawstatus($row[STATUS])." class= klein><span class=itemtitle> ";
                if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM  `kuume_comments` WHERE IID=$row[IID] AND VISABLE=1"))>0){
                echo "<img class=klein src=img/comment.png>";
            }
        if(mysqli_num_rows(mysqli_query($conn, "SELECT LABEL  FROM  `kuume_inventory` WHERE LABEL>0 AND IID=$row[IID]"))>0){
                echo "<img class=klein src=img/".draw_label($row[IID]).">";
            }    
         if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM  `kuume_inventory` WHERE IID=$row[IID] AND DATETIME_LEND <= NOW() - INTERVAL $hours HOUR AND DATETIME_LEND!=0"))>0){
                echo "<img class=klein src=img/time.png>";
            } 
       // echo " <b>$row[IID]</b>";
        if($row[LENDER]!=0){
            echo "<b>[$row[LENDER]] </b>";
        }
        echo $row[NAME]."</span> </span>";
        echo "<span class=itemlinks>";
        echo "<a href=comments.php?IID=$row[IID] target='thatframeyo' ><img class=klein src=img/edit.png></a>";
         if(checkthis(3)){
            echo "<a href=edit.php?IID=$row[IID] target='thatframeyo' ><img class=klein src=img/edit_all.png></a>";
        }
        if(checkthis(4)){
            echo "<a href=log.php?IID=$row[IID] target='thatframeyo' ><img class=klein src=img/log.png></a>";
        }
        if(checkthis(0)){
            echo "<a href=delete.php?IID=$row[IID] target='thatframeyo' ><img class=klein src=img/delete.png></a>";
        }
        if($_POST[not]=="TRUE" && $_POST[date]==0){
            echo "<a href=scanone.php?IID=$row[IID] target='thatframeyo' ><img class=klein src=img/checkmark.png></a>";
        }
        echo "</span>";
        echo "</p>";
        
        if(1){
            if(isset($_POST[detail]) && $_POST[detail]=="TRUE"){
            if(substr_count($row[CONTENT],";")-1>0){
                echo "<p class=detailsinlist><b>".(substr_count($row[CONTENT],";")-1)." Dinge sind hier verstaut</b></p>";
                        } 
                        
            }
        }
        
        if(1){
            if(isset($_POST[detail]) && $_POST[detail]=="TRUE"){
                if($row[PERCENT]>0){
                echo "<p class=detailsinlist><b>$row[PERCENT]</b> Prozent</p>";
                        } 
                        
            }
        }
        
        if(1){
            if(isset($_POST[detail]) && $_POST[detail]=="TRUE"){
                if($row[DESIRED]!=0){
                        echo "<p class=detailsinlist><b>$row[ACTUAL]</b> von <b>$row[DESIRED]</b> gelagert</p>";
                        } 
                        
            }
        }
        
      if(1){
            if(isset($_POST[detail]) && $_POST[detail]=="TRUE"){
                        $query="SELECT COUNT(IID) AS TOTAL FROM `kuume_actions` WHERE IID=$row[IID] AND TEXT LIKE '%verliehen%' AND TIME >= ".date(Y);
                        $temp2=mysqli_query($conn, $query);
                                    $row2 = mysqli_fetch_array($temp2);
                                     if( $row2[TOTAL]>0){
                                         echo "<p class=detailsinlist> $row2[TOTAL] Mal verliehen dieses Jahr ";
                                        echo "</p>";   
                                     }
  
                     }
      }
        
        if(1){
            if(isset($_POST[detail]) && $_POST[detail]=="TRUE"){
                
                    if(checkthis(24)){
                        $query="SELECT * FROM `kuume_comments` WHERE IID=$row[IID] AND VISABLE=1 ORDER BY DATETIME DESC LIMIT 1";
                        $temp2=mysqli_query($conn, $query);
                             while ($row2 = mysqli_fetch_array($temp2)) {
                                  if($row2[VISABLE]==1){
                                     echo "<p class=detailsinlist><b>".getUser($conn,$row2[UID])."</b> <i>($row2[DATETIME])</i>: ".stripslashes($row2[COMMENT]);
                                     echo "</p>";   
                                    }

                            }
                     }
            }
           
        }           
        } 
echo "</div>";
?>
</div>
</div>

<iframe id="thatframeyo" name="thatframeyo" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true" src="cockpit.php">  
</iframe>