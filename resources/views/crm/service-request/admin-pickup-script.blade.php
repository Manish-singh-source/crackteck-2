
        // Admin Pickup Action Form Submission
        $(document).ready(function() {
            $('#adminPickupActionForm').on('submit', function(e) {
                e.preventDefault();

                var action = $('#admin_action').val();
                if (!action) {
                    alert('Please select an action');
                    return;
                }

                if (!confirm('Are you sure you want to ' + action + ' this pickup request?')) {
                    return;
                }

                var formData = $(this).serialize();
                var submitBtn = $(this).find('button[type="submit"]');
                var originalBtnText = submitBtn.html();

                submitBtn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin"></i> Processing...');

                $.ajax({
                    url: "{{ route('service-request.pickup-admin-action') }}",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        submitBtn.prop('disabled', false).html(originalBtnText);

                        if (response.success) {
                            alert('Pickup request ' + action + ' successfully!');
                            location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false).html(originalBtnText);
                        console.error('Admin Action Error:', xhr);
                        const error = xhr.responseJSON?.message ||
                            'Error processing admin action. Please try again.';
                        alert(error);
                    }
                });
            });
        });
