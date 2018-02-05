<?php


/* 
 Like a rock,
like a planet,
like a fucking atom bomb,
I'll remain unperturbed by the joy and the madness
that I encounter everywhere I turn
I've seen it all before
in books and magazines
like a twitch before dying
like a pornographic sea
there's a flower behind the window
there's an ugly laughing man
like a hummingbird in silence
like the blood on my door
it's the generator
oh yeah, oh yeah, like the blood on my door
wash me clean and I will run
until I reach the shore
I've known it all along
like the bone under my skin
like actors in a photograph
like paper in the wind
there's a hammer by the window
there's a knife on the floor
like turbines in darkness
like the blood on my door
it's the generator
 */

$start=time();
include '../../../func.inc.php';


kuume_session();

if(!isset($_POST['IamPissedThatIExist'])){
    die("Fehler.");
}


if($_POST['IamPissedThatIExist']>10){
    die("Max 10... Liess den Text OIDA!");
    header("Location https://www.youtube.com/watch?v=mR5h_EXYKA0");
}


$conn=connect();
require('fpdf181/fpdf.php');


$pdf = new FPDF('L','mm','A4');
$pdf->SetFont('Arial','B',12);
    
$anfang =$group_stickers[4][0];
$end = $group_stickers[4][1];

$counter=1;
$max=mysqli_real_escape_string($conn,$_POST['IamPissedThatIExist']);
$rotation=0;



while($counter<=$max){
    if(howmany((int) $anfang+$rotation*50,(int) $anfang+$rotation*50+50)==0){
        $pdf->AddPage();
        $row=0;
        $col=0;
        for($i=1;$i<51;$i++){
            $number=$anfang+$rotation*50+$i;
            $pdf->Image("https://".$_SERVER["SERVER_NAME"]."/Desktop/Uploads/Skripte/qrmaker.php?IID=$number", 8+$col*32, 5+$row*31, 25, 25, "GIF");
            $pdf->SetXY(8+$col*32, 5+$row*31+23);
            $pdf->Cell(25, 5, "#$number", 0, 0, "C");
            $col++;
            if($i%9==0){
                $col=0;
                $row++;
            }
        }
    $pdf->SetXY(8+6*32, 8+5*31);
    $string="Datum: ".date("m-d-h-i-s")."\nSeite: $counter\nSektor: [Sticker-$rotation]\nLaufzeit: ".(time()-$start)." Sekunden";
    $pdf->MultiCell(60, 6, $string,1,"R");
    $counter++;
    }
    $rotation++;
}
$counter--;
document($conn, $_SESSION[UID], 1,"Exportiert $counter Sektoren, Dauer ".(time()-$start)." Sekunden", 0, 0);
$pdf->Output();


?>