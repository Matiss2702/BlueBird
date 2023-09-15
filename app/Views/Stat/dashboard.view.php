<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php $this->partial('back/topbar'); ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Number of users</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($User)?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Article number</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($Post)?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6 col-lg-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">User (date)</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="userChart"  style="height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Message (category)</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="messageChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Movie (duration) </h6>
                        </div>
                        <div class="card-body">
                            <canvas id="movieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->partial('back/footer'); ?>
</div>

<script>
    var users = <?php echo json_encode($User); ?>;
    var messages = <?php echo json_encode($Message); ?>;
    var movies = <?php echo json_encode($Movie); ?>;

    users.sort(function(a, b) {
        return new Date(a.created_at) - new Date(b.created_at);
    });

    var dataByDate = {};

    users.forEach(function(user) {
        var createdAt = user.created_at.split(' ')[0];
        if (dataByDate[createdAt]) {
            dataByDate[createdAt]++;
        } else {
            dataByDate[createdAt] = 1;
        }
    });

    var userLabels = Object.keys(dataByDate);
    var userData = Object.values(dataByDate);

    var messageCounts = {};

    messages.forEach(function(message) {
        var description = message.description;
        if (messageCounts[description]) {
            messageCounts[description]++;
        } else {
            messageCounts[description] = 1;
        }
    });

    var messageLabels = Object.keys(messageCounts);
    var messageData = Object.values(messageCounts);

    movies.sort(function(a, b) {
        return a.duration - b.duration;
    });

    var movieLabels = movies.map(function(movie) {
        return movie.title;
    });
    var movieData = movies.map(function(movie) {
        return movie.duration;
    });

    var userCtx = document.getElementById('userChart').getContext('2d');
    var userChart = new Chart(userCtx, {
        type: 'line',
        data: {
            labels: userLabels,
            datasets: [{
                label: 'Nombre d\'utilisateurs',
                data: userData,
                backgroundColor: 'rgba(0, 123, 255, 0.5)'
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    maxTicksLimit: 5,
                    precision: 0
                }
            }
        }
    });

    var messageCtx = document.getElementById('messageChart').getContext('2d');
    var messageChart = new Chart(messageCtx, {
        type: 'doughnut',
        data: {
            labels: messageLabels,
            datasets: [{
                data: messageData,
                backgroundColor: ['rgba(0, 123, 255, 0.5)', 'rgba(255, 0, 0, 0.5)', 'rgba(0, 255, 0, 0.5)']
            }]
        },
        options: {
            maintainAspectRatio: false
        }
    });

    var movieCtx = document.getElementById('movieChart').getContext('2d');
    var movieChart = new Chart(movieCtx, {
        type: 'bar',
        data: {
            labels: movieLabels,
            datasets: [{
                label: 'Durée',
                data: movieData,
                backgroundColor: 'rgba(0, 123, 255, 0.5)'
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    maxTicksLimit: 5,
                    precision: 0
                }
            }
        }
    });
</script>
