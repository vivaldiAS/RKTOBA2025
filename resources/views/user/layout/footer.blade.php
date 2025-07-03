<footer class="footer footer-2">
    <div class="icon-boxes-container">
        <div class="container">
            <!-- <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <div class="icon-box icon-box-side">
                        <span class="icon-box-icon text-dark">
                            <i class="icon-rocket"></i>
                        </span>
                        <div class="icon-box-content">
                            <h3 class="icon-box-title">Free Shipping</h3>
                            <p>orders $50 or more</p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="icon-box icon-box-side">
                        <span class="icon-box-icon text-dark">
                            <i class="icon-rotate-left"></i>
                        </span>

                        <div class="icon-box-content">
                            <h3 class="icon-box-title">Free Returns</h3>
                            <p>within 30 days</p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="icon-box icon-box-side">
                        <span class="icon-box-icon text-dark">
                            <i class="icon-info-circle"></i>
                        </span>

                        <div class="icon-box-content">
                            <h3 class="icon-box-title">Get 20% Off 1 Item</h3>
                            <p>When you sign up</p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="icon-box icon-box-side">
                        <span class="icon-box-icon text-dark">
                            <i class="icon-life-ring"></i>
                        </span>

                        <div class="icon-box-content">
                            <h3 class="icon-box-title">We Support</h3>
                            <p>24/7 amazing services</p>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>

    <!-- <div class="footer-newsletter bg-image" style="background-image: url({{ URL::asset('asset/Molla/assets/images/backgrounds/bg-2.jpg') }})">
        <div class="container">
            <div class="heading text-center">
                <h3 class="title">Get The Latest Deals</h3>
                <p class="title-desc">and receive <span>$20 coupon</span> for first shopping</p>
            </div>

            <div class="row">
                <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                    <form action="#">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Enter your Email Address" aria-label="Email Adress" aria-describedby="newsletter-btn" required>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" id="newsletter-btn"><span>Subscribe</span><i class="icon-long-arrow-right"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> -->

    <div class="footer-middle">
        <div class="container">
            <div class="row">
                <div class="col-sm-2 col-lg-1">
                    <div class="widget widget-about">
                        <img src="{{ URL::asset('asset/Image/logo_rkt.png') }}" class="footer-logo" alt="Footer Logo RK TOba" width="75">
                        <p>

                        </p>
                        
                        <!-- <div class="widget-about-info">
                            <div class="row">
                                <div class="col-sm-6 col-md-4">
                                    <span class="widget-about-title">Got Question? Call us 24/7</span>
                                    <a href="tel:123456789">+0123 456 789</a>
                                </div>
                                <div class="col-sm-6 col-md-8">
                                    <span class="widget-about-title">Payment Method</span>
                                    <figure class="footer-payments">
                                        <img src="{{ URL::asset('asset/Molla/assets/images/payments.png') }}" alt="Payment methods" width="272" height="20">
                                    </figure>
                                </div>
                            </div>
                        </div> -->

                    </div>
                </div>
                
                <div class="col-sm-2 col-lg-1">
                    <div class="widget widget-about">
                        <img src="{{ URL::asset('asset/Image/logo_pemkab_toba.png') }}" class="footer-logo" alt="Footer Logo Pemkab Toba" width="75">
                    </div>
                </div>
                        
                <div class="col-sm-2 col-lg-1">
                    <div class="widget widget-about">
                        <img src="{{ URL::asset('asset/Image/logo_itdel.png') }}" class="footer-logo" alt="Footer Logo IT DEL" width="75">
                    </div>
                </div>

                <div class="col-sm-4 col-lg-1"></div>

                <!-- <div class="col-sm-12 col-lg-3">
                    <div class="widget">
                        <a href="http://tobajourney.com/"  target="_blank">
                            <h4 class="widget-title">WISATA DANAU TOBA</h4>
                        </a>

                        <ul class="widget-list">
                            <li><a href="http://tobajourney.com/"  target="_blank">Partner Terbaik Berwisata di Danau Toba</a></li>
                        </ul>
                    </div>
                </div> -->

                <div class="col-sm-12 col-lg-3">
                    <div class="widget">
                        <a>
                            <h4 class="widget-title">Produk</h4>
                        </a>

                        <ul class="widget-list">
                            <li>
                                <a href="{{ url('/produk/kategori[1]') }}">Makanan</a> | 
                                <a href="{{ url('/produk/kategori[7]') }}">Minuman</a> | 
                                <a href="{{ url('/produk/kategori[2]') }}">Pakaian</a>
                                <br><a href="{{ url('/produk') }}"><i>Lainnya...</i></a>
                            </li>
                        </ul>
                    </div>
                </div>

                @if(Session::get('toko'))

                @else
                <div class="col-sm-4 col-lg-2">
                    <div class="widget">
                        <h4 class="widget-title">HELP</h4>

                        <ul class="widget-list">
                            <li><a href="../panduan_penggunaan">Panduan Penggunaan</a></li>
                        </ul>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <!-- <p class="footer-copyright">Copyright © 2019 Molla Store. All Rights Reserved.</p>
            <ul class="footer-menu">
                <li><a href="#">Terms Of Use</a></li>
                <li><a href="#">Privacy Policy</a></li>
            </ul> -->

            <!-- <div class="social-icons social-icons-color">
                <span class="social-label">Sosial Media</span>
                <a href="#" class="social-icon social-facebook" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                <a href="#" class="social-icon social-twitter" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                <a href="#" class="social-icon social-instagram" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                <a href="#" class="social-icon social-youtube" title="Youtube" target="_blank"><i class="icon-youtube"></i></a>
                <a href="#" class="social-icon social-pinterest" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
            </div> -->
        </div>
    </div>
</footer>