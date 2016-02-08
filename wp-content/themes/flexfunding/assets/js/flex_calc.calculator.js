(function ($) {
flexCalcCalculator = {
  addSeperator: function(nStr) {
      nStr += '';
      var x = nStr.split('.');
      var x1 = x[0];
      var x2 = x.length > 1 ? '.' + x[1] : '';
      var rgx = /(\d+)(\d{3})/;
      while (rgx.test(x1)) {
          x1 = x1.replace(rgx, '$1' + '.' + '$2');
      }
      return x1 + x2;
  },
  attach: function (context, settings) {
    var conf = settings.flex_calc_conf;
    conf.min_max = conf.min_max || {};
    conf.min_max.min_amount_loaner = parseInt(conf.min_max.min_amount_loaner, 10);
    conf.min_max.max_amount_loaner = parseInt(conf.min_max.max_amount_loaner, 10);
    conf.min_max.min_amount_lender = parseInt(conf.min_max.min_amount_lender, 10);
    conf.min_max.max_amount_lender = parseInt(conf.min_max.max_amount_lender, 10);
    conf.min_fee = parseInt(conf.min_fee, 10);
    conf.interest.loaner = parseFloat(conf.interest.loaner, 10);
    conf.interest.lender = parseFloat(conf.interest.lender, 10);
    conf.interest.current = parseFloat($(".flex-calc-interest").val(), 10);
    conf.fee = parseFloat(conf.fee, 10);
    conf.type = 'loaner';
    if (conf.steps === '') {
      conf.steps = 10000;
    }
    conf.steps = parseInt(conf.steps, 10);
    flexCalcCalculator.conf = conf;
    flexCalcCalculator.conf.period = $(".flex-calc-length").val();
    $(".pane-flex-calc .flex-calc-length").keyup(function(event) {
      flexCalcCalculator.conf.period = $(this).val();
      flexCalcCalculator.calculate();
    });
    flexCalcCalculator.setMinMax();
    $(".pane-flex-calc .slider").slider({
      step: conf.steps,
      slide: function( event, ui) {
        var value = ui.value;
        $(".pane-flex-calc").find(".flex-calc-amount").val(flexCalcCalculator.addSeperator(value));
        flexCalcCalculator.conf.amount = value;
        flexCalcCalculator.calculate();
      }
    });
    $(".pane-flex-calc .flex-calc-amount").on("keyup", function(event) {
      var value = $(this).val();
      value = parseInt(value.replace(/\./g, ''), 10);
      if (value !== NaN && value > 0) {
        $(".pane-flex-calc .slider").slider("value", value);
        flexCalcCalculator.conf.amount = value;
        flexCalcCalculator.calculate();
        $(this).val(flexCalcCalculator.addSeperator(value));
      }
    });
    $(".flex-calc-length").hide();
    if (flexCalcCalculator.notHasRun) {
      $(".flex-calc-length option").each(function() {
        $(".flex-calc-length-new-inner").append('<div class="flex-calc-length-button flex-calc-length-value-' + $(this).val() + '">' + $(this).html() + '</div>');
      });
      flexCalcCalculator.notHasRun = false;
    }
    var lengthValue = $("select.flex-calc-length").val();
    $("div.flex-calc-length-value-" + lengthValue).addClass("active");
    $(".flex-calc-length-new-inner div").click(function() {
      if ($(this).hasClass('active')) {
        return;
      }
      var lengthValue = $(this).attr('class').split('flex-calc-length-value-')[1];
      $(".flex-calc-length-new-inner div.active").removeClass('active');
      $(this).addClass('active');
      $("select.flex-calc-length").val(lengthValue).trigger("keyup");
    });
    $(".flex-calc-amount").trigger('keyup');
    flexCalcCalculator.calculate();
    // Trigger the form swithcer.
    $(".switcher > span").click(function(event) {
      if (!$(this).hasClass('active')) {
        var active = $(this).attr('class');
        var oldClass = $(this).parent().find('.active').removeClass('active').attr('class');
        flexCalcCalculator.conf.type = active;
        $(this).addClass('active');
        $(".pane-flex-calc").find('span.'+oldClass).hide();
        $(".pane-flex-calc").find('span.'+active).show();
        $(".switcher > span").show();
        if (active == 'lender') {
          $(".pane-flex-calc .current-interest").show();
          $(".min-max-lender").show();
          $(".min-max-loaner").hide();
        }
        else {
          $(".pane-flex-calc .current-interest").hide();
          $(".min-max-loaner").show();
          $(".min-max-lender").hide();
        }
        flexCalcCalculator.setMinMax();
        flexCalcCalculator.calculate();
        $(".flex-calc-amount").trigger('keyup');
      }
    });
    if ($("body").hasClass("page-laangiver")) {
      $(".switcher span.lender").click();
    }
    if ($(".switcher .loaner").hasClass('active')) {
      $(".result span.loaner").show();
      $(".result span.lender").hide();
      $(".min-max-loaner").show();
      $(".min-max-lender").hide();
    } else {
      $(".result span.lender").show();
      $(".result span.loaner").hide();
    }
    $(".flex-calc-interest").on("change keyup", function(event) {
      var value = $(this).val().replace(',', '.');
      flexCalcCalculator.conf.interest.current = parseFloat(value, 10);
      console.log(flexCalcCalculator.conf);
      flexCalcCalculator.calculate();
    });
  },
  calculate: function() {
    console.log(flexCalcCalculator.conf);
    var conf = flexCalcCalculator.conf;
    if (conf.type === 'loaner') {
      // Setup vars.
      var fee = Math.max(conf.fee * conf.amount / 100, conf.min_fee);
      var totalLoan = conf.amount;
      var mInterest = conf.interest.loaner / 1200;
      // Do calculation.
      var monthlyPayment = totalLoan * mInterest / (1 - (Math.pow(1/(1 + mInterest), conf.period)));
      // Clean up.
      monthlyPayment = parseInt(monthlyPayment, 10);
      var totalPayment = monthlyPayment * conf.period;
      // display result on page.
      $(".pane-flex-calc .result").find("span.monthly-fee").text(flexCalcCalculator.addSeperator(monthlyPayment) + ' ' + conf.currency).end()
        .find("span.total-fee").text(flexCalcCalculator.addSeperator(totalPayment) + ' ' + conf.currency).end()
        .find("span.establish-fee").text(flexCalcCalculator.addSeperator(fee) + ' ' + conf.currency).end();
    }
    else {
      var totalLoan = conf.amount;
      var currentInterest = parseInt(totalLoan * conf.interest.current / 100 * conf.period / 12, 10);
      var flexInterest = parseInt(totalLoan * conf.interest.lender / 100 * conf.period / 12, 10);
      $(".pane-flex-calc .result").find("span.monthly-fee").text(flexCalcCalculator.addSeperator(currentInterest) + ' ' + conf.currency).end()
        .find("span.total-fee").text(flexCalcCalculator.addSeperator(flexInterest) + ' ' + conf.currency).end()
        .find("span.establish-fee").text(flexCalcCalculator.addSeperator(flexInterest - currentInterest) + ' ' + conf.currency).end();
    }
  },
  setMinMax: function() {
    var conf = flexCalcCalculator.conf;
    if ($(".switcher .loaner").hasClass("active")) {
      $(".flex-calc-amount").val(conf.min_max.min_amount_loaner);
      $(".pane-flex-calc .slider").slider({
        min: conf.min_max.min_amount_loaner,
        max: conf.min_max.max_amount_loaner,
      });
    } else {
      $(".flex-calc-amount").val(conf.min_max.min_amount_lender);
      $(".pane-flex-calc .slider").slider({
        min: conf.min_max.min_amount_lender,
        max: conf.min_max.max_amount_lender,
      });
    }
  },
  conf: {},
  notHasRun: true
};
}(jQuery));
