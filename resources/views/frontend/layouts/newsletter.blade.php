<style>
    
    @media(max-width:350px)
    {
        .subs-btn{
            width: 35%;
            font-size: 10px;
            padding-left: 10px;
        }
    }
</style>

<section class="section mb-0">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-12">
                <div>
                    <p class="fs-15 text-uppercase fw-medium text-center "> <span class="fw-semibold "> 
                            Marmik</span>
                        Newsletter</p>
                    <h1 class="lh-base text-capitalize mb-3"></h1>
                    <form action="{{ route('subscribe') }}" method="post" class="newsletter-inner">
                        <div class="position-relative ecommerce-subscript">
                            @csrf
                            <input type="email" class="form-control rounded-pill " name="email"
                                placeholder="Enter your email">
                            <button type="submit" class="btn btn-dark rounded-pill subs-btn" style="top: 50%; transform: translate(-2px, -50%);">Subscribe Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end row-->
    </div>
    <!--end container-->
</section>
