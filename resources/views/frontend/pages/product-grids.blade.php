@extends('frontend.layouts.master')

@section('title', 'MARMIK || PRODUCT PAGE')

@section('main-content')

<section class="section mt-5">
    <div class="">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="text-center">

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb  justify-content-center mt-4" style="color:black !important">
                            <li class="breadcrumb-item"><a href="{{URL::to('/')}}">Home</a></li>
                            @if (isset($type))
                                <li class="breadcrumb-item"><a href="#">{{ $type }}</a></li>
                            @endif

                        </ol>
                    </nav>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </div>
</section>
<!-- <section class=" container d-flex justify-content-center image-hover overflow-hidden" style="">
    <img src="\assets\images\product_grid_picture.webp" class="img-fluid rounded-4 overflow-hidden product-page-img"
        style=""></img>
</section> -->

<div class="section" style="background-color: black;">
    <div class="container">
        <div id="col-3-layout">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row align-items-center mb-4">
                        <div class="col-md-auto mt-2">
                            <div class="search-box">
                                <input type="text" class="form-control rounded-pill" id="searchProductList"
                                    autocomplete="off" placeholder="Search Products...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="col-md mt-2">
                            <div class="d-flex gap-2 justify-content-md-end">
                                <div class="flex-shrink-0">
                                    <label for="sort-elem" class="col-form-label text-light ">Sort By:</label>
                                </div>
                                <div class="flex-shrink-0">
                                    <select class="form-select w-md rounded-pill" id="sort-elem">
                                        <option value="">All</option>
                                        <option value="low_to_high">Low to High</option>
                                        <option value="high_to_low">High to Low</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="alert alert-danger" id="searchrecords"></div>
            <p></p>

            <div class="row" id="product-grid-right">


            </div>
            <div class="row" id="pagination-element">
                <div class="col-lg-12">
                    <div
                        class="pagination-block pagination pagination-separated justify-content-center justify-content-sm-end mb-sm-0">
                        <div class="page-item rounded-pill">
                            <a href="javascript:void(0);" class="page-link " id="page-prev">Previous</a>
                        </div>
                        <span id="page-num" class="pagination rounded-pill"></span>
                        <div class="page-item">
                            <a href="javascript:void(0);" class="page-link" id="page-next">Next</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row d-none" id="search-result-elem">
                <div class="col-lg-12">
                    <div class="text-center py-5">
                        <div class="avatar-lg mx-auto mb-4">
                            <div class="avatar-title bg-primary-subtle text-primary rounded-circle fs-24">
                                <i class="bi bi-search"></i>
                            </div>
                        </div>

                        <h5 class="text">No matching records found</h5>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </div>
    </div><!--end container-->
</div>
@if (isset($summary))
    <section class="section pt-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    <div class="tab-content text-muted">
                        <div class="tab-pane active">
                            <p class="text-black fs-15">{!! $summary !!}</p>
                        </div>

                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
    </section>
@endif

@include('frontend.layouts.newsletter')

