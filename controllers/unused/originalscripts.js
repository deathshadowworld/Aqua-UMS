const monitorwindow = document.getElementById('monitorwindow');
const adminwindow = document.getElementById('adminwindow');
const loginwindow = document.getElementById('loginwindow');
const registerwindow = document.getElementById('registerwindow');
const profilewindow = document.getElementById('profilewindow');
const passwordwindow = document.getElementById('passwordwindow');

function generateRandomData() {
    // Replace with your own logic to generate data
    const data = [];
    for (let i = 0; i < 10; i++) {
        data.push(Math.random() * 100);
    }
    return data;
}

    // Create time series charts
const charts = [];
const colors = ['#00bfff', '#4682b4', '#4169e1', '#0000cd', '#191970', '#483d8b', '#6a5acd'];
for (let i = 1; i <= 7; i++) {
    const chartId = `chart${i}`;
    const chartElement = document.getElementById(chartId);
    const chart = new Chart(chartElement, {
        type: 'line',
        data: {
            labels: ['1','2','3','4','5','6','7','8'],
            datasets: [{
                label:'Fish Tank',
                data: generateRandomData(),
                backgroundColor: '#00bfff33',
                borderColor: '#00b2ff',
                borderWidth: 2,
                fill: true
            },{
                label:'Biofilter',
                data: generateRandomData(),
                backgroundColor: '#f700ff2c',
                borderColor: '#f700ff',
                borderWidth: 2,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true
                }
            },
            scales: {
                x: {
                    max: 120,
                    min: 1,
                    stepSize: 1,
                    
                },
                y: {
                    max: 100,
                    min: 0,
                    stepSize: 10
                }
            },
                
        }
    });
    charts.push(chart);
}

setInterval(() => {
    for (let i = 0; i < charts.length; i++) {
        const chart = charts[i];
        const dataset = chart.data.datasets[0];
        const dataset2 = chart.data.datasets[1];
        

        const newDataPoint = generateRandomData();
        const newDataPoint2 = generateRandomData();
        chart.data.labels.push(new Date().toLocaleTimeString());
        chart.data.datasets[0].data.push(newDataPoint);
        chart.data.datasets[1].data.push(newDataPoint2);

        // Limit the chart data to 7 data points
        if (chart.data.labels.length > 7) {
            chart.data.labels.shift();
            chart.data.datasets[0].data.shift();
        }

        // Update the chart with new data
        chart.update();
    }
}, 5000);



    // Data for the bar chart
var data = {
    labels: ["Depth (cm)"], // Label for the bar
    datasets: [{
        data: [250], // Value for the bar (ranging from 0 to 300)
        backgroundColor: '#00bfff33', // Bar color
        borderColor: '#00b2ff', // Bar border color
        borderWidth: 2 // Bar border width
    }]
};

    // Chart options
var options = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
                legend: {
                    display: false,
                }
            },
    scales: {
        y: {
            beginAtZero: true,
            max: 300 // Maximum value on the y-axis
        }
    }
};

        // Create a bar chart
var ctx = document.getElementById('chartbar1').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: data,
    options: options
});

// Data for the bar chart
var data = {
    labels: ["Depth (cm)"], // Label for the bar
    datasets: [{
        data: [220], // Value for the bar (ranging from 0 to 300)
        backgroundColor: '#f700ff2c', // Bar color
        borderColor: '#f700ff', // Bar border color
        borderWidth: 2 // Bar border width
    }]
};

// Chart options
var options = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
                legend: {
                    display: false,
                }
            },
    scales: {
        y: {
            beginAtZero: true,
            max: 300 // Maximum value on the y-axis
        }
    }
};


// Create a bar chart
var ctx = document.getElementById('chartbar2').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: data,
    options: options
});

    // Dummy data for the multiple pie charts
var data = {
    labels: ["Water Quality Percentage", ""], // Labels for the pie charts
    datasets: [{
        data: [90,10], // Values for the first pie chart (percentages)
        backgroundColor: ["#00bfff33", "#aaaaaa00"], // Colors for the first pie chart slices
        borderWidth: 1, // Border width of the first pie chart slices
        borderColor: "#00b2ff" // Border color of the first pie chart slices
    }, {
        data: [95,5], // Values for the second pie chart (percentages)
        backgroundColor: ["#f700ff2c", "#aaaaaa00"], // Colors for the second pie chart slices
        borderWidth: 1, // Border width of the second pie chart slices
        borderColor: "#f700ff" // Border color of the second pie chart slices
    }]
};

// Chart options
var options = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
            legend: {
                display: false,
            }
        },
};


// Create a doughnut chart
var ctx = document.getElementById('mainChart').getContext('2d');
var donutChart = new Chart(ctx, {
    type: 'doughnut',
    data: data,
    options: options
});

function updateBarChart(){
    const d1 = donutChart.data.datasets[0];
    const d2 = donutChart.data.datasets[1];
    const x1 = Math.floor(Math.random() * 100);
    const y1 = 100 - x1;
    const x2 = Math.floor(Math.random() * 100);
    const y2 = 100 - x2;
    d1.data = [x1,y1];
    console.log(donutChart.data.dataset);
    d2.data = [x2,y2];
    donutChart.update();
    document.getElementById('mainright').innerHTML = `Fish Tank</br><b style="font-size: 40px;">${x2}%</b>`;
    document.getElementById('mainleft').innerHTML = `Biofilter</br><b style="font-size: 40px;">${x1}%</b>`;

};

