<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4>Welcome to the Dashboard</h4>
            </div>
            <div class="card-body">
                <h1>Welcome to the Dashboard</h1>
                <p><strong>Name:</strong> {{ $name }}</p>
                <p><strong>Email:</strong> {{ $email }}</p>
                <p><strong>Role:</strong> {{ $role }}</p>
            </div>
        </div>
    </div>

</body>
</html>
