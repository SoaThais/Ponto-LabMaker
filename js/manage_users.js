$(document).ready(function(){
  $(document).on('click', '#user_add', function(){
    var user_id = $('#user_id2').val();
    var name = $('#name2').val();
    var email = $('#email2').val();
    var dev_uid = $('#dev_uid').val();

    console.log(dev_uid);

    var dev_uid = $('#dev_sel2 option:selected').val();
    
    $.ajax({
      url: 'manage_users_conf.php',
      type: 'POST',
      data: {
        'Add': 1,
        'user_id': user_id,
        'name': name,
        'email': email,
        'dev_uid': dev_uid,
      },
      success: function(response){

        if (response == 1) {
          $('#user_id2').val('');
          $('#name2').val('');
          $('#email2').val('');

          $('#dev_sel2').val('0');
          $("#add_user").modal("hide");
          $('#add_user')[0].reset();
          $("#alert-password-text3").hide();
          $("#alert-password-icon3").hide();
        }
        else{
          $("#alert-password-text3").show();
          $("#alert-password-text3").html(response);
          $("#alert-password-icon3").show();
          $("#alert-password-icon3").html("!");
          $("#alert-password-icon3").css("backgroundColor", "#FF0000");
          $("#alert-password-icon3").css("border-radius", "50%");
          $("#alert-password-icon3").css("width", "16px");
          $("#alert-password-icon3").css("height", "16px");
          $("#alert-password-icon3").css("justify-content", "center");
          $("#alert-password-icon3").css("align-items", "center");
          $("#alert-password-icon3").css("text-align", "center");
        }
        
        $.ajax({
          url: "manage_users_up.php"
          }).done(function(data) {
          $('#manage_users').html(data);
        });
      }
    });
  });

  $(document).on('click', '#user_upd', function(){
    var user_id = $('#user_id').val();
    var name = $('#name').val();
    var email = $('#email').val();
    var dev_uid = $('#dev_uid').val();
    var dev_uid = $('#dev_sel option:selected').val();

    console.log(dev_uid);

    $.ajax({
      url: 'manage_users_conf.php',
      type: 'POST',
      data: {
        'Update': 1,
        'user_id': user_id,
        'name': name,
        'email': email,
        'dev_uid': dev_uid,
      },
      success: function(response){

        if (response == 1) {
          $('#user_id').val('');
          $('#name').val('');
          $('#email').val('');

          $('#dev_sel').val('0');
          $("#update_user").modal("hide");
          $('#update_user')[0].reset();
          $("#alert-password-text2").hide();
          $("#alert-password-icon2").hide();
        }
        else{
          $("#alert-password-text2").show();
          $("#alert-password-text2").html(response);
          $("#alert-password-icon2").show();
          $("#alert-password-icon2").html("!");
          $("#alert-password-icon2").css("backgroundColor", "#FF0000");
          $("#alert-password-icon2").css("border-radius", "50%");
          $("#alert-password-icon2").css("width", "16px");
          $("#alert-password-icon2").css("height", "16px");
          $("#alert-password-icon2").css("justify-content", "center");
          $("#alert-password-icon2").css("align-items", "center");
          $("#alert-password-icon2").css("text-align", "center");
        }
        
        $.ajax({
          url: "manage_users_up.php"
          }).done(function(data) {
          $('#manage_users').html(data);
        });
      }
    });   
  });

  $(document).on('click', '.user_rmo', function(){
    var card_uid = $(this).attr("id");

    $.ajax({
      url: 'manage_users_conf.php',
      type: 'GET',
      data: {
      'select': 1,
      'card_uid': card_uid,
      },
      success: function(response){

        if (response == "Database Error") {
          bootbox.alert({
            message: response,
            closeButton: false,
            buttons: {
              ok: {
                label: 'OK',
                className: 'btn-success'
              }
            }
          }).find('.modal-dialog').addClass('modal-dialog-centered');
        }
        else {
          var user_id = {
            User_id : []
          };
          var user_name = {
            User_name : []
          };
          var user_email = {
            User_email : []
          };
          var user_dev = {
            User_dev : []
          };

          var len = response.length;

          for (var i = 0; i < len; i++) {
              user_id.User_id.push(response[i].id);
              user_name.User_name.push(response[i].username);
              user_email.User_email.push(response[i].email);
              user_dev.User_dev.push(response[i].device_uid);
          }

          if (user_dev.User_dev == "All") {
            user_dev.User_dev = 0;
          }
          
          $('#user_id').val(user_id.User_id);
          $('#name').val(user_name.User_name);
          $('#email').val(user_email.User_email);
          $('#dev_sel').val(user_dev.User_dev);

          var user_id = $('#user_id').val();

          bootbox.confirm({
            message: "Delete User?",
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
                $.ajax({
                  url: 'manage_users_conf.php',
                  type: 'POST',
                  data: {
                    'delete': 1,
                    'user_id': user_id,
                  },
                  success: function(response){

                    if (response == 1) {
                      $('#user_id').val('');
                      $('#name').val('');
                      $('#email').val('');
                      $('#dev_sel').val('0');
                    }
                    else {
                      bootbox.alert({
                        message: response,
                        closeButton: false,
                        buttons: {
                          ok: {
                            label: 'OK',
                            className: 'btn-success'
                          }
                        }
                      }).find('.modal-dialog').addClass('modal-dialog-centered');
                    }
                    
                    $.ajax({
                      url: "manage_users_up.php"
                      }).done(function(data) {
                      $('#manage_users').html(data);
                    });
                  }
                });
              }
            }
          }).find('.modal-dialog').addClass('modal-dialog-centered');;
        }
      }
    });
  });

  $(document).on('click', '.select_btn', function(){
    var card_uid = $(this).attr("id");

    $.ajax({
      url: 'manage_users_conf.php',
      type: 'GET',
      data: {
      'select': 1,
      'card_uid': card_uid,
      },
      success: function(response){

        if (response == "Database Error") {
          bootbox.alert({
            message: response,
            closeButton: false,
            buttons: {
              ok: {
                label: 'OK',
                className: 'btn-success'
              }
            }
          }).find('.modal-dialog').addClass('modal-dialog-centered');
        }
        else {
          var user_id = {
            User_id : []
          };
          var user_name = {
            User_name : []
          };
          var user_email = {
            User_email : []
          };
          var user_dev = {
            User_dev : []
          };

          var len = response.length;

          for (var i = 0; i < len; i++) {
              user_id.User_id.push(response[i].id);
              user_name.User_name.push(response[i].username);
              user_email.User_email.push(response[i].email);
              user_dev.User_dev.push(response[i].device_uid);
          }

          if (user_dev.User_dev == "All") {
            user_dev.User_dev = 0;
          }
          
          $('#user_id').val(user_id.User_id);
          $('#name').val(user_name.User_name);
          $('#email').val(user_email.User_email);
          $('#dev_sel').val(user_dev.User_dev);

          $("#update_user").modal("show");
        }
      }
    });
  });

  $(document).on('click', '.select_btn2', function(){
    var card_uid = $(this).attr("id");

    $.ajax({
      url: 'manage_users_conf.php',
      type: 'GET',
      data: {
      'select': 1,
      'card_uid': card_uid,
      },
      success: function(response){

        if (response == "Database Error") {
          bootbox.alert({
            message: response,
            closeButton: false,
            buttons: {
              ok: {
                label: 'OK',
                className: 'btn-success'
              }
            }
          }).find('.modal-dialog').addClass('modal-dialog-centered');
        }
        else {
          var user_id = {
            User_id : []
          };
          var user_name = {
            User_name : []
          };
          var user_email = {
            User_email : []
          };
          var user_dev = {
            User_dev : []
          };

          var len = response.length;

          console.log(response);

          for (var i = 0; i < len; i++) {
              user_id.User_id.push(response[i].id);
              user_name.User_name.push(response[i].username);
              user_email.User_email.push(response[i].email);
              user_dev.User_dev.push(response[i].device_uid);
          }

          if (user_dev.User_dev == "All") {
            user_dev.User_dev = 0;
          }
          
          $('#user_id2').val(user_id.User_id);
          $('#name2').val(user_name.User_name);
          $('#email2').val(user_email.User_email);
          $('#dev_sel2').val(user_dev.User_dev);

          $("#add_user").modal("show");
        }
      }
    });
  });
});