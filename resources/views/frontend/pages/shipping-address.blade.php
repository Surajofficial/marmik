@extends('frontend.layouts.master')

@section('title', 'Dr Awish || SHIPPING Address')

@section('main-content')


    <section class="page-wrapper bg-primary1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center d-flex align-items-center justify-content-between">
                        <h4 class="text-white mb-0"></h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-light justify-content-center mb-0 fs-15">
                                <li class="breadcrumb-item"><a href="#!">Shop</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Address</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end container-->
    </section>
    <!-- end page title -->

    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <h4 class="fs-18 mb-4">Select or add an address</h4>
                        <form action="{{ route('cart') }}" method="get" id="selectAddress">
                            <div class="row g-4" id="address-list">

                            </div>
                            <input type="hidden" name="reward" value="{{ $_GET['reward'] ?? '' }}">
                            <input type="hidden" name="tprice" value="{{ $_GET['tprice'] ?? '' }}">
                        </form>
                        <!-- end row -->
                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <div class="text-center p-4 rounded-3  border-2 border-dashed">
                                    <div class="avatar-md mx-auto mb-4">
                                        <div class="avatar-title bg-success-subtle text-success rounded-circle display-6">
                                            <i class="bi bi-house-add"></i>
                                        </div>
                                    </div>
                                    <h5 class="fs-16 mb-3">Add New Address</h5>
                                    <button type="button"
                                        class="btn btn-success btn-sm w-xs stretched-link addAddress-modal"
                                        data-bs-toggle="modal" id="addAddressModalbtn">Add</button>
                                </div>
                            </div>
                        </div>


                        <div class="d-flex">


                            <div class="hstack gap-2 justify-content-start mt-3 mx-1">
                                <button type="button" class="btn btn-hover btn-danger">Continue Shopping</button>
                            </div>
                            @if (Helper::cartCount())
                                <div class="hstack gap-2 justify-content-start mt-3 mx-1">
                                    <button id="formSubmit" type="button" class="btn btn-hover btn-success">Check
                                        Out <i class="ri-logout-box-r-line align-bottom ms-1"></i></button>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

                <!-- end col -->
            </div>
            <!--end row-->
        </div>
        <!--end container-->
    </section>

    <!-- Modal -->
    <div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addAddressModalLabel">Add New Address</h1>
                    <button type="button" id="addAddress-close" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="addressid-input" class="form-control" value="">
                    <form action="{{ route('shipping.submit') }}" id="addressFrom" method="post">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-lg-6 col-md-6 col-12">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="hidden" name="reward" value="{{ $_GET['reward'] ?? '' }}">
                                <input type="hidden" name="tprice" value="{{ $_GET['tprice'] ?? '' }}">
                                <input type="text" name="first_name" class="form-control" id="name"
                                    value="{{ explode(' ', $user->name)[0] ?? '' }}" placeholder="Enter name" required>
                                <input type="hidden" id="add_num" name="add_num">
                                <div class="invalid-feedback">Please enter a name.</div>
                            </div>
                            <div class="mb-3 col-lg-6 col-md-6 col-12">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text"name="last_name" class="form-control" id="lname"
                                    value="{{ explode(' ', $user->name)[1] ?? '' }}" placeholder="Enter name">
                                <div class="invalid-feedback">Please enter a name.</div>
                            </div>
                            <div class="mb-3 col-lg-6 col-md-6 col-12">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" name="email" placeholder="" value="{{ $user->email ?? '' }}"
                                    class="form-control" id="email" placeholder="Enter name" required>
                                <div class="invalid-feedback">Please enter a email.</div>
                            </div>
                            <div class="mb-3 col-lg-6 col-md-6 col-12">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" id="phone"
                                    placeholder="Enter phone no." value="{{ $user->mobile ?? '' }}" required>
                                <div class="invalid-feedback">Please enter a phone no.</div>
                            </div>
                            <div class="mb-3 col-lg-6 col-md-6 col-12">
                                <label for="alter_nate_phone" class="form-label">Alternate Phone</label>
                                <input type="text" name="alter_nate_phone" class="form-control" id="alter_nate_phone"
                                    placeholder="Enter Alt. phone no." value="{{ $user->alter_nate_phone ?? '' }}">
                                <div class="invalid-feedback">Please enter alt. phone no.</div>
                            </div>

                            <div class="mb-3 col-lg-6 col-md-6 col-12">
                                <label for="post_code" class="form-label">Postal Code</label>
                                <input type="text" name="post_code" value="{{ old('post_code') }}"
                                    class="form-control" id="post_code" placeholder="Enter Postal code." required>
                                <div class="invalid-feedback text-danger" id="post_code_error">Please enter a postal.
                                </div>
                            </div>
                            <div class="mb-3 col-lg-6 col-md-6 col-12">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" name="address1" id="address1" placeholder="Enter address" rows="2" required></textarea>
                                <div class="invalid-feedback">Please enter address.</div>
                            </div>
                            <div class="mb-3 col-lg-6 col-md-6 col-12">
                                <label for="address2" class="form-label">Address Line1</label>
                                <textarea class="form-control" name="address2" id="address2" placeholder="Enter address" rows="2"></textarea>
                                <div class="invalid-feedback">Please enter address.</div>
                            </div>
                            <div class="mb-3 col-lg-6 col-md-6 col-12">
                                <label for="country" class="form-label">Country<span>*</span></label>
                                <select class="form-control" name="country" id="country">
                                    <option value="AF">Afghanistan</option>
                                    <option value="AX">Åland Islands</option>
                                    <option value="AL">Albania</option>
                                    <option value="DZ">Algeria</option>
                                    <option value="AS">American Samoa</option>
                                    <option value="AD">Andorra</option>
                                    <option value="AO">Angola</option>
                                    <option value="AI">Anguilla</option>
                                    <option value="AQ">Antarctica</option>
                                    <option value="AG">Antigua and Barbuda</option>
                                    <option value="AR">Argentina</option>
                                    <option value="AM">Armenia</option>
                                    <option value="AW">Aruba</option>
                                    <option value="AU">Australia</option>
                                    <option value="AT">Austria</option>
                                    <option value="AZ">Azerbaijan</option>
                                    <option value="BS">Bahamas</option>
                                    <option value="BH">Bahrain</option>
                                    <option value="BD">Bangladesh</option>
                                    <option value="BB">Barbados</option>
                                    <option value="BY">Belarus</option>
                                    <option value="BE">Belgium</option>
                                    <option value="BZ">Belize</option>
                                    <option value="BJ">Benin</option>
                                    <option value="BM">Bermuda</option>
                                    <option value="BT">Bhutan</option>
                                    <option value="BO">Bolivia</option>
                                    <option value="BA">Bosnia and Herzegovina</option>
                                    <option value="BW">Botswana</option>
                                    <option value="BV">Bouvet Island</option>
                                    <option value="BR">Brazil</option>
                                    <option value="IO">British Indian Ocean Territory</option>
                                    <option value="VG">British Virgin Islands</option>
                                    <option value="BN">Brunei</option>
                                    <option value="BG">Bulgaria</option>
                                    <option value="BF">Burkina Faso</option>
                                    <option value="BI">Burundi</option>
                                    <option value="KH">Cambodia</option>
                                    <option value="CM">Cameroon</option>
                                    <option value="CA">Canada</option>
                                    <option value="CV">Cape Verde</option>
                                    <option value="KY">Cayman Islands</option>
                                    <option value="CF">Central African Republic</option>
                                    <option value="TD">Chad</option>
                                    <option value="CL">Chile</option>
                                    <option value="CN">China</option>
                                    <option value="CX">Christmas Island</option>
                                    <option value="CC">Cocos [Keeling] Islands</option>
                                    <option value="CO">Colombia</option>
                                    <option value="KM">Comoros</option>
                                    <option value="CG">Congo - Brazzaville</option>
                                    <option value="CD">Congo - Kinshasa</option>
                                    <option value="CK">Cook Islands</option>
                                    <option value="CR">Costa Rica</option>
                                    <option value="CI">Côte d’Ivoire</option>
                                    <option value="HR">Croatia</option>
                                    <option value="CU">Cuba</option>
                                    <option value="CY">Cyprus</option>
                                    <option value="CZ">Czech Republic</option>
                                    <option value="DK">Denmark</option>
                                    <option value="DJ">Djibouti</option>
                                    <option value="DM">Dominica</option>
                                    <option value="DO">Dominican Republic</option>
                                    <option value="EC">Ecuador</option>
                                    <option value="EG">Egypt</option>
                                    <option value="SV">El Salvador</option>
                                    <option value="GQ">Equatorial Guinea</option>
                                    <option value="ER">Eritrea</option>
                                    <option value="EE">Estonia</option>
                                    <option value="ET">Ethiopia</option>
                                    <option value="FK">Falkland Islands</option>
                                    <option value="FO">Faroe Islands</option>
                                    <option value="FJ">Fiji</option>
                                    <option value="FI">Finland</option>
                                    <option value="FR">France</option>
                                    <option value="GF">French Guiana</option>
                                    <option value="PF">French Polynesia</option>
                                    <option value="TF">French Southern Territories</option>
                                    <option value="GA">Gabon</option>
                                    <option value="GM">Gambia</option>
                                    <option value="GE">Georgia</option>
                                    <option value="DE">Germany</option>
                                    <option value="GH">Ghana</option>
                                    <option value="GI">Gibraltar</option>
                                    <option value="GR">Greece</option>
                                    <option value="GL">Greenland</option>
                                    <option value="GD">Grenada</option>
                                    <option value="GP">Guadeloupe</option>
                                    <option value="GU">Guam</option>
                                    <option value="GT">Guatemala</option>
                                    <option value="GG">Guernsey</option>
                                    <option value="GN">Guinea</option>
                                    <option value="GW">Guinea-Bissau</option>
                                    <option value="GY">Guyana</option>
                                    <option value="HT">Haiti</option>
                                    <option value="HM">Heard Island and McDonald Islands</option>
                                    <option value="HN">Honduras</option>
                                    <option value="HK">Hong Kong SAR China</option>
                                    <option value="HU">Hungary</option>
                                    <option value="IS">Iceland</option>
                                    <option value="IN" selected="selected">India</option>
                                    <option value="ID">Indonesia</option>
                                    <option value="IR">Iran</option>
                                    <option value="IQ">Iraq</option>
                                    <option value="IE">Ireland</option>
                                    <option value="IM">Isle of Man</option>
                                    <option value="IL">Israel</option>
                                    <option value="IT">Italy</option>
                                    <option value="JM">Jamaica</option>
                                    <option value="JP">Japan</option>
                                    <option value="JE">Jersey</option>
                                    <option value="JO">Jordan</option>
                                    <option value="KZ">Kazakhstan</option>
                                    <option value="KE">Kenya</option>
                                    <option value="KI">Kiribati</option>
                                    <option value="KW">Kuwait</option>
                                    <option value="KG">Kyrgyzstan</option>
                                    <option value="LA">Laos</option>
                                    <option value="LV">Latvia</option>
                                    <option value="LB">Lebanon</option>
                                    <option value="LS">Lesotho</option>
                                    <option value="LR">Liberia</option>
                                    <option value="LY">Libya</option>
                                    <option value="LI">Liechtenstein</option>
                                    <option value="LT">Lithuania</option>
                                    <option value="LU">Luxembourg</option>
                                    <option value="MO">Macau SAR China</option>
                                    <option value="MK">Macedonia</option>
                                    <option value="MG">Madagascar</option>
                                    <option value="MW">Malawi</option>
                                    <option value="MY">Malaysia</option>
                                    <option value="MV">Maldives</option>
                                    <option value="ML">Mali</option>
                                    <option value="MT">Malta</option>
                                    <option value="MH">Marshall Islands</option>
                                    <option value="MQ">Martinique</option>
                                    <option value="MR">Mauritania</option>
                                    <option value="MU">Mauritius</option>
                                    <option value="YT">Mayotte</option>
                                    <option value="MX">Mexico</option>
                                    <option value="FM">Micronesia</option>
                                    <option value="MD">Moldova</option>
                                    <option value="MC">Monaco</option>
                                    <option value="MN">Mongolia</option>
                                    <option value="ME">Montenegro</option>
                                    <option value="MS">Montserrat</option>
                                    <option value="MA">Morocco</option>
                                    <option value="MZ">Mozambique</option>
                                    <option value="MM">Myanmar [Burma]</option>
                                    <option value="NA">Namibia</option>
                                    <option value="NR">Nauru</option>
                                    <option value="NP">Nepal</option>
                                    <option value="NL">Netherlands</option>
                                    <option value="AN">Netherlands Antilles</option>
                                    <option value="NC">New Caledonia</option>
                                    <option value="NZ">New Zealand</option>
                                    <option value="NI">Nicaragua</option>
                                    <option value="NE">Niger</option>
                                    <option value="NG">Nigeria</option>
                                    <option value="NU">Niue</option>
                                    <option value="NF">Norfolk Island</option>
                                    <option value="MP">Northern Mariana Islands</option>
                                    <option value="KP">North Korea</option>
                                    <option value="NO">Norway</option>
                                    <option value="OM">Oman</option>
                                    <option value="PK">Pakistan</option>
                                    <option value="PW">Palau</option>
                                    <option value="PS">Palestinian Territories</option>
                                    <option value="PA">Panama</option>
                                    <option value="PG">Papua New Guinea</option>
                                    <option value="PY">Paraguay</option>
                                    <option value="PE">Peru</option>
                                    <option value="PH">Philippines</option>
                                    <option value="PN">Pitcairn Islands</option>
                                    <option value="PL">Poland</option>
                                    <option value="PT">Portugal</option>
                                    <option value="PR">Puerto Rico</option>
                                    <option value="QA">Qatar</option>
                                    <option value="RE">Réunion</option>
                                    <option value="RO">Romania</option>
                                    <option value="RU">Russia</option>
                                    <option value="RW">Rwanda</option>
                                    <option value="BL">Saint Barthélemy</option>
                                    <option value="SH">Saint Helena</option>
                                    <option value="KN">Saint Kitts and Nevis</option>
                                    <option value="LC">Saint Lucia</option>
                                    <option value="MF">Saint Martin</option>
                                    <option value="PM">Saint Pierre and Miquelon</option>
                                    <option value="VC">Saint Vincent and the Grenadines</option>
                                    <option value="WS">Samoa</option>
                                    <option value="SM">San Marino</option>
                                    <option value="ST">São Tomé and Príncipe</option>
                                    <option value="SA">Saudi Arabia</option>
                                    <option value="SN">Senegal</option>
                                    <option value="RS">Serbia</option>
                                    <option value="SC">Seychelles</option>
                                    <option value="SL">Sierra Leone</option>
                                    <option value="SG">Singapore</option>
                                    <option value="SK">Slovakia</option>
                                    <option value="SI">Slovenia</option>
                                    <option value="SB">Solomon Islands</option>
                                    <option value="SO">Somalia</option>
                                    <option value="ZA">South Africa</option>
                                    <option value="GS">South Georgia</option>
                                    <option value="KR">South Korea</option>
                                    <option value="ES">Spain</option>
                                    <option value="LK">Sri Lanka</option>
                                    <option value="SD">Sudan</option>
                                    <option value="SR">Suriname</option>
                                    <option value="SJ">Svalbard and Jan Mayen</option>
                                    <option value="SZ">Swaziland</option>
                                    <option value="SE">Sweden</option>
                                    <option value="CH">Switzerland</option>
                                    <option value="SY">Syria</option>
                                    <option value="TW">Taiwan</option>
                                    <option value="TJ">Tajikistan</option>
                                    <option value="TZ">Tanzania</option>
                                    <option value="TH">Thailand</option>
                                    <option value="TL">Timor-Leste</option>
                                    <option value="TG">Togo</option>
                                    <option value="TK">Tokelau</option>
                                    <option value="TO">Tonga</option>
                                    <option value="TT">Trinidad and Tobago</option>
                                    <option value="TN">Tunisia</option>
                                    <option value="TR">Turkey</option>
                                    <option value="TM">Turkmenistan</option>
                                    <option value="TC">Turks and Caicos Islands</option>
                                    <option value="TV">Tuvalu</option>
                                    <option value="UG">Uganda</option>
                                    <option value="UA">Ukraine</option>
                                    <option value="AE">United Arab Emirates</option>
                                    <option value="Uk">United Kingdom</option>
                                    <option value="UY">Uruguay</option>
                                    <option value="UM">U.S. Minor Outlying Islands</option>
                                    <option value="VI">U.S. Virgin Islands</option>
                                    <option value="UZ">Uzbekistan</option>
                                    <option value="VU">Vanuatu</option>
                                    <option value="VA">Vatican City</option>
                                    <option value="VE">Venezuela</option>
                                    <option value="VN">Vietnam</option>
                                    <option value="WF">Wallis and Futuna</option>
                                    <option value="EH">Western Sahara</option>
                                    <option value="YE">Yemen</option>
                                    <option value="ZM">Zambia</option>
                                    <option value="ZW">Zimbabwe</option>
                                </select>
                            </div>
                            <div class="mb-3 col-lg-6 col-md-6 col-12">
                                <label for="state" class="form-label">State</label>
                                <input type="text" name="state" value="{{ old('state') }}" class="form-control"
                                    id="state" placeholder="Enter State." required>
                                <div class="invalid-feedback">Please enter a State.</div>
                            </div>
                            <div class="mb-3 col-lg-6 col-md-6 col-12">
                                <label for="city" class="form-label">City</label>
                                <input type="text" name="city" value="{{ old('city') }}" class="form-control"
                                    id="city" placeholder="Enter City Name." required>
                                <div class="invalid-feedback">Please enter a City.</div>
                            </div>

                            <div class="mb-3 col-lg-6 col-md-6 col-12">
                                <label for="atype" class="form-label">Address Type</label>
                                <select class="form-select" name="atype" id="atype" required>
                                    <option value="Home">Home (7am to 10pm)</option>
                                    <option value="Office">Office (11am to 7pm)</option>
                                </select>
                                <div class="invalid-feedback">Please select address type.</div>
                            </div>


                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- remove address Modal -->
    <div id="removeAddressModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" id="close-removeAddressModal" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                            colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>Are you sure ?</h4>
                            <p class="text-muted mx-4 mb-0">Are you sure You want to remove this address ?</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="remove-address" class="btn w-sm btn-danger">Yes, Delete It!</button>
                    </div>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    @include('frontend.layouts.newsletter')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#post_code').on('blur keyup', function() {
                var pincode = $(this).val();
                if (pincode && /^\d{6}$/.test(pincode)) {
                    $.ajax({
                        url: '/get-address-details/' + pincode,
                        method: 'GET',
                        success: function(data) {
                            if (data) {
                                $('#city').val(data.city);
                                $('#state').val(data.state);
                                $('#country').val(data.country);
                            }
                        },
                        error: function(response) {
                            if (response.status === 422) {
                                $('#post_code_error').text('Invalid pincode format.').show();
                            } else {
                                $('#post_code_error').text(
                                    'Invalid pincode or no data available for this pincode.'
                                ).show();
                            }
                        }
                    });
                } else {
                    $('#post_code_error').text('Please enter a valid 6-digit postal code.').show();
                }
            });

            $('#post_code').on('input', function() {
                $('#post_code_error').hide();
            });
        });
        var addressListData = <?php print_r($shipping); ?>

        var editlist = false;
        $(document).on('click', '#formSubmit', function(e) {
            valid = validateForm()
            if (e.target && e.target.id === 'formSubmit' && valid) {
                document.getElementById('selectAddress').submit();
            }
        });

        function validateForm() {
            const radios = document.querySelectorAll('input[name="shippingAddress"]');
            let isChecked = false;

            for (const radio of radios) {
                if (radio.checked) {
                    isChecked = true;
                    break;
                }
            }

            if (!isChecked) {
                alert("Please select a shipping address.");
                return false; // Prevent form submission
            }

            return true; // Allow form submission
        }
        loadAddressList(addressListData);

        function loadAddressList(datas) {
            document.getElementById("address-list").innerHTML = "";
            Array.from(datas).forEach(function(listdata) {
                var checkinput = listdata.checked ? "checked" : "";
                const addressList = document.getElementById("address-list");

                addressList.innerHTML += `
                        <div class="col-lg-6">
                            <div>
                                <div class="form-check card-radio">
                                    <input id="shippingAddress${listdata.id}" name="shippingAddress" type="radio" class="form-check-input" value="${listdata.id}" ${checkinput} required>
                                    <label class="form-check-label" for="shippingAddress${listdata.id}">
                                        <span class="mb-4 fw-semibold fs-12 d-block text-muted text-uppercase">${listdata.atype} Address</span>
                                        <span class="fs-14 mb-2 fw-semibold d-block">${listdata.first_name}</span>
                                        <span class="text-muted fw-normal text-wrap mb-1 d-block">${listdata.address1}</span>
                                        <span class="text-muted fw-normal d-block">Mo. ${listdata.phone}</span>
                                    </label>
                                </div>
                                <div class="d-flex flex-wrap p-2 py-1 bg-light rounded-bottom border mt-n1 fs-13">
                                    <div>
                                        <a href="#" class="d-block text-body p-1 px-2 edit-list" data-edit-id="${listdata.id}">
                                            <i class="ri-pencil-fill text-muted align-bottom me-1"></i> Edit
                                        </a>
                                    </div>
                                    <div>
                                        <a href="#" class="d-block text-body p-1 px-2 remove-list" data-remove-id="${listdata.id}">
                                            <i class="ri-delete-bin-fill text-muted align-bottom me-1"></i> Remove
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>`;
            });
        };

        function fetchIdFromObj(list) {
            return parseInt(list.id);
        }

        function findNextId() {
            if (addressListData.length === 0) {
                return 0;
            }
            var lastElementId = fetchIdFromObj(addressListData[addressListData.length - 1]),
                firstElementId = fetchIdFromObj(addressListData[0]);
            return (firstElementId >= lastElementId) ? (firstElementId + 1) : (lastElementId + 1);
        }
        $(document).on('click', '.edit-list', function(e) {
            e.preventDefault()
            id = $(this).data('edit-id')
            $.ajax({
                url: `/get-address/${id}`,
                type: 'GET', // Use 'POST' if your route accepts POST requests
                success: function(response) {
                    setAddressFields(response)
                    $('#add_num').val(response.id);
                    $('#addAddressModalLabel').text('Edit Address')
                    $('#addAddressModal').modal('show')
                },
                error: function(xhr, status, error) {
                    // Handle the error here
                    alert('An error occurred: ' + error);
                }
            });
        })
        $(document).on('click', '#remove-address', function(e) {
            e.preventDefault()
            id = $(this).data('id')
            $.ajax({
                url: `/remove-address/${id}`,
                type: 'GET', // Use 'POST' if your route accepts POST requests
                success: function(response) {
                    $('#removeAddressModal').modal('hide')
                    window.location.reload()
                },
                error: function(xhr, status, error) {
                    // Handle the error here
                    alert('An error occurred: ' + error);
                }
            });
        })
        $(document).on('click', '.remove-list', function(e) {
            e.preventDefault()
            id = $(this).data('remove-id')
            $('#remove-address').attr('data-id', id);
            $('#removeAddressModal').modal('show')
        })
        $(document).on('click', '#addAddressModalbtn', function(e) {
            e.preventDefault()
            $('#add_num').val(0);
            $('#addressFrom')[0].reset();
            $('#addAddressModalLabel').text('Add New Address')
            $('#addAddressModal').modal('show')
        })

        function setAddressFields(data) {

            $('#name').val(data.first_name);
            $('#lname').val(data.last_name);
            $('#email').val(data.email);
            $('#phone').val(data.phone);
            $('#country').val(data.country);
            $('#address1').val(data.address1);
            $('#address2').val(data.address2);
            $('#post_code').val(data.post_code);
            $('#atype').val(data.atype);
            $('#alter_nate_phone').val(data.alter_nate_phone);
            $('#city').val(data.city);
            $('#state').val(data.state);
        }
    </script>

@endsection
