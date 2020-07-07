<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="{{asset('js/jquery-3.3.1.js')}}"></script>

    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('css/animate.css')}}">

    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/6631cf4e8b.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/sidebar1.css')}}">
    <link rel="stylesheet" href="{{asset('css/button.css')}}">
    <script type="text/javascript" src="{{asset('js/sidebar.js')}}"></script>

    <title>Document</title>
</head>
<style>
    * {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    .btn {
        width: 200px;
        font-size: 16px;
        font-weight: 600;
        color: #fff;
        cursor: pointer;
        margin: 20px;
        height: 55px;
        text-align: center;
        border: none;
        background-size: 300% 100%;
        border-radius: 50px;
        moz-transition: all .4s ease-in-out;
        -o-transition: all .4s ease-in-out;
        -webkit-transition: all .4s ease-in-out;
        transition: all .4s ease-in-out;

    }

    .btn:hover {
        background-position: 100% 0;
        moz-transition: all .4s ease-in-out;
        -o-transition: all .4s ease-in-out;
        -webkit-transition: all .4s ease-in-out;
        transition: all .4s ease-in-out;

    }

    .btn:focus {
        outline: none;
    }

    .btn.btn-raised {
        background-image: linear-gradient(to right, #25aae1, #40e495, #30dd8a, #2bb673);
        box-shadow: 0 4px 15px 0 rgba(49, 196, 190, 0.75);
    }
</style>

<body>
    <div class="container-fluid">
        <div class="row card card-body text-center" style="margin:10% 30% 10% 30%;">
            <h2>Please sign in</h2>
            @if(count($errors)>0)
            <div class="alert alert-danger">
                @foreach($errors->all() as $err)
                {{$err}}<br>
                @endforeach
            </div>
            @endif

            @if(session('thongbao'))
            <div class="alert alert-danger">
                {{session('thongbao')}}
            </div>
            @endif
            <form method="POST" action="login">
                <fieldset>
                    <input type="hidden" name="_token" value="{{csrf_token()}}" />
                    <div class="mt-2"><input type='text' name='email' id="email" class="form-control" placeholder="Email" required="required" /></div>
                    <div class="mt-4 mb-1"><input type='password' name='password' id="password" class="form-control" placeholder="Password" required="required" /></div>
                    <div class="mt-2"><button class="btn btn-raised" name="submit" type="submit">Login</button></div>
                </fieldset>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="js/darkmode-js.min.js"></script>
    <script type="text/javascript" src="js/s.js"></script>
</body>

</html>