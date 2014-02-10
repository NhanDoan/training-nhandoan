$(document).ready(function () {
  $.ajax({
    url:"http://localhost/api_remote/index.php",
    type:"get",
    dataType:"json",
    error:function (jqXHR, textStatus, errorThrown) {
      alert(errorThrown);
    },
    success: function (data) {
          if (data[0] == 0) {
            $("#loginForm").show();
            $("#productForm").hide();
          } else {
            console.log('Hello user #' + data[0]);
            $("#loginForm").hide();
            $("#productForm").show();
          }
    }
  });

  /**
   * Login
   * 
   */
  $("#login").bind('click', function() {
    var _username = $("#username").val(),
        _password = $("#password").val();
    $.ajax({
      url:"http://localhost/api_remote/verify.php",
      type:"post",
      dataType:"json",
      data: {username: _username, password: _password},
      error:function (jqXHR, textStatus, errorThrown) {
        alert(errorThrown);
      },
      success: function (data) {
      	if ( data[0] == 0 ) {
			    $("#loginForm").show();
          $("#productForm").hide();
      	} else {
      		console.log('Hello user #' + data[0]);
            $("#loginForm").hide();
            $("#productForm").show();
      	}
      }
    })    
  });

  /**
   * view product
   * 
   * @return {[type]} [description]
   */
	$("#view").bind('click', function() {
    var _username = $("#username").val(),
        _password = $("#password").val();
  	$.ajax({
  		url:"http://localhost/api_remote/view.php",
  		type: "get",
  		dataType:"json",
  		error: function(jqXHR, textStatus, errorThrown) {
  			alert(errorThrown);
  		},
  		success: function(data) {

  			for( var key in data) {

         	    var _products = data[key];
             	    
				var _html = $("#view_product").html();
                $("#view_product").html( _html + 
                  "Product ID : <strong>" + _products.product_id + "</strong>"
                  + "<br> Title: <strong>" +_products.title + "</strong>"
                  + "<br> Product Type:  <strong>" +_products.type + "</strong>"
                  + "<br> SKU: <strong>" +_products.sku + "</strong>"
                  + "<br> Created: <strong>" + _products.created + "</strong>"
                  +  "<br> <a class='product' id='"+ _products.product_id +"' href='javascript:void(0)'>EDIT</a>"
                  +  "<br> <a class='delete' id='"+ _products.product_id +"' href='javascript:void(0)'>DELETE</a><hr>"

                  );
  			}

        /**
         * Delete product
         * 
         */
        $(".delete").bind('click', function() {
          var _th = $(this), _id = _th.attr('id');
          $.ajax({
            url:"http://localhost/api_remote/delete.php",
            type: "post",
            dataType:"json",
            data: {
              username: _username,
              password: _password,
              id : _id
            },

            error: function(jqXHR, textStatus, errorThrown) {
              alert(errorThrown);
            },

            success: function(data) {
              alert("Product has deleted!");

            }
          });
        })

        /**
         * Update product
         */
        $(".product").bind('click', function() {
          var _th = $(this), _id = _th.attr('id'),
            rowElement = $(this).parent().parent();
            $.ajax({
              url: "http://localhost/api_remote/edit.php",
              type: "post",
              dataType: "json",
              data: {id: _id},
              error: function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
              },

              success: function(data) {
                var _data = data;
                document.getElementById('titleProduct').innerHTML = "Update Product"
                document.getElementById('sku').value = _data.sku;
                document.getElementById('type').value = _data.type; 
                document.getElementById('title').value = _data.title; 
                document.getElementById('amount').value = _data.commerce_price.amount; 
                document.getElementById('currency_code').value = _data.commerce_price.currency_code; ;
                $("#save").bind( 'click', function() {
                  $.ajax({
                    url: "http://localhost/api_remote/save.php",
                    type: "post",
                    dataType: "json",
                    data: {
                      username: _username,
                      password: _password,
                      data_old: _data,
                      id: _id
                      , type: $("#type").val()
                      , sku: $("#sku").val()
                      , title: $("#title").val()
                      , commerce_price: {
                        amount: $("#amount").val(),
                        currency_code: $("#currency_code").val()
                      }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                      alert(errorThrown);
                    },
                    success: function (data) {

                      alert('Product has update');
                    }
                  });
                })
              }
            });
        })
  		}
  	});
	});


	/**
	 * Creating new product
   * 
	 */
	
	$("#submit").bind('click', function() {
    var _username = $("#username").val(),
        _password = $("#password").val();

		$.ajax({
			url:"http://localhost/api_remote/create.php",
			type: "post",
			dataType:"json",
			data:{
    				username: _username
            , password:  _password
    				, type: $("#type").val()
          	, sku: $("#sku").val()
          	, title: $("#title").val()
          	, commerce_price: {
            amount: $("#amount").val(),
            currency_code: $("#currency_code").val()
          }},
      error: function(jqXHR, textStatus, errorThrown) {
        alert(errorThrown);
      },
      success: function(data) {
      	alert("Produst has created and save in Store")
      },

		})
	});

});