@php
    $settings = DB::table('settings')->get();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <title>Marmik|| Skin Assessment</title>
    <style>
        :root {
            --primary-color: rgb(11, 78, 179);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        body {
            font-family: Montserrat, "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            place-items: center;
            min-height: 100vh;
        }

        /* Global Stylings */
        label {
            display: block;
            margin-bottom: 0.5rem;
        }

        input {
            display: block;
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 0.25rem;
        }

        .width-50 {
            width: 50%;
        }

        .ml-auto {
            margin-left: auto;
        }

        .text-center {
            text-align: center;
        }

        /* Progressbar */
        .progressbar {
            position: relative;
            display: flex;
            justify-content: space-between;
            counter-reset: step;
            margin: 2rem 0 4rem;
        }

        .progressbar::before,
        .progress {
            content: "";
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            height: 4px;
            width: 100%;
            background-color: #dcdcdc;
            z-index: -1;
        }

        .progress {
            background-color: var(--primary-color);
            width: 0%;
            transition: 0.3s;
        }

        .progress-step {
            width: 2.1875rem;
            height: 2.1875rem;
            background-color: #dcdcdc;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .progress-step::before {
            counter-increment: step;
            content: counter(step);
        }

        .progress-step::after {
            content: attr(data-title);
            position: absolute;
            top: calc(100% + 0.5rem);
            font-size: 0.85rem;
            color: #666;
        }

        .progress-step-active {
            background-color: var(--primary-color);
            color: #f3f3f3;
        }

        /* Form */
        .form {
            width: clamp(320px, 30%, 430px);
            margin: 0 auto;
            border: 1px solid #ccc;
            border-radius: 0.35rem;
            padding: 1.5rem;
        }

        .form-step {
            display: none;
            transform-origin: top;
            animation: animate 0.5s;
        }

        .form-step-active {
            display: block;
        }

        .input-group {
            margin: 2rem 0;
        }

        @keyframes animate {
            from {
                transform: scale(1, 0);
                opacity: 0;
            }

            to {
                transform: scale(1, 1);
                opacity: 1;
            }
        }

        /* Button */
        .btns-group {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .btn {
            padding: 0.5rem;
            display: block;
            text-decoration: none;
            background-color: var(--primary-color);
            color: #f3f3f3;
            text-align: center;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            box-shadow: 0 0 0 2px #fff, 0 0 0 3px var(--primary-color);
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-light w-100 shadow mt-0">
        <a class="navbar-brand ms-2" href="/">
            <i class="mdi mdi-arrow-left" style="font-size:larger; margin-top: 3 rem !important"></i>
            <img src="@foreach ($settings as $data) {{ $data->logo }} @endforeach" alt="logo" width="250"
                height="50" class="d-inline-block align-top">
        </a>
    </nav>
    <form action="#" class="form mt-5">
        <!-- Progress bar -->
        <div class="progressbar">
            <div class="progress" id="progress"></div>

            <div class="progress-step progress-step-active" data-title="Age Group"></div>
            <div class="progress-step" data-title="Skin Type"></div>
            <div class="progress-step" data-title="Skin Concern"></div>
            <div class="progress-step" data-title="Generate Your Routine"></div>
        </div>

        <!-- Steps -->
        <div class="form-step form-step-active">
            <div class="mb-3">
                <div class="mb-3 mt-1 ms-1 ">
                    <label class="form-label ms-2">
                        <b>Age Group</b> <span class="text-danger">*</span>
                    </label>
                    <div class="form-check rounded-pill bg-light py-2 px-3" style="width: 16rem">
                        <input class="form-check-input mx-1" type="radio" name="age" id="age1"
                            value="1">
                        <label class="form-check-label mx-2 mt-1" for="age1">
                            12 to 18
                        </label>
                    </div>
                    <div class="form-check rounded-pill bg-light py-2 px-3 mt-2" style="width: 16rem">
                        <input class="form-check-input mx-1" type="radio" name="age" id="age2"
                            value="2">
                        <label class="form-check-label mx-2 mt-1" for="age2">
                            19 to 25
                        </label>
                    </div>
                    <div class="form-check rounded-pill bg-light py-2 px-3 mt-2" style="width: 16rem">
                        <input class="form-check-input mx-1" type="radio" name="age" id="age3"
                            value="3">
                        <label class="form-check-label mx-2 mt-1" for="age3">
                            25 to 30
                        </label>
                    </div>
                    <div class="form-check rounded-pill bg-light py-2 px-3 mt-2" style="width: 16rem">
                        <input class="form-check-input mx-1" type="radio" name="age" id="age4"
                            value="4">
                        <label class="form-check-label mx-2 mt-1" for="age4">
                            30 to 40
                        </label>
                    </div>
                </div>
                <div class="">
                    <a href="#" class="btn btn-next width-50 ml-auto">Next</a>
                </div>
            </div>
        </div>
        </div>
        <div class="form-step">
            <div class="mb-3 mt-1 ms-1">
                <label class="form-label ms-2 input-group"><b>Skin Type</b> <span class="text-danger">*</span></label>
                <div class="form-check rounded-pill bg-light py-2 px-3" style="width: 16rem">
                    <input class="form-check-input mx-1" type="radio" name="skin" id="oily" value="oily">
                    <label class="form-check-label mx-2 mt-1" for="oily">
                        Oily
                    </label>
                </div>
                <div class="form-check rounded-pill bg-light py-2 px-3 mt-2" style="width: 16rem">
                    <input class="form-check-input mx-1" type="radio" name="skin" id="dry" value="dry">
                    <label class="form-check-label mx-2 mt-1" for="dry">
                        Dry
                    </label>
                </div>
                <div class="form-check rounded-pill bg-light py-2 px-3 mt-2" style="width: 16rem">
                    <input class="form-check-input mx-1" type="radio" name="skin" id="normal"
                        value="normal">
                    <label class="form-check-label mx-2 mt-1" for="normal">
                        Normal
                    </label>
                </div>
            </div>
            <div class="btns-group">
                <a href="#" class="btn btn-prev">Previous</a>
                <a href="#" class="btn btn-next">Next</a>
            </div>
        </div>
        <div class="form-step">
            <div class="mb-3 mt-1 ms-1">
                <label for="useremail" class="form-label input-group"><b>What is your primary skin concern ? </b><span
                        class="text-danger">*</span></label>
                <div class="form-check rounded-pill bg-light py-2 px-3" style="width: 16rem">
                    <input class="form-check-input mx-1" type="radio" name="concern1" id="acne"
                        value="acne">
                    <label class="form-check-label mx-2 mt-1" for="acne">
                        Acne
                    </label>
                </div>
                <div class="form-check rounded-pill bg-light py-2 px-3 mt-2" style="width: 16rem">
                    <input class="form-check-input mx-1" type="radio" name="concern1" id="hyperpigmentation"
                        value="hyperpigmentation">
                    <label class="form-check-label mx-2 mt-1" for="hyperpigmentation">
                        Hyperpigmentation
                    </label>
                </div>
                <div class="form-check rounded-pill bg-light py-2 px-3 mt-2" style="width: 16rem">
                    <input class="form-check-input mx-1" type="radio" name="concern1" id="dryness"
                        value="dryness">
                    <label class="form-check-label mx-2 mt-1" for="dryness">
                        Dryness
                    </label>
                </div>

            </div>
            <div class="btns-group">
                <a href="#" class="btn btn-prev">Previous</a>
                <a href="#" class="btn btn-next">Next</a>
            </div>
        </div>
        <div class="form-step">
            <div class="my-4 pt-4 text-center">
                <h3>Take a selfie to get your skincare routine!</h3>
            </div>
            <div class="btns-group">
                <a href="#" class="btn btn-prev">Previous</a>
                <a href="face-scan" class="btn"><span class="mdi  mdi-camera-outline me-1"></span>Take Selfie</a>
            </div>
        </div>
    </form>
</body>
<script>
    const prevBtns = document.querySelectorAll(".btn-prev");
    const nextBtns = document.querySelectorAll(".btn-next");
    const progress = document.getElementById("progress");
    const formSteps = document.querySelectorAll(".form-step");
    const progressSteps = document.querySelectorAll(".progress-step");

    let formStepsNum = 0;

    nextBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            formStepsNum++;
            updateFormSteps();
            updateProgressbar();
        });
    });

    prevBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            formStepsNum--;
            updateFormSteps();
            updateProgressbar();
        });
    });

    function updateFormSteps() {
        formSteps.forEach((formStep) => {
            formStep.classList.contains("form-step-active") &&
                formStep.classList.remove("form-step-active");
        });

        formSteps[formStepsNum].classList.add("form-step-active");
    }

    function updateProgressbar() {
        progressSteps.forEach((progressStep, idx) => {
            if (idx < formStepsNum + 1) {
                progressStep.classList.add("progress-step-active");
            } else {
                progressStep.classList.remove("progress-step-active");
            }
        });

        const progressActive = document.querySelectorAll(".progress-step-active");

        progress.style.width =
            ((progressActive.length - 1) / (progressSteps.length - 1)) * 100 + "%";
    }
</script>

</html>
