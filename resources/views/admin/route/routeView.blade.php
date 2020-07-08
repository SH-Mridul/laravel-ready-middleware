@extends('layouts.admin')
@section('title','Routes')
@push('topasset')
{{-- top asset file --}}
@endpush


@section('content')



<div class="card text-center">
    <div class="card-header">
        Routes View
    </div>
    <div class="card-body">
       
        <div class="row">
            <div class="col-md-9">

            <div class="row">
                <div class="col-md-12">
                    <select class="form-control form-control-sm" onchange="getModuleRoute(this.value)" id="module">
                        <option value="" disabled selected>--select module--</option>
                        @foreach($modules as $module)
                            <option value="{{$module->id}}">{{$module->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name Of Module</th>
                                <th scope="col">Name Of Path</th>
                                <th scope="col">Route Path</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="routeData">
                            @foreach($routes as $route)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{$route->module->name}}</td>
                                <td>{{$route->name}}</td>
                                <td>{{$route->path}}</td>
                                <td>
                                    @if($route->is_active == 1)
                                         <span class="badge badge-success" style="cursor: pointer"
                                             onclick="inactiveRoute({{ $route->id }})">Active</span>
                                    @else
                                        
                                        <span class="badge badge-danger" style="cursor: pointer"
                                             onclick="activeRoute({{ $route->id }})">Inactive</span>
                                             
                                    @endif
        
                                </td>
                                <td class="text-center">
                                    
                                    <button type="button" class="btn btn-outline-primary badge" onclick="editRoute({{ $route->id }})"><i class="fas fa-pencil-alt"></i></button>
                                    <button type="button" class="btn btn-outline-danger badge" onclick="deleteRoute({{ $route->id }})"><i class="far fa-trash-alt"></i></button>
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
                        <h5 class="card-title">Create New Route Path</h5>
                        
                         <form id="routeForm">

                             <div class="form-group text-left">
                                 <select class="form-control form-control-sm" name="module_id">
                                    <option value="" disabled selected>--select module--</option>
                                    @foreach ($modules as $module)
                                        <option value="{{ $module->id }}">{{ $module->name }}</option>
                                    @endforeach

                                </select>
                             </div>

                             <div class="form-group text-left">
                                 <select class="form-control form-control-sm text" name="type">
                                    <option value="" disabled selected>--select type--</option>
                                    <option value="menu">Menu</option>
                                    <option value="internal">Internal</option>
                                </select>
                             </div>

                             <div class="form-group text-left">
                                 <input type="text" class="form-control form-control-sm" name="name" placeholder="name">
                             </div>


                             <div class="form-group text-left">
                                 <input type="text" class="form-control form-control-sm" name="path" placeholder="route path">
                             </div>

                             <button type="submit" class="btn btn-secondary btn-sm btn-block">Save</button>

                         </form>


                        
                    </div>
                </div>

               
            </div>


        </div>
        
    </div>
</div>





<div class="modal fade" id="update-route-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <p class="modal-title" id="exampleModalLongTitle">Update Route Info</p>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <form id="route_update_form">

                             <div class="form-group text-left">
                                 <input type="hidden" name="id" id="routeId">
                                 <select class="form-control form-control-sm" name="module_id" id="module_id">
                                    <option value="" disabled selected>--select module--</option>
                                    @foreach ($modules as $module)
                                        <option value="{{ $module->id }}">{{ $module->name }}</option>
                                    @endforeach

                                </select>
                             </div>

                             <div class="form-group text-left">
                                 <select class="form-control form-control-sm text" name="type" id="type">
                                    <option value="" disabled selected>--select type--</option>
                                    <option value="menu">Menu</option>
                                    <option value="internal">Internal</option>
                                </select>
                             </div>

                             <div class="form-group text-left">
                                 <input type="text" class="form-control form-control-sm" name="name" placeholder="name" id="route_name">
                             </div>


                             <div class="form-group text-left">
                                 <input type="text" class="form-control form-control-sm" name="path" placeholder="route path" id="route_path">
                             </div>

                            

                        

                    
                

            </div>
            <div class="modal-footer">
                 <button type="submit" class="btn btn-secondary btn-sm btn-block">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>





<script>

$(document).ready(function(){
   
    $('#routeForm').submit(function () {
            event.preventDefault();
             alertify.confirm('are you sure ?', 'route will be created', function () {
             Notiflix.Loading.Dots();  
            

            $.ajax({
                type: 'post',
                url: '{{URl("routeInsertAjax")}}',
                data: $('#routeForm').serialize(),
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                        Notiflix.Loading.Remove();
                        alertify.error('Something Went Wrong');
                    } else if (typeof data.warning !== 'undefined') {
                         Notiflix.Loading.Remove();
                        alertify.error('Already Exists');
                    } else {
                        clearForm('routeForm');
                        $('#module').val('');
                        $('#routeData').load(location.href+" #routeData>*","");
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
        });





        $('#route_update_form').submit(function () {
            event.preventDefault();
             alertify.confirm('are you sure ?', 'route will be updated!', function () {
             Notiflix.Loading.Dots();  
            
            $.ajax({
                type: 'post',
                url: '{{URl("routeUpdateAjax")}}',
                data: $('#route_update_form').serialize(),
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                        Notiflix.Loading.Remove();
                        alertify.error(data.errors.path[0]);
                    } else {
                        clearForm('route_update_form');
                        $('#update-route-modal').modal('hide');
                        $('#routeData').load(location.href+" #routeData>*","");
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
        });
    });


    function editRoute(id){
        $.ajax({
                type: 'post',
                url: '{{URl("getRouteInfoDetailsAjax")}}',
                data: {
                    id:id
                },
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                        Notiflix.Loading.Remove();
                        alertify.error('Something Went Wrong');
                    }else {
                            $('#module_id').val(data.module_id);
                            $('#routeId').val(id);
                            $('#type').val(data.type);
                            $('#route_name').val(data.name)
                            $('#route_path').val(data.path);
                        $('#update-route-modal').modal('show');
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


    function deleteRoute(id){
        event.preventDefault();
             alertify.confirm('are you sure ?', 'route will be deleted', function () {
             Notiflix.Loading.Dots();  
            
            $.ajax({
                type: 'post',
                url: '{{URl("routeDeleteAjax")}}',
                data:{
                    id:id
                },
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                        Notiflix.Loading.Remove();
                        alertify.error('Something Went Wrong');
                    }else {
                        $('#routeData').load(location.href+" #routeData>*","");
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


    function activeRoute(id) {
         event.preventDefault();
             alertify.confirm('are you sure ?', 'route will be active', function () {
             Notiflix.Loading.Dots();  
            $.ajax({
                type: 'post',
                url: '{{URl("activeRouteAjax")}}',
                data: {
                    id:id
                },
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                        Notiflix.Loading.Remove();
                        alertify.error('Something Went Wrong');
                    }else {
                        $('#routeData').load(location.href+" #routeData>*","");
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







    function inactiveRoute(id) {
         event.preventDefault();
             alertify.confirm('are you sure ?', 'route will be inactive!', function () {
             Notiflix.Loading.Dots();  

            $.ajax({
                type: 'post',
                url: '{{URl("inactiveRouteAjax")}}',
                data: {
                    id : id
                },
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                        Notiflix.Loading.Remove();
                        alertify.error('Something Went Wrong');
                    }else {
                        $('#routeData').load(location.href+" #routeData>*","");
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



    function getModuleRoute(val){
        Notiflix.Loading.Dots();  
       $.ajax({
                type: 'post',
                url: '{{URl("getRouteByModule")}}',
                data: {
                    id:val
                },
                dataType: 'html',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                        Notiflix.Loading.Remove();
                        alertify.error('Something Went Wrong');
                    }else {
                        $('#routeData').html(data);
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






      function clearForm(id){
        $( "#"+id).trigger( "reset" );
      }  

</script>

@endsection

@push('footerasset')
{{-- footer asset --}}
@endpush
