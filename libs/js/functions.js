
function suggetion() {

     $('#sug_input').keyup(function(e) {

         var formData = {
             'product_name' : $('input[name=title]').val()
         };

         if(formData['product_name'].length >= 1){

           // process the form
           $.ajax({
               type        : 'POST',
               url         : '../settings/ajax.php',
               data        : formData,
               dataType    : 'json',
               encode      : true
           })
               .done(function(data) {
                   //console.log(data);
                   $('#result').html(data).fadeIn();
                   $('#result li').click(function() {

                     $('#sug_input').val($(this).text());
                     $('#result').fadeOut(500);

                   });

                   $("#sug_input").blur(function(){
                     $("#result").fadeOut(500);
                   });

               });

         } else {

           $("#result").hide();

         };

         e.preventDefault();
     });

 }
  $('#sug-form').submit(function(e) {
      var formData = {
          'p_name' : $('input[name=title]').val()
      };
        // process the form
        $.ajax({
            type        : 'POST',
            url         : '../settings/ajax.php',
            data        : formData,
            dataType    : 'json',
            encode      : true
        })
            .done(function(data) {
                //console.log(data);
                $('#product_info').html(data).show();
                total();
                $('.datePicker').datepicker('update', new Date());

            }).fail(function() {
                $('#product_info').html(data).show();
            });
      e.preventDefault();
  });
  function total(){
    $('#product_info input').change(function(e)  {
            var price = +$('input[name=price]').val() || 0;
            var qty   = +$('input[name=quantity]').val() || 0;
            var total = qty * price ;
                $('input[name=total]').val(total.toFixed(2));
    });
  }

$(document).ready(function () {

    //tooltip
    $('[data-toggle="tooltip"]').tooltip();

    $('.submenu-toggle').click(function () {
        $(this).parent().children('ul.submenu').toggle(200);
    });
    //suggetion for finding product names
    suggetion();
    // Callculate total ammont
    total();

    $('.datepicker')
        .datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true,
            autoclose: true
        });
      
});      



    // Common JavaScript functions
    document.addEventListener("DOMContentLoaded", function () {
      const openModalBtns = document.querySelectorAll(".openModalBtn");
  
      openModalBtns.forEach(function (btn) {
        btn.addEventListener("click", function () {
          // Get the value from the button's data-value attribute
          const buttonValue = btn.getAttribute("data-value");
  
          // Get the modal ID from the button's data-modal-id attribute
          const modalId = btn.getAttribute("data-modal-id");
  
          // Get the URL from the button's data-url attribute
          const url = btn.getAttribute("data-url");
  
          // Make an AJAX request to dynamically fetch content based on the button value
          makeAjaxRequest(url, { buttonValue, modalId }, displayResultModal);
        });
      });
    });
  
    function makeAjaxRequest(url, data, callback) {
      const xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
          // Call the provided callback function with the response text
          callback(xhr.responseText, data);
        }
      };
  
      // Construct a query string from the data object
      const queryString = Object.keys(data)
        .map(key => `${encodeURIComponent(key)}=${encodeURIComponent(data[key])}`)
        .join("&");
  
      // Append the query string to the URL
      const fullUrl = url + "?" + queryString;
  
      xhr.open("GET", fullUrl, true);
      xhr.send();
    }
  
    function displayResultModal(result, data) {
      // Get the modalContent and modal elements based on modal ID
      const modalContentId = `modalContent-${data.modalId}`;
      const modalContent = document.getElementById(modalContentId);
      const modalId = `modal${data.modalId}`;
      const modal = document.getElementById(modalId);
  
      // Check if the elements are found
      if (modalContent && modal) {
        modalContent.innerHTML = result;
  
        // Display the modal
        modal.style.display = "flex";
      } else {
        console.error(`Modal content or modal element not found for ID: ${modalContentId}`);
      }
    }
  
    function closeModal(modalId) {
      const modal = document.getElementById(`modal${modalId}`);
      // Check if the modal element is found
      if (modal) {
        modal.style.display = "none";
      } else {
        console.error(`Modal element not found for ID: modal${modalId}`);
      }
    }
  
    function printModal(modalId) {
      const modalContent = document.getElementById(`modalContent-${modalId}`);
    
      // Check if the modal content element is found
      if (modalContent) {
        const printWindow = window.open('', '_blank');
        printWindow.document.open();
        printWindow.document.write('<html><head><title>Print</title></head><body>' + modalContent.innerHTML + '</body></html>');
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
      } else {
        console.error(`Modal content element not found for ID: modalContent-${modalId}`);
      }
    }
 
  