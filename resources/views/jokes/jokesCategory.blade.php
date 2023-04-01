@include('common.head')

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        @include('common.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Liftcash</span>
            </a>

            <!-- Sidebar -->
            @include('common.sidebar')
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-3">
                            @if(!empty($type) && $type =="edit")
                            <h1>Edit Jokes Category</h1>
                            @else
                            <h1>Jokes Category</h1>
                            @endif

                        </div>
                        <div class="col-sm-9">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                @if(!empty($type) && $type =="edit")
                                <li class="breadcrumb-item active">Edit Jokes Category</li>
                                @else
                                <li class="breadcrumb-item active">Jokes Category</li>
                                @endif

                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">

                                    @if(!empty($type) && $type =="edit")
                                    <h3 class="card-title">Edit Jokes Category</h3>
                                    @else
                                    <h3 class="card-title">Jokes Category</h3>
                                    @endif

                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form method="POST" action="{{ route('addJokeCategory') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Category Name</label>
                                            <input type="text" name="jokeCat" value="@if(!empty(old('jokeCat'))) {{ old('jokeCat') }} @else {{ !empty($gameData->CATEGORY_NAME) ? $gameData->CATEGORY_NAME : ''  }} @endif" class="form-control" i placeholder="Category Name">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputFile">Category Banner</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" accept="image/*" name="image" value="{{ old('image') }} {{ !empty($jokeData->image) ? $gameData->image : ''  }}" class="custom-file-input">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                </div>
                                            </div>
                                            @if(!empty($gameData->image))
                                            <img style="height:50px; width:100px" src="{{url('images/games/'.$gameData->image)}}">
                                            @endif
                                        </div>
                                        
                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                            </div>
                            <!-- /.card-body -->



                            </form>
                        </div>
                        <!-- /.card -->
                    </div>

                </div>
                <!-- /.row -->
        </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @include('common.footer')

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{!! asset('plugins/jquery/jquery.min.js') !!}"></script>

    <!-- Bootstrap 4 -->
    <script src="{!! asset('plugins/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>
    <script src="{!! asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') !!}"></script>
    <!-- bs-custom-file-input -->
    <script src="{!! asset('dist/js/adminlte.min.js') !!}"></script>
    <!-- AdminLTE App -->

    <!-- AdminLTE for demo purposes -->
    <script src="{!! asset('dist/js/demo.js') !!}"></script>
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="{!! asset('plugins/toastr/toastr.min.js') !!}"></script>

    <!-- Page specific script -->
    <script>
        $(document).ready(function() {
            $('#send_to').on('change', function() {
                if ( this.value == '1')
                {
                    $("#user_list").hide();
                }
                else
                {
                    $("#user_list").show();
                }
            });
        });

        $(function() {
            bsCustomFileInput.init();
        });

      
        // alerts
        // $(function() {
        //     var Toast = Swal.mixin({
        //         toast: true,
        //         position: 'top-end',
        //         showConfirmButton: false,
        //         timer: 3000
        //     });

        //     toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
        //     toastr.error('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
        // });
    </script>
    @if($errors->any())
    <script>
        $(function() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            // toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
            toastr.error("{{ implode('', $errors->all()) }}.</br>");
        });
    </script>
    @elseif(!empty(session('success')))

    <script>
        $(function() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            toastr.success("{{ session('success') }}")

        });
    </script>
    @endif
</body>

</html>