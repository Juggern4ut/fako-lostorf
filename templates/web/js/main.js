$(document).ready(function() {
  mobileNavLinks()
  initFormSubmit()
  initSwipebox()
  initTileArticleHandler()
  initNavigation()
})

$(window).resize(function() {
  handleMobileNav()
  handleTableSize()
})

$(window).scroll(function() {
  setMobileNavTop()
})

function initNavigation() {
  $(".navigation__list-link--subnav").click(function() {
    if (
      $(this)
        .parent()
        .hasClass("navigation__list-item--open")
    ) {
      $(this)
        .parent()
        .parent()
        .find("> li")
        .removeClass("navigation__list-item--open")
    } else {
      $(this)
        .parent()
        .parent()
        .find("> li")
        .removeClass("navigation__list-item--open")
      $(this)
        .parent()
        .addClass("navigation__list-item--open")
    }
  })

  $(".navigation__mobile-burger").click(function() {
    $(".navigation").toggleClass("navigation--open")
    $("header").toggleClass("open")
  })
}

function handleMobileNav() {
  if (window.innerWidth < 1024) {
    $("header nav").css({ height: $("html").height() - 73 + "px" })
  } else {
    $("header nav").css({ height: "auto" })
  }
}

function handleTableSize() {
  $("main article table").each(function() {
    var table = $(this)
    table.find("tr").each(function() {
      var row = $(this)
      if (row.find("td").length == 2) {
        if (
          row
            .find("td")
            .eq(0)
            .find("img").length > 0
        ) {
          row
            .find("td")
            .eq(0)
            .css({ width: "33%" })
        } else {
          row
            .find("td")
            .eq(0)
            .css({ width: "67%" })
        }

        if (
          row
            .find("td")
            .eq(1)
            .find("img").length > 0
        ) {
          row
            .find("td")
            .eq(1)
            .css({ width: "33%" })
        } else {
          row
            .find("td")
            .eq(1)
            .css({ width: "67%" })
        }
      }
    })
  })
}

function setMobileNavTop() {
  if (window.innerWidth <= 1024) {
    var scrollTop = $(window).scrollTop()
    var navTop = 73
    $("header nav").css({ top: navTop - scrollTop + "px" })
  }
}

function mobileNavLinks() {
  $("nav a").click(function(e) {
    if (window.innerWidth <= 1024) {
      if ($(this).hasClass("navigation__list-link--subnav")) {
        return true
      }
      e.preventDefault()
      var link = $(this).attr("href")
      $("header").removeClass("open")
      $(".navigation").removeClass("navigation--open")
      setTimeout(function() {
        window.location.href = link
      }, 400)
    }
  })
}

function initTileArticleHandler() {
  $(".main--tile article").click(function() {
    $(this).toggleClass("article--open")
  })
}

function initSwipebox() {
  $("body").swipebox({ selector: ".swipebox" })
}

function initFormSubmit() {
  $("#contact-form").submit(function(e) {
    e.preventDefault()

    $(this)
      .find("input[type=submit]")
      .hide()
    $(this).append("<label class='form__label'>L&auml;dt...</label>")

    var message = $("#message").val()
    var name = $("#name").val()
    var mail = $("#mail").val()
    var subject = $("#subject").val()
    var message = $("#message").val()
    var captchaResponse = grecaptcha.getResponse()

    $.post("/?async=1", { "contact-form": "sent", message: message, name: name, mail: mail, subject: subject, grecaptcha: captchaResponse }, function(data) {
      if (data == 1) {
        $("#contact-form").slideUp()
        $("#contact-form").after("<h3 style=\"display: none;\" class='form-status'>Ihre Kontaktanfrage wurde erfolgreich versandt.</h3>")
        $(".form-status").slideDown()
      } else {
        $(".g-recaptcha").after("<h3 style=\"display: none;\" class='form-error'>Bitte aktivieren sie das ReCaptcha.</h3>")
        $(".form-error").slideDown()

        setTimeout(function() {
          $(".form-error").slideUp(function() {
            $(".form-error").remove()
          })
        }, 2500)

        $("#contact-form > label").remove()
        $("#contact-form").append('<input type="submit" value="Abschicken">')
      }
    })
  })
}

function initCountdown(selector) {
  var endTime = new Date("11 November 2019 00:00:00")
  endTime = Date.parse(endTime) / 1000

  var container = $(selector)
  container.append("<div class='countdown__tile countdown__tile--days'></div>")
  container.append("<div class='countdown__tile countdown__tile--hours'></div>")
  container.append("<div class='countdown__tile countdown__tile--minutes'></div>")
  container.append("<div class='countdown__tile countdown__tile--seconds'></div>")
  setInterval(function() {
    var now = new Date()
    now = Date.parse(now) / 1000

    var timeLeft = endTime - now

    var days = Math.floor(timeLeft / 86400)
    var hours = Math.floor((timeLeft - days * 86400) / 3600)
    var minutes = Math.floor((timeLeft - days * 86400 - hours * 3600) / 60)
    var seconds = Math.floor(timeLeft - days * 86400 - hours * 3600 - minutes * 60)

    hours = hours < "10" ? "0" + hours : hours
    minutes = minutes < "10" ? "0" + minutes : minutes
    seconds = seconds < "10" ? "0" + seconds : seconds

    container.find(".countdown__tile--days").html(days + "<span class='countdown__span'>Tage</span>")
    container.find(".countdown__tile--hours").html(hours + "<span class='countdown__span'>Stunden</span>")
    container.find(".countdown__tile--minutes").html(minutes + "<span class='countdown__span'>Minuten</span>")
    container.find(".countdown__tile--seconds").html(seconds + "<span class='countdown__span'>Sekunden</span>")
  }, 1000)
}
