$(document).ready(function(){

	//Add Device 
	$(document).on('click', '#dev_add', function(){

		var dev_name = $('#dev_name').val();

		$.ajax({
			url: 'dev_config.php',
			type: 'POST',
			data: {
				'dev_add': 1,
				'dev_name': dev_name,
			},
			success: function(response){
				$('#dev_name').val('');

				if (response == 1) {	
					$('#new-device').modal('hide');
					$("#alert-name-device").hide();
					$("#alert-name-device-icon").hide();
                    $('#form_add_device')[0].reset();
				}
				else {
					$("#alert-name-device").show();
					$('#alert-name-device').html(response);
					$("#alert-name-device-icon").show();
                    $("#alert-name-device-icon").html("!");
                    $("#alert-name-device-icon").css("backgroundColor", "#FF0000");
                    $("#alert-name-device-icon").css("border-radius", "50%");
                    $("#alert-name-device-icon").css("width", "16px");
                    $("#alert-name-device-icon").css("height", "16px");
                    $("#alert-name-device-icon").css("justify-content", "center");
                    $("#alert-name-device-icon").css("align-items", "center");
                    $("#alert-name-device-icon").css("text-align", "center");
				}

				$.ajax({
					url: "dev_up.php",
					type: 'POST',
					data: {
						'dev_up': 1,
					}
				}).done(function(data) {
					$('#devices').html(data);
				});
			}
		});
	});

	//Device Token update
	$(document).on('click', '.dev_uid_up', function(){

		var el = this;
		var dev_id = $(this).data('id');

		bootbox.confirm({
			message: "Update Device Token?", 
			buttons: {
				confirm: {
					label: 'Ok',
					className: 'btn-success'
				},
				cancel: {
					label: 'Cancel',
					className: 'btn-secondary'
				}
			},
			callback: function(result) {
				if(result){
					// AJAX Request
					$.ajax({
					url: 'dev_config.php',
					type: 'POST',
					data: { 
						'dev_uid_up': 1,
						'dev_id_up': dev_id,
					},
					success: function(response){

						$(el).closest('tr').css('background','#5cb85c');
						$(el).closest('tr').fadeOut(300,function(){
							$(this).show();
						});
						if(response == 1){			    
							// bootbox.alert({
							// 	message: 'Device Token Updated Successfully',
							// 	closeButton: false,
							// 	buttons: {
							// 		ok: {
							// 			label: 'OK',
							// 			className: 'btn-success'
							// 		}
							// 	}
							// }).find('.modal-dialog').addClass('modal-dialog-centered');

							$.ajax({
								url: "dev_up.php",
								type: 'POST',
								data: {
								'dev_up': 1,
								}
								}).done(function(data) {
								$('#devices').html(data);
							});
						}
						else {
							bootbox.alert({
								message: 'Device Token Not Updated. ' + response,
								closeButton: false,
								buttons: {
									ok: {
										label: 'OK',
										className: 'btn-success'
									}
								}
							}).find('.modal-dialog').addClass('modal-dialog-centered');
						}
					}
					});
				}
			}
		}).find('.modal-dialog').addClass('modal-dialog-centered');
	});

	//Delete Device
	$(document).on('click', '.dev_del', function(){

		var el = this;
		var deleteid = $(this).data('id');

		bootbox.confirm({
			message: "Delete Device?", 
			buttons: {
				confirm: {
					label: 'Ok',
					className: 'btn-success'
				},
				cancel: {
					label: 'Cancel',
					className: 'btn-secondary'
				}
			},
			callback: function(result) {
				if(result){
					// AJAX Request
					$.ajax({
					url: 'dev_config.php',
					type: 'POST',
					data: { 
						'dev_del': 1,
						'dev_sel': deleteid,
					},
					success: function(response){

						// Removing row from HTML Table
						if(response == 1){
							$(el).closest('tr').css('background','#d9534f');
							$(el).closest('tr').fadeOut(800, function(){
								$(this).remove();
							});

							$.ajax({
								url: "dev_up.php",
								type: 'POST',
								data: {
									'dev_up': 1,
								}
								}).done(function(data) {
								$('#devices').html(data);
							});
						}
						else{
							bootbox.alert({
								message: 'Device not deleted. ' + response,
								closeButton: false,
								buttons: {
									ok: {
										label: 'OK',
										className: 'btn-success'
									}
								}
							}).find('.modal-dialog').addClass('modal-dialog-centered');
						}
					}
					});
				}
			}
		}).find('.modal-dialog').addClass('modal-dialog-centered');
	});

	//Device Mode
	$(document).on('click', '.mode_sel', function(){

		var el = this;
    	var dev_mode = $(this).attr("value");
		var dev_id = $(this).data('id');

		bootbox.confirm({
			message: "Change Device Mode?", 
			buttons: {
				confirm: {
					label: 'Ok',
					className: 'btn-success'
				},
				cancel: {
					label: 'Cancel',
					className: 'btn-secondary'
				}
			},
			callback: function(result) {
				if(result) {
						// AJAX Request
						$.ajax({
							url: 'dev_config.php',
							type: 'POST',
							data: { 
								'dev_mode_set': 1,
								'dev_mode': dev_mode,
								'dev_id': dev_id,
							},
							success: function(response) {
								if(response == 1){
									$(el).closest('tr').css('background','#5cb85c');
									$(el).closest('tr').fadeOut(300, function(){
										$(this).show();
									});

									$.ajax({
										url: "dev_up.php",
										type: 'POST',
										data: {
										'dev_up': 1,
										}
									}).done(function(data) {
										$('#devices').html(data);
									});

									// bootbox.alert({
									// 	message: 'Device Mode Changed',
									// 	closeButton: false,
									// 	buttons: {
									// 		ok: {
									// 			label: 'OK',
									// 			className: 'btn-success'
									// 		}
									// 	}
									// }).find('.modal-dialog').addClass('modal-dialog-centered');
								}
								else{
									bootbox.alert({
										message: 'Device Mode Not Changed. ' + response,
										closeButton: false,
										buttons: {
											ok: {
												label: 'OK',
												className: 'btn-success'
											}
										}
									}).find('.modal-dialog').addClass('modal-dialog-centered');
								}
							}
						});
				}
				else {
					$.ajax({
						url: "dev_up.php",
						type: 'POST',
						data: {
							'dev_up': 1,
						}
						}).done(function(data) {
							$('#devices').html(data);
					});
				}
			}
		}).find('.modal-dialog').addClass('modal-dialog-centered');
	});
});