setInterval(updateBarChart, 5000)

    // Select all div elements with class name "my-div"
const divs = document.querySelectorAll('.widget');

// Define the animation properties
const animation = anime({
    targets: divs, // Elements to animate
    opacity: 1, // Target opacity to animate to
    translateY: ['100%', '0%'], // Animation for translation on Y-axis
    duration: 1000, // Animation duration in milliseconds
    delay: anime.stagger(100), // Delay between each animation (staggered effect)
    easing: 'easeInOutQuad' // Easing function for the animation
});

const btnavi = document.querySelectorAll('.navicon');

        // Define the animation properties
const navianimation = anime({
    targets: btnavi, // Elements to animate
    opacity: 1, // Target opacity to animate to
    translateY: ['100%', '0%'], // Animation for translation on Y-axis
    duration: 1000, // Animation duration in milliseconds
    delay: anime.stagger(100), // Delay between each animation (staggered effect)
    easing: 'easeInOutQuad' // Easing function for the animation
});
var modal = document.getElementById("modalwindow");
var trigger = document.getElementById("sadiv");
trigger.onclick = function() {
    modal.style.display = "block";
    }
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
var btlogout = document.getElementById("logoutbutton");
var btadmin = document.getElementById("adminbutton");
var btprofile = document.getElementById("profilebutton");
var bthome = document.getElementById("homebutton");
var btregister = document.getElementById("registerbutton");
var btreset = document.getElementById("changepass");
var btlogin = document.getElementById("loginsubmit");
        
btlogout.onmouseover = function(event){
    toggleDivs();

}
function toggleDivs() {
    if (bthome.style.opacity === '0') {
        anime({
        targets: ['.navicon'],
        opacity: 1,
        translateX: '0px',
        duration: 500,
        easing: 'easeOutExpo',
        delay: anime.stagger(100)
        });
    } else {
        anime({
        targets: ['.navicon'],
        opacity: 0,
        translateX: '50px',
        duration: 500,
        easing: 'easeOutExpo',
        delay: anime.stagger(100)
        });
    }
}
function nopacity(){
    bthome.style.opacity = 0;
    btprofile.style.opacity = 0;
    btadmin.style.opacity = 0;
}
window.onload = function() {
    setTimeout(() => {  toggleDivs(); }, 3000);
    checkNav();
};

btadmin.addEventListener('click', ()=>{
    monitorwindow.style.display = 'none';
    adminwindow.style.display = 'block';
    loginwindow.style.display = 'none';
    registerwindow.style.display = 'none';
    profilewindow.style.display = 'none';
    passwordwindow.style.display = 'none';
    checkNav();
})

btprofile.addEventListener('click', ()=>{
    monitorwindow.style.display = 'none';
    adminwindow.style.display = 'none';
    loginwindow.style.display = 'none';
    registerwindow.style.display = 'none';
    profilewindow.style.display = 'block';
    passwordwindow.style.display = 'none';
    checkNav();
})

bthome.addEventListener('click', ()=>{
    monitorwindow.style.display = 'block';
    adminwindow.style.display = 'none';
    loginwindow.style.display = 'none';
    registerwindow.style.display = 'none';
    profilewindow.style.display = 'none';
    passwordwindow.style.display = 'none';
    checkNav();
})

btlogout.addEventListener('click', ()=>{
    monitorwindow.style.display = 'none';
    adminwindow.style.display = 'none';
    loginwindow.style.display = 'block';
    registerwindow.style.display = 'none';
    profilewindow.style.display = 'none';
    passwordwindow.style.display = 'none';
    checkNav();
})

btregister.addEventListener('click', ()=>{
    monitorwindow.style.display = 'none';
    adminwindow.style.display = 'none';
    loginwindow.style.display = 'none';
    registerwindow.style.display = 'block';
    profilewindow.style.display = 'none';
    passwordwindow.style.display = 'none';
    checkNav();
})

btreset.addEventListener('click', ()=>{
    monitorwindow.style.display = 'none';
    adminwindow.style.display = 'none';
    loginwindow.style.display = 'none';
    registerwindow.style.display = 'none';
    profilewindow.style.display = 'none';
    passwordwindow.style.display = 'block';
    checkNav();
})

btlogin.addEventListener('click', ()=>{
    monitorwindow.style.display = 'block';
    adminwindow.style.display = 'none';
    loginwindow.style.display = 'none';
    registerwindow.style.display = 'none';
    profilewindow.style.display = 'none';
    passwordwindow.style.display = 'none';
    checkNav();
})
const navbt = document.getElementById("navbuttons");

function checkNav(){
    if (loginwindow.style.display == "block" || profilewindow.style.display == "block" || registerwindow.style.display == "block" || passwordwindow.style.display == "block"){
        navbt.style.display = 'none';
        console.log("this is executed");
    } else {
        navbt.style.display = 'block';
        console.log("this is too");
    }
}


