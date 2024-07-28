<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-5">Payment Confirmation</h1>
        <div class="alert alert-success">
            Your payment was successful!
        </div>
        <a href="{{ route('shop') }}" class="btn btn-primary">Back to Shop</a>
    </div>
</body>

</html>
