function SetTimeHeader(){
    var toDay = new Date();
    var timeString = "";
    var  preHour = 0;
    var getMinute =  toDay.getMinutes();
    if(toDay.getHours()> 12)
    {
        preHour = toDay.getHours() - 12;
        timeString += preHour.toString() +":" +  getMinute.toString() + "  PM";
    }
    else {
        timeString += toDay.getHours().toString() + ":" +  getMinute.toString() + "  AM";
    }
    var dayOfWeek = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
    timeString += "   " + dayOfWeek[toDay.getDay()].toString()+ "     " + toDay.getDate().toString() + "/"
    + toDay.getMonth().toString() + "/" + toDay.getFullYear().toString();
    
    var headerTime = document.getElementsByClassName('headerTime');
    headerTime[0].innerHTML = timeString;
}






fetch('server.php').then((res)=>res.json()).then(response=>{
    // js for chart circle water
    const ctxWater = document.getElementById('myChartWater').getContext('2d');
    const myChartWater = new Chart(ctxWater, {
        type: 'pie',
        data: {
            labels: ['Recent Month', 'Total'],
            datasets: [{
                label: '# of Votes',
                data: [response[1],response[0]],
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

    // js for chart circle electricity

    const ctxElectricity = document.getElementById('myChartElectricity').getContext('2d');
    const myChartElectricity = new Chart(ctxElectricity, {
        type: 'pie',
        data: {
            labels: ['Recent Month', 'Total'],
            datasets: [{
                label: '# of Votes',
                data: [response[3],response[2]],
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

    //Revenue chart
    const ctxRevenue = document.getElementById('myChartRevenue').getContext('2d');
    const myChartRevenue = new Chart(ctxRevenue, {
        type: 'line',
        data: {
            labels: ['1','2','3','4','5','6','7','8','9','10','11', '12'],
            datasets: [{
                label: 'Revenue',
                data: [response[4],response[5],response[6],response[7],response[8],response[9],response[10],response[11],response[12],response[13],response[14],response[15]],
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


}).catch(error => console.log(error));