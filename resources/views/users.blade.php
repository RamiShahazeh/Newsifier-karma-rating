<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            <table id="example" class="display" style="width:80%">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>Karma Score</th>
                        <th>Position</th>
                        <th>Image URL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr style="text-align: center">
                        <td>{{$user->id}}</td>
                        <td>{{$user->username}}</td>
                        <td>{{$user->karma_score}}</td>
                        <td>{{$user->position}}</td>
                        <td><a href={{url($user->image_url) }}>{{url($user->image_url) }}</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
               <div class="container mt-5">
               <form class="col-6 offset-3" name="user-form" method="post" action="{{route('user_positions')}}">
                @csrf
                <div class="form-group mb-3">
                  <label for="exampleInputEmail1">User ID</label>
                  <input type="number" class="form-control" name="user_id" value="{{old('user_id', $user_id)}}" id="exampleInputEmail1" placeholder="Enter User ID">
                </div>
                <div class="form-group mb-3">
                  <label for="exampleInputPassword1">Results Limit</label>
                  <input type="number" class="form-control" name="limit" value="{{old('limit', $limit)}}" id="exampleInputPassword1" placeholder="Number of Results">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
              <div class="col-3"></div>
            </div>
        </div>
    </body>
</html>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
<script>
$(document).ready(function() {
    $('#example').DataTable( {
        "paging":   false,
        "ordering": false,
        "info":     false
    } );
} );
</script>

