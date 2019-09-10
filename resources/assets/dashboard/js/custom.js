(function($){
	$(document).on("submit","#add_role_form",function(e){
		e.preventDefault();

		var form = $(this);
		var action = form.attr('action');
		var method = form.attr('method');

		var formData = new FormData(form[0]);

		$.ajax({
			url: action,
			method: method,
			dataType: 'json',
			data: formData,
			contentType: false,
			cache: false,
			processData: false,
			success: function(result){
				// console.log( result );
				if( result.success == true ) {

					var viewBtn = '<a href="#" class="view_role btn btn-warning" title="View" data-id="'+result.role.id+'" data-toggle="modal" data-target="#viewRoleModal">View</a> ';
  		            var editBtn = '<a href="#" class="edit_role btn btn-info" data-id="'+result.role.id+'" data-action="/admin/role/'+result.role.id+'" title="Edit" data-toggle="modal" data-target="#editRoleModal">Edit</a> ';
  		            var deleteBtn = '<a href="#" class="delete_role btn btn-danger" title="Delete" data-id="'+result.role.id+'">Delete</a> ';
					
					$('#role_table').DataTable().row.add([
						result.role.name, viewBtn + editBtn + deleteBtn
					]).draw();

					form.trigger("reset");

					$("#addRoleModal").modal('hide');
					$('body').removeClass('modal-open');
	                $('.modal-backdrop').fadeOut();
				}
			},
			error: function(err){
				console.log( err );
			}
		});
	});

	$(document).on("click",".view_role", function(e){
		e.preventDefault();

		var id = $(this).data('id');
		// var action = $(this).data('action');

		$.ajax({
			url: '/admin/role/'+id,
			method: 'GET',
			dataType: 'json',
			data: {
				'id' : id
			},
			success: function(result){
				// console.log( result );
				if( result.success == true ){
					var form = $('#edit_role_form');
					$("#role_id").val(id);

					var role_name_html = '<div class="form-group"><label for="role_name">Name</label><p>'+result.role.name+'</p></div>';
          			var permissions_html = '<div class="form-group"><label>Permissions</label>';

					if( result.permissions.length > 0 ) {
						var listItem = '';
						$.each(result.permissions, function( index, permission ){
							listItem = listItem + '<li><label>'+permission.name+'</label>';
						});
					}

					var permissions_html = permissions_html + '<ul class="permission-list-view">'+listItem+'</ul></div>'

					$("#viewRoleModal").find(".modal-body").html(role_name_html+permissions_html);
				}
			},
			error: function( err ){
				console.log(err);
			}
		});
	});

	$(document).on("click",".edit_role", function(e){
		e.preventDefault();

		var id = $(this).data('id');
		var action = $(this).data('action');

		$.ajax({
			url: action,
			method: 'GET',
			dataType: 'json',
			data: {
				'id' : id
			},
			success: function(result){
				console.log( result );
				if( result.success == true ){
					document.getElementById("edit_role_form").reset(); 
					var form = $('#edit_role_form');
					form.find('#role_name').val("");
					form.find(".edit_permissions").each(function(i, v){
						$(this).removeAttr("checked");
					});
					$("#role_id").val(id);

					form.find('#role_name').val(result.role.name);

					if( result.permissions.length > 0 ) {
						$.each(result.permissions, function( index, permission ){
							form.find(".edit_permissions").each(function(i, v){
								if( $(this).val() == permission.id ) {
									$(this).attr('checked', 'checked');
								}
							});
						});
					}
				}
			},
			error: function( err ){
				console.log(err);
			}
		});
	});

	$(document).on("submit","#edit_role_form", function(e){
		e.preventDefault();
		var form = $(this);
		var id = $('#role_id').val();
		var action = form.attr("action");
		var method = form.find('input[name="_method"]').val();
 
		var formData = new FormData(form[0]);

		$.ajax({
			url: action,
			method: 'POST',
			dataType: 'json',
			data: formData,
			contentType: false,
			cache: false,
			processData: false,
			success: function( result ){
				// console.log( result );
				if( result.success == true ) {
					var row_id = $('#row_'+result.role.id).data("row");
					
					var viewBtn = '<a href="#" class="view_role btn btn-warning" title="View" data-id="'+result.role.id+'" data-toggle="modal" data-target="#viewRoleModal">View</a> ';
  		            var editBtn = '<a href="#" class="edit_role btn btn-info" data-id="'+result.role.id+'" data-action="/admin/role/'+result.role.id+'" title="Edit" data-toggle="modal" data-target="#editRoleModal">Edit</a> ';
  		            var deleteBtn = '<a href="#" class="delete_role btn btn-danger" title="Delete" data-id="'+result.role.id+'">Delete</a> ';
					
					$('#role_table').DataTable().row(row_id).data([
						result.role.name, viewBtn + editBtn + deleteBtn
					]).draw();

					form.trigger("reset");

					$("#editRoleModal").modal('hide');
					$('body').removeClass('modal-open');
	                $('.modal-backdrop').fadeOut();
				}
			},
			error: function( err ) {
				console.log( err );
			}
		});
	});

	$(document).on("click",".delete_role", function(e){
	    e.preventDefault();
	    Swal.fire({
	        title: 'Are you sure?',
	        text: 'You will not be able to recover this Role',
	        type: 'warning',
	        showCancelButton: true,
	        confirmButtonText: 'Yes, delete it!',
	        cancelButtonText: 'No, keep it'
	    }).then((result) => {
	        if (result.value) {
	            $.ajax({
	                url: '/admin/role/delete',
	                method: 'POST',
	                dataType: 'json',
	                data: {
	                	"_method": 'DELETE',
	                    "_token": $('meta[name="csrf-token"]').attr('content'),
	                    'role_id': $(this).data('id'),
	                },
	                success: function(result){
	                	console.log( result );
	                    if( result.success == true ) {
	                        // console.log( data );
	                        Swal.fire(
	                            'Deleted!',
	                            'Role Deleted Successfully',
	                            'success'
	                        );

	                        var row_id = $('#row_'+result.role.id).data("row");
	                        $('#role_table').DataTable().row(row_id).remove().draw();

	                        // $(".menu-container").html(data.html);

	                        // $('body').removeClass('modal-open');
	                        // $('.modal-backdrop').fadeOut();
	                    }
	                },
	                error: function(err){
	                    console.log( err );
	                }
	            });
	        } else if (result.dismiss === Swal.DismissReason.cancel) {
	            Swal.fire(
	                'Cancelled',
	                'Your imaginary file is safe :)',
	                'error'
	            )
	        }
	    })
	});

	/*
	 * Permission
	 */

	$(document).on("submit","#add_permission_form",function(e){
		e.preventDefault();

		var form = $(this);
		var action = form.attr('action');
		var method = form.attr('method');

		var formData = new FormData(form[0]);

		$.ajax({
			url: action,
			method: method,
			dataType: 'json',
			data: formData,
			contentType: false,
			cache: false,
			processData: false,
			success: function(result){
				console.log( result );
				if( result.success == true ) {

					var viewBtn = '<a href="#" class="view_permission btn btn-warning" title="View" data-id="'+result.permission.id+'" data-toggle="modal" data-target="#viewPermissionModal">View</a> ';
  		            var editBtn = '<a href="#" class="edit_permission btn btn-info" data-id="'+result.permission.id+'" data-action="/admin/permission/'+result.permission.id+'" title="Edit" data-toggle="modal" data-target="#editPermissionModal">Edit</a> ';
  		            var deleteBtn = '<a href="#" class="delete_permission btn btn-danger" title="Delete" data-id="'+result.permission.id+'">Delete</a> ';
					
					$('#permission_table').DataTable().row.add([
						result.permission.name, viewBtn + editBtn + deleteBtn
					]).draw();

					form.trigger("reset");

					$("#addPermissionModal").modal('hide');
					$('body').removeClass('modal-open');
	                $('.modal-backdrop').fadeOut();
				}
			},
			error: function(err){
				console.log( err );
			}
		});
	});

	$(document).on("click",".view_permission", function(e){
		e.preventDefault();

		var id = $(this).data('id');
		// var action = $(this).data('action');

		$.ajax({
			url: '/admin/permission/'+id,
			method: 'GET',
			dataType: 'json',
			data: {
				'id' : id
			},
			success: function(result){
				console.log( result );
				if( result.success == true ){
					var form = $('#edit_permission_form');
					$("#permission_id").val(id);

					var permission_html = '<div class="form-group"><label for="role_name">Name</label><p>'+result.permission.name+'</p></div>';

					$("#viewPermissionModal").find(".modal-body").html(permission_html);
				}
			},
			error: function( err ){
				console.log(err);
			}
		});
	});

	$(document).on("click",".edit_permission", function(e){
		e.preventDefault();

		var id = $(this).data('id');
		var action = $(this).data('action');

		$.ajax({
			url: action,
			method: 'GET',
			dataType: 'json',
			data: {
				'id' : id
			},
			success: function(result){
				console.log( result );
				if( result.success == true ){

					document.getElementById("edit_permission_form").reset(); 
					var form = $('#edit_permission_form');
					form.find('#role_name').val("");
					form.find(".edit_roles").each(function(i, v){
						$(this).removeAttr("checked");
					});
					$("#permission_id").val(id);

					form.find('#permission_name').val(result.permission.name);

					if( result.roles.length > 0 ) {
						$.each(result.roles, function( index, role ){
							form.find(".edit_roles").each(function(i, v){
								if( $(this).val() == role.id ) {
									$(this).attr('checked', 'checked');
								}
							});
						});
					}
				}
			},
			error: function( err ){
				console.log(err);
			}
		});
	});

	$(document).on("submit","#edit_permission_form", function(e){
		e.preventDefault();
		var form = $(this);
		var id = $('#permission_id').val();
		var action = form.attr("action");
		var method = form.find('input[name="_method"]').val();
 
		var formData = new FormData(form[0]);

		$.ajax({
			url: action,
			method: 'POST',
			dataType: 'json',
			data: formData,
			contentType: false,
			cache: false,
			processData: false,
			success: function( result ){
				console.log( result );
				if( result.success == true ) {
					var row_id = $('#row_'+result.permission.id).data("row");
					
					var viewBtn = '<a href="#" class="view_permission btn btn-warning" title="View" data-id="'+result.permission.id+'" data-toggle="modal" data-target="#viewPermissionModal">View</a> ';
  		            var editBtn = '<a href="#" class="edit_permission btn btn-info" data-id="'+result.permission.id+'" data-action="/admin/permission/'+result.permission.id+'" title="Edit" data-toggle="modal" data-target="#editPermissionModal">Edit</a> ';
  		            var deleteBtn = '<a href="#" class="delete_permission btn btn-danger" title="Delete" data-id="'+result.permission.id+'">Delete</a> ';
					
					$('#permission_table').DataTable().row(row_id).data([
						result.permission.name, viewBtn + editBtn + deleteBtn
					]).draw();

					form.trigger("reset");

					$("#editPermissionModal").modal('hide');
					$('body').removeClass('modal-open');
	                $('.modal-backdrop').fadeOut();
				}
			},
			error: function( err ) {
				console.log( err );
			}
		});
	});

	$(document).on("click",".delete_permission", function(e){
	    e.preventDefault();
	    Swal.fire({
	        title: 'Are you sure?',
	        text: 'You will not be able to recover this Permission',
	        type: 'warning',
	        showCancelButton: true,
	        confirmButtonText: 'Yes, delete it!',
	        cancelButtonText: 'No, keep it'
	    }).then((result) => {
	        if (result.value) {
	            $.ajax({
	                url: '/admin/permission/delete',
	                method: 'POST',
	                dataType: 'json',
	                data: {
	                	"_method": 'DELETE',
	                    "_token": $('meta[name="csrf-token"]').attr('content'),
	                    'permission_id': $(this).data('id'),
	                },
	                success: function(result){
	                	console.log( result );
	                    if( result.success == true ) {
	                        // console.log( data );
	                        Swal.fire(
	                            'Deleted!',
	                            'Permission Deleted Successfully',
	                            'success'
	                        );

	                        var row_id = $('#row_'+result.permission.id).data("row");
	                        $('#permission_table').DataTable().row(row_id).remove().draw();

	                        // $(".menu-container").html(data.html);

	                        // $('body').removeClass('modal-open');
	                        // $('.modal-backdrop').fadeOut();
	                    }
	                },
	                error: function(err){
	                    console.log( err );
	                }
	            });
	        } else if (result.dismiss === Swal.DismissReason.cancel) {
	            Swal.fire(
	                'Cancelled',
	                'Your imaginary file is safe :)',
	                'error'
	            )
	        }
	    })
	});
})(jQuery);