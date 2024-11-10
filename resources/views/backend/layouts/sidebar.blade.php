<style>
    /* Hide scrollbar but still allow scrolling */
    #accordionSidebar {
        overflow: auto;
        /* Enable scrolling */
        -ms-overflow-style: none;
        /* IE and Edge */
        scrollbar-width: none;
        /* width: 250px !important; */
        /* Firefox */
    }



    #accordionSidebar::-webkit-scrollbar {
        display: none;
        /* For Chrome, Safari, and Edge */
    }

    #accordionSidebar::-webkit-scrollbar {
        display: none;
        /* Chrome, Safari, and Edge */
    }
</style>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="overflow-y:auto">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin') }}">
        <div class="sidebar-brand-text mx-3">Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <li class="nav-item">
        <a class =""></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Banner
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <!-- Nav Item - Charts -->

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMedia"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-image"></i>
            <span>Media Manager</span>
        </a>
        <div id="collapseMedia" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Media Manager Options:</h6>
                <a class="collapse-item" href="{{ route('file-manager') }}?type=image">Image</a>
                <a class="collapse-item" href="{{ route('file-manager') }}">Files</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-image"></i>
            <span>Banners</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Banner Options:</h6>
                <a class="collapse-item" href="{{ route('banner.index') }}">Banners</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsecenter"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-image"></i>
            <span>Centers</span>
        </a>
        <div id="collapsecenter" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Centers Options:</h6>
                <a class="collapse-item" href="{{ route('centers.index') }}">Centers</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwoo"
            aria-expanded="true" aria-controls="collapseTwoo">
            <i class="fas fa-image"></i>
            <span>Skin Routine</span>
        </a>
        <div id="collapseTwoo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Routine Type Options:</h6>
                <a class="collapse-item" href="{{ route('routine.index') }}">Skin Routine</a>
                <a class="collapse-item" href="{{ route('routine.create') }}">Add Routine Type</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePromise"
            aria-expanded="true" aria-controls="collapsePromise">
            <i class="fas fa-image"></i>
            <span>Promise</span>
        </a>
        <div id="collapsePromise" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Promise Options:</h6>
                <a class="collapse-item" href="{{ route('promise.index') }}">Promise</a>
                <a class="collapse-item" href="{{ route('promise.create') }}">Add Promise</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCertified"
            aria-expanded="true" aria-controls="collapseCertified">
            <i class="fas fa-image"></i>
            <span>Certified</span>
        </a>
        <div id="collapseCertified" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Certified Options:</h6>
                <a class="collapse-item" href="{{ route('certified.index') }}">Certified</a>
                <a class="collapse-item" href="{{ route('certified.create') }}">Add Certified</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#Information"
            aria-expanded="true" aria-controls="Information">
            <i class="fas fa-image"></i>
            <span>Information</span>
        </a>
        <div id="Information" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Information:</h6>
                <a class="collapse-item" href="{{ route('information.index') }}">Information</a>
                <a class="collapse-item" href="{{ route('information.create') }}">Add Information</a>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Shop
    </div>

    <!-- Categories -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#categoryCollapse"
            aria-expanded="true" aria-controls="categoryCollapse">
            <i class="fas fa-sitemap"></i>
            <span>Category</span>
        </a>
        <div id="categoryCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Category Options:</h6>
                <a class="collapse-item" href="{{ route('category.index') }}">Category</a>
                <a class="collapse-item" href="{{ route('category.create') }}">Add Category</a>
            </div>
        </div>
    </li>

    <!-- Concern-->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#appointment"
            aria-expanded="true" aria-controls="appointment">
            <i class="fas fa-sitemap"></i>
            <span>Appointment</span>
        </a>
        <div id="appointment" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Appoints Options:</h6>
                <a class="collapse-item" href="{{ route('show.slot') }}">Slot</a>

            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#concernCollapse"
            aria-expanded="true" aria-controls="concernCollapse">
            <i class="fas fa-sitemap"></i>
            <span>Concern</span>
        </a>
        <div id="concernCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Concern Options:</h6>
                <a class="collapse-item" href="{{ route('concern.index') }}">Concern</a>
                <a class="collapse-item" href="{{ route('concern.create') }}">Add Concern</a>
            </div>
        </div>
    </li>


    <!-- Concern-->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#ptypeCollapse"
            aria-expanded="true" aria-controls="ptypeCollapse">
            <i class="fas fa-sitemap"></i>
            <span>Product Type</span>
        </a>
        <div id="ptypeCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Product Type:</h6>
                <a class="collapse-item" href="{{ route('product_type.index') }}">Product Type</a>
                <a class="collapse-item" href="{{ route('product_type.create') }}">Add Product Type</a>
            </div>
        </div>
    </li>
    {{-- Products --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#productCollapse"
            aria-expanded="true" aria-controls="productCollapse">
            <i class="fas fa-cubes"></i>
            <span>Products</span>
        </a>
        <div id="productCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Product Options:</h6>
                <a class="collapse-item" href="{{ route('product.index') }}">Products</a>
                <a class="collapse-item" href="{{ route('product.create') }}">Add Product</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#variantCollapse"
            aria-expanded="true" aria-controls="variantCollapse">
            <i class="fas fa-cubes"></i>
            <span>Products Variants</span>
        </a>
        <div id="variantCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Variants Options:</h6>
                <a class="collapse-item" href="{{ route('variant.index') }}">Products Variants</a>
                <a class="collapse-item" href="{{ route('variant.create') }}">Add Product Variants</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#BillingCollapse"
            aria-expanded="true" aria-controls="BillingCollapse">
            <i class="fas fa-cubes"></i>
            <span>Billing</span>
        </a>
        <div id="BillingCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Billing Options:</h6>
                <a class="collapse-item" href="{{ route('show.invoice') }}">All Offline Invoice</a>
                <a class="collapse-item" href="{{ route('stocks.buy') }}">Create Invoice</a>
                <a class="collapse-item" href="{{ route('stocks.new_sale_return') }}">New Sale Return</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#stocksCollapse"
            aria-expanded="true" aria-controls="stocksCollapse">
            <i class="fas fa-cubes"></i>
            <span>Stocks</span>
        </a>
        <div id="stocksCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Stocks Options:</h6>
                <a class="collapse-item" href="{{ route('stocks.index') }}">Stocks</a>
                <a class="collapse-item" href="{{ route('stocks.create') }}">Add Stocks</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#reportCollapse"
            aria-expanded="true" aria-controls="reportCollapse">
            <i class="fas fa-cubes"></i>
            <span>Product Report</span>
        </a>
        <div id="reportCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Product Report:</h6>
                <a class="collapse-item" href="{{ route('sales.index') }}">Sell Report</a>
                <a class="collapse-item" href="{{ route('purchases.index') }}">Purchase Report</a>
            </div>
        </div>
    </li>
    {{-- Brand --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#brandCollapse"
            aria-expanded="true" aria-controls="brandCollapse">
            <i class="fas fa-table"></i>
            <span>Brand</span>
        </a>
        <div id="brandCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Brand Options:</h6>
                <a class="collapse-item" href="{{ route('brand.index') }}">Brand</a>
                <a class="collapse-item" href="{{ route('brand.create') }}">Add Brand</a>
            </div>
        </div>
    </li>


    {{-- Strep --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#strepCollapse"
            aria-expanded="true" aria-controls="strepCollapse">
            <i class="fas fa-table"></i>
            <span>Quantity</span>
        </a>
        <div id="strepCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Quantity Options:</h6>
                <a class="collapse-item" href="{{ route('strep.index') }}">Quantity</a>
                <a class="collapse-item" href="{{ route('strep.create') }}">Add Quantity</a>
            </div>
        </div>
    </li>
    {{-- Supplier --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#supplierCollapse"
            aria-expanded="true" aria-controls="supplierCollapse">
            <i class="fas fa-table"></i>
            <span>Supplier</span>
        </a>
        <div id="supplierCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Supplier Options:</h6>
                <a class="collapse-item" href="{{ route('suppliers.index') }}">Supplier</a>
                <a class="collapse-item" href="{{ route('suppliers.create') }}">Add Supplier</a>
            </div>
        </div>
    </li>
    {{-- Shipping --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#shippingCollapse"
            aria-expanded="true" aria-controls="shippingCollapse">
            <i class="fas fa-truck"></i>
            <span>Shipping</span>
        </a>
        <div id="shippingCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Shipping Options:</h6>
                <a class="collapse-item" href="{{ route('shipping.index') }}">Shipping</a>
                <a class="collapse-item" href="{{ route('shipping.create') }}">Add Shipping</a>
            </div>
        </div>
    </li>

    <!--Orders -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('order.index') }}">
            <i class="fas fa-hammer fa-chart-area"></i>
            <span>Orders</span>
        </a>
    </li>

    <!--Invoice-->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('billing.index') }}">
            <i class="fas fa-hammer fa-chart-area"></i>
            <span>Billing</span>
        </a>
    </li>
    <!-- Reviews -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('review.index') }}">
            <i class="fas fa-comments"></i>
            <span>Reviews</span></a>
    </li>
    <!-- Stores -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('store.index') }}">
            <i class="fas fa-comments"></i>
            <span>Stores</span></a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Shipment
    </div>

    <!-- Shipment -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#shipCollapse"
            aria-expanded="true" aria-controls="shipCollapse">
            <i class="fas fa-fw fa-ship"></i>
            <span>Shipment</span>
        </a>
        <div id="shipCollapse" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Ship Options:</h6>
                <a class="collapse-item" href="{{route('shipUserDetail')}}">Add User</a>
                <a class="collapse-item" href="{{URL::to('admin/generate_token')}}">Generate Token</a>
                <a class="collapse-item" href="javascript:void(0);">Change Password</a>
                <a class="collapse-item" href="{{route('pickup_index')}}">Pickup Address</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#pickCollapse"
            aria-expanded="true" aria-controls="pickCollapse">
            <i class="fas fa-fw fa-ship"></i>
            <span>Pickup Address</span>
        </a>
        <div id="pickCollapse" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pickup Options:</h6>
                <a class="collapse-item" href="{{route('pickup_index')}}">Pickup Address</a>
            </div>
        </div>
    </li>



    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Post
    </div>

    <!-- Posts -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#postCollapse"
            aria-expanded="true" aria-controls="postCollapse">
            <i class="fas fa-fw fa-folder"></i>
            <span>Posts</span>
        </a>
        <div id="postCollapse" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Post Options:</h6>
                <a class="collapse-item" href="{{ route('post.index') }}">Posts</a>
                <a class="collapse-item" href="{{ route('post.create') }}">Add Post</a>
            </div>
        </div>
    </li>

    <!-- Category -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#postCategoryCollapse"
            aria-expanded="true" aria-controls="postCategoryCollapse">
            <i class="fas fa-sitemap fa-folder"></i>
            <span>Category</span>
        </a>
        <div id="postCategoryCollapse" class="collapse" aria-labelledby="headingPages"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Category Options:</h6>
                <a class="collapse-item" href="{{ route('post-category.index') }}">Category</a>
                <a class="collapse-item" href="{{ route('post-category.create') }}">Add Category</a>
            </div>
        </div>
    </li>

    <!-- Tags -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#tagCollapse"
            aria-expanded="true" aria-controls="tagCollapse">
            <i class="fas fa-tags fa-folder"></i>
            <span>Tags</span>
        </a>
        <div id="tagCollapse" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Tag Options:</h6>
                <a class="collapse-item" href="{{ route('post-tag.index') }}">Tag</a>
                <a class="collapse-item" href="{{ route('post-tag.create') }}">Add Tag</a>
            </div>
        </div>
    </li>

    <!-- Comments -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('comment.index') }}">
            <i class="fas fa-comments fa-chart-area"></i>
            <span>Comments</span>
        </a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Heading -->
    <div class="sidebar-heading">
        General Settings
    </div>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('coupon.index') }}">
            <i class="fas fa-table"></i>
            <span>Coupon</span></a>
    </li>
    <!-- Users -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('users.index') }}">
            <i class="fas fa-users"></i>
            <span>Users</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#userCollapse"
            aria-expanded="true" aria-controls="tagCollapse">
            <i class="fas fa-tags fa-folder"></i>
            <span>User & Permission</span>
        </a>
        <div id="userCollapse" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">User Options:</h6>
                <a class="collapse-item" href="{{ route('roles.index') }}">Add Role</a>
                <!-- <a class="collapse-item" href="{{ route('permissions.index') }}">Add Permisson</a> -->
                <a class="collapse-item" href="{{ route('users.index') }}">Add User</a>
            </div>
        </div>
    </li>

    <!-- General settings -->
    <li class="nav-item">

    </li>


    <!-- Category -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#featureCollapse"
            aria-expanded="true" aria-controls="featureCollapse">
            <i class="fas fa-sitemap fa-folder"></i>
            <span>Frontend Feature</span>
        </a>
        <div id="featureCollapse" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Feature Options:</h6>
                <a class="collapse-item" href="{{ route('testimonial.index') }}">Testimonial</a>
                <a class="collapse-item" href="{{ route('faq.index') }}">FAQ</a>
                <a class="collapse-item" href="{{ route('terms.index') }}">Term & Condition</a>
                <a class="collapse-item" href="{{ route('cta.index') }}">CTA</a>
                <a class="collapse-item" href="{{ route('story.index') }}">Our Story</a>
                <a class="collapse-item" href="{{ route('returns.index') }}">Return Policy</a>
                <a class="collapse-item" href="{{ route('social.index') }}">Social Media</a>
                <a class="collapse-item" href="{{ route('settings') }}"> Settings</a>
                <a class="collapse-item" href="{{ route('centerUpdate') }}">Update Profile</a>

            </div>
        </div>
    </li>

</ul>
