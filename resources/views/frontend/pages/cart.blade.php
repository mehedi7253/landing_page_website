<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cart</title>
    <meta content="{{ siteSetting()->meta_description }}" name="description">
    <meta content="{{ siteSetting()->keywords }}" name="keywords">
    <!-- Favicons -->
    <link href="{{ siteSetting()->favicon }}" rel="icon">
    <link href="{{ siteSetting()->logo }}" rel="apple-touch-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/animate.css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="https://unpkg.com/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,700;1,400&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

</head>
<body>
    <section id="topbar" class="d-flex align-items-center">
        <div class="container d-flex justify-content-center justify-content-md-between">
           <div class="contact-info d-flex align-items-center">
              <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:{{ siteSetting()->email }}">{{ siteSetting()->email }}</a></i>
              <i class="bi bi-phone d-flex align-items-center ms-4"><span>{{ siteSetting()->phone }}</span></i>
           </div>
           <div class="social-links d-none d-md-flex align-items-center">
              <a href="{{ siteSetting()->twitter ?? '' }}" class="twitter"><i class="bi bi-twitter"></i></a>
              <a href="{{ siteSetting()->facebook ?? '' }}"  target="_blank" class="facebook"><i class="bi bi-facebook"></i></a>
              <a href="{{ siteSetting()->linkedin ?? '' }}" class="linkedin"><i class="bi bi-linkedin"></i></a>
           </div>
        </div>
     </section>
     <!-- ======= Header ======= -->
    <header id="header" class="d-flex align-items-center">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="logo">
                <h1>
                    <a href="index.html"> <img src="{{ siteSetting()->logo }}"></a>
                </h1>
            </div>
            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="active" href="/">Home</a></li>
                    <li><a href="/">About Us</a></li>
                    <li><a href="/">Shop Now</a></li>
                    <li><a href="/">Services</a></li>
                    <li><a href="/">Clients</a></li>
                    <li><a href="{{route('cart.item')}}"><i class="bi bi-basket" style="font-size: 25px"></i><sup class="text-info" style="font-size: 15px">{{ cartData() }}</sup></a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav>
        </div>
    </header>
    <!-- ======= Hero Section ======= -->
    <main id="main" class="product py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mx-auto py-5">
                    <label class="p-2">Shooping Cart</label>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cart as $i=>$item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>
                                            <img src="{{ $item['image'] }}" style="height: 50px; width: 50px" class="img-thumbnail">
                                        </td>
                                        <td>
                                            <a href="{{ route('product.details', $item['url']) }}" class="text-decoration-none text-dark">{{ $item['name'] }}</a>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <button class="decrease btn btn-sm btn-info" data-id="{{ $item['productId'] }}">-</button>
                                                <span class="quantity col-3 text-center border" data-id="{{ $item['productId'] }}">{{ $item['quantity'] }}</span>
                                                <button class="increase btn btn-sm btn-info" data-id="{{ $item['productId'] }}">+</button>
                                                {{-- <input class="sub_total" data-id="{{ $item['productId'] }}"  value="{{ number_format($item['quantity'] * $item['price'],2) }}"> --}}
                                            </div>
                                        </td>
                                        <td>
                                            <span id="price">{{ number_format($item['quantity'] * $item['price'],2) }}</span>
                                            {{-- {{ number_format($item['quantity'] * $item['price'],2) }} --}}
                                        </td>
                                        <td>
                                            <form action="{{ route('cart.remove', $item['productId'])}}" method="POST" >
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger" type="submit" onclick="return confirm('Are you sure to delete !!');"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end">Total</td>
                                    <td colspan="1" class="text-center">{{ number_format(totalPrice(),2) }}</td>
                                    <td colspan="1" class="text-center"></td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="text-end">
                                        <a href="{{ route('orders.index')}}" class="btn btn-success">Checkout</a>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>




    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 footer-links">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#about">About us</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#products">prodcuts</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#services">Services</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#client">Clients</a></li>
                    </ul>
                    </div>
                    <div class="col-lg-3 col-md-6 footer-links">
                    <h4>Our Services</h4>
                    <ul>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">Toner, Cartridge, Ribbon Supplies.</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">CCTV Solution</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">PA System</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">PC Servicing.</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">Total IT Support.</a></li>
                    </ul>
                    </div>
                    <div class="col-lg-3 col-md-6 footer-contact">
                    <h4>Contact Us</h4>
                    <p>
                        {{ siteSetting()->address }}
                        <br>
                        <strong>Phone:</strong> {{ siteSetting()->phone }},<br/>
                        {{ siteSetting()->additional_phone }} <br>
                        <strong>Email:</strong> {{ siteSetting()->email }}<br>
                    </p>
                    </div>
                    <div class="col-lg-3 col-md-6 footer-info">
                    <h3>About Arshiya</h3>
                    <p style="text-align: justify;">{{ siteSetting()->meta_description }}</p>
                    <div class="social-links mt-3">
                        <a href="{{ siteSetting()->facebook ?? '' }}" class="facebook"><i class="bx bxl-facebook"></i></a>
                        <a href="{{ siteSetting()->twitter ?? '' }}" class="twitter"><i class="bx bxl-twitter"></i></a>
                        <a href="{{ siteSetting()->linkedin ?? '' }}" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong><span>Arshiya Technology </span></strong>. All Rights Reserved
            </div>
        </div>
    </footer>
    <!-- End Footer -->
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>
        @if (Session::has('message'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('message') }}");
        @endif


        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.increase').click(function() {
                var id = $(this).data('id');
                var quantity = parseInt($(`.quantity[data-id="${id}"]`).text());
                quantity++;
                updateQuantity(id, quantity);
            });

            $('.decrease').click(function() {
                var id = $(this).data('id');
                var quantity = parseInt($(`.quantity[data-id="${id}"]`).text());
                if (quantity > 0) {
                    quantity--;
                    decreaseQuantity(id, quantity);
                }
            });

            function updateQuantity(id, quantity) {
                $.ajax({
                    url: '/cart/increase',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        quantity: quantity,
                    },
                    success: function(response) {
                        if (response.success) {
                            $(`.quantity[data-id="${id}"]`).text(response.quantity);
                            // $('#price').text(response.price);
                            //reload 1 second later
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    }
                });
            }

            function decreaseQuantity(id, quantity) {
                $.ajax({
                    url: '/cart/decrease',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        quantity: quantity,
                    },
                    success: function(response) {
                        if (response.success) {
                            $(`.quantity[data-id="${id}"]`).text(response.quantity);
                            // $('#price').text(response.price);
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    }
                });
            }

        });
    </script>
</body>
</html>
