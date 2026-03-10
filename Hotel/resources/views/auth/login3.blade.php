
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{asset('bootstrap.min.css')}}">
    <script src="{{asset('jquery.slim.min.js')}}"></script>
    <script src="{{asset('bootstrap.bundle.min.js')}}"></script>


    <title>Document</title>
</head>

<body>
    <div class="container">
        <form class="form-horizontal" method="POST" action="{{ action([App\Http\Controllers\LoginController::class, 'iniciar_sesion']) }}">
            {{csrf_field()}}


            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                <div class="col-md-6">
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                </div>
            </div>



            <div class="form-group{{ $errors->has('password') ? 'has-error' : ''}}">
                <label for="password" class="col-md-4 control-label">Password</label>
                <div class="col-md-6">
                    <input id="password" type="password" class="form-control" name="password" required>
                </div>
            </div>



            <div class="form-group">
                <div class="col-md-4 col-form-label text-md-end">
                    <button type="submit" class="btn btn-primary">
                        Login
                    </button>
                </div>
            </div>
        </form>

    </div>

</body> 
</html> 