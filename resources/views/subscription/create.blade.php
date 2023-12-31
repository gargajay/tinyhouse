@extends('layouts.guest')
@section('page_style')
<style>
    .alert.parsley {
        margin-top: 5px;
        margin-bottom: 0px;
        padding: 10px 15px 10px 15px;
    }

    .check .alert {
        margin-top: 20px;
    }

    .credit-card-box .panel-title {
        display: inline;
        font-weight: bold;
    }

    .credit-card-box .display-td {
        display: table-cell;
        vertical-align: middle;
        width: 100%;
    }

    .credit-card-box .display-tr {
        display: table-row;
    }
</style>
@endsection
@section('content')

<div id="bodyWrapper" class="flex-grow-1">
    <div class="post_house_page pb-5">
        <div class="container_md py-17">
            <nav aria-label="breadcrumb" class="mt-0 pb-4 mt-lg-5 pb-lg-5">
                <ol class="breadcrumb p-0 bg-transparent">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Post</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Payment</li>
                </ol>
            </nav>
            <div class="post_house_inner">
                @php

                $expirationDate = \Carbon\Carbon::parse($car->expiry_date);
                // Get today's date
                $today = \Carbon\Carbon::now();

                // Compare the dates
                @endphp

                @if($today->gt($expirationDate))


                <div class="card">
                    <div class="card-header">
                        Your tiny home is currently saved in draft mode and is not visible to users. Please make a payment to have it appear in the search list. Please choose subscription plan below.
                    </div>
                    <br>
                    <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif

                        <form action="{{ url('order-post') }}" method="post" >
                            @csrf

                            <input type="hidden" name="car_id" value="{{$car->id}}">
                            <!-- <input type="hidden" name="plan" value="basic"> -->

                            <div class="form-group">
                                <label for="">Have a promo code ?</label>
                                <input type="text" name="promo_code"  class="form-control" value="" placeholder="Promo code" required>
                            </div>

                            <button type="submit" class="btn btn-primary" >Submit</button>

                        </form>
                    </div>
                    <br>
                    <div class="card-body">
                        <form action="{{ url('order-post') }}" method="post" id="payment-form">
                            @csrf

                            <input type="hidden" name="car_id" value="{{$car->id}}">
                            <!-- <input type="hidden" name="plan" value="basic"> -->


                        

                            <div class="form-group">
                                <label for="">Choose Product with Pricing</label>
                                <select name="plan" id="product" class="form-control">
                                    @foreach($products as $product)
                                    <optgroup label="{{$product['name']}}">
                                        @foreach($product['prices'] as $price)
                                        <option value="{{$price['price']}}">
                                            {{$price['amount']}} {{$price['currency']}}
                                        </option>
                                        @endforeach
                                    </optgroup>
                                    @endforeach
                                </select>
                            </div>



                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" name="name" id="card-holder-name" class="form-control" value="" placeholder="Name on the card">
                            </div>


                            <div class="form-group">
                                <label for="card-element">Credit or Debit Card:</label>
                                <div id="card-element" class="form-control">
                                    <!-- A Stripe Element will be inserted here. -->
                                </div>
                            </div>

                            <!-- Used to display form errors. -->
                            <div id="card-errors" role="alert"></div>



                            <button type="submit" class="btn btn-primary" id="card-button" data-secret="{{ $intent->client_secret }}">Purchase</button>

                        </form>
                    </div>
                </div>

                @else
                <div class="card">
                    <div class="card-body">
                        Your current plan will be exipres on {{$car->expiry_date}}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>




    @endsection








    @section('page_script')
    <script>
        window.ParsleyConfig = {
            errorsWrapper: '<div></div>',
            errorTemplate: '<div class="alert alert-danger parsley" role="alert"></div>',
            errorClass: 'has-error',
            successClass: 'has-success'
        };
    </script>



    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ env('STRIPE_KEY') }}')

        const elements = stripe.elements()
        const cardElement = elements.create('card', {
            hidePostalCode: true // Hide the postal code field
        });

        cardElement.mount('#card-element')

        const form = document.getElementById('payment-form')
        const cardBtn = document.getElementById('card-button')
        const cardHolderName = document.getElementById('card-holder-name')

        form.addEventListener('submit', async (e) => {
            e.preventDefault()

            cardBtn.disabled = true;
            const {
                setupIntent,
                error
            } = await stripe.confirmCardSetup(
                cardBtn.dataset.secret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: {
                            name: cardHolderName.value
                        }
                    }
                }
            )

            if (error) {
                cardBtn.disable = false
            } else {
                let token = document.createElement('input')
                token.setAttribute('type', 'hidden')
                token.setAttribute('name', 'token')
                token.setAttribute('value', setupIntent.payment_method)
                form.appendChild(token)
                form.submit();
            }
        })
    </script>

    @endsection