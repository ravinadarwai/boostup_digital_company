<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Vegetables</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center">Buy Vegetables</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success_message'))
                            <div class="alert alert-success">
                                {{ session('success_message') }}
                            </div>
                        @elseif(session('error_message'))
                            <div class="alert alert-danger">
                                {{ session('error_message') }}
                            </div>
                        @endif
                        <form action="{{ route('handle.payment') }}" method="post" id="payment-form">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <label for="vegetable" class="form-label">Select Vegetable</label>
                                <select name="vegetable" class="form-control" required>
                                    <option value="20">Carrot - 20 INR</option>
                                    <option value="30">Potato - 30 INR</option>
                                    <option value="50">Tomato - 50 INR</option>
                                    <option value="40">Onion - 40 INR</option>
                                    <option value="60">Spinach - 60 INR</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="card-element" class="form-label">Credit or Debit Card</label>
                                <div id="card-element" class="form-control"></div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Pay Now</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var stripe = Stripe('{{ config('services.stripe.key') }}');
        var elements = stripe.elements();
        var card = elements.create('card', {
            style: {
                base: {
                    iconColor: '#666EE8',
                    color: '#31325F',
                    lineHeight: '40px',
                    fontWeight: 300,
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSize: '18px',
                    '::placeholder': {
                        color: '#CFD7E0'
                    }
                }
            }
        });
        card.mount('#card-element');

        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    console.error(result.error.message);
                } else {
                    var hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'stripeToken');
                    hiddenInput.setAttribute('value', result.token.id);
                    form.appendChild(hiddenInput);
                    form.submit();
                }
            });
        });
    </script>
</body>
</html>
