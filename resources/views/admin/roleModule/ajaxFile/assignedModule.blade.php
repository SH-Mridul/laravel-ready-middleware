

@foreach($modules as $module)
            <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td>{{$module->module->name}}</td>
            </tr> 
@endforeach
