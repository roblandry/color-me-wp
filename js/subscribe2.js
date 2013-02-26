  jQuery.extend(jQuery.easing, {
      easeOutCubic: function (x, t, b, c, d) {
          return c * ((t = t / d - 1) * t * t + 1) + b;
      }
  });
  jQuery(document).ready(function () {
      var isopen = false,
          bitHeight = jQuery('#bitsubscribe').height();
      setTimeout(function () {
          jQuery('#bit').animate({
              bottom: '-' + bitHeight - 30 + 'px'
          }, 200);
      }, 300);
      jQuery('#bit a.bsub').click(function () {
          if (!isopen) {
              isopen = true;
              jQuery('#bit a.bsub').addClass('open');
              jQuery('#bit #bitsubscribe').addClass('open')
              jQuery('#bit').stop();
              jQuery('#bit').animate({
                  bottom: '0px'
              }, {
                  duration: 400,
                  easing: "easeOutCubic"
              });
          } else {
              isopen = false;
              jQuery('#bit').stop();
              jQuery('#bit').animate({
                  bottom: '-' + bitHeight - 30 + 'px'
              }, 200, function () {
                  jQuery('#bit a.bsub').removeClass('open');
                  jQuery('#bit #bitsubscribe').removeClass('open');
              });
          }
      });
  });
