$(function () {
 
  $('#phone').mask('(000) 000-0000');

  // Datepicker
  $('#reservation-date').datepicker({
    dateFormat: 'yy-mm-dd',
    minDate: 0
  });

 
  toastr.options = {
    positionClass: 'toast-bottom-right',
    timeOut: 3500
  };


  $('#support-form').validate({
    rules: {
      first_name: { required: true, minlength: 2 },
      last_name:  { required: true, minlength: 2 },
      email:      { required: true, email: true },
      phone:      { required: true },
      date:       { required: false },
      topic:      { required: false },
      message:    { required: true, minlength: 10 }
    },
    errorClass:   'is-invalid',
    validClass:   'is-valid',
    errorElement: 'span',

    submitHandler: function (form) {
      // AJAX POST to support_submit.php
      $.ajax({
        url: 'support_submit.php',
        method: 'POST',
        data: $(form).serialize(),
        dataType: 'text',
        success: function (resp) {
          const name = $('#first-name').val();
          toastr.success(`Thanks, ${name}! We’ll reply ASAP.`, 'Message sent');
          form.reset();
          $('#reservation-date').datepicker('setDate', null);
        },
        error: function () {
          toastr.error('Submission failed. Please try again later.', 'Error');
        }
      });
      return false; 
    }
  });
});
