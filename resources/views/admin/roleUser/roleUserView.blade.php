@extends('layouts.admin')
@section('title','Assign Role View')
@push('topasset')
{{-- top asset file --}}
@endpush


@section('content')



<div class="card text-center">
    <div class="card-header">
         User Role Assign View
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-md-9">

                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Role Name</th>
                            </tr>
                        </thead>
                        <tbody id="roleAssignData">
                            


                        </tbody>
                    </table>
                </div>

            </div>




            <div class="col-md-3">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Assign New Role</h5>

                        <form id="assignRoleForm">

                            <div class="form-group text-left">
                                <select class="form-control form-control-sm" name="user_id" onchange="getUserRole(this.value)">
                                    <option value="" disabled selected>--select user--</option>
                                    @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group text-left">
                                <select class="form-control form-control-sm" name="role_id">
                                    <option value="" disabled selected>--select role--</option>
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach

                                </select>
                            </div>


                            <button type="submit" class="btn btn-secondary btn-sm btn-block">Save</button>

                        </form>



                    </div>
                </div>


            </div>


        </div>

    </div>
</div>







<script>
    $(document).ready(function () {

        $('#assignRoleForm').submit(function () {
            event.preventDefault();
            alertify.confirm('are you sure ?', 'role will be assigned!', function () {
                Notiflix.Loading.Dots();


                $.ajax({
                    type: 'post',
                    url: '{{URl("userNewRoleAssignInsertAjax")}}',
                    data: $('#assignRoleForm').serialize(),
                    dataType: 'json',
                    success: function (data) {
                        if (typeof data.errors !== 'undefined') {
                            Notiflix.Loading.Remove();
                            alertify.error('Something Went Wrong');
                        } else if (typeof data.warning !== 'undefined') {
                            Notiflix.Loading.Remove();
                            alertify.error('Already Exists');
                        } else {
                            clearForm('assignRoleForm');
                            $('#roleAssignData').load(location.href + " #roleAssignData>*","");
                            Notiflix.Loading.Remove(1000);
                            $('#user').val('');
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


   


    function deleteAssignedRole(id) {
        event.preventDefault();
        alertify.confirm('are you sure ?', 'route will be deleted', function () {
            Notiflix.Loading.Dots();

            $.ajax({
                type: 'post',
                url: '{{URl("routeDeleteAjax")}}',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                        Notiflix.Loading.Remove();
                        alertify.error('Something Went Wrong');
                    } else {
                        $('#routeData').load(location.href + " #routeData>*", "");
                        Notiflix.Loading.Remove(1000);
                        $('#module').val('');
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
                        $('#roleInfo').load(location.href + " #roleInfo>*", "");
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
                        $('#roleInfo').load(location.href + " #roleInfo>*", "");
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



    function getUserRole(val) {
        Notiflix.Loading.Dots();
        $.ajax({
            type: 'post',
            url: '{{URl("getUserRoleById")}}',
            data: {
                id: val
            },
            dataType: 'html',
            success: function (data) {
                if (typeof data.errors !== 'undefined') {
                    Notiflix.Loading.Remove();
                    alertify.error('Something Went Wrong');
                } else {
                    $('#roleAssignData').empty();
                    $('#roleAssignData').html(data);
                    Notiflix.Loading.Remove();
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






    function clearForm(id) {
        $("#" + id).trigger("reset");
    }
</script>

@endsection

@push('footerasset')
{{-- footer asset --}}
@endpush
