@extends('layouts.admin')
@section('title','Assigned Role View')
@push('topasset')
{{-- top asset file --}}
@endpush


@section('content')



<div class="card text-center">
    <div class="card-header">
         User Assigned Role View
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-md-12">

                <div class="table-responsive">
                    <table class="table table-sm table-bordered" id="dataTable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">User Name</th>
                                <th scope="col">Roles</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody id="roleData">
                
                            @foreach($users as $user)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{$user->name}}</td>

                                <td>
                                    @foreach($user->roles as $role)
                                        <span class="badge badge-primary" style="cursor:pointer" onclick="deleteAssignedRole({{$role->id}})"><i class="far fa-times-circle"></i> {{$role->role->name}}</span>
                                    @endforeach
                                
                                </td>
                            
                                <td>
                                    @foreach($user->roles as $role)
                                        @if($role->is_active == 1)
                                            <span class="badge badge-success" style="cursor: pointer" onclick="inactiveAssignedRole({{ $role->id }})">Active</span>
                                        @else  
                                            <span class="badge badge-danger" style="cursor: pointer" onclick="activeAssignedRole({{ $role->id }})">Inactive</span>
                                        @endif
                                    @endforeach
                                </td>
                
                            </tr> 
                            @endforeach 
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</div>







<script>
   
    function deleteAssignedRole(id) {
        event.preventDefault();
        alertify.confirm('are you sure ?', 'role will be deleted', function () {
            Notiflix.Loading.Dots();

            $.ajax({
                type: 'post',
                url: '{{URl("assignedUserRoleDeleteAjax")}}',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                        Notiflix.Loading.Remove();
                        alertify.error('Something Went Wrong');
                    } else {
                        $('#roleData').load(location.href + " #roleData>*", "");
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





    function activeAssignedRole(id) {
        event.preventDefault();
        alertify.confirm('are you sure ?', 'role will be active', function () {
            Notiflix.Loading.Dots();
            $.ajax({
                type: 'post',
                url: '{{URl("activeAssignedRoleAjax")}}',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                        Notiflix.Loading.Remove();
                        alertify.error('Something Went Wrong');
                    } else {
                        $('#roleData').load(location.href + " #roleData>*", "");
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







    function inactiveAssignedRole(id) {
        event.preventDefault();
        alertify.confirm('are you sure ?', 'role will be inactive!', function () {
            Notiflix.Loading.Dots();

            $.ajax({
                type: 'post',
                url: '{{URl("inactiveAssignedRoleAjax")}}',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                        Notiflix.Loading.Remove();
                        alertify.error('Something Went Wrong');
                    } else {
                        $('#roleData').load(location.href + " #roleData>*", "");
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



    

</script>

@endsection

@push('footerasset')
{{-- footer asset --}}
@endpush
