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
                        <div class="col-sm-3">
                            @if(!empty($type) && $type =="edit")
                            <h1>Edit Tournament</h1>
                            @else
                            <h1>Create Tournament</h1>
                            @endif

                        </div>
                        <div class="col-sm-9">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                @if(!empty($type) && $type =="edit")
                                <li class="breadcrumb-item active">Edit Tournament</li>
                                @else
                                <li class="breadcrumb-item active">Create Tournament</li>
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
                            <div class="card card-default">
                                <div class="card-header">

                                    @if(!empty($type) && $type =="edit")
                                    <h3 class="card-title">Edit Tournament</h3>
                                    @else
                                    <h3 class="card-title">Create Tournament</h3>
                                    @endif

                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                               
                                <form method="POST" action="{{ route('createTurnament') }}" enctype="multipart/form-data">
                                    @csrf
                                    @if(!empty($type))
                                    <input type="hidden" name="editType" value="{{ !empty($type) ? $type : ''  }}">
                                    <input type="hidden" name="id" value="{{ !empty($tourData->TOUR_ID) ? $tourData->TOUR_ID : ''  }}">
                                    @endif
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label>Tournament Type</label>
                                            <select name="tour_type" class="form-control select2 select2-danger select2-hidden-accessible" data-dropdown-css-class="select2-danger" style="width: 100%;" data-select2-id="12" tabindex="-1" aria-hidden="true">
                                                <option selected="selected" data-select2-id="14">Select</option>
                                                <option value="1" {{ !empty(old('tour_type')) ? old('tour_type') == 1 ? "selected" : ''  : ''  }} {{ !empty($tourData->TOUR_TYPE) ? $tourData->TOUR_TYPE == 1 ? "selected" : ''  : ''  }}>Solo</option>
                                                <option value="2" {{ !empty(old('tour_type')) ? old('tour_type') == 2 ? "selected" : ''  : ''  }} {{ !empty($tourData->TOUR_TYPE) ? $tourData->TOUR_TYPE == 2 ? "selected" : ''  : ''  }}>Team</option>

                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Name</label>
                                            <input type="text" name="name" value="@if(!empty(old('name'))) {{ old('name') }} @else {{ !empty($tourData->TOUR_NAME) ? $tourData->TOUR_NAME : ''  }} @endif" class="form-control" i placeholder="Name">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Description</label>
                                            <input type="text" name="description" value="@if(!empty(old('description'))) {{ old('description') }} @else {{ !empty($tourData->TOUR_DESCRIPTION) ? $tourData->TOUR_DESCRIPTION : ''  }} @endif" class="form-control" i placeholder="Description">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Prize Money</label>
                                            <input type="text" name="prize_money" value="@if(!empty(old('prize_money'))) {{ old('prize_money') }} @else {{ !empty($tourData->TOUR_PRIZE_MONEY) ? $tourData->TOUR_PRIZE_MONEY : ''  }} @endif" class="form-control" i placeholder="Prize Money">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Prize Type</label>
                                            <input type="text" name="prize_type" value="@if(!empty(old('prize_type'))) {{ old('prize_type') }} @else {{ !empty($tourData->TOUR_PRIZE_TYPE) ? $tourData->TOUR_PRIZE_TYPE : ''  }} @endif" class="form-control" i placeholder="Prize Type">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Status</label>
                                            <input type="text" name="status" value="@if(!empty(old('status'))) {{ old('status') }} @else {{ !empty($tourData->TOUR_STATUS) ? $tourData->TOUR_STATUS : ''  }} @endif" class="form-control" i placeholder="status">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Max Team Allowed</label>
                                            <input type="text" name="max_team_allowed" value="@if(!empty(old('max_team_allowed'))) {{ old('max_team_allowed') }} @else {{ !empty($tourData->TOUR_MAX_TEAM_ALLOWED) ? $tourData->TOUR_MAX_TEAM_ALLOWED : ''  }} @endif" class="form-control" i placeholder="Max Team allowed">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Min Team Required</label>
                                            <input type="text" name="min_team_required" value="@if(!empty(old('min_team_required'))) {{ old('min_team_required') }} @else {{ !empty($tourData->TOUR_MIN_TEAM_REQUIRED) ? $tourData->TOUR_MIN_TEAM_REQUIRED : ''  }} @endif" class="form-control" i placeholder="Min Team Required">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Max Players Allowed</label>
                                            <input type="text" name="max_players_allowed" value="@if(!empty(old('max_players_allowed'))) {{ old('max_players_allowed') }} @else{{ !empty($tourData->TOUR_MAX_PLAYERS_ALLOWED) ? $tourData->TOUR_MAX_PLAYERS_ALLOWED : ''  }} @endif" class="form-control" i placeholder="Max Players Allowed">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Min Players Required</label>
                                            <input type="text" name="min_players_required" value="@if(!empty(old('min_players_required'))) {{ old('min_players_required') }} @else{{ !empty($tourData->TOUR_MIN_PLAYERS_REQUIRED) ? $tourData->TOUR_MIN_PLAYERS_REQUIRED : ''  }} @endif" class="form-control" i placeholder="Min Players Required">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputFile">Logo</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                   <!-- <input type="file" accept="image/*" name="logo" value="{{ old('logo') }} {{ !empty($tourData->TOUR_LOGO) ? $tourData->TOUR_LOGO : ''  }}" class="custom-file-input">
                                                    !-->
                                                   <input type="file" accept="image/*" name="logo" value="@if(!empty(old('logo'))) {{ old('logo') }} @else{{ !empty($tourData->TOUR_LOGO) ? $tourData->TOUR_LOGO : ''  }} @endif" class="custom-file-input">
                                                    
                                                    
                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                </div>
                                            </div>
                                            @if(!empty($tourData->TOUR_LOGO))
                                            <img style="height:50px; width:100px" src="{{url('images/tournaments/'.$tourData->TOUR_LOGO)}}">
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputFile">Banner</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" accept="image/*" name="banner" value="{{ old('banner') }} {{ !empty($tourData->TOUR_BANNER) ? $tourData->TOUR_BANNER : ''  }}" class="custom-file-input">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                </div>
                                            </div>
                                            @if(!empty($tourData->TOUR_BANNER))
                                            <img style="height:50px; width:100px" src="{{url('images/tournaments/banner/'.$tourData->TOUR_BANNER)}}">
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputFile">Mini Banner</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" accept="image/*" name="mini_banner" value="{{ old('mini_banner') }} {{ !empty($tourData->TOUR_MINI_BANNER) ? $tourData->TOUR_MINI_BANNER : ''  }}" class="custom-file-input">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                </div>
                                            </div>
                                            @if(!empty($tourData->TOUR_MINI_BANNER))
                                            <img style="height:50px; width:100px" src="{{url('images/tournaments/mini_banner/'.$tourData->TOUR_MINI_BANNER)}}">
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Organiser Name</label>
                                            <input type="text" name="org_name" value="@if(!empty(old('org_name'))) {{ old('org_name') }} @else {{ !empty($tourData->ORG_NAME) ? $tourData->ORG_NAME : ''  }} @endif" class="form-control" i placeholder="Org name">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Organiser Contact</label>
                                            <input type="text" name="org_contact" value="@if(!empty(old('org_contact'))) {{ old('org_contact') }} @else {{ !empty($tourData->ORG_CONTACT) ? $tourData->ORG_CONTACT : ''  }} @endif" class="form-control" i placeholder="Org contact">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Start Time</label>
                                            <input type="datetime-local" name="start_time" value="@if(!empty(old('start_time'))) {{ date("YYYY-dd-mm", strtotime(old('start_time'))) }}@else{{!empty($tourData->TOUR_START_TIME)?\Carbon\Carbon::parse($tourData->TOUR_START_TIME)->format('Y-m-d\TH:i'):''}}@endif" class="form-control" i placeholder="TOUR_START_TIME">
                                        
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">End Time</label>
                                            <input type="datetime-local" name="end_time" value="@if(!empty(old('end_time'))) {{ date("YYYY-dd-mm", strtotime(old('end_time'))) }}@else{{!empty($tourData->TOUR_END_TIME)?\Carbon\Carbon::parse($tourData->TOUR_END_TIME)->format('Y-m-d\TH:i'):''}}@endif" class="form-control" i placeholder="TOUR_END_TIME">
                                        
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Registration Start Time</label>
                                            <input type="datetime-local" name="reg_start_time" value="@if(!empty(old('reg_start_time'))) {{ date("YYYY-dd-mm", strtotime(old('reg_start_time'))) }}@else{{!empty($tourData->TOUR_REGISTRATION_START_TIME)?\Carbon\Carbon::parse($tourData->TOUR_REGISTRATION_START_TIME)->format('Y-m-d\TH:i'):''}}@endif" class="form-control" i placeholder="TOUR_REGISTRATION_START_TIME">
                                        
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Registration End Time</label>
                                            <input type="datetime-local" name="reg_end_time" value="@if(!empty(old('reg_end_time'))) {{ date("YYYY-dd-mm", strtotime(old('reg_end_time'))) }}@else{{!empty($tourData->TOUR_REGISTRATION_END_TIME)? \Carbon\Carbon::parse($tourData->TOUR_REGISTRATION_END_TIME)->format('Y-m-d\TH:i') :''}}@endif" class="form-control" i placeholder="TOUR_REGISTRATION_END_TIME">
                                        
                                        </div>

                                        <div class="form-group" id="wrap-input">
                                            <label for="example-select">Tournament Rules</label>
                                            @if(!empty($tourData->TOUR_RULES))
                                            @foreach(json_decode($tourData->TOUR_RULES) as $tourRules)
                                            <div class="input-group "><input name="tour_rules[]" type="text" class="form-control username" value="{{ $tourRules }}" placeholder="Add Rules here" aria-label="Add Rules here" required>
                                                <div class="input-group-append"><button type="button" id="add_field_button" class="btn btn-blue btn-xs waves-effect waves-light mr-1"><i class="fa fa-plus"></i> </button>
                                                </div>
                                            </div>&nbsp
                                            @endforeach
                                            @else
                                            <div class="input-group "><input name="tour_rules[]" type="text" class="form-control username" value="" placeholder="Add Rules here" aria-label="Add Rules here" required>
                                                <div class="input-group-append"><button type="button" id="add_field_button" class="btn btn-blue btn-xs waves-effect waves-light mr-1"><i class="fa fa-plus"></i> </button>
                                                </div>

                                            </div>&nbsp
                                            @endif
                                        </div>
                                    </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>


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
        $(function() {
            bsCustomFileInput.init();
        });

        $(document).ready(function() {
            var max_fields = 1000; //maximum input boxes allowed
            var wrapper = $("#wrap-input"); //Fields wrapper
            var add_button = $("#add_field_button"); //Add button ID

            var x = 1; //initlal text box count
            $(add_button).click(function(e) { //on add input button click

                e.preventDefault();
                if (x < max_fields) { //max input box allowed
                    x++; //text box increment
                    $(wrapper).append('<div class="input-group"><input name="tour_rules[]" type="text" class="form-control username" placeholder="Add Rules here" aria-label="Add Rules here" required><div class="input-group-append"></button><button type="button" class="btn btn-danger btn-xs waves-effect waves-light remove_field"><i class="fa fa-trash"></i> </button></div><div class="invalid-feedback">Username Not exist..</div></div>&nbsp');
                }
            });

            $(wrapper).on("click", ".remove_field", function(e) { //user click on remove text
                // alert('dsads');
                // e.preventDefault();
                $(this).parents('.input-group').remove();
                // $(this).parent().parent().remove();

            })
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
