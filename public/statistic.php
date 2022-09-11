<?php
 $myData = mysqli_connect('localhost','root','','chungcu');
 $i =1;
 $electricity = 0;
 $water = 0;
 $money = 0;
 $monthWater = array();
 $monthEletricity = array();
 $monthMoney = array();
$date = getdate();
$presentMonth = $date['mon'];
$presentMonthMoney = 0;
$previousMonth = $presentMonth -1;
$previousMonthMoney = 0;

while($i<=12)
{
    $hoaDonDienNuocMonthQuery ="SELECT * FROM hoadon, thongtinhoadon WHERE hoadon.id=thongtinhoadon.linkId  AND MONTH(hoadon.createdDate)= $i";
    $sql = mysqli_query($myData,$hoaDonDienNuocMonthQuery);
    if($sql->num_rows !=0)
    {
        $water =0;
        $electricity =0;
            while($row = $sql->fetch_assoc())
            {
                $electricity+= $row['eletricity'];
                $water += $row['water'];
                $money += $row['water'] + $row['eletricity'] + $row['internet'];
            }
            $monthWater["$i"] = $water;
            $monthEletricity["$i"] = $electricity;
            $monthMoney["$i"] = $money;
            if($i == $previousMonth)
            {
                $previousMonthMoney = $money;
            }
            if($i == $presentMonth)
            {
                $presentMonthMoney = $money;
            }
    }
    else
    {
        echo $myData->error;
    }

    $i++;
 }
if($presentMonthMoney > $previousMonthMoney)
{
    $status = "Good";
}
else{
    $status = "Bad";
}
$increaseRatio = ROUND($previousMonthMoney/$presentMonthMoney,2);
$nextMontEstimate = $increaseRatio + 0.3;

 $a = array(0 => $monthWater,
            1 => $monthEletricity,
            2=>$monthMoney,
            3=>$status,
            4=>$increaseRatio,
            5=>$nextMontEstimate

);

exit(json_encode($a));

 ?>