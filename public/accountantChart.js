fetch('statistic.php').then((res)=>res.json()).then(response=>{
    var i = 1;
    while(i<=12){ // thêm giá trị 0 vào các tháng không có giá trị 
        let vitri1 = Object.keys(response[0]).find(function(element){
            return element ==i;
          });
        if(vitri1 == undefined)
        {
            response[0][i] = 0;
        }

        let vitri2 = Object.keys(response[1]).find(function(element){
            return element ==i;
          });
        if(vitri2 == undefined)
        {
            response[1][i] = 0;
        }
        let vitri3 = Object.keys(response[2]).find(function(element){
            return element ==i;
          });
        if(vitri3 == undefined)
        {
            response[2][i] = 0;
        }
        i++;
    }
   

    const ctxEletricityUsage = document.getElementById('chart--usage-celetricity').getContext('2d');
    const myChartEletricityUsage = new Chart(ctxEletricityUsage, {
        type: 'line',
        data: {
            labels: ['1','2','3','4','5','6','7','8','9','10','11', '12'],
            datasets: [{
                label: 'Eletricity',
                data: [response[1]["1"], response[1]["2"],response[1]["3"],response[1]["4"],response[1]["5"],response[1]["6"],response[1]["7"],response[1]["8"],response[1]["9"],response[1]["10"],response[1]["11"],response[1]["12"]],
                backgroundColor: [
                    'rgba(255, 99, 132, 1.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const ctxWaterUsage = document.getElementById('chart--usage-water').getContext('2d');
    const myChartWaterUsage = new Chart(ctxWaterUsage, {
        type: 'line',
        data: {
            labels: ['1','2','3','4','5','6','7','8','9','10','11', '12'],
            datasets: [{
                label: 'Water',
                data: [response[0]["1"], response[0]["2"],response[0]["3"],response[0]["4"],response[0]["5"],response[0]["6"],response[0]["7"],response[0]["8"],response[0]["9"],response[0]["10"],response[0]["11"],response[0]["12"]],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });


    const cxtchartinoutput = document.getElementById('chart-inoutput').getContext('2d');
    const myChartinoutput = new Chart(cxtchartinoutput, {
        type: 'line',
        data: {
            labels: ['1','2','3','4','5','6','7','8','9','10','11', '12'],
            datasets: [{
                label: 'Money',
                data: [response[2]["1"], response[2]["2"],response[2]["3"],response[2]["4"],response[2]["5"],response[2]["6"],response[2]["7"],response[2]["8"],response[2]["9"],response[2]["10"],response[2]["11"],response[2]["12"]],
                backgroundColor: [
                    'rgba(255, 99, 132, 1.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    document.getElementById("status").innerHTML=response[3];
    document.getElementById("increaseratio").innerHTML=response[4];
    document.getElementById("nextMonthEstimate").innerHTML=response[5];
}).catch(error => console.log(error));

