var users = <? php echo json_encode($User); ?>;

// Sort the users array by created_at date
users.sort(function(a, b) {
    return new Date(a.created_at) - new Date(b.created_at);
});

// Prepare data for the user chart
var dataByDate = {};

users.forEach(function(user) {
    var createdAt = user.created_at.split(' ')[0]; // Extracting date part from created_at
    if (dataByDate[createdAt]) {
        dataByDate[createdAt]++;
    } else {
        dataByDate[createdAt] = 1;
    }
});

var labels = Object.keys(dataByDate);
var data = Object.values(dataByDate);

var userCtx = document.getElementById('userChart').getContext('2d');
var userChart = new Chart(userCtx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Nombre d\'utilisateurs',
            data: data,
            backgroundColor: 'rgba(0, 123, 255, 0.5)'
        }]
    },
    options: {
        maintainAspectRatio: false, // Prevent chart from maintaining aspect ratio
        scales: {
            y: {
                beginAtZero: true, // Start y-axis at zero
                maxTicksLimit: 5, // Limit the number of y-axis ticks
                precision: 0 // Set y-axis tick precision to whole numbers
            }
        }
    }
});
