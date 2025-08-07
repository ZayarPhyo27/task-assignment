 <!DOCTYPE html>
<html lang="en">

<head>
       <title>Stylish - Shoes Online Store HTML Template</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="author" content="TemplatesJungle">
  <meta name="keywords" content="Online Store">
  <meta name="description" content="Stylish - Shoes Online Store HTML Template">

  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendor.css') }}">
    <!-- Custom Css -->
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" />

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,900;1,900&family=Source+Sans+Pro:wght@400;600;700;900&display=swap"
    rel="stylesheet">
</head>
<body>
    <div class=" container-fluid my-5 ">
        <div class="row justify-content-center ">
            <div class="col-xl-10">
                <div class="card shadow-lg ">
                    <div class="row p-2 mt-3 justify-content-between mx-sm-2">
                        <div class="col">
                            <p class="text-muted space mb-0 shop"> Shop No.78618K</p>
                            <p class="text-muted space mb-0 shop">Store Locator</p>
                        </div>
                        <div class="col">
                            <div class="row justify-content-start ">
                                <div class="col">
                                    <img class="irc_mi img-fluid cursor-pointer " src="{{ asset('assets/img/logo.jpg') }}"  width="70" height="70" >
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-auto">
                            <img class="irc_mi img-fluid bell" src="https://i.imgur.com/uSHMClk.jpg" width="30" height="30"  >
                        </div> --}}
                    </div>
                    <div class="row  mx-auto justify-content-center text-center">
                        <div class="col-12 mt-3 ">
                            <nav aria-label="breadcrumb" class="second ">
                                <ol class="breadcrumb indigo lighten-6 first  ">
                                    <li class="breadcrumb-item font-weight-bold "><a class="black-text text-uppercase " href="/website"><span class="mr-md-3 mr-1">BACK TO SHOP</span></a><i class="fa fa-angle-double-right " aria-hidden="true"></i></li>
                                    <li class="breadcrumb-item font-weight-bold"><a class="black-text text-uppercase active-2" href="#"><span class="mr-md-3 mr-1">CHECKOUT</span></a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>


                {{-- form --}}

                    <div class="row justify-content-around">
                        <div class="col-md-5">
                            <div class="card border-0">
                                <div class="card-header pb-0">
                                    <h2 class="card-title space ">Checkout</h2>
                                    <p class="card-text text-muted mt-4  space">SHIPPING DETAILS</p>
                                    <hr class="my-0">
                                </div>
                                <div class="card-body">
                                    <div class="row justify-content-between">
                                        <div class="col-auto mt-0"><p><b>Stylish Shoes - Yangon, Myanmar </b></p></div>
                                        <div class="col-auto"><p><b>stylish@gmail.com</b> </p></div>
                                    </div>
                                    <div class="row mt-4">
                                         <form action="{{ url('orders') }}" enctype="multipart/form-data" method="POST" id="checkoutForm">
                                        @csrf
                                        <div class="col"><p class="text-muted mb-2">Delivery Info Detail</p><hr class="mt-0"></div>
                                    </div>
                                            <div class="form-group">
                                                <label for="NAME" class="small text-muted mb-1">NAME </label>
                                                <input type="text" class="form-control form-control-sm" name="customer_name" id="customer_name" aria-describedby="helpId" placeholder="Enter your name">
                                            </div>
                                            <div class="form-group">
                                                <label for="Address" class="small text-muted mb-1">Address</label>
                                                <input type="text" class="form-control form-control-sm" name="address" id="address" aria-describedby="helpId" placeholder="Enter your address">
                                            </div>
                                            <div class="form-group">
                                                <label for="Phone" class="small text-muted mb-1">Phone Number</label>
                                                <input type="text" class="form-control form-control-sm" name="phone_number" id="phone_number" aria-describedby="helpId" placeholder="Enter your phone number">
                                            </div>
                                            <div class="row mb-md-5">
                                                <div class="form-group">
                                                <label for="paymentMethod" class="small text-muted mb-1">PAYMENT METHOD</label>
                                                <select class="form-control form-control-sm" id="paymentMethod" name="payment_method" required>
                                                    <option value="">-- Select Payment Method --</option>
                                                    <option value="cod">Cash On Delivery</option>
                                                    <option value="mobile_banking">Mobile Banking</option>
                                                    <option value="kbz_pay">KBZ Pay</option>
                                                    <option value="aya_pay">AYA Pay</option>
                                                </select>
                                            </div>
                                         <!-- Hidden field for cart data -->
                                        <input type="hidden" name="cart_data" id="cartData">

                                        <!-- Total Amount -->
                                        <input type="hidden" name="total" id="totalAmount">

                                        <button type="submit" class="btn btn-success mt-5">Place Order</button>


                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-5">
                            <div class="card border-0 ">
                                <div class="card-header card-2">
                                    <p class="card-text text-muted mt-md-4  mb-2 space">YOUR ORDER </p>
                                    <hr class="my-2">
                                </div>
                                {{-- <div class="card-body pt-0">
                                    <div class="row  justify-content-between">
                                        <div class="col-auto col-md-7">
                                            <div class="media flex-column flex-sm-row">
                                                <img class=" img-fluid" src="https://i.imgur.com/6oHix28.jpg" width="62" height="62">
                                                <div class="media-body  my-auto">
                                                    <div class="row ">
                                                        <div class="col-auto"><p class="mb-0"><b>EC-GO Bag Standard</b></p><small class="text-muted">1 Week Subscription</small></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class=" pl-0 flex-sm-col col-auto  my-auto "><p><b>179 $</b></p></div>
                                    </div>
                                    <hr class="my-2">
                                    <div class="row ">
                                        <div class="col">
                                            <div class="row justify-content-between">
                                                <div class="col-4"><p class="mb-1"><b>Subtotal</b></p></div>
                                                <div class="flex-sm-col col-auto"><p class="mb-1"><b>179 $</b></p></div>
                                            </div>
                                            <div class="row justify-content-between">
                                                <div class="col"><p class="mb-1"><b>Shipping</b></p></div>
                                                <div class="flex-sm-col col-auto"><p class="mb-1"><b>0 $</b></p></div>
                                            </div>
                                            <div class="row justify-content-between">
                                                <div class="col-4"><p ><b>Total</b></p></div>
                                                <div class="flex-sm-col col-auto"><p  class="mb-1"><b>537 $</b></p> </div>
                                            </div><hr class="my-0">
                                        </div>
                                    </div>
                                    <div class="row mb-5 mt-4 ">
                                        <div class="col-md-7 col-lg-6 mx-auto"><button type="button" class="btn btn-block btn-outline-primary btn-lg">ADD GIFT CODE</button></div>
                                    </div>
                                </div> --}}


                                <div class="card-body pt-0">
                                    <div class="checkout-cart-items"></div>  <!-- Dynamic cart items here -->
                                    <hr class="my-2">
                                    <div class="row">
                                        <div class="col">
                                            <div class="row justify-content-between">
                                                <div class="col-4"><p class="mb-1"><b>Subtotal</b></p></div>
                                                <div class="flex-sm-col col-auto"><p class="mb-1"><b class="checkout-subtotal">0 $</b></p></div>
                                            </div>
                                             <div class="row justify-content-between">
                                                <div class="col"><p class="mb-1"><b>Delivery Fees</b></p></div>
                                                <div class="flex-sm-col col-auto"><p class="mb-1"><b>20 $</b></p></div>
                                            </div>
                                            <div class="row justify-content-between">
                                                <div class="col-4"><p><b>Total</b></p></div>
                                                <div class="flex-sm-col col-auto"><p class="mb-1"><b class="checkout-total">0 $</b></p></div>
                                            </div><hr class="my-0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                          </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    const container = document.querySelector('.checkout-cart-items');
    const subtotalElement = document.querySelector('.checkout-subtotal');
    const totalElement = document.querySelector('.checkout-total');

    container.innerHTML = ''; // Clear any static content

    if (cartItems.length === 0) {
        container.innerHTML = '<p>Your cart is empty.</p>';
        subtotalElement.textContent = '0 $';
        totalElement.textContent = '0 $';
        return;
    }

    let subtotal = 0;

    cartItems.forEach(item => {
        let itemTotal = item.price * item.quantity;
        subtotal += itemTotal;

        container.innerHTML += `
            <div class="row justify-content-between mb-2">
                <div class="col-auto col-md-7">
                    <div class="media flex-column flex-sm-row">
                        <img class="img-fluid" src="${item.image}" width="62" height="62">
                        <div class="media-body my-auto">
                            <div class="row">
                                <div class="col-auto">
                                    <p class="mb-0"><b>${item.name}</b></p>
                                    <small class="text-muted">Quantity: ${item.quantity}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pl-0 flex-sm-col col-auto my-auto"><p><b>${itemTotal} $</b></p></div>
            </div>
            <hr class="my-2">
        `;
    });

    subtotalElement.textContent = `${subtotal} $`;
    totalElement.textContent = `${subtotal + 20} $` ; // Add shipping if needed


    // cart data add
        document.getElementById('checkoutForm').addEventListener('submit', function (e) {
        // Get cart data from localStorage
        const cartItems = localStorage.getItem('cartItems');
        document.getElementById('cartData').value = cartItems;

        // Calculate total
        let total = 0;
        if (cartItems) {
            JSON.parse(cartItems).forEach(item => {
                total += item.price * item.quantity;
            });
        }
        document.getElementById('totalAmount').value = total;
    });
});


</script>
</body>
</html>
    <script src="{{ asset('assets/js/jquery-1.11.0.min.js')}}"></scrip>
    <script src="{{ asset('assets/js/plugins.js')}}"></scr>
    <script src="{{ asset('assets/js/script.js')}}"></script>

