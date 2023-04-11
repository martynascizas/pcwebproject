$(document).ready(function () {
    $('#gamintojas').on('change', function () {
        $('#submit_btn').click();
    });
});

$(document).ready(function () {
    $('#ekrano_istrizaine').on('change', function () {
        $('#submit_btn').click();
    });
});

$(document).ready(function () {
    $('#procesorius').on('change', function () {
        $('#submit_btn').click();
    });
});

$(document).ready(function () {
    $('#vaizdo_plokste').on('change', function () {
        $('#submit_btn').click();
    });
});

$(document).ready(function () {
    $('#ram').on('change', function () {
        $('#submit_btn').click();
    });
});

$(document).ready(function () {
    $('#hdd').on('change', function () {
        // $('#filter-form').submit();
        $('#submit_btn').click();
    });
});

$(document).ready(function () {
    $('#rezoliucija').on('change', function () {
        // $('#filter-form').submit();
        $('#submit_btn').click();
    });
});

$(document).ready(function () {
    $('#lieciamas_ekranas').on('change', function () {
        // $('#filter-form').submit();
        $('#submit_btn').click();
    });
});


$(document).ready(function () {
    $('#pavadinimas').on('change', function () {
        // $('#filter-form').submit();
        $('#submit_btn').click();
    });
});

$(document).ready(function () {
    $('#aprasymas').on('change', function () {
        // $('#filter-form').submit();
        $('#submit_btn').click();
    });
});


// function clearForm() {
//     document.getElementById("filter_form").reset();
//   }

/*navbar animation*/
// window.addEventListener("scroll", function () {
//     var navbar = document.querySelector(".navbar");
//     if (window.scrollY > 0) {
//         navbar.classList.add("scrolled", "animated");
//     } else {
//         navbar.classList.remove("scrolled", "animated");
//     }
// });

/*img zoom*/
// const zoomableImages = document.querySelectorAll('.zoomable');
// zoomableImages.forEach(image => {
//     image.addEventListener('click', e => {
//         e.target.classList.toggle('active');
//         document.body.classList.toggle('no-scroll');
//         const exitBtn = document.createElement('button');
//         exitBtn.innerHTML = 'Exit';
//         exitBtn.classList.add('exit-btn');
//         document.body.appendChild(exitBtn);
//         exitBtn.addEventListener('click', () => {
//             e.target.classList.remove('active');
//             document.body.classList.remove('no-scroll');
//             exitBtn.remove();
//         });
//     });
// });