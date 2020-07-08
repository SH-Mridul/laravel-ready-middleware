@extends('layouts.admin')
@section('title','Assigned Role View')
@push('topasset')
{{-- top asset file --}}
@endpush


@section('content')



<div class="card text-center">
    <div class="card-header">
          Assigned Module View
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-md-12">

                <div class="table-responsive">
                    <table class="table table-sm table-bordered" id="dataTable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Role Name</th>
                                <th scope="col">Modules</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody id="moduleData">
                
                            @foreach($roles as $role)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{$role->name}}</td>

                                <td>
                                    @foreach($role->modules as $module)
                                        <span class="badge badge-primary" style="cursor:pointer" onclick="deleteAssignedModule({{$module->id}})"><i class="far fa-times-circle"></i> {{$module->module->name}}</span>
                                    @endforeach
                                
                                </td>
                            
                                <td>
                                    @foreach($role->modules as $module)
                                        @if($module->is_active == 1)
                                            <span class="badge badge-success" style="cursor: pointer" onclick="inactiveAssignedModule({{ $module->id }})">Active</span>
                                        @else  
                                            <span class="badge badge-danger" style="cursor: pointer" onclick="activeAssignedModule({{ $module->id }})">Inactive</span>
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
   
    function deleteAssignedModule(id) {
        event.preventDefault();
        alertify.confirm('are you sure ?', 'module will be deleted', function () {
            Notiflix.Loading.Dots();

            $.ajax({
                type: 'post',
                url: '{{URl("assignedRoleModuleDeleteAjax")}}',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                        Notiflix.Loading.Remove();
                        alertify.error('Something Went Wrong');
                    } else {
                        $('#moduleData').load(location.href + " #moduleData>*", "");
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





    function activeAssignedModule(id) {
        event.preventDefault();
        alertify.confirm('are you sure ?', 'module will be active', function () {
            Notiflix.Loading.Dots();
            $.ajax({
                type: 'post',
                url: '{{URl("activeAssignedModuleAjax")}}',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                        Notiflix.Loading.Remove();
                        alertify.error('Something Went Wrong');
                    } else {
                        $('#moduleData').load(location.href + " #moduleData>*", "");
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





    

  


    function inactiveAssignedModule(id) {
        event.preventDefault();
        alertify.confirm('are you sure ?', 'module will be inactive!', function () {
            Notiflix.Loading.Dots();

            $.ajax({
                type: 'post',
                url: '{{URl("inactiveAssignedModuleAjax")}}',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                        Notiflix.Loading.Remove();
                        alertify.error('Something Went Wrong');
                    } else {
                        $('#moduleData').load(location.href + " #moduleData>*", "");
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
