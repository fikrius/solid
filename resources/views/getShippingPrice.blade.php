<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="content">
            <div class="container mt-5">
                <form method="post" action="{{ url('site/getShippingPrice') }}">
                    {{ csrf_field() }}
                    <div class="row mt-2">
                        <div class="col-lg-2">
                            <div class="form-group">
                                <h5>Kota Asal</h5>
                                <select name="ShippingPrice[origin]" id="origin" class="form-control" required>
                                    @foreach ($originCitySamples as $key => $originCitySample)
                                        <option value="{{ $key }}" {{ isset($inputData['origin']) && $inputData['origin'] == $key ? 'selected' : '' }}>{{ $originCitySample }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <h5>Kota Tujuan</h5>
                                <select name="ShippingPrice[destination]" id="destination" class="form-control" required>
                                    @foreach ($destinationCitySamples as $key => $destinationCitySample)
                                        <option value="{{ $key }}" {{ isset($inputData['destination']) && $inputData['destination'] == $key ? 'selected' : '' }}>{{ $destinationCitySample }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <h5>Berat</h5>
                                <input type="number" name="ShippingPrice[weight]" value="{{ isset($inputData['weight']) ? $inputData['weight'] : '' }}" class="form-control" placeholder="in gram" required>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <h5>Kurir</h5>
                                <select name="ShippingPrice[courier]" id="courier" class="form-control" required>
                                    @foreach ($courierSamples as $courierSample)
                                        <option value="{{ $courierSample != '-- Pilih --' ? $courierSample : '' }}" {{ isset($inputData['courier']) && $inputData['courier'] == $courierSample ? 'selected' : '' }}>{{ $courierSample }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <h5 style="color: white">Cek Ongkir</h5>
                                <button type="submit" class="btn btn-success form-control">Cek Ongkir</button>
                            </div>
                        </div>
                    </div>

                    @if (!empty($errors))
                        <div class="alert alert-danger mt-5">
                            <ul>
                                @foreach ($errors as $error)
                                    <li class="text-left">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </form>
            </div>

            @if (isset($results['success']) && $results['success'])
                @if (isset($results['data'][0]['costs']))
                    <div class="container mt-5">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="text-center">{{ "Kurir : " . $results['data'][0]['name'] ?? "-" }}</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-hover">
                                    <thead>
                                        <th>No</th>
                                        <th>Servis</th>
                                        <th>Deskripsi</th>
                                        <th>Estimasi Waktu</th>
                                        <th>Ongkir</th>
                                    </thead>
                                    <tbody>
        
                                        @if (empty($results['data'][0]['costs']))
                                            <td>Data tidak ditemukan</td>
                                        @else
                                            @php
                                                $counter = 1;
                                            @endphp
        
                                            @foreach ($results['data'][0]['costs'] as $key=>$data)
                                                <tr>
                                                    <td>{{ $counter }}</td>
                                                    <td>{{ $data['service'] ?? "-" }}</td>    
                                                    <td>{{ $data['description'] ?? "-" }}</td>    
                                                    <td>{{ $data['cost'][0]['etd'] . " Hari" ?? "-" }}</td>    
                                                    <td>{{ $data['cost'][0]['value'] ?? "-" }}</td>    
                                                </tr>
                                                @php
                                                    $counter++;
                                                @endphp
                                            @endforeach
        
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </body>
</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

    // Tidak jadi dipakai
    $('.origin').select2({
        dropdownCssClass : 'no-search',
        ajax: {
            url: '/city/getCities',
            data: function (params) {
                console.log(params);
                var query = {
                    search: params.term,
                    type: 'public'
                }

                // Query parameters will be ?search=[term]&type=public
                return query;
            },
            processResults: function (data) {
                console.log(data);
                return data;
            },
            cache: true
        }
    });

    // Tidak jadi dipakai
    $('.destination').select2({
        ajax: {
            url: '/city/getCities',
            data: function (params) {
                var query = {
                    search: params.term,
                    type: 'public'
                }

                // Query parameters will be ?search=[term]&type=public
                return query;
            }
        }
    });

    // {{-- <select class="origin form-control" name="state" style="width: 100%"></select> --}}
    // {{-- <select class="destination form-control" name="state" style="width: 100%"></select> --}}

</script>