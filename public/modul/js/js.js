$(function() {
    $('input[name="daterange"]').daterangepicker({
  "autoApply": true,
  "locale": {
      "format": "DD/MM/YYYY",
      "separator": " - ",
      "applyLabel": "Seç",
      "cancelLabel": "Kapat",
      "fromLabel": "Tarihinden",
      "toLabel": "Tarihine",
      "customRangeLabel": "Özel",
      "weekLabel": "W",
      "daysOfWeek": [
          "Paz",
          "Pzt",
          "Sal",
          "Çar",
          "Per",
          "Cum",
          "Cmt"
      ],
      "monthNames": [
          "Ocak",
          "Şubat",
          "Mart",
          "Nisan",
          "Mayıs",
          "Haziran",
          "Temmuz",
          "Ağustos",
          "Eylül",
          "Ekim",
          "Kasım",
          "Aralık"
      ],
      "firstDay": 1
  },
  "opens": "center",
  "startDate": moment().startOf('day'),
    "endDate": moment().startOf('day'),
    "minDate": moment().startOf('day')
}, function(start, end, label) {
//console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
$('#check_in').val(start.format('D.M.YYYY'));
$('#check_out').val(end.format('D.M.YYYY'));
$('#counts').dropdown('toggle');
});

});

$(".dropdown-menu").click(function(e){
  e.stopPropagation();
});

function showChilds(child_quantity) {
  if(child_quantity==0){
      $('.child-title').removeClass("d-block").addClass("d-none");
      $('#child_count_1').closest('.child-item').removeClass("d-block").addClass("d-none");
      $('#child_count_2').closest('.child-item').removeClass("d-block").addClass("d-none");
      $('#child_count_3').closest('.child-item').removeClass("d-block").addClass("d-none");
  }
  if(child_quantity==1){
      $('.child-title').removeClass("d-none").addClass("d-block");
      $('#child_count_1').closest('.child-item').removeClass("d-none").addClass("d-block");
      $('#child_count_2').closest('.child-item').removeClass("d-block").addClass("d-none");
      $('#child_count_3').closest('.child-item').removeClass("d-block").addClass("d-none");
  }
  if(child_quantity==2){
      $('.child-title').removeClass("d-none").addClass("d-block");
      $('#child_count_1').closest('.child-item').removeClass("d-none").addClass("d-block");
      $('#child_count_2').closest('.child-item').removeClass("d-none").addClass("d-block");
      $('#child_count_3').closest('.child-item').removeClass("d-block").addClass("d-none");
  }
  if(child_quantity==3){
      $('.child-title').removeClass("d-none").addClass("d-block");
      $('#child_count_1').closest('.child-item').removeClass("d-none").addClass("d-block");
      $('#child_count_2').closest('.child-item').removeClass("d-none").addClass("d-block");
      $('#child_count_3').closest('.child-item').removeClass("d-none").addClass("d-block");
  }
}

function countsUpdate() {
  $('#counts').val($("#hotel_adult_count").val() + " YETİŞKİN, " + $("#hotel_child_count").val() + " ÇOCUK");
}

var getParameterByName = function (name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

$(document).ready(function(){
  //var adult_quantity=2;
  $('.adult-right-plus').click(function(e){
      e.preventDefault();
      var adult_quantity = parseInt($('#hotel_adult_count').val());
      if(adult_quantity<10){
          $('#hotel_adult_count').val(adult_quantity + 1);
          $('#hotel_adult_count').attr('value', adult_quantity + 1);
          countsUpdate();
      }
  });
  $('.adult-left-minus').click(function(e){
      e.preventDefault();
      var adult_quantity = parseInt($('#hotel_adult_count').val());
      if(adult_quantity>0){
          $('#hotel_adult_count').val(adult_quantity - 1);
          $('#hotel_adult_count').attr('value', adult_quantity - 1);
          countsUpdate();
      }
  });

  $('.child-right-plus').click(function(e){
      e.preventDefault();
      var child_quantity = parseInt($('#hotel_child_count').val());
      if(child_quantity<3){
          $('#hotel_child_count').val(child_quantity + 1);
          $('#hotel_child_count').attr('value', child_quantity + 1);
          showChilds($('#hotel_child_count').val());
          countsUpdate();
      }
  });
  $('.child-left-minus').click(function(e){
      e.preventDefault();
      var child_quantity = parseInt($('#hotel_child_count').val());
      if(child_quantity>0){
          $('#hotel_child_count').val(child_quantity - 1);
          $('#hotel_child_count').attr('value', child_quantity - 1);
          showChilds($('#hotel_child_count').val());
          countsUpdate();
      }
  });

  $('.child1-right-plus').click(function(e){
      e.preventDefault();
      var child1_quantity = parseInt($('#child_count_1').val());
      if(child1_quantity<12){
          $('#child_count_1').val(child1_quantity + 1);
          $('#child_count_1').attr('value', child1_quantity + 1);
          countsUpdate();
      }
  });
  $('.child1-left-minus').click(function(e){
      e.preventDefault();
      var child1_quantity = parseInt($('#child_count_1').val());
      if(child1_quantity>0){
          $('#child_count_1').val(child1_quantity - 1);
          $('#child_count_1').attr('value', child1_quantity - 1);
          countsUpdate();
      }
  });
  $('.child2-right-plus').click(function(e){
      e.preventDefault();
      var child2_quantity = parseInt($('#child_count_2').val());
      if(child2_quantity<12){
          $('#child_count_2').val(child2_quantity + 1);
          $('#child_count_2').attr('value', child2_quantity + 1);
          countsUpdate();
      }
  });
  $('.child2-left-minus').click(function(e){
      e.preventDefault();
      var child2_quantity = parseInt($('#child_count_2').val());
      if(child2_quantity>0){
          $('#child_count_2').val(child2_quantity - 1);
          $('#child_count_2').attr('value', child2_quantity - 1);
          countsUpdate();
      }
  });
  $('.child3-right-plus').click(function(e){
      e.preventDefault();
      var child3_quantity = parseInt($('#child_count_3').val());
      if(child3_quantity<12){
          $('#child_count_3').val(child3_quantity + 1);
          $('#child_count_3').attr('value', child3_quantity + 1);
          countsUpdate();
      }
  });
  $('.child3-left-minus').click(function(e){
      e.preventDefault();
      var child3_quantity = parseInt($('#child_count_3').val());
      if(child3_quantity>0){
          $('#child_count_3').val(child3_quantity - 1);
          $('#child_count_3').attr('value', child3_quantity - 1);
          countsUpdate();
      }
  });

  var style = getParameterByName('style');
  jQuery('body').attr('class', style);

});


(function() {
    'use strict';
    window.addEventListener('load', function() {
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();