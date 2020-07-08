 @foreach($routes as $route)
            <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td>{{$route->module->name}}</td>
                <td>{{$route->name}}</td>
                <td>{{$route->path}}</td>
                <td>
                    @if($route->is_active == 1)
                        <span class="badge badge-success" style="cursor: pointer" onclick="inactiveRoute({{ $route->id }})">Active</span>
                    @else  
                        <span class="badge badge-danger" style="cursor: pointer" onclick="activeRoute({{ $route->id }})">Inactive</span>
                    @endif
        
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-outline-primary badge" onclick="editRoute({{ $route->id }})"><i class="fas fa-pencil-alt"></i></button>
                    <button type="button" class="btn btn-outline-danger badge" onclick="deleteRoute({{ $route->id }})"><i class="far fa-trash-alt"></i></button>
                </td>
            </tr> 
@endforeach
