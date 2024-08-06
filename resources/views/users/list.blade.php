<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="_token" content="{{ csrf_token()}}">
    <meta http-equiv="X-UA-Compatible" content="IE=7">
    <title>Dynamic Dependent Dropdown</title>
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
</head>

<body>
    <div class="bg p-3 text-white shadow-lg text-center">
        <h1>Laravel Dynamic Dependent Dropdown Tutorial</h1>
    </div>
    <div class="container mt-3">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6">
                <div class="card card-primary p-4 border-0 shadow-lg">
@if(Session::has("success"))
<p class="alert alert-success">
{{Session::get('success')}}
</p>
@endif
                        <div class="card-body">
                            <h3>User</h3>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if(!empty($users))
                      @foreach($users as $user )

<tr>
    <td>{{$user->id}}</td>
    <td>{{$user->name}}</td>
    <td>{{$user->email}}</td>
    <td>
        <a href="{{route('edit',$user->id)}}" class="btn btn-success">
            Edit
        </a>
    </td>
    <td>
        <a href="{{route('delete',$user->id)}}" class="btn btn-danger btn-sm">
            Delete
        </a>
    </td>
</tr>
                      @endforeach
                      @endif
                                </tbody>
                            </table>
                    
                        </div>
                    
                 
                </div>
            </div>
        </div>
    </div>




    <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
 
</body>

</html>