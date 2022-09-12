@include('common.head')

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        @include('common.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">LiftCash</span>
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
                        <div class="col-sm-6">
                            <h1>Team List</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb-item active">Team List</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">

                            <!-- /.card -->

                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">All Team list</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Sl No.</th>
                                                <th>TEAM_NAME</th>
                                                <th>TEAM_DESCRIPTION</th>
                                                <th>TEAM_CONTACT</th>
                                                <th>TEAM_STATUS</th>
                                                <th>CREATED_BY</th>
                                                <th>UPDATED_BY</th>
                                                <th>CREATED_AT</th>
                                                <th>UPDATED_AT</th>
                                                

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($teamdata))
                                            @foreach($teamdata as $teamdata)
                                            <tr>
                                                <td>{{ $loop->iteration }} </td>
                                                <td>{{ $teamdata->TEAM_NAME }}</td>
                                                <td>{{ $teamdata->TEAM_DESCRIPTION }}</td>
                                                <td>{{ $teamdata->TEAM_CONTACT }}</td>
                                                <td>{{ $teamdata->TEAM_STATUS }}</td>
                                                <td>{{ $teamdata->CREATED_BY }}</td>

                                                <td>{{ $teamdata->UPDATED_BY }}</td>
                                                <td>{{ $teamdata->CREATED_AT }}</td>
                                                <td>{{ $teamdata->UPDATED_AT }}</td>
                                               
                                                  </tr>
                                            @endforeach
                                            @endif
                                        </tbody>

                                    </table>

                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
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
    <!-- DataTables  & Plugins -->
    <script src="{!! asset('plugins/datatables/jquery.dataTables.min.js') !!}"></script>
    <script src="{!! asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') !!}"></script>
    <script src="{!! asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') !!}"></script>
    <script src="{!! asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') !!}"></script>
    <script src="{!! asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') !!}"></script>
    <script src="{!! asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') !!}"></script>
    <script src="{!! asset('plugins/jszip/jszip.min.js') !!}"></script>
    <script src="{!! asset('plugins/pdfmake/pdfmake.min.js') !!}"></script>
    <script src="{!! asset('plugins/pdfmake/vfs_fonts.js') !!}"></script>
    <script src="{!! asset('plugins/datatables-buttons/js/buttons.html5.min.js') !!}"></script>
    <script src="{!! asset('plugins/datatables-buttons/js/buttons.print.min.js') !!}"></script>
    <script src="{!! asset('plugins/datatables-buttons/js/buttons.colVis.min.js') !!}"></script>
    <script src="{!! asset('dist/js/adminlte.min.js') !!}"></script>
    <script src="{!! asset('dist/js/demo.js') !!}"></script>

    <script>
        $(function() {
            $("#example1").DataTable({

                "scrollX": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });


        jQuery(document).ready(function(){
            jQuery('.status').click(function(e){
               e.preventDefault();
               var offer_id=$(this).attr("data-offer-id");
               jQuery.ajax({
                  url: "{{ url('/updateGameStatus') }}",
                  method: 'post',
                  data: {
                    "_token": "{{ csrf_token() }}",
                    id: offer_id,

                  },
                  success: function(result){
                    location.reload();
                  }});
               });
            });

            jQuery(document).ready(function(){
            jQuery('.recco').click(function(e){
               e.preventDefault();
               var offer_id=$(this).attr("data-offer-id");
               jQuery.ajax({
                  url: "{{ url('/makeReccomendedGame') }}",
                  method: 'post',
                  data: {
                    "_token": "{{ csrf_token() }}",
                    id: offer_id,

                  },
                  success: function(result){
                    location.reload();
                  }});
               });
            });
    </script>
</body>

</html>
