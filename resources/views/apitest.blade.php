<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test sQuare IDS API</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
</head>

<body style="background-color: #cdd9fe;">
    <div class="container-md my-5 py-5 d-flex justify-content-center">
        <div class="row">
            <h1 class="pb-3 text-center">Test sQuare IDS API endpoint</h1>
            <div class="col-12 bg-white p-5 border-none shadow rounded">
                <h4>Path: <b>/classification</b></h4>
                <p>Input parameters</p>
                @if (session('output'))
                    <div class="row">
                        {{-- <h5 class="text-end">Expected Output: </h5>
                        <p class="text-end">{{ session('label') }}</p> --}}
                        <h5 class="text-end">Output: </h5>
                        <p class="text-end">{{ session('output') }}</p>
                    </div>
                @endif
                <form class="row" action="{{ route('api.call') }}" method="post">
                    @csrf

                    @foreach ($column_names as $field => $data)
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="{{ $field }}Input" class="form-label">{{ $data[0] }}</label>
                            <input name="{{ $field }}" type="text" class="form-control"
                                id="{{ $field }}Input" value="{{ old($field, $testData[$data[0]]) }}">
                        </div>
                    </div>
                    @endforeach

                    <input type="hidden" name="label" value="{{$testData['Label']}}">

                    <button class="btn btn-primary" type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script> --}}
    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
