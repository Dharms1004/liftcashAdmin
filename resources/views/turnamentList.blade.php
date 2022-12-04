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
                            <h1>Tournament List</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb-item active">Tournament List</li>
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
                                    <h3 class="card-title">All Tournament list</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                            <th>S No.</th>
                                            <th>TOUR NAME</th>
                                            <th>TOUR DESCRIPTION</th>
                                            <th>TOUR PRIZE MONEY</th>
                                            <th>TOUR PRIZE TYPE</th>
                                            <th>TOUR STATUS</th>
                                            <th>TOUR MAX TEAM ALLOWED</th>
                                            <th>TOUR MIN TEAM REQUIRED</th>
                                            <th>TOUR MAX PLAYERS ALLOWED</th>
                                            <th>TOUR MIN PLAYERS REQUIRED</th>
                                            <th>TOUR LOGO</th>
                                            <th>TOUR BANNER</th>
                                            <th>TOUR MINI BANNER</th>
                                            <th>TOUR START TIME</th>
                                            <th>TOUR END TIME</th>
                                            <th>TOUR REGISTRATION START TIME</th>
                                            <th>TOUR REGISTRATION END TIME</th>
                                            <th>CREATED BY</th>
                                            <th>UPDATED BY</th>
                                            <th>CREATED AT</th>
                                            <th>UPDATED AT</th>

                                            <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($tournamentdata))
                                            @foreach($tournamentdata as $tournamentdata)
                                            <tr>
                                                <td>{{ $loop->iteration }} </td>
                                                <td>{{ $tournamentdata->TOUR_NAME }}</td>
                                                <td>{{ $tournamentdata->TOUR_DESCRIPTION }}</td>
                                                <td>{{ $tournamentdata->TOUR_PRIZE_MONEY }}</td>
                                                <td>{{ $tournamentdata->TOUR_PRIZE_TYPE }}</td>
                                                <td>{{ $tournamentdata->TOUR_STATUS }}</td>

                                                <td>{{ $tournamentdata->TOUR_MAX_TEAM_ALLOWED }}</td>
                                                <td>{{ $tournamentdata->TOUR_MIN_TEAM_REQUIRED }}</td>
                                                <td>{{ $tournamentdata->TOUR_MAX_PLAYERS_ALLOWED }}</td>
                                                <td>{{ $tournamentdata->TOUR_MIN_PLAYERS_REQUIRED }}</td>
                                                <td>
                                                @if(!empty($tournamentdata->TOUR_LOGO))
                                            <img style="height:50px; width:100px" src="{{url('images/tournaments/'.$tournamentdata->TOUR_LOGO)}}">
                                            @endif    
                                                </td>
                                                <td>
                                                @if(!empty($tournamentdata->TOUR_BANNER))
                                            <img style="height:50px; width:100px" src="{{url('images/tournaments/banner/'.$tournamentdata->TOUR_BANNER)}}">
                                            @endif      
                                                </td>
                                                <td>
                                                @if(!empty($tournamentdata->TOUR_MINI_BANNER))
                                            <img style="height:50px; width:100px" src="{{url('images/tournaments/mini_banner/'.$tournamentdata->TOUR_MINI_BANNER)}}">
                                            @endif      
                                               </td>
                                                <td>{{ $tournamentdata->TOUR_START_TIME }}</td>
                                                <td>{{ $tournamentdata->TOUR_END_TIME }}</td>
                                                <td>{{ $tournamentdata->TOUR_REGISTRATION_START_TIME }}</td>
                                                <td>{{ $tournamentdata->TOUR_REGISTRATION_END_TIME }}</td>
                                                <td>{{ $tournamentdata->CREATED_BY }}</td>

                                                <td>{{ $tournamentdata->UPDATED_BY }}</td>

                                                <td>{{ $tournamentdata->CREATED_AT }}</td>
                                                <td>{{ $tournamentdata->UPDATED_AT }}</td>

                                                <td><a href="{{ route('createTurnament') }}?type=edit&id={{ $tournamentdata->TOUR_ID }}" class="btn btn-app"><i class="fas fa-edit"></i> Edit</a></td>
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
