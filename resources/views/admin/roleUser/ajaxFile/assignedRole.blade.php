

@foreach($assignedRole as $role)
            <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td>{{$role->role->name}}</td>
            </tr> 
@endforeach
