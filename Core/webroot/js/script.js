

var div = document.getElementById('side_1');
var div2 = document.getElementById('side_2');
var div3 = document.getElementById('side_3');
var div4 = document.getElementById('side_4');
var div5 = document.getElementById('side_5');
var div6 = document.getElementById('side_6');
var display = 0;

function hideShow() {
      if (display == 1) {

            div.style.display = 'block';
            display = 0;
      }
      else {
            div.style.display = 'none';
            div2.style.display = 'none';
            div3.style.display = 'none';
            div4.style.display = 'none';
            div5.style.display = 'none';
            display = 1;
      }
}
function hideShow2() {
      if (display == 1) {

            div2.style.display = 'block';
            display = 0;
      }
      else {
            div.style.display = 'none';
            div2.style.display = 'none';
            div3.style.display = 'none';
            div4.style.display = 'none';
            div5.style.display = 'none';
            display = 1;
      }
}
function hideShow3() {
      if (display == 1) {

            div3.style.display = 'block';
            display = 0;
      }
      else {
            div.style.display = 'none';
            div2.style.display = 'none';
            div3.style.display = 'none';
            div4.style.display = 'none';
            div5.style.display = 'none';
            display = 1;
      }
}
function hideShow4() {
      if (display == 1) {

            div4.style.display = 'block';
            display = 0;
      }
      else {
            div.style.display = 'none';
            div2.style.display = 'none';
            div3.style.display = 'none';
            div4.style.display = 'none';
            div5.style.display = 'none';
            display = 1;
      }
}
function hideShow5() {
      if (display == 1) {

            div5.style.display = 'block';
            display = 0;
      }
      else {
            div.style.display = 'none';
            div2.style.display = 'none';
            div3.style.display = 'none';
            div4.style.display = 'none';
            div5.style.display = 'none';
            display = 1;
      }
}


//NAV MENU JS STARTS
$(document).on('click', '.dropdown-menu', function (e) {
  e.stopPropagation();
});

// make it as accordion for smaller screens
if ($(window).width() < 992) {
  $('.dropdown-menu a').click(function (e) {
    e.preventDefault();
    if ($(this).next('.submenu').length) {
      $(this).next('.submenu').toggle();
    }
    $('.dropdown').on('hide.bs.dropdown', function () {
      $(this).find('.submenu').hide();
    })
  });
}

// Get all elements with the class ".bg-dark"
var elementsWithBgDarkClass = document.querySelectorAll(".bg-dark");

// Iterate through the elements and remove the class
elementsWithBgDarkClass.forEach(function (element) {
  element.classList.remove("bg-dark");
});

//NAV MENU JS ENDS



function toggleForm() {
  var formContainer = document.getElementsByClassName("fleft");
  if (formContainer.style.display === "none") {
    formContainer.style.display = "block";
  } else {
    formContainer.style.display = "none";
  }
}
