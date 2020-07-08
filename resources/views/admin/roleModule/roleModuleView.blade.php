@extends('layouts.admin')
@section('title','Assign Module View')
@push('topasset')
{{-- top asset file --}}
@endpush


@section('content')



<div class="card text-center">
    <div class="card-header">
         Assign Role Modules View
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-md-9">

                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Module Name</th>
                            </tr>
                        </thead>
                        <tbody id="moduleAssignData">
                            


                        </tbody>
                    </table>
                </div>

            </div>




            <div class="col-md-3">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Assign New Module</h5>

                        <form id="assignRoleModuleForm">


                            <div class="form-group text-left">
                                <select class="form-control form-control-sm" name="role_id" onchange="getRoleModule(this.value)">
                                    <option value="" disabled selected>--select role--</option>
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group text-left">
                                <select class="form-control form-control-sm" name="module_id">
                                    <option value="" disabled selected>--select module--</option>
                                    @foreach ($modules as $module)
                                    <option value="{{ $module->id }}">{{ $module->name }}</option>
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

        $('#assignRoleModuleForm').submit(function () {
            event.preventDefault();
            alertify.confirm('are you sure ?', 'module will be assigned!', function () {
                Notiflix.Loading.Dots();


                $.ajax({
                    type: 'post',
                    url: '{{URl("assignNewRoleModuleInsertAjax")}}',
                    data: $('#assignRoleModuleForm').serialize(),
                    dataType: 'json',
                    success: function (data) {
                        if (typeof data.errors !== 'undefined') {
                            Notiflix.Loading.Remove();
                            alertify.error('Something Went Wrong');
                        } else if (typeof data.warning !== 'undefined') {
                            Notiflix.Loading.Remove();
                            alertify.error('Already Exists');
                        } else {
                            clearForm('assignRoleModuleForm');
                            $('#moduleAssignData').load(location.href + " #moduleAssignData>*","");
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


   

    function getRoleModule(val) {
        Notiflix.Loading.Dots();
        $.ajax({
            type: 'post',
            url: '{{URl("getRoleModuleById")}}',
            data: {
                id: val
            },
            dataType: 'html',
            success: function (data) {
                if (typeof data.errors !== 'undefined') {
                    Notiflix.Loading.Remove();
                    alertify.error('Something Went Wrong');
                } else {
                    $('#moduleAssignData').empty();
                    $('#moduleAssignData').html(data);
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
