<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Documentation of sQuare IDS API</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
  </head>
  <body>
    <div class="container-md m-5 mb-0 pt-5" style="padding-left: 20rem;">
        <h1 class="pb-3 text-center">sQuare IDS API</h1>
        <div class="row">
            <div class="text-end"><a class="btn btn-sm btn-outline-primary" href="{{ route('api.test') }}">Test API</a></div>
        </div>
        <div class="row">
            <h4>Path: <b>/binary-classification</b></h4>
            <p>Input parameter list:</p>
            
            <ol class="ps-3">
                @foreach ($column_names as $param => $data)
                    <li class="my-2"><code>{{ $param }}</code>: {{ $data[0] }} <br>
                        <p>{{ $data[1] }}</p> 
                    </li>
                @endforeach
            </ol>
        </div>
    </div>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script> --}}
    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  </body>
</html>