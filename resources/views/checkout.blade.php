<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://js.stripe.com/v3/"></script>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-5">Checkout</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <img src="{{ asset('public/images/' . $vegetable->image) }}" class="card-img-top" alt="{{ $vegetable->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $vegetable->name }}</h5>
                        <p class="card-text">₹{{ $vegetable->price }}</p>
                        <form action="{{ route('handle.payment') }}" method="POST" id="payment-form">
                            @csrf
                            <input type="hidden" name="vegetable_id" value="{{ $vegetable->id }}">
                            <input type="hidden" name="amount" value="{{ $vegetable->price }}">
                            <div class="form-group mb-3">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="card-element">Credit or debit card</label>
                                <div id="card-element" class="form-control">
                                    <!-- A Stripe Element will be inserted here. -->
                                </div>
                                <div id="card-errors" role="alert"></div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Pay ₹{{ $vegetable->price }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var stripe = Stripe('{{ env('STRIPE_KEY') }}');
            var elements = stripe.elements();

            var style = {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };

            var card = elements.create('card', {style: style});
            card.mount('#card-element');

            card.addEventListener('change', function(event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });

            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                stripe.createToken(card).then(function(result) {
                    if (result.error) {
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                    } else {
                        stripeTokenHandler(result.token);
                    }
                });
            });

            function stripeTokenHandler(token) {
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);
                form.submit();
            }
        });
    </script>
</body>

</html>
