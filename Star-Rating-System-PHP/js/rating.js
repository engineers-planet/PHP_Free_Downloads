$(function() {
	$('#loginForm').on('submit', function(e){
		$.ajax({
			type: 'POST',
			url : "action.php",
			dataType: "json",
			data:$(this).serialize(),
			success: function (response) {
				if(response.success == 1) {
					$('#loginModal').modal('hide');
					$('#loggedPanel').removeClass('hidden');
					$('#loggedUser').text(response.username);

				//	$( "#rateProduct" ).removeClass('loginRequired');


					$("#ratingDetails").show();
					$("#ratingSection").show();
				} else {
					$('#loginError').show();
				}
			}
		});
		return false;
	});

	// rating form hide/show
 	$( "#rateProduct" ).click(function() {
		if($(this).hasClass('loginRequired')) {
			$('#loginModal').modal('show');
		} else {
			//$("#ratingDetails").hide();
			$("#ratingSection").show();
		}
	});
	$( "#cancelReview" ).click(function() {
		$("#ratingSection").hide();
		$("#ratingDetails").show();
	});
	// implement start rating select/deselect
	$( ".rateButton" ).click(function() {
		if($(this).hasClass('star-grey')) {
			$(this).removeClass('star-grey').addClass('star-highlight star-selected');
			$(this).prevAll('.rateButton').removeClass('star-grey').addClass('star-highlight star-selected');
			$(this).nextAll('.rateButton').removeClass('star-highlight star-selected').addClass('star-grey');
		} else {
			$(this).nextAll('.rateButton').removeClass('star-highlight star-selected').addClass('star-grey');
		}
		$("#rating").val($('.star-selected').length);  //count the num of star selected
	});
	// save review using Ajax
	$('#ratingForm').on('submit', function(event){
		event.preventDefault();
		var formData = $(this).serialize();
		$.ajax({
			type : 'POST',
			dataType: "json",
			url : 'action.php',
			data : formData,
			success:function(response){
				if(response.success == 1) {
					$("#ratingForm")[0].reset();
					window.location.reload();
				}
			}
		});
	});
});
