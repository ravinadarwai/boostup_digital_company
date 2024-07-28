<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Now</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-img-top {
            object-fit: cover;
            height: 10rem;
            width: 15rem;
        }
        .image-container {
            display: flex;
            justify-content: center;
            padding-left: 2rem;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-5">Shop Vegetables</h1>
        <div class="row">
            @foreach ($vegetables as $vegetable)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="image-container">
                        <img src="{{ asset('public/images/' . $vegetable->image) }}" class="card-img-top" alt="{{ $vegetable->name }}">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $vegetable->name }}</h5>
                        <p class="card-text">${{ $vegetable->price }}</p>
                        <a href="{{ route('checkout', ['id' => $vegetable->id]) }}" class="btn btn-primary">Buy Now</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</body>

</html>
