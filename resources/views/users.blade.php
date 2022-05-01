<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet"/>

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
        
        
    </head>
    <body class="d-flex flex-column">
        <div class="container">
            @if(!empty($error_message))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{$error_message}}
            </div>
            @endif
            <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
                <table id="example" class="display" style="width:80%">
                    <thead>
                        <tr style="text-align: center">
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
                <form class="col-6 offset-3" name="user-form" method="post" action="{{route('post_user_positions')}}">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="exampleInputEmail1">User ID</label>
                            <input type="number" class="form-control" name="user_id" value="{{old('user_id', isset($user_id) ?$user_id:5)}}" id="exampleInputEmail1" placeholder="Enter User ID">
                        </div>
                        <div class="form-group mb-3">
                            <label for="exampleInputPassword1">Results Limit</label>
                            <input type="number" class="form-control" name="limit" value="{{old('limit',isset($limit) ?$limit:5)}}" id="exampleInputPassword1" placeholder="Number of Results">
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                </form>

                </div>
            </div>
        </div>
    </body>

    <footer class="mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-12 align-self-center">
                    <h5>Made By Rami ALSHAZA</h5>
                    <h6>{{ (microtime(true) - LARAVEL_START) }}s</h6>
                </div>
                <div class="col-md-4 col-12 align-self-center">
                    <h5>Contact</h5>
                    <address>
		              <i class="fa fa-phone fa-lg"></i> <a href="tel:+963941520509">+963941520509</a><br>
		              <i class="fa fa-envelope fa-lg"></i> <a href="mailto:rami.shahade@gmail.com">rami.shahade@gmail.com</a>
		           </address>
                </div>
                <div class="col-md-4 col-12 align-self-center">
                        <a class="btn btn-social-icon btn-linkedin" href="https://www.linkedin.com/in/rami-alshahazeh/" style="text-decoration: none;"><i class="fa fa-linkedin fa-lg"></i></a>
                        <a class="btn btn-social-icon btn-github" href="https://github.com/RamiShahazeh" style="text-decoration: none"><i class="fa fa-github fa-lg"></i></a>
                </div>
            </div>
    </footer>
</html>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script>
$(document).ready(function() {
    $('#example').DataTable( {
        "paging":   false,
        "ordering": false,
        "info":     false
    } );
} );
</script>

