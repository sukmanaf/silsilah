<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css">


</head>

<body>

    <div class="container mt-5">
        <button class="btn btn-primary" onclick="add()">Tambah</button>
        <button class="btn btn-primary pull-right" onclick="tree()">Tree</button>
        <button class="btn btn-primary pull-right" onclick="api()">Api</button>
        <table id="dtables" class="table datatable-responsive table-bordered table-striped">
        </table>
    </div>

    <div class="modal " id="modalaction" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" id="postForm" class="form-horizontal" enctype="multipart/form-data" method="post">

                        <input type="hidden" class="form-control" id="posturl" name="" placeholder="">
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" id="InpNama" name="Nama" placeholder="Nama">
                        </div>
                        <div class="form-group">
                            <label for="">Jenis Kelamin</label><br>
                            <input type="Radio" name="JK" style="width: 50px;display:inline" class="form-control" id="RadioLaki" placeholder="JenisKelamin" checked value="L">Laki-Laki
                            <input type="Radio" id="RadioPerem" name="JK" style="width: 50px;;display:inline" class="form-control" id="" placeholder="JenisKelamin" value="P">Perempuan
                        </div>
                        <div class="form-group">
                            <label for="">Orang Tua</label>
                            <select name="Parent" id="SelectParent" class="form-control">
                                <option value="">Tidak Ada</option>
                                @foreach($data as $v)
                                <option value="{{$v->Id}}">{{$v->Nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="modal " id="modaltree" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="tree"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal " id="modalapi" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 20px;">
                    <h3>API Semua Anak Budi</h3>
                    <code style="white-space: pre; color:black;" id="apisemua"></code>

                    <hr>
                    <h3>API Cucu dari Budi</h3>
                    <code style="white-space: pre; color:black;" id="apicucubudi"></code>
                    <hr>
                    <h3>API Cucu Perempuan dari Budi</h3>
                    <code style="white-space: pre; color:black;" id="apicucuperempuan"></code>
                    <hr>
                    <h3>API Bibi dari Farah</h3>
                    <code style="white-space: pre; color:black;" id="apibibifarah"></code>
                    <hr>
                    <h3>API bibi Sepupu laki-laki dari Hani</h3>
                    <code style="white-space: pre; color:black;" id="apisepupulaki"></code>
                    <hr>

                </div>
            </div>
        </div>
    </div>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>


<script>
    $(document).ready(function() {

        datatables()

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#postForm").submit(function(event) {
            event.preventDefault(); //prevent default action
            var post_url = $('#posturl').val(); //get form action url
            var request_method = $(this).attr("method"); //get form GET/POST method
            var form_data = new FormData(this); //Encode form elements for submission

            $.ajax({
                url: post_url,
                type: 'POST',
                data: form_data,
                processData: false,
                contentType: false,
                cache: false,
                async: false,
            }).done(function(response) {
                if (response.success) {
                    alert(response.message)
                    if (response.message = "Silsilah Updated") {
                        $('#modalaction').modal('hide');
                        $('#dtables').DataTable().clear().destroy();
                        datatables()

                    } else {
                        str = '<option value="">Tidak Ada</option>';
                        var select = response.select
                        select.forEach(v => {
                            str += '<option value="' + v.Id + '">' + v.Nama + '</option>'
                        });
                        $('#SelectParent').html(str)
                        $('#RadioLaki').prop('checked', true)
                        $('#InpNama').val('')
                        $('#dtables').DataTable().clear().destroy();
                        datatables()
                    }

                } else {
                    alert("simpan gagal!")

                }
            });
        });
    });

    function datatables() {
        $.ajax({
            url: '{{url("get")}}',
            type: 'GET',
            data: {},
            dataType: 'json',
        }).done(function(response) { //
            $('#dtables').DataTable({
                fixedColumns: true,
                data: response.data,
                searching: false, // Search Box will Be Disabled
                ordering: true, // Ordering (Sorting on Each Column)will Be Disabled
                info: true, // Will show "1 to n of n entries" Text at bottom
                lengthChange: false, // Will Disabled Record number per page
                columns: [{
                        title: "No"
                    },
                    {
                        title: "Nama"
                    },
                    {
                        title: "Jenis Kelamin"
                    },
                    {
                        title: "Parent"
                    },
                    {
                        title: "Action"
                    }
                ]

            });
        });
    }


    function edit(v) {

        $.ajax({
            url: "{{url('edit')}}/" + v,
        }).done(function(data) {
            var datas = data.data[0]
            $('#posturl').val('{{url("update")}}/' + v)
            $('#InpNama').val(datas.Nama);
            if (datas.JenisKelamin == 'L') {
                $('#RadioLaki').prop('checked', true)
            } else {
                $('#RadioPerem').prop('checked', true)

            }
            str = '<option value="">Tidak Ada</option>';
            var select = data.select
            console.log(select)
            select.forEach(v => {
                if (v.Id == datas.Parent) {
                    str += '<option selected value="' + v.Id + '">' + v.Nama + '</option>'

                } else {

                    str += '<option value="' + v.Id + '">' + v.Nama + '</option>'
                }

            });
            $('#SelectParent').html(str)
            $('#modalaction').modal('show');


        });
    }

    function add() {
        $.ajax({
            url: '{{url("getnama")}}',
            type: 'GET',
            data: {},
            dataType: 'json',
        }).done(function(response) { //
            str = '<option value="">Tidak Ada</option>';
            var select = response.data
            select.forEach(v => {
                str += '<option value="' + v.Id + '">' + v.Nama + '</option>'
            });
            $('#SelectParent').html(str)
            $('#RadioLaki').prop('checked', true)
            $('#InpNama').val('')
        });
        $('#posturl').val('{{url("store")}}')
        $('#modalaction').modal('show');
    }

    function hapus(v) {
        if (confirm('Apakah Anda Yakin Ingin Menghapus Data Ini?')) {
            $.ajax({
                url: '{{url("destroy")}}/' + v,
                type: 'GET',
                data: {},
                dataType: 'json',
            }).done(function(response) { //
                alert(response.message)
                $('#dtables').DataTable().clear().destroy();
                datatables()
            });
        }

    }

    function tree() {
        $.ajax({
            url: '{{url("trees")}}',
            type: 'GET',
            data: {},
            dataType: 'json',
        }).done(function(response) { //
            $('#tree').html(response)
            $('#modaltree').modal('show')

        });
    }
    function api() {
        $.ajax({
            url: '{{url("api")}}',
            type: 'GET',
            data: {},
            dataType: 'json',
        }).done(function(response) { //
            console.log(response)

            $('#apisemua').html(JSON.stringify(response.SemuaAnak,null,4))
            $('#apicucubudi').html(JSON.stringify(response.CucuBudi,null,4))
            $('#apicucuperempuan').html(JSON.stringify(response.CucuPerempuanBudi,null,4))
            $('#apibibifarah').html(JSON.stringify(response.BibiFarah,null,4))
            $('#apisepupulaki').html(JSON.stringify(response.SepupuLaki,null,4))
            $('#modalapi').modal('show')

        });
    }
</script>

</html>
