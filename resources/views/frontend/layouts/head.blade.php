<!-- Meta Tag -->
@yield('meta')
<!-- Title Tag  -->
<title>@yield('title')</title>
<!-- App favicon -->
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!--Swiper slider css-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<!-- Bootstrap Css -->
<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
<!-- Icons Css -->
<link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
<!-- App Css-->
<link href="{{ asset('assets/css/app.min.css?v=6.1') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/style.css?v=1.13') }}" rel="stylesheet" type="text/css">
<!-- Link to CSS file for screens -->
<link rel="stylesheet" href="{{ asset('css/navbar.css?v=2.7') }}">
<!-- custom Css-->
<link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css">
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/f.png') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link href="{{ asset('css/new.css?v=2') }}" rel="stylesheet" type="text/css">
<style>
    * {
        font-family: "Poppins", sans-serif !important;
    }

    /* Rating */
    .rating_box {
        display: inline-flex;
    }

    .star-rating {
        font-size: 0;
        padding-left: 10px;
        padding-right: 10px;
    }

    .star-rating__wrap {
        display: inline-block;
        font-size: 1rem;
    }

    .star-rating__wrap:after {
        content: "";
        display: table;
        clear: both;
    }

    .star-rating__ico {
        float: right;
        padding-left: 2px;
        cursor: pointer;
        color: #F7941D;
        font-size: 16px;
        margin-top: 5px;
    }

    .star-rating__ico:last-child {
        padding-left: 0;
    }

    .star-rating__ico:hover:before,
    .star-rating__ico:hover~.star-rating__ico:before,
    .star-rating__input:checked~.star-rating__ico:before {
        content: "\F005";
    }

    .blink {
        animation: blinker 1s step-start infinite;
    }

    @keyframes blinker {
        50% {
            opacity: 0;
        }
    }

    .carousel-inner .carousel-item {
        transition: -webkit-transform 2s ease;
        transition: transform 2s ease;
        transition: transform 2s ease, -webkit-transform 2s ease;
    }

    .zoom-img {
        width: 300px;
        height: 300px;
        overflow: hidden;
    }

    .zoom-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all .3s ease;
    }

    .zoom-img img:hover {
        transform: scale(1.2);
    }

    * {
        box-sizing: border-box;
    }

    .img-zoom-container {
        position: relative;
    }

    .img-zoom-lens {
        position: absolute;
        border: 1px solid #d4d4d4;
        /*set the size of the lens:*/
        width: 40px;
        height: 40px;
    }

    .img-zoom-result {
        border: 1px solid #d4d4d4;
        /*set the size of the result div:*/
        width: 300px;
        height: 300px;
    }

    .bg-primary1 {
        background-color: #e1cb78;
    }

    .nav-success .nav-link.active {
        color: #fff;
        background-color: #e1cb78;
    }

    #regForm {
        background-color: #ffffff;
        margin: 100px auto;
        padding: 40px;
        width: 70%;
        min-width: 300px;
    }

    /* Style the input fields */
    input {
        padding: 10px;
        width: 100%;
        font-size: 17px;
        font-family: Raleway;
        border: 1px solid #aaaaaa;
    }

    /* Mark input boxes that gets an error on validation: */
    input.invalid {
        background-color: #ffdddd;
    }

    /* Hide all steps by default: */
    .tab {
        display: none;
    }

    /* Make circles that indicate the steps of the form: */
    .step {
        height: 15px;
        width: 15px;
        margin: 0 2px;
        background-color: #bbbbbb;
        border: none;
        border-radius: 50%;
        display: inline-block;
        opacity: 0.5;
    }

    /* Mark the active step: */
    .step.active {
        opacity: 1;
    }

    /* Mark the steps that are finished and valid: */
    .step.finish {
        background-color: #04AA6D;
    }

    .breadcrumb {
        margin-top: 3rem !important;
    }

    .auth-page-wrapper {
        padding: 142px 0 80px;
    }

    /* here is css for accunt page  */

    /* Container styling to place elements in a row */
    .edit-container {
        display: flex;
        align-items: center;
        /* Vertically align the button and input */
    }

    /* Adjust the spacing between the input and button */
    .edit-container .edit-name {
        margin-right: 10px;
        /* Space between input and button */
    }

    /* Optional: Make input smaller if needed */
    .edit-container .edit-name {
        width: auto;
        /* Adjust width as needed */
    }

    #searchrecords {
        display: none;
    }
</style>
