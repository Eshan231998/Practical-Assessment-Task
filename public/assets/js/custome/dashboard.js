// Chart.js analytics

document.addEventListener('DOMContentLoaded', function() {
    if (window.Chart) {
        // Age Group Chart - Enhanced
        var ageGroupCtx = document.getElementById('ageGroupChart');
        if (ageGroupCtx) {
            new Chart(ageGroupCtx, {
                type: 'bar',
                data: {
                    labels: window.ageGroupLabels || [],
                    datasets: [{
                        label: 'Persons',
                        data: window.ageGroupData || [],
                        backgroundColor: [
                            '#6a89cc', // soft blue
                            '#38ada9', // teal
                            '#b8e994'  // light green
                        ],
                        borderRadius: 8,
                        borderSkipped: false,
                        borderWidth: 2,
                        borderColor: '#fff',
                    }]
                },
                options: {
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.parsed.y + ' persons';
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: 'Distribution by Age Group',
                            font: { size: 16, weight: 'bold' }
                        },
                        datalabels: {
                            anchor: 'end',
                            align: 'top',
                            color: '#333',
                            font: { weight: 'bold' },
                            formatter: Math.round
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        }
                    }
                }
            });
        }
        // Birth Month Chart - Enhanced
        var birthMonthCtx = document.getElementById('birthMonthChart');
        if (birthMonthCtx) {
            new Chart(birthMonthCtx, {
                type: 'line',
                data: {
                    labels: window.birthMonthLabels || [],
                    datasets: [{
                        label: 'Persons',
                        data: window.birthMonthData || [],
                        fill: true,
                        backgroundColor: 'rgba(255, 193, 7, 0.2)',
                        borderColor: 'rgba(255, 87, 34, 0.9)',
                        pointBackgroundColor: 'rgba(255, 87, 34, 1)',
                        pointRadius: 5,
                        tension: 0.4
                    }]
                },
                options: {
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.parsed.y + ' persons';
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: 'Births by Month',
                            font: { size: 16, weight: 'bold' }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        }
                    }
                }
            });
        }
        // Religion Chart - Enhanced
        var religionCtx = document.getElementById('religionChart');
        if (religionCtx) {
            new Chart(religionCtx, {
                type: 'doughnut',
                data: {
                    labels: window.religionLabels || [],
                    datasets: [{
                        data: window.religionData || [],
                        backgroundColor: [
                            '#007bff', '#28a745', '#dc3545', '#ffc107', '#6f42c1', '#fd7e14', '#20c997', '#343a40',
                            '#00bcd4', '#ff9800', '#8bc34a', '#e91e63'
                        ],
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    plugins: {
                        legend: { position: 'bottom', labels: { color: '#333', font: { weight: 'bold' } } },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    var label = context.label || '';
                                    var value = context.parsed || 0;
                                    var total = context.chart._metasets[0].total || 1;
                                    var percent = ((value / total) * 100).toFixed(1);
                                    return ' ' + label + ': ' + value + ' (' + percent + '%)';
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: 'Distribution by Religion',
                            font: { size: 16, weight: 'bold' }
                        }
                    }
                }
            });
        }
    }
});


setInterval(displayclock, 500);

function displayclock() {
    var time = new Date();
    var hrs = time.getHours();
    var min = time.getMinutes();
    var sec = time.getSeconds();
    var en = 'AM';
    if (hrs >= 12) {
        en = 'PM';
    }
    if (hrs > 12) {
        hrs = hrs - 12;
    }
    if (hrs == 0) {
        hrs = 12;
    }
    if (hrs < 10) {
        hrs = '0' + hrs;
    }
    if (min < 10) {
        min = '0' + min;
    }
    if (sec < 10) {
        sec = '0' + sec;
    }
    var timeEl = document.getElementById("time");
    if (timeEl) {
        timeEl.innerHTML = hrs + ':' + min + ':' + sec + ' ' + en;
    }
}

var myDate = new Date();
var hrs = myDate.getHours();
var greet;
if (hrs < 12)
    greet = 'Good Morning';
else if (hrs >= 12 && hrs <= 17)
    greet = 'Good Afternoon';
else if (hrs >= 17 && hrs <= 24)
    greet = 'Good Evening';

var greetEl = document.getElementById('greetings');
if (greetEl) {
    greetEl.innerHTML = greet;
}

if (window.jQuery) {
    $('tr[data-href]').on("click", function() {
        document.location = $(this).data('href');
    });
}