<script>
    
    var productListData = {!! $products !!}; // Use json_encode to safely handle the variable

    var prevButton = document.getElementById('page-prev');
    var nextButton = document.getElementById('page-next');
    var currentPage = 1;
    var itemsPerPage

    if (document.getElementById("col-3-layout")) {
        itemsPerPage = 12;
    } else {
        itemsPerPage = 9;
    }

    loadProductList(productListData, currentPage);
    paginationEvents();


    if (productListData && productListData.length > 0) {
        loadProductList(productListData, currentPage);
    } else {
        document.getElementById('searchrecords').style.display = "block";
        document.getElementById('searchrecords').innerHTML = "<p class='mb-0'>No Matching Records Found</p>";
    }

    // Function to load product list to display sorted products
    // function loadProductList(datas, page) {
    //     var productGridRight = document.getElementById("product-grid-right");
    //     productGridRight.innerHTML = ""; // Clear the current grid

    //     // Calculate pagination
    //     var pages = Math.ceil(datas.length / itemsPerPage);
    //     page = Math.max(1, Math.min(page, pages));

    //     // Loop through the products based on the current page
    //     for (var i = (page - 1) * itemsPerPage; i < Math.min(page * itemsPerPage, datas.length); i++) {
    //         var data = datas[i];
    //         // console.log(datas[i]);
    //         if (data && data.max_price_variant && (data.status === 'active' || typeof data.status === 'undefined')) {
    //             var url = "{{ route('product-detail', ['slug' => ':slug', 'id' => ':id']) }}";
    //             url = url.replace(':slug', data.slug).replace(':id', data.max_price_variant.id);

    //             var stock = data.max_price_variant.stock;
    //             // console.log(stock);
    //             var stockMessage = stock > 0 ? '' : '<span style="color:red;">Out of Stock</span>';

    //             var productGridRighthtml = `
    //             <div class="col-sm-12 col-xxl-3 col-lg-4 col-md-6 mb-3 col-xs-6">
    //                 <div class="card shadow-lg overflow-hidden element-item rounded-4 p-0 h-100 w-100">
    //                     <div class="gallery-product overflow-hidden">
    //                         <a href="${url}">
    //                             <img src="${data.photo.split(',')[0]}" alt="" class="img-fluid w-100 m-0">
    //                         </a>
    //                     </div>
    //                     <div class="card-body pb-0">
    //                         <a href="${url}">
    //                             <h6 class="fs-16 fw-500 mb-3 lh-base text-wrap">${data.title.substring(0,40)}${data.title.length>20?'...':''}</h6>
    //                         </a>
    //                         <div class="mt-3">
    //                             ${stockMessage} ₹ ${(data.max_price_variant.price - (data.max_price_variant.price * data.max_price_variant.discount / 100)).toFixed(2)}
                              
    //                             ${data.max_price_variant.discount > 0 ? `
    //                                 <span class="text-muted fs-12 text-decoration-line-through">
    //                                     <del>MRP ₹ ${data.max_price_variant.price}</del>
    //                                 </span>
    //                             ` : ''}
    //                         </div>
    //                     </div>
    //                 </div>
    //             </div>`;
                
    //             productGridRight.innerHTML += productGridRighthtml;
    //         }
    //     }

    //     // Handle pagination (you can expand this for next/prev controls)
    //     selectedPage();
    //     currentPage == 1 ? prevButton.parentNode.classList.add('disabled') : prevButton.parentNode.classList.remove('disabled');
    //     currentPage == pages ? nextButton.parentNode.classList.add('disabled') : nextButton.parentNode.classList.remove('disabled');
    // }

    function loadProductList(datas, page) {
        var pages = Math.ceil(datas.length / itemsPerPage);
        page = Math.max(1, Math.min(page, pages));

        var productGridRight = document.getElementById("product-grid-right");
        var col3Layout = document.getElementById("col-3-layout");
        if (productGridRight) {
            productGridRight.innerHTML = "";
            for (var i = (page - 1) * itemsPerPage; i < Math.min(page * itemsPerPage, datas.length); i++) {
                var data = datas[i];
                
                // console.log(data);
                // console.log(data.max_price_variant);
                if (data && data.max_price_variant) {
                    var url = "{{ route('product-detail', ['slug' => ':slug', 'id' => ':id']) }}"
                    url = url.replace(':slug', data.slug).replace(':id', data.max_price_variant.id);
                    var checkinput = data.wishList ? "active" : "";
                    var productLabel = data.arrival ?
                        '<p class="fs-11 fw-medium badge bg-primary py-2 px-3 product-label mb-0">Best Arrival</p>' :
                        "";
                    var num = 1;
                    var colorElem = getColorOrSizeElement(data, num, true);
                    var discount = data.discount;                    

                    var discount = data.max_price_variant.discount;
                    var afterDiscount = data.max_price_variant.price - (data.max_price_variant.price * discount / 100);
                    var afterDiscountElem = discount > 0 ? getAfterDiscountElement(data.max_price_variant,
                        afterDiscount,
                        true) :
                        getRegularPriceElement(data.max_price_variant, true);
                    var layout = col3Layout ? '<div class="col-sm-12 col-xxl-3 col-lg-4 col-md-6 mb-3 col-xs-6">' :
                        '<div class=" col-6 col-lg-4 col-md-6 mb-3 col-xs-6">';
                    var photos = data.photo != null ? data.photo.split(",") : '';

                    productGridRighthtml = `
                            ${layout}
                        <div class="card shadow-lg overflow-hidden element-item rounded-4 p-0 h-100 w-100" style="background-color: rgb(246, 246, 246);">
                            <div class="gallery-product overflow-hidden">
                            <a href="${url}" class="">
                                <img src="${photos[0]}" alt="" style=" border-radius: 20px 20px 0 0;" class="img-fluid w-100 m-0">
                            </a>
                            </div>
                            `
                        if (data.max_price_variant.stock > 0) {
                            productGridRighthtml +=
                                ` <div class="product-btn">  <a href="${url}" data-slug="${data.slug}" data-variant="${data.max_price_variant.id}" class="btn  product-btn-hover rounded-pill w-75 px-2 add-btn addtocart card-mg-overlay overflow-hidden"><i class="mdi mdi-cart me-1"></i> Add to Cart</a></div>`
                        } else {
                            productGridRighthtml +=
                                ` <div class="product-btn"><a href="javascript:void(0);" class="btn product-btn-hover rounded-pill w-75 px-2 add-btn card-mg-overlay overflow-hidden"><i class="mdi mdi-cart me-1"></i> Out of Stock</a></div> <span style="color:red;width: 100%; margin-left:1rem; margin-top:1rem  ">Out of stock</span>`
                        }

                        // console.log(data.max_price_variant.id);
                        
                    productGridRighthtml +=
                        `   
                                <div class="gallery-product-actions card-image-overlay">
                                    <div class="mb-2">
                                        <button type="button" class="btn btn-danger btn-sm custom-toggle wishlist-toggle rounded-5 ${checkinput}" data-product-id="${data.id}" data-product_variants-id="${data.max_price_variant.id}">
                                            <span class="icon-on"><i class="mdi mdi-heart-outline align-bottom fs-15"></i></span>
                                            <span class="icon-off"><i class="mdi mdi-heart align-bottom fs-15"></i></span>
                                        </button>
                                    </div>
                                    <div>
                                        <a href="${url}" class="btn btn-success btn-sm custom-toggle rounded-5 ">
                                            <span class="icon-on"><i class="mdi mdi-eye-outline align-bottom fs-15"></i></span>
                                            <span class="icon-off"><i class="mdi mdi-eye align-bottom fs-15"></i></span>
                                        </a>
                                    </div>
                                </div>
                                ${productLabel}
                                
                            <div class="card-body pb-0">
                                <div>
                                    ${colorElem}
                                    <a href="${url}" class="w-100" style="white-space: unset;">
                                        <h6 class="fs-16 fw-500 mb-3 lh-base truncate-text text-wrap ">${data.title}</h6>
                                    </a>
                                    <div class="mt-3">
                                        ${afterDiscountElem}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                    productGridRight.innerHTML += productGridRighthtml
                }
            }
        }

        selectedPage();
        currentPage == 1 ? prevButton.parentNode.classList.add('disabled') : prevButton.parentNode.classList.remove(
            'disabled');
        currentPage == pages ? nextButton.parentNode.classList.add('disabled') : nextButton.parentNode.classList.remove(
            'disabled');
    }

    function getColorOrSizeElement(data, num, isHidden = false) {
        if (Array.isArray(data.color) && data.color.length > 0) {
            return createColorOrSizeElement(data.color, data.id, num, 'clothe-colors', 'btn-', '', isHidden);
        } else if (Array.isArray(data.size) && data.size.length > 0) {
            return createColorOrSizeElement(data.size, data.id, num, 'clothe-size',
                'btn-soft-primary text-uppercase p-0 fs-12', elem => elem, isHidden);
        } else {
            return isHidden ?
                '<div class="avatar-xxs mb-3 d-none"><div class="avatar-title bg-light1 text-muted rounded cursor-pointer"><i class="ri-error-warning-line"></i></div></div>' :
                '<div class="avatar-xxs mb-3"><div class="avatar-title bg-light1 text-muted rounded cursor-pointer"><i class="ri-error-warning-line"></i></div></div>';
        }
    }

    function createColorOrSizeElement(items, id, num, className, btnClass, labelContent, isHidden) {
        var elem = `<ul class="${className} list-unstyled hstack gap-1 mb-3 flex-wrap${isHidden ? ' d-none' : ''}">`;
        items.forEach(function (item) {
            num++;
            elem += `<li>
                                <input type="radio" name="sizes${id}" id="product-color-${id}${num}">
                                <label class="avatar-xxs ${btnClass} d-flex align-items-center justify-content-center rounded-circle" for="product-color-${id}${num}">${typeof labelContent === 'function' ? labelContent(item) : item}</label>
                            </li>`;
        });
        elem += '</ul>';
        return elem;
    }

    function getDiscountElement(data) {
        return `<div class="avatar-xs label">
                            <div class="avatar-title bg-danger rounded-circle fs-11">${data.discount}</div>
                        </div>`;
    }

    function getAfterDiscountElement(data, afterDiscount, isCompact = false) {
        return isCompact ?
            `<h5 class="mb-0 ">₹${afterDiscount.toFixed(2)} <span class="text-muted fs-12 text-decoration-line-through"><del>MRP ₹ ${data.price}</del></span></h5>` :
            `<h5 class="text-secondary text-danger mb-0">₹ ${afterDiscount.toFixed(2)} <span class="text-muted fs-12 text-decoration-line-through"><del>MRP ₹ ${data.price}</del></span></h5>`;
    }

    function getRegularPriceElement(data, isCompact = false) {
        return isCompact ? `<h5 class="mb-0">₹${data.price}</h5>` :
            `<h5 class="text-secondary mb-0">₹ ${data.price}</h5>`;
    }

    function getButtonElement(data) {
        if (data.stock <= 0) {
            return `<div class="mt-3 hstack gap-2 justify-content-end"><a href="#" class="btn btn-primary"><i class="ri-bell align-bottom me-1"></i> Notify Me</a></div>`;
        } else {
            return `<div class="mt-3 hstack gap-2 justify-content-end">
                                <a href="../../add-to-cart/${data.slug}" class="btn btn-primary"><i class="ri-shopping-cart-2-fill align-bottom me-1"></i> Add To Cart</a>
                                <a href="../../product-detail/${data.slug}" class="btn btn-soft-secondary"><i class="ri-eye-fill align-bottom"></i></a>
                            </div>`;
        }
    }


    function selectedPage() {
        var pagenumLink = document.getElementById('page-num').getElementsByClassName('clickPageNumber');
        for (var i = 0; i < pagenumLink.length; i++) {
            if (i == currentPage - 1) {
                pagenumLink[i].parentNode.classList.add("active");
            } else {
                pagenumLink[i].parentNode.classList.remove("active");
            }
        }
    };

    // paginationEvents
    function paginationEvents() {
        var numPages = function numPages() {
            return Math.ceil(productListData.length / itemsPerPage);
        };

        function clickPage() {
            document.addEventListener('click', function (e) {
                if (e.target.nodeName == "A" && e.target.classList.contains("clickPageNumber")) {
                    currentPage = e.target.textContent;
                    loadProductList(productListData, currentPage);
                }
            });
        };

        function pageNumbers() {
            var pageNumber = document.getElementById('page-num');
            pageNumber.innerHTML = "";
            // for each page
            for (var i = 1; i < numPages() + 1; i++) {
                pageNumber.innerHTML +=
                    "<div class='page-item'><a class='page-link clickPageNumber' href='javascript:void(0);'>" + i +
                    "</a></div>";
            }
        }

        prevButton.addEventListener('click', function () {
            if (currentPage > 1) {
                currentPage--;
                loadProductList(productListData, currentPage);
            }
        });

        nextButton.addEventListener('click', function () {
            if (currentPage < numPages()) {
                currentPage++;
                loadProductList(productListData, currentPage);
            }
        });

        pageNumbers();
        clickPage();
        selectedPage();
    }

    function searchResult(data) {
        if (data.length == 0) {
            document.getElementById("pagination-element").style.display = "none";
            document.getElementById("search-result-elem").classList.remove("d-none");
        } else {
            document.getElementById("pagination-element").style.display = "flex";
            document.getElementById("search-result-elem").classList.add("d-none");
        }

        var pageNumber = document.getElementById('page-num');
        pageNumber.innerHTML = "";
        var dataPageNum = Math.ceil(data.length / itemsPerPage)
        // for each page
        for (var i = 1; i < dataPageNum + 1; i++) {
            pageNumber.innerHTML +=
                `<div class='page-item'><a class='page-link clickPageNumber' href='javascript:void(0);'> ${i}</a></div>`;
        }
    }

    //  category list filter
    Array.from(document.querySelectorAll('.filter-list a')).forEach(function (filterItem) {
        filterItem.addEventListener("click", function () {
            var activeFilterItem = document.querySelector(".filter-list a.active");
            if (activeFilterItem) activeFilterItem.classList.remove("active");
            filterItem.classList.add('active');

            var filterItemValue = filterItem.querySelector(".listname").textContent;
            var filterData = productListData.filter(function (filterListItem) {
                return filterListItem.category === filterItemValue;
            });

            searchResult(filterData);
            loadProductList(filterData, currentPage);
        });
    });


    // Search product list
    var searchProductList = document.getElementById("searchProductList");
    searchProductList.addEventListener("keyup", function () {
        var inputVal = searchProductList.value.toLowerCase();

        function filterItems(arr, query) {
            return arr.filter(function (el) {
                return el.title.toLowerCase().indexOf(query.toLowerCase()) !== -1
            })
        }
        var filterData = filterItems(productListData, inputVal);
        searchResult(filterData);
        loadProductList(filterData, currentPage);
    });


    // price range slider
    var slider = document.getElementById('product-price-range');
    if (slider) {
        noUiSlider.create(slider, {
            start: [0, 2000], // Handle start position
            step: 10, // Slider moves in increments of '10'
            margin: 20, // Handles must be more than '20' apart
            connect: true, // Display a colored bar between the handles
            behaviour: 'tap-drag', // Move handle on tap, bar is draggable
            range: { // Slider can select '0' to '100'
                'min': 0,
                'max': 2000
            },
            format: wNumb({
                decimals: 0,
                prefix: '$ '
            })
        });

        var minCostInput = document.getElementById('minCost'),
            maxCostInput = document.getElementById('maxCost');

        var filterDataAll = '';

        // When the slider value changes, update the input and span
        slider.noUiSlider.on('update', function (values, handle) {
            var productListupdatedAll = productListData;

            if (handle) {
                maxCostInput.value = values[handle];

            } else {
                minCostInput.value = values[handle];
            }

            var maxvalue = maxCostInput.value.substr(2);
            var minvalue = minCostInput.value.substr(2);
            filterDataAll = productListupdatedAll.filter(
                product => parseFloat(product.price) >= minvalue && parseFloat(product.price) <= maxvalue
            );

            searchResult(filterDataAll);
            loadProductList(filterDataAll, currentPage);
        });

        minCostInput.addEventListener('change', function () {
            slider.noUiSlider.set([null, this.value]);
        });

        maxCostInput.addEventListener('change', function () {
            slider.noUiSlider.set([null, this.value]);
        });
    }


    // discount-filter
    var arraylist = [];
    document.querySelectorAll("#discount-filter .form-check").forEach(function (item) {
        var inputVal = item.querySelector(".form-check-input").value;
        item.querySelector(".form-check-input").addEventListener("change", function () {
            if (item.querySelector(".form-check-input").checked) {
                arraylist.push(inputVal);
            } else {
                arraylist.splice(arraylist.indexOf(inputVal), 1);
            }

            var filterproductdata = productListData;
            if (item.querySelector(".form-check-input").checked && inputVal == 0) {
                filterDataAll = filterproductdata.filter(function (product) {
                    if (product.discount) {
                        var listArray = product.discount.split("%");

                        return parseFloat(listArray[0]) < 10;
                    }
                });
            } else if (item.querySelector(".form-check-input").checked && arraylist.length > 0) {
                var compareval = Math.min.apply(Math, arraylist);
                filterDataAll = filterproductdata.filter(function (product) {
                    if (product.discount) {
                        var listArray = product.discount.split("%");
                        return parseFloat(listArray[0]) >= compareval;
                    }
                });
            } else {
                filterDataAll = productListData;
            }

            searchResult(filterDataAll);
            loadProductList(filterDataAll, currentPage);
        });
    });

    // rating-filter
    document.querySelectorAll("#rating-filter .form-check").forEach(function (item) {
        var inputVal = item.querySelector(".form-check-input").value;
        item.querySelector(".form-check-input").addEventListener("change", function () {
            if (item.querySelector(".form-check-input").checked) {
                arraylist.push(inputVal);
            } else {
                arraylist.splice(arraylist.indexOf(inputVal), 1);
            }

            var filterproductdata = productListData;
            if (item.querySelector(".form-check-input").checked && inputVal == 1) {
                filterDataAll = filterproductdata.filter(function (product) {
                    if (product.rating) {
                        var listArray = product.rating;
                        return parseFloat(listArray) == 1;
                    }
                });
            } else if (item.querySelector(".form-check-input").checked && arraylist.length > 0) {
                var compareval = Math.min.apply(Math, arraylist);
                filterDataAll = filterproductdata.filter(function (product) {
                    if (product.rating) {
                        var listArray = product.rating;
                        return parseFloat(listArray) >= compareval;
                    }
                });
            } else {
                filterDataAll = productListData;
            }

            searchResult(filterDataAll);
            loadProductList(filterDataAll, currentPage);
        });
    });

    // color-filter
    document.querySelectorAll("#color-filter li").forEach(function (item) {
        var inputVal = item.querySelector("input[type='radio']").value;
        item.querySelector("input[type='radio']").addEventListener("change", function () {

            var filterData = productListData.filter(function (filterlist) {
                if (filterlist.color) {
                    return filterlist.color.some(function (g) {
                        return g == inputVal;
                    });
                }
            });

            searchResult(filterData);
            loadProductList(filterData, currentPage);

        });
    });

    // size-filter
    document.querySelectorAll("#size-filter li").forEach(function (item) {
        var inputVal = item.querySelector("input[type='radio']").value;
        item.querySelector("input[type='radio']").addEventListener("change", function () {

            var filterData = productListData.filter(function (filterlist) {
                if (filterlist.size) {
                    return filterlist.size.some(function (g) {
                        return g == inputVal;
                    });
                }
            });

            searchResult(filterData);
            loadProductList(filterData, currentPage);
        });
    });

    document.getElementById("sort-elem").addEventListener("change", function (e) {
        var inputVal = e.target.value;


        if (inputVal == "low_to_high") {
            sortElementsByAsc();
        } else if (inputVal == "high_to_low") {
            sortElementsByDesc();
        } else if (inputVal == "") {
            sortElementsById();
        }
    });

    function sortElementsByAsc() {
        var list = productListData.sort(function (a, b) {
            if (a.max_price_variant && b.max_price_variant) {
                var discountA = a.max_price_variant.discount || 0;
                var priceA = a.max_price_variant.price - (a.max_price_variant.price * discountA / 100);

                var discountB = b.max_price_variant.discount || 0;
                var priceB = b.max_price_variant.price - (b.max_price_variant.price * discountB / 100);

                return priceA - priceB; // Ascending order (low to high)
            } else if (a.max_price_variant) {
                return -1; // a has price variant, b doesn't
            } else if (b.max_price_variant) {
                return 1; // b has price variant, a doesn't
            }
            return 0; // neither has price variant
        });
        loadProductList(list, currentPage);
    }

    // Function to sort from high to low (descending order)
    function sortElementsByDesc() {
        var list = productListData.sort(function (a, b) {
            if (a.max_price_variant && b.max_price_variant) {
                var discountA = a.max_price_variant.discount || 0;
                var priceA = a.max_price_variant.price - (a.max_price_variant.price * discountA / 100);

                var discountB = b.max_price_variant.discount || 0;
                var priceB = b.max_price_variant.price - (b.max_price_variant.price * discountB / 100);

                return priceB - priceA; // Descending order (high to low)
            } else if (a.max_price_variant) {
                return 1; // a has price variant, b doesn't
            } else if (b.max_price_variant) {
                return -1; // b has price variant, a doesn't
            }
            return 0; // neither has price variant
        });
        loadProductList(list, currentPage);
    }

    // Function to sort by product ID (default fallback)
    function sortElementsById() {
        var list = productListData.sort(function (a, b) {
            return a.id - b.id; // Sorting by product ID as fallback
        });
        loadProductList(list, currentPage);
    }

    

    // Function to highlight selected page in pagination (if applicable)
    function selectedPage() {
        var pagenumLink = document.getElementById('page-num').getElementsByClassName('clickPageNumber');
        for (var i = 0; i < pagenumLink.length; i++) {
            if (i == currentPage - 1) {
                pagenumLink[i].parentNode.classList.add("active");
            } else {
                pagenumLink[i].parentNode.classList.remove("active");
            }
        }
    }

    

    // no sidebar page

    var hidingTooltipSlider = document.getElementById('slider-hide');
    if (hidingTooltipSlider) {
        noUiSlider.create(hidingTooltipSlider, {
            range: {
                min: 0,
                max: 2000
            },
            start: [20, 800],
            tooltips: true,
            connect: true,
            pips: {
                mode: 'count',
                values: 5,
                density: 4
            },
            format: wNumb({
                decimals: 2,
                prefix: '$ '
            })
        });

        var minCostInput = document.getElementById('minCost'),
            maxCostInput = document.getElementById('maxCost');

        var filterDataAll = '';

        // When the slider value changes, update the input and span
        hidingTooltipSlider.noUiSlider.on('update', function (values, handle) {
            var productListupdatedAll = productListData;

            if (handle) {
                maxCostInput.value = values[handle];

            } else {
                minCostInput.value = values[handle];
            }

            var maxvalue = maxCostInput.value.substr(2);
            var minvalue = minCostInput.value.substr(2);
            filterDataAll = productListupdatedAll.filter(
                product => parseFloat(product.price) >= minvalue && parseFloat(product.price) <= maxvalue
            );

            searchResult(filterDataAll);
            loadProductList(filterDataAll, currentPage);
        });
    }

    // choices category input
    if (document.getElementById('select-category')) {
        var productCategoryInput = new Choices(document.getElementById('select-category'), {
            searchEnabled: false,
        });

        productCategoryInput.passedElement.element.addEventListener('change', function (event) {
            var productCategoryValue = event.detail.value
            if (event.detail.value) {
                var filterData = productListData.filter(productlist => productlist.category ===
                    productCategoryValue);
            } else {
                var filterData = productListData;
            }
            searchResult(filterData);
            loadProductList(filterData, currentPage);
        }, false);
    }

    // select-rating
    if (document.getElementById('select-rating')) {
        var productRatingInput = new Choices(document.getElementById('select-rating'), {
            searchEnabled: false,
            allowHTML: true,
            delimiter: ',',
            editItems: true,
            maxItemCount: 5,
            removeItemButton: true,
        });

        productRatingInput.passedElement.element.addEventListener('change', function (event) {
            var productRatingInputValue = productRatingInput.getValue(true);
            if (event.detail.value == 1) {
                filterDataAll = productListData.filter(function (product) {
                    if (product.rating) {
                        var listArray = product.rating;
                        return parseFloat(listArray) == 1;
                    }
                });
            } else if (productRatingInputValue.length > 0) {
                var compareval = Math.min.apply(Math, productRatingInputValue);
                filterDataAll = productListData.filter(function (product) {
                    if (product.rating) {
                        var listArray = product.rating;
                        return parseFloat(listArray) >= compareval;
                    }
                });
            } else {
                filterDataAll = productListData;
            }

            searchResult(filterDataAll);
            loadProductList(filterDataAll, currentPage);
        }, false);
    }

    // select-discount
    if (document.getElementById('select-discount')) {
        var productDiscountInput = new Choices(document.getElementById('select-discount'), {
            searchEnabled: false,
            allowHTML: true,
            delimiter: ',',
            editItems: true,
            maxItemCount: 5,
            removeItemButton: true,
        });

        productDiscountInput.passedElement.element.addEventListener('change', function (event) {
            var productDiscountInputValue = productDiscountInput.getValue(true);
            var filterproductdata = productListData;
            if (event.detail.value == 0) {
                filterDataAll = productListData.filter(function (product) {
                    if (product.discount) {
                        var listArray = product.discount.split("%");
                        return parseFloat(listArray[0]) < 10;
                    }
                });
            } else if (productDiscountInputValue.length > 0) {
                var compareval = Math.min.apply(Math, productDiscountInputValue);
                filterDataAll = productListData.filter(function (product) {
                    if (product.discount) {
                        var listArray = product.discount.split("%");
                        return parseFloat(listArray[0]) >= compareval;
                    }
                });
            } else {
                filterDataAll = productListData;
            }
            searchResult(filterDataAll);
            loadProductList(filterDataAll, currentPage);
        }, false);
    }
    
</script>
@endsection