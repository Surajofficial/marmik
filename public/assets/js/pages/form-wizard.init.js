document.querySelector("#profile-img-file-input") && document.querySelector("#profile-img-file-input").addEventListener("change", function () { var e = document.querySelector(".user-profile-image"), t = document.querySelector(".profile-img-file-input").files[0], r = new FileReader; r.addEventListener("load", function () { e.src = r.result }, !1), t && r.readAsDataURL(t) }), document.querySelectorAll(".form-steps") && Array.from(document.querySelectorAll(".form-steps")).forEach(function (e) { e.querySelectorAll(".nexttab") && Array.from(e.querySelectorAll(".nexttab")).forEach(function (t) { Array.from(e.querySelectorAll('button[data-bs-toggle="pill"]')).forEach(function (e) { e.addEventListener("show.bs.tab", function (e) { e.target.classList.add("done") }) }), t.addEventListener("click", function () { var e = t.getAttribute("data-nexttab"); document.getElementById(e).click() }) }), e.querySelectorAll(".previestab") && Array.from(e.querySelectorAll(".previestab")).forEach(function (e) { e.addEventListener("click", function () { for (var t = e.getAttribute("data-previous"), r = e.closest("form").querySelectorAll(".custom-nav .done").length, o = r - 1; o < r; o++)e.closest("form").querySelectorAll(".custom-nav .done")[o] && e.closest("form").querySelectorAll(".custom-nav .done")[o].classList.remove("done"); document.getElementById(t).click() }) }); var t = e.querySelectorAll('button[data-bs-toggle="pill"]'); t && Array.from(t).forEach(function (r, o) { r.setAttribute("data-position", o), r.addEventListener("click", function () { var l; r.getAttribute("data-progressbar") && (l = o / (l = document.getElementById("custom-progress-bar").querySelectorAll("li").length - 1) * 100, document.getElementById("custom-progress-bar").querySelector(".progress-bar").style.width = l + "%"), 0 < e.querySelectorAll(".custom-nav .done").length && Array.from(e.querySelectorAll(".custom-nav .done")).forEach(function (e) { e.classList.remove("done") }); for (var n = 0; n <= o; n++)t[n].classList.contains("active") ? t[n].classList.remove("done") : t[n].classList.add("done") }) }) });