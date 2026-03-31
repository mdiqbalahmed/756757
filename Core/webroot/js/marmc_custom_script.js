// ## HEADER MENU DROPDOWN INDICATOR

var elements = document.querySelectorAll('li.dropdown');

// Loop through each element
elements.forEach(function (element) {
  // Check if the element has only the "dropdown" class
  if (element.classList.length === 1 && element.classList.contains('dropdown')) {
    // Create the <i> element
    var chevronRightIcon = document.createElement('i');
    chevronRightIcon.classList.add('fa', 'fa-chevron-right');

    // Get the first child of the <li> (which is the <a> tag)
    var firstChild = element.firstChild;

    // Insert the <i> element right after the <a> tag
    element.insertBefore(chevronRightIcon, firstChild);
  }
});



// ## NODE DESIGN AND CLASS ADDITION

// Get all ul elements within elements with the class .node-list
var ulElements = document.querySelectorAll('.marmc_node_list ul');

// Loop through the NodeList and add the new class to each ul element
ulElements.forEach(function (ulElement) {
  ulElement.classList.add('list-unstyled', 'ul-minus', 'mb-5', 'primary', 'aos-init', 'aos-animate');
  ulElement.setAttribute('data-aos', 'fade-up');
  ulElement.setAttribute('data-aos-delay', '200');
});



// ## DEPARTMENT DROPDOWN INDICATOR

var elements = document.querySelectorAll('.dropdown_root');

// Loop through each element
elements.forEach(function (element) {
  // Check if the element has the class "list-group-item"
  if (element.classList.contains('dropdown_root')) {
    // Create the <i> element
    var chevronDownIcon = document.createElement('i');
    chevronDownIcon.classList.add('fa', 'fa-chevron-down');

    // Append the <i> element to the <a> element
    element.appendChild(chevronDownIcon);
  }
});



// ## DEPARTMENT DISPLAYING BY CATEGORY

$(document).ready(function () {
  // Show default content
  $("#pre_clinical").show();

  // Handle click events on navbar items
  $(".navbar-nav .nav-item").click(function () {
    // Hide all content divs
    $("[id^='']").hide();

    // Show the selected content div
    var target = $(this).data("target");
    $("#" + target).show();
  });
});



// ## ADD A BARS ON MOBILE MENU
$(document).ready(function () {
  $('#medical_menu_wrap').prepend('<div id="medical_menu_trigger"><i class="fa fa-bars mr-2"></i></div>');
  $('#medical_menu_trigger').on('click', function () {
    $('.medical_menu').slideToggle();
  });
});



// ## ADD AND REMOVE DEFAULT CLASSES FROM NAV MENU
var elementsWithBgDarkClass = document.querySelectorAll(".bg-dark");
var elementsWithDropdownClass = document.querySelectorAll(".dropdown-toggle");

// Function to remove classes based on screen size
function removeClassesBasedOnScreenSize() {
  if (window.innerWidth < 700) {
    var elementsWithNavItemClass = document.querySelectorAll(".nav-item");
    var elementsWithNavLinkClass = document.querySelectorAll(".nav-link");

    elementsWithNavItemClass.forEach(function (element) {
      element.classList.remove("nav-item");
    });

    elementsWithNavLinkClass.forEach(function (element) {
      element.classList.remove("nav-link");
    });
  }
}

elementsWithBgDarkClass.forEach(function (element) {
  element.classList.remove("bg-dark");
  element.classList.remove("dropdown-menu");
  element.classList.remove("dropdown-item");
});
elementsWithDropdownClass.forEach(function (element) {
  element.classList.remove("dropdown-toggle");
});

// Call the function on page load and when the window is resized
removeClassesBasedOnScreenSize();

window.addEventListener("resize", removeClassesBasedOnScreenSize);



// ## ADD A CONTAIER CLASS WITH THE NODE-BODY

$(document).ready(function () {
  // Add the 'container' class to the node-body
  $('.node-body').addClass('container mt-5');
});
