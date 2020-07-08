@extends('layouts.admin')
@section('title','Module')
@push('topasset')
{{-- top asset file --}}
@endpush


@section('content')



<div class="card text-center">
    <div class="card-header">
        Module View
    </div>
    <div class="card-body">
       
        <div class="row">
            <div class="col-md-9">

                <div class="table-responsive">
                    <table class="table table-sm table-bordered" id="dataTable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Module Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="moduleData">
                            @foreach($modules as $module)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{$module->name}}</td>
                                <td>
                                    @if($module->is_active == 1)
                                         <span class="badge badge-success" style="cursor: pointer"
                                             onclick="inactiveModule({{ $module->id }})">Active</span>
                                    @else
                                        
                                        <span class="badge badge-danger" style="cursor: pointer"
                                             onclick="activeModule({{ $module->id }})">Inactive</span>
                                             
                                    @endif
        
                                </td>
                                <td class="text-center">
                                    
                                    <button type="button" class="btn btn-outline-primary badge" onclick="editModule({{ $module->id }})"><i class="fas fa-pencil-alt"></i></button>
                                    <button type="button" class="btn btn-outline-danger badge" onclick="deleteModule({{ $module->id }})"><i class="far fa-trash-alt"></i></button>
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
                        <h5 class="card-title">Create New Module</h5>
                        
                         <form id="moduleForm">

                             <div class="form-group text-left">
                                 <input type="text" class="form-control form-control-sm" name="name" placeholder="module name..">
                             </div>
                             <button type="submit" class="btn btn-secondary btn-sm btn-block">Save</button>

                         </form>


                        
                    </div>
                </div>

               
            </div>


        </div>
        
    </div>
</div>





<div class="modal fade" id="update-module-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <p class="modal-title" id="exampleModalLongTitle">Update Module</p>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <form id="module_update_form">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Module Name</label>
                         <input type="hidden" name="id" id="module_id">
                        <input type="text" class="form-control form-control-sm" id="module_name" name="name"
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
   
    $('#moduleForm').submit(function () {
            event.preventDefault();
             alertify.confirm('Are You Sure ?', 'Module Will Be Created', function () {
             Notiflix.Loading.Dots();  
            

            $.ajax({
                type: 'post',
                url: '{{URl("moduleInsertAjax")}}',
                data: $('#moduleForm').serialize(),
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                        Notiflix.Loading.Remove();
                        alertify.error('Something Went Wrong');
                    } else if (typeof data.warning !== 'undefined') {
                        clearForm('moduleForm');
                         Notiflix.Loading.Remove();
                        alertify.error('Module Already Exists');
                    } else {
                        clearForm('moduleForm');
                        $('#moduleData').load(location.href+" #moduleData>*","");
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





        $('#module_update_form').submit(function () {
            event.preventDefault();
             alertify.confirm('Are You Sure ?', 'Module Will Be Updated', function () {
             Notiflix.Loading.Dots();  
            
            $.ajax({
                type: 'post',
                url: '{{URl("moduleUpdateAjax")}}',
                data: $('#module_update_form').serialize(),
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                        Notiflix.Loading.Remove();
                        alertify.error(data.errors.name[0]);
                    } else {
                        clearForm('module_update_form');
                        $('#update-module-modal').modal('hide');
                        $('#moduleData').load(location.href+" #moduleData>*","");
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


    function editModule(id){
        $.ajax({
                type: 'post',
                url: '{{URl("getModuleInfoDetailsAjax")}}',
                data: {
                    id:id
                },
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                        Notiflix.Loading.Remove();
                        alertify.error('Something Went Wrong');
                    }else {
                        $('#module_id').val(data.id)
                        $('#module_name').val(data.name)
                         $('#update-module-modal').modal('show');
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


    function deleteModule(id){
        event.preventDefault();
             alertify.confirm('Are You Sure ?', 'Module Will Be Deleted', function () {
             Notiflix.Loading.Dots();  
            
            $.ajax({
                type: 'post',
                url: '{{URl("moduleDeleteAjax")}}',
                data:{
                    id:id
                },
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                        Notiflix.Loading.Remove();
                        alertify.error('Something Went Wrong');
                    }else {
                        $('#moduleData').load(location.href+" #moduleData>*","");
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


    function activeModule(id) {
         event.preventDefault();
             alertify.confirm('Are You Sure ?', 'Module Will Be Active', function () {
             Notiflix.Loading.Dots();  
            $.ajax({
                type: 'post',
                url: '{{URl("activeModuleAjax")}}',
                data: {
                    id:id
                },
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                        Notiflix.Loading.Remove();
                        alertify.error('Something Went Wrong');
                    }else {
                        $('#moduleData').load(location.href+" #moduleData>*","");
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







    function inactiveModule(id) {
         event.preventDefault();
             alertify.confirm('Are You Sure ?', 'Module Will Be Inactive!', function () {
             Notiflix.Loading.Dots();  

            $.ajax({
                type: 'post',
                url: '{{URl("inactiveModuleAjax")}}',
                data: {
                    id : id
                },
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                        Notiflix.Loading.Remove();
                        alertify.error('Something Went Wrong');
                    }else {
                        $('#moduleData').load(location.href+" #moduleData>*","");
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
