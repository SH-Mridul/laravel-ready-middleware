@extends('layouts.admin')
@section('title','Role')
@push('topasset')
{{-- top asset file --}}
@endpush


@section('content')



<div class="card text-center">
    <div class="card-header">
        Roles View
    </div>
    <div class="card-body">
       
        <div class="row">
            <div class="col-md-9">

                <div class="table-responsive">
                    <table class="table table-sm table-bordered" id="dataTable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Role Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="roleData">
                            @foreach($roles as $role)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{$role->name}}</td>
                                <td>
                                    @if($role->is_active == 1)
                                         <span class="badge badge-success" style="cursor: pointer"
                                             onclick="inactiveRole({{ $role->id }})">Active</span>
                                    @else
                                        
                                        <span class="badge badge-danger" style="cursor: pointer"
                                             onclick="activeRole({{ $role->id }})">Inactive</span>
                                             
                                    @endif
        
                                </td>
                                <td class="text-center">
                                    
                                    <button type="button" class="btn btn-outline-primary badge" onclick="editRole({{ $role->id }})"><i class="fas fa-pencil-alt"></i></button>
                                    <button type="button" class="btn btn-outline-danger badge" onclick="deleteRole({{ $role->id }})"><i class="far fa-trash-alt"></i></button>
                                </td>
                            </tr> 
                            @endforeach

                        </tbody>
                    </table>
                </div>
                
            </div>


                

            <div class="col-md-3">


                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Create New Role</h5>
                        
                         <form id="roleForm">

                             <div class="form-group text-left">
                                 <input type="text" class="form-control form-control-sm" name="name" placeholder="role name..">
                             </div>
                             <button type="submit" class="btn btn-secondary btn-sm btn-block">Save</button>

                         </form>


                        
                    </div>
                </div>

               
            </div>


        </div>
        
    </div>
</div>





<div class="modal fade" id="update-role-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <p class="modal-title" id="exampleModalLongTitle">Update Role</p>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <form id="role_update_form">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Role Name</label>
                         <input type="hidden" name="id" id="role_id">
                        <input type="text" class="form-control form-control-sm" id="role_name" name="name"
                            placeholder="name">
                    </div>
                    
                

            </div>
            <div class="modal-footer">

                <button type="submit" class="btn badge badge-primary"><i class="fas fa-share-square"></i></button>
                <button type="button" class="btn badge badge-secondary" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </form>
            </div>
        </div>
    </div>
</div>





<script>

