(function ($) {
  "use strict";

  // Initiate the wowjs for animations
  new WOW().init();

  // Sticky Navbar
  $(window).on('scroll', function () {
    if ($(this).scrollTop() > 45) {
      $(".navbar").addClass("shadow-sm");
    } else {
      $(".navbar").removeClass("shadow-sm");
    }
  });

  // Header carousel
  $(".header-carousel").owlCarousel({
    animateOut: "fadeOut",
    items: 1,
    margin: 0,
    stagePadding: 0,
    autoplay: true, // Enable automatic sliding
    autoplayTimeout: 5000, // Time between slides (in milliseconds)
    autoplayHoverPause: true, // Pause on mouse hover
    smartSpeed: 600,
    dots: true, // Keep pagination dots
    loop: true, // Enable looping of slides
    nav: false, // Disable navigation buttons (arrows)
  });

  // Smooth Scrolling for Navigation Links
  $('a.nav-link').on('click', function(event) {
    if (this.hash !== "") {
      event.preventDefault();
      var hash = this.hash;

      $('html, body').animate({
        scrollTop: $(hash).offset().top - 70 // Adjust for fixed navbar height
      }, 800, function(){
        window.location.hash = hash;
      });
    }
  });

  // Active Link Switching on Scroll
  $(window).on('scroll', function() {
    var scrollDistance = $(window).scrollTop();

    // Assign active class to nav links while scrolling
    $('.container-fluid .navbar-nav .nav-link').each(function() {
      var currentLink = $(this);
      var refElement = $(currentLink.attr("href"));

      if (refElement.position().top - 80 <= scrollDistance && refElement.position().top + refElement.height() > scrollDistance) {
        $('.container-fluid .navbar-nav .nav-link').removeClass("active");
        currentLink.addClass("active");
      }
    });
  }).scroll();

})(jQuery);

// Registration form (if applicable)
$(document).ready(function () {
  var current_fs, next_fs, previous_fs; //fieldsets
  var opacity;

  $(".next").click(function () {
    current_fs = $(this).parent();
    next_fs = $(this).parent().next();

    // Activate next step on progressbar using the index of next_fs
    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

    // Show the next fieldset
    next_fs.show();
    // Hide the current fieldset with style
    current_fs.hide();
  });

  $(".previous").click(function () {
    current_fs = $(this).parent();
    previous_fs = $(this).parent().prev();

    // De-activate current step on progressbar
    $("#progressbar li")
      .eq($("fieldset").index(current_fs))
      .removeClass("active");

    // Show the previous fieldset
    previous_fs.show();
    // Hide the current fieldset with style
    current_fs.hide();
  });
});

// Registration form functions (if applicable)
window.nextStep = function (step) {
  document.querySelectorAll(".step").forEach(function (el) {
    el.classList.add("d-none");
  });
  document.getElementById("step" + step).classList.remove("d-none");
};

window.submitForm = function () {
  // Form submission logic here
  alert("Form submitted!");
};

