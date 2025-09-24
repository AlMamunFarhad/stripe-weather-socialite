<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

</head>

<body>

    <div class="container justify-content-center align-items-center">
        <div class="col-md-4 card p-4 mt-5">
            <h2>💳 Stripe (Test Mode)</h2>
            <form action="/stripe" method="POST">
                @csrf
                <input type="text" id="card-holder-name" placeholder="Cardholder Name" class="form-control mb-3">
                <!-- Stripe Card Element -->
                <div id="card-element" class="form-control mb-3"></div>
                <!-- Submit Button -->
                <button type="button" id="card-button" data-secret="{{ $clientSecret }}" class="btn btn-primary">Pay Now</button>
            </form>
        </div>
</div>



<!-- Include Stripe.js -->
<script src="https://js.stripe.com/v3/"></script>

<script>
    const stripe = Stripe("{{ config('services.stripe.key') }}");
    const elements = stripe.elements();
    const cardElement = elements.create('card');

    cardElement.mount('#card-element');

    const cardHolderName = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('card-button');
    const clientSecret = cardButton.dataset.secret;

    cardButton.addEventListener('click', async () => {
        const { paymentIntent, error } = await stripe.confirmCardPayment(
            clientSecret, {
                payment_method: {
                    card: cardElement,
                    billing_details: {
                        name: cardHolderName.value
                    }
                }
            }
        );

        if (error) {
            alert(error.message);
        } else if (paymentIntent.status === 'succeeded') {
            alert('✅ Payment Successful!');
        }
    });
</script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>


</body>

</html>
