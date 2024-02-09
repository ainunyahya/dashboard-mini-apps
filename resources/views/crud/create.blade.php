<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Nucleo Icons -->
    <link href="{{ asset('css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{ asset('css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('css/soft-ui-dashboard.css?v=1.0.7') }}" rel="stylesheet" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap 4.3.1 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <!-- Date Range Picker -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.js"></script>
    <!-- DataTables and Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" />
    <title>Dashboard</title>
</head>
<body>
    <div class="container-fluid ">

    <div class="container">
        <div>
            <div class="row" style="padding-right: 10px">
                <div class="col-lg-12 margin-t">
                    <div class="pull-left d-flex justify-content-between align-items-center py-3">
                        <h2 style="font-family: 'Poppins Semi-Bold';">Buat Pesanan</h2>
                    </div>
                    <a href="{{ route('demo.index') }}" class="btn btn-primary">Kembali</a>
                </div>
            </div>
            
            <!-- Main content -->
            <div class="row justify-content-centers">
              <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-3">
                        <h2> </h2>
                    </div>
                    <div class="card-body px-2 pt-0 pb-2">
                        <form action="{{ route('demo.store') }}" method="POST">
                            @csrf
                            <div class="mb-3 mt-2">
                              <h6 style="font-family: 'Poppins Medium'; color: #000000;" for="exampleInputEmail1" >Nama</h6>
                              <input name="user_name" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="masukkan nama anda">
                            </div>
                            <div class="mb-3">
                              <h6 style="font-family: 'Poppins Medium'; color: #000000;" for="exampleInputEmail1" >Unit</h6>
                               <select name="unit_name" class="form-select" aria-label="Default select example">
                                <option selected>pilih unit</option>
                                <!-- Loop untuk menampilkan opsi dari data produk -->
                                @foreach($datas1 as $data1)
                                    <option value="{{ $data1->id }}">{{ $data1->name }}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="mb-3">
                              <h6 style="font-family: 'Poppins Medium'; color: #000000;" for="exampleInputEmail1" >Produk</h6>
                              <select name="product_id" class="form-select" aria-label="Default select example">
                                <option selected>pilih produk</option>
                                <!-- Loop untuk menampilkan opsi dari data produk -->
                                @foreach($datas as $data)
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="mb-3">
                              <h6 style="font-family: 'Poppins Medium'; color: #000000;" for="exampleInputEmail1" >Jumlah</h6>
                              <input name="qty" type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="masukkan jumlah produk">
                            </div>
                            <div class="mb-3">
                              <h6 style="font-family: 'Poppins Medium'; color: #000000;" for="exampleInputEmail1" >Extra Cost</h6>
                              <input name="extra_cost" type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="masukkan nominal extra cost">
                            </div>
                            <div class="mb-3">
                              <h6 style="font-family: 'Poppins Medium'; color: #000000;" for="exampleInputEmail1" >Note</h6>
                              <input name="note" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="masukkan pesan anda">
                            </div>
                            <div class="mb-3">
                              <h6 style="font-family: 'Poppins Medium'; color: #000000;" for="exampleInputEmail1" >Alamat</h6>
                              <input name="address" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="masukkan alamat anda">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>

        </div>
    </div>
    </div> 

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>




