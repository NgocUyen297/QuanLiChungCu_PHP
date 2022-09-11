<?php

    $totalElectricity = 0;           
    $totalWater = 0;           
    $Water = 0;        
    $Electricity = 0;        
    $demo = '';   
    $myData = mysqli_connect('localhost','root','','chungcu');
    $myQuery ="SELECT * FROM hoadon, hoadondiennuoc WHERE hoadon.id=hoadondiennuoc.linkId";
    $sql = mysqli_query($myData,$myQuery);
    // total electricity and total water
    if($sql->num_rows !=0)
    {
            while($row = $sql->fetch_assoc())
            {
                $totalElectricity+= $row['electricity'];
                $totalWater += $row['water'];
            }
    }
    else{
        echo $myData->error;
    }

    $date = getdate();
    $hoaDonDienNuocInRecentMonthQuery ="SELECT * FROM hoadon, hoadondiennuoc WHERE hoadon.id=hoadondiennuoc.linkId AND MONTH(hoadon.createdDate)=MONTH(NOW())";
    $resultRecentMonth = mysqli_query($myData,$hoaDonDienNuocInRecentMonthQuery);
    //  electricity and water in present month
    if($resultRecentMonth->num_rows !=0)
    {
            while($rowRecentMonth = $resultRecentMonth->fetch_assoc())
            {
                    $Water += $rowRecentMonth['water'];
                    $Electricity += $rowRecentMonth['electricity'];
            }
    }
    else{
        echo $myData->error;
    }

    $WaterPercent = $Water/$totalWater;
    $ElectricityPercent = $Electricity/$totalElectricity;
    $WateRest = 1 - $WaterPercent;
    $ElectricityRest = 1 - $ElectricityPercent;
    
    // Revenue chart 
        //thang1
    $revenue1 = 0;
    $hoadonT1Query ="SELECT * FROM hoadon WHERE MONTH(hoadon.createdDate)=1 AND hoadon.paid=1";
    $hoadonT1 = mysqli_query($myData,$hoadonT1Query);
 
    if($hoadonT1->num_rows !=0)
    {
            while($row1 = $hoadonT1->fetch_assoc())
            {
                $revenue1 += $row1['moneyIn'];
            }
    }
    else{
        echo $myData->error;
    }

    //thang2
    $revenue2 = 0;
    $hoadonT2Query ="SELECT * FROM hoadon WHERE MONTH(hoadon.createdDate)=2 AND hoadon.paid=1";
    $hoadonT2 = mysqli_query($myData,$hoadonT2Query);
 
    if($hoadonT2->num_rows !=0)
    {
            while($row2 = $hoadonT2->fetch_assoc())
            {
                $revenue2 += $row2['moneyIn'];
            }
    }
    else{
        echo $myData->error;
    }
     //thang3
     $revenue3 = 0;
     $hoadonT3Query ="SELECT * FROM hoadon WHERE MONTH(hoadon.createdDate)=3 AND hoadon.paid=1";
     $hoadonT3 = mysqli_query($myData,$hoadonT3Query);
  
     if($hoadonT3->num_rows !=0)
     {
             while($row3 = $hoadonT3->fetch_assoc())
             {
                 $revenue3 += $row3['moneyIn'];
             }
     }
     else{
         echo $myData->error;
     }
      //thang4
    $revenue4 = 0;
    $hoadonT4Query ="SELECT * FROM hoadon WHERE MONTH(hoadon.createdDate)=4 AND hoadon.paid=1";
    $hoadonT4 = mysqli_query($myData,$hoadonT4Query);
 
    if($hoadonT4->num_rows !=0)
    {
            while($row4 = $hoadonT4->fetch_assoc())
            {
                $revenue4 += $row4['moneyIn'];
            }
    }
    else{
        echo $myData->error;
    }
     //thang5
     $revenue5 = 0;
     $hoadonT5Query ="SELECT * FROM hoadon WHERE MONTH(hoadon.createdDate)=5 AND hoadon.paid=1";
     $hoadonT5 = mysqli_query($myData,$hoadonT5Query);
  
     if($hoadonT5->num_rows !=0)
     {
             while($row5 = $hoadonT5->fetch_assoc())
             {
                 $revenue5 += $row5['moneyIn'];
             }
     }
     else{
         echo $myData->error;
     }
      //thang6
    $revenue6 = 0;
    $hoadonT6Query ="SELECT * FROM hoadon WHERE MONTH(hoadon.createdDate)=6 AND hoadon.paid=1";
    $hoadonT6 = mysqli_query($myData,$hoadonT6Query);
 
    if($hoadonT6->num_rows !=0)
    {
            while($row6 = $hoadonT6->fetch_assoc())
            {
                $revenue6 += $row6['moneyIn'];
            }
    }
    else{
        echo $myData->error;
    }
     //thang7
     $revenue7 = 0;
     $hoadonT7Query ="SELECT * FROM hoadon WHERE MONTH(hoadon.createdDate)=7 AND hoadon.paid=1";
     $hoadonT7 = mysqli_query($myData,$hoadonT7Query);
  
     if($hoadonT7->num_rows !=0)
     {
             while($row7 = $hoadonT7->fetch_assoc())
             {
                 $revenue7 += $row7['moneyIn'];
             }
     }
     else{
         echo $myData->error;
     }
      //thang8
    $revenue8 = 0;
    $hoadonT8Query ="SELECT * FROM hoadon WHERE MONTH(hoadon.createdDate)=8 AND hoadon.paid=1";
    $hoadonT8 = mysqli_query($myData,$hoadonT8Query);
 
    if($hoadonT8->num_rows !=0)
    {
            while($row8 = $hoadonT8->fetch_assoc())
            {
                $revenue8 += $row8['moneyIn'];
            }
    }
    else{
        echo $myData->error;
    }
     //thang9
     $revenue9 = 0;
     $hoadonT9Query ="SELECT * FROM hoadon WHERE MONTH(hoadon.createdDate)=9 AND hoadon.paid=1";
     $hoadonT9 = mysqli_query($myData,$hoadonT9Query);
  
     if($hoadonT9->num_rows !=0)
     {
             while($row9 = $hoadonT9->fetch_assoc())
             {
                 $revenue9 += $row9['moneyIn'];
             }
     }
     else{
         echo $myData->error;
     }
      //thang10
    $revenue10 = 0;
    $hoadonT10Query ="SELECT * FROM hoadon WHERE MONTH(hoadon.createdDate)=10 AND hoadon.paid=1";
    $hoadonT10 = mysqli_query($myData,$hoadonT10Query);
 
    if($hoadonT10->num_rows !=0)
    {
            while($row10 = $hoadonT10->fetch_assoc())
            {
                $revenue10 += $row10['moneyIn'];
            }
    }
    else{
        echo $myData->error;
    }
     //thang11
     $revenue11 = 0;
     $hoadonT11Query ="SELECT * FROM hoadon WHERE MONTH(hoadon.createdDate)=11 AND hoadon.paid=1";
     $hoadonT11 = mysqli_query($myData,$hoadonT11Query);
  
     if($hoadonT11->num_rows !=0)
     {
             while($row11 = $hoadonT11->fetch_assoc())
             {
                 $revenue11 += $row11['moneyIn'];
             }
     }
     else{
         echo $myData->error;
     }
      //thang12
    $revenue12 = 0;
    $hoadonT12Query ="SELECT * FROM hoadon WHERE MONTH(hoadon.createdDate)=12 AND hoadon.paid=1";
    $hoadonT12 = mysqli_query($myData,$hoadonT12Query);
 
    if($hoadonT12->num_rows !=0)
    {
            while($row12 = $hoadonT12->fetch_assoc())
            {
                $revenue12 += $row12['moneyIn'];
            }
    }
    else{
        echo $myData->error;
    }
    //result tra ve js
    $a = array(0 => $WateRest,
               1 => $WaterPercent,
                2=>$ElectricityRest,
                3=>$ElectricityPercent,
                4=>$revenue1,
                5=>$revenue2,
                6=>$revenue3,
                7=>$revenue4,
                8=>$revenue5,
                9=>$revenue6,
                10=>$revenue7,
                11=>$revenue8,
                12=>$revenue9,
                13=>$revenue10,
                14=>$revenue11,
                15=>$revenue12
            );

    // $result = mysqli_fetch_all($sql, MYSQLI_ASSOC);

    exit(json_encode($a));
?>