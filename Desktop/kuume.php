<?php


include_once '../func.inc.php';
checkordie();

if($_POST[time]=="TEST"){
    $_POST[egal]="TRUE";
}


include 'balken.php';


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
        if(checkthis(26)){
            echo "<input type=checkbox name=bestellt value=TRUE";
            if($_POST[bestellt]==TRUE){
                echo " checked";
            }
            echo "> Nachbestellung<br>";
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
            Filter:  <input type="submit" value="Aktualisieren">
        </td>
        
    </tr>
</table>
   
    </form>

</div>
<div id="query">
<?php

$conn=connect();

$buildingquery ="SELECT * FROM `kuume_inventory` WHERE";

include 'build-query.php';

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
        echo"<p class=item><img src=img/".drawstatus($row[STATUS])." class=klein title='".$status[$row[STATUS]]."'><span class=itemtitle> ";
                if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM  `kuume_comments` WHERE IID=$row[IID] AND VISABLE=1"))>0 AND checkthis(24)){
                echo "<img class=klein src=img/comment.png title=Kommentar>";
            }
        if(mysqli_num_rows(mysqli_query($conn, "SELECT LABEL  FROM  `kuume_inventory` WHERE LABEL>0 AND IID=$row[IID]"))>0){
                echo "<img class=klein src=img/".draw_label($row[IID])." title=Favorit>";
            }    
         if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM  `kuume_inventory` WHERE IID=$row[IID] AND DATETIME_LEND <= NOW() - INTERVAL $hours HOUR AND DATETIME_LEND!=0"))>0){
                echo "<img class=klein src=img/time.png title=Verliehen!>";
            } 
       // echo " <b>$row[IID]</b>";
        if($row[LENDER]!="0"){
            echo "<b>[$row[LENDER]] </b>";
        }
        echo ($row[NAME])."</span> </span>";
        echo "<span class=itemlinks>";
        echo "<a href=comments.php?IID=$row[IID] target='thatframeyo' ><img class=klein src=img/edit.png title=Detailansicht></a>";
         if(checkthis(3)){
            echo "<a href=edit.php?IID=$row[IID] target='thatframeyo' ><img class=klein src=img/edit_all.png title=Editieren></a>";
        }
        if(checkthis(4)){
            echo "<a href=log.php?IID=$row[IID] target='thatframeyo' ><img class=klein src=img/log.png title=Log></a>";
        }
        if(checkthis(0)){
            echo "<a href=delete.php?IID=$row[IID] target='thatframeyo' ><img class=klein src=img/delete.png title=Entfernen></a>";
        }
        if(($_POST[not]=="TRUE" && $_POST[date]==0) && ($row[STATUS]==0 OR $row[STATUS]==1)){
            echo "<a href=scanone.php?IID=$row[IID] target='thatframeyo' ><img class=klein src=img/checkmark.png title=Checken></a>";
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


<?php
echo '<form action="omini.php" method="POST" target="thatframeyo" id="quick" name=Omni>Suche: <input required type="text" size="10" name="omniIID"><input type="submit" value="Go!">   ';

if(checkthis(20)){
    echo 'Scan<input type="checkbox" name="Check" value="1">';
}

if(checkthis(24)){
    echo 'inkl. Kommentare<input type="checkbox" name="kom" value="1">';
}
    echo '</form>';

?>
<iframe id="thatframeyo" name="thatframeyo" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true" src="cockpit.php">  
</iframe>