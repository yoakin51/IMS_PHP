$('#sug-form').submit(function (e) {
    var formData = {
        'title': $('.product-input').map(function () {
            return $(this).val();
        }).get()
    };

    // process the form
    $.ajax({
        type: 'POST',
        url: '../test/ajax.php',
        data: formData,
        dataType: 'json',
        encode: true
    })
        .done(function (data) {
            // console.log(data);
            $('#product_info').append(data).show(); // Append the new results
            total();
            $('.datePicker').datepicker('update', new Date());
        })
        .fail(function () {
            $('#product_info').html('Error fetching data').show();
        });

    e.preventDefault();
});

// Add new input field dynamically
$('#product-inputs').on('click', '.btn-primary', function (e) {
    e.preventDefault();
    var newInput = $('.product-input:first').clone();
    newInput.val('');
    $('#product-inputs').append(newInput);
});