$(document).ready(function(){
   
    $('#roleForm').submit(function () {
            event.preventDefault();
             alertify.confirm('Are You Sure ?', 'Role Will Be Created', function () {
             Notiflix.Loading.Dots();  
            

            $.ajax({
                type: 'post',
                url: '{{URl("roleInsertAjax")}}',
                data: $('#roleForm').serialize(),
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                        
                        Notiflix.Loading.Remove();
                        alertify.error('Something Went Wrong');
                    } else if (typeof data.warning !== 'undefined') {
                        clearForm('roleForm');
                         Notiflix.Loading.Remove();
                        alertify.error('Role Already Exists');
                    } else {
                        clearForm('roleForm');
                        $('#roleData').load(location.href+" #roleData>*","");
                        Notiflix.Loading.Remove(1000);
                        setTimeout(function () {
                           alertify.success(data);
                        }, 1500)
                    }
                },

                error: function (jqXHR, exception) {
                    Notiflix.Loading.Remove();
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.Verify Network.';
                        alertify.warning(msg);

                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                        alertify.warning(msg);
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                        alertify.warning(msg);
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                        alertify.warning(msg);
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                        alertify.warning(msg);
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                        alertify.warning(msg);
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                        alertify.warning(msg);
                    }

                }


            });

             }, function () {
             alertify.error('Cancel')
             });
        });





        $('#role_update_form').submit(function () {
            event.preventDefault();
             alertify.confirm('Are You Sure ?', 'Role Will Be Created', function () {
             Notiflix.Loading.Dots();  
            
            $.ajax({
                type: 'post',
                url: '{{URl("roleUpdateAjax")}}',
                data: $('#role_update_form').serialize(),
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                        Notiflix.Loading.Remove();
                        alertify.error(data.errors.name[0]);
                    } else {
                        clearForm('role_update_form');
                        $('#update-role-modal').modal('hide');
                        $('#roleData').load(location.href+" #roleData>*","");
                        Notiflix.Loading.Remove(1000);
                        setTimeout(function () {
                           alertify.success(data);
                        }, 1500)
                    }
                },

                error: function (jqXHR, exception) {
                    Notiflix.Loading.Remove();
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.Verify Network.';
                        alertify.warning(msg);

                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                        alertify.warning(msg);
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                        alertify.warning(msg);
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                        alertify.warning(msg);
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                        alertify.warning(msg);
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                        alertify.warning(msg);
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                        alertify.warning(msg);
                    }

                }


            });

             }, function () {
             alertify.error('Cancel')
             });
        });
    });


    function editRole(id){
        $.ajax({
                type: 'post',
                url: '{{URl("getRoleInfoDetailsAjax")}}',
                data: {
                    id:id
                },
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                        Notiflix.Loading.Remove();
                        alertify.error('Something Went Wrong');
                    }else {
                        $('#role_id').val(data.id)
                        $('#role_name').val(data.name)
                         $('#update-role-modal').modal('show');
                    }
                },

                error: function (jqXHR, exception) {
                    Notiflix.Loading.Remove();
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.Verify Network.';
                        alertify.warning(msg);

                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                        alertify.warning(msg);
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                        alertify.warning(msg);
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                        alertify.warning(msg);
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                        alertify.warning(msg);
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                        alertify.warning(msg);
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                        alertify.warning(msg);
                    }

                }


            });
    }


    function deleteRole(id){
        event.preventDefault();
             alertify.confirm('Are You Sure ?', 'Role Will Be Deleted', function () {
             Notiflix.Loading.Dots();  
            
            $.ajax({
                type: 'post',
                url: '{{URl("roleDeleteAjax")}}',
                data:{
                    id:id
                },
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                        Notiflix.Loading.Remove();
                        alertify.error('Something Went Wrong');
                    }else {
                        $('#roleData').load(location.href+" #roleData>*","");
                        Notiflix.Loading.Remove(1000);
                        setTimeout(function () {
                           alertify.success(data);
                        }, 1500)
                    }
                },

                error: function (jqXHR, exception) {
                    Notiflix.Loading.Remove();
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.Verify Network.';
                        alertify.warning(msg);

                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                        alertify.warning(msg);
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                        alertify.warning(msg);
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                        alertify.warning(msg);
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                        alertify.warning(msg);
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                        alertify.warning(msg);
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                        alertify.warning(msg);
                    }

                }


            });

             }, function () {
             alertify.error('Cancel')
             });
    }


    function activeRole(id) {
         event.preventDefault();
             alertify.confirm('Are You Sure ?', 'Role Will Be Active', function () {
             Notiflix.Loading.Dots();  
            $.ajax({
                type: 'post',
                url: '{{URl("activeRoleAjax")}}',
                data: {
                    id:id
                },
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                        Notiflix.Loading.Remove();
                        alertify.error('Something Went Wrong');
                    }else {
                        $('#roleData').load(location.href+" #roleData>*","");
                        Notiflix.Loading.Remove(1000);
                        setTimeout(function () {
                           alertify.success(data);
                        }, 1500)
                    }
                },

                error: function (jqXHR, exception) {
                    Notiflix.Loading.Remove();
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.Verify Network.';
                        alertify.warning(msg);

                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                        alertify.warning(msg);
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                        alertify.warning(msg);
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                        alertify.warning(msg);
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                        alertify.warning(msg);
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                        alertify.warning(msg);
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                        alertify.warning(msg);
                    }

                }
            });


          }, function () {
          alertify.error('Cancel')
          });
        
    }







    function inactiveRole(id) {
         event.preventDefault();
             alertify.confirm('Are You Sure ?', 'Role Will Be Inactive!', function () {
             Notiflix.Loading.Dots();  

            $.ajax({
                type: 'post',
                url: '{{URl("inactiveRoleAjax")}}',
                data: {
                    id : id
                },
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                        Notiflix.Loading.Remove();
                        alertify.error('Something Went Wrong');
                    }else {
                        $('#roleData').load(location.href+" #roleData>*","");
                        Notiflix.Loading.Remove(1000);
                        setTimeout(function () {
                           alertify.success(data);
                        }, 1500)
                    }
                },

                error: function (jqXHR, exception) {
                    Notiflix.Loading.Remove();
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.Verify Network.';
                        alertify.warning(msg);

                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                        alertify.warning(msg);
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                        alertify.warning(msg);
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                        alertify.warning(msg);
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                        alertify.warning(msg);
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                        alertify.warning(msg);
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                        alertify.warning(msg);
                    }

                }
            });


          }, function () {
          alertify.error('Cancel')
          });
        
    }








      function clearForm(id){
        $( "#"+id).trigger( "reset" );
      }  

</script>

@endsection

@push('footerasset')
{{-- footer asset --}}
@endpush
