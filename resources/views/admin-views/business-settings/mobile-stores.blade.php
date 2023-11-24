@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('general_settings'))

@push('css_or_js')
    <link href="{{ asset('public/assets/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{ asset('public/assets/back-end/css/custom.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="pb-2">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{asset('/public/assets/back-end/img/business-setup.png')}}" alt="">
                Mobile Stores Set Up
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Mob Stores Start Here -->
        <form action="" method="POST">
            @csrf
            <div class="row" style="margin-top: 30px">
                <div class="col-md-6">
                    @php($google_store_link=\App\Model\BusinessSetting::where('type','download_app_google_stroe')->first())
                    <?php
                        $google_store_linkV = $google_store_link->value;
                        $parsed_data_google=json_decode($google_store_linkV,true);
                        $google_status = $parsed_data_google['status'];
                        $google_link = $parsed_data_google['link'];

                    ?>
                    
                    <div class="form-group">
                        <div class="row" >
                            <label class="title-color d-flex">Google Play Store Link</label>
                            <label class="switcher" style="margin: 0 20px 0 auto">
                            <!-- $banner->id -->
                                <input type="checkbox" class="switcher_input status1"
                                        id="download_app_google_stroe" <?php if ($google_status == 1) echo "checked" ?>>
                                <span class="switcher_control"></span>
                            </label>
                        </div>
                        <input class="form-control google_play_link" type="text" 
                            value="{{ $google_link?$google_link:"" }}"
                            placeholder="New Business">
                            
                            <button class="btn btn-primary sBtn1" style="margin-top: 30px" type="button">Save Changes</button>
                    </div>

                    

                </div>

                <div class="col-md-6">
                    @php($apple_store_link=\App\Model\BusinessSetting::where('type','download_app_apple_stroe')->first())
                    <?php
                        $apple_store_linkV = $apple_store_link->value;
                        $parsed_data_apple=json_decode($apple_store_linkV,true);
                        $apple_status = $parsed_data_apple['status'];
                        $apple_link = $parsed_data_apple['link'];

                    ?>
                    
                    <div class="form-group">
                        <div class="row">
                            <label class="title-color d-flex">Apple Play Store Link</label>
                            <label class="switcher" style="margin: 0 20px 0 auto">
                            <!-- $banner->id -->
                                <input type="checkbox" class="switcher_input status2" 
                                        <?php if ($apple_status == 1) echo "checked" ?>>
                                <span class="switcher_control"></span>
                            </label>
                        </div>
                        
                        <input class="form-control apple_store_link" type="text" name="apple_store_link"
                            value="{{ $apple_link?$apple_link:"" }}"
                            placeholder="New Business">

                        <button class="btn btn-primary sBtn2" style="margin-top:30px;" type="button">Save Changes</button>

                        
                    </div>

                    

                </div>
                

                

            </div>
        </form>

        <!-- Mob Store End Here -->
    
</div>
@endsection


@push('script')
    <script src="{{asset('public/assets/back-end')}}/js/tags-input.min.js"></script>
    <script src="{{ asset('public/assets/select2/js/select2.min.js')}}"></script>
    <script>

        $("#customFileUploadShop").change(function () {
            read_image(this, 'viewerShop');
        });

        $("#customFileUploadWL").change(function () {
            read_image(this, 'viewerWL');
        });

        $("#customFileUploadWFL").change(function () {
            read_image(this, 'viewerWFL');
        });

        $("#customFileUploadML").change(function () {
            read_image(this, 'viewerML');
        });

        $("#customFileUploadFI").change(function () {
            read_image(this, 'viewerFI');
        });

        $("#customFileUploadLoader").change(function () {
            read_image(this, 'viewerLoader');
        });

        function read_image(input, id) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#' + id).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            width: 'resolve'
        });

    </script>
    <script>
        $(document).ready(function () {
            $('.color-var-select').select2({
                templateResult: colorCodeSelect,
                templateSelection: colorCodeSelect,
                escapeMarkup: function (m) {
                    return m;
                }
            });

            function colorCodeSelect(state) {
                var colorCode = $(state.element).val();
                if (!colorCode) return state.text;
                return "<span class='color-preview' style='background-color:" + colorCode + ";'></span>" + state.text;
            }
        });
    </script>

    <script>
        @php($language=\App\Model\BusinessSetting::where('type','pnc_language')->first())
        @php($language = $language->value ?? null)
        let language = {{$language}};
        $('#language').val(language);
    </script>

    <script>
        
        
        $(document).on('click', '.sBtn1', function () {
            
            if ($(".status1").prop("checked") === true) {
                var status = 1;
            } else if ($(".status1").prop("checked") === false) {
                var status = 0;
            }
            let mbLink = $(".google_play_link").val();
           
            
           
       
            

            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            
            $.ajax({
                
                url: "{{route('admin.business-settings.web-config.app-store-update', ['name' => 'download_app_google_stroe' ])}}",
                method: 'post',
                data: {
                    
                    status: status,
                    link: mbLink
                },
                success: function (data) {
                    console.log("success");
                    
                        toastr.success('{{\App\CPU\translate('Store_link_uploaded_successfully')}}');
                    
                }
            });

        });

        $(document).on('click', '.sBtn2', function () {
            
            if ($(".status2").prop("checked") === true) {
                var status = 1;
            } else if ($(".status2").prop("checked") === false) {
                var status = 0;
            }
            let mbLink = $(".apple_store_link").val();
           
            
           
       
            

            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            
            $.ajax({
                
                url: "{{route('admin.business-settings.web-config.app-store-update', ['name' => 'download_app_apple_stroe' ])}}",
                method: 'post',
                data: {
                    
                    status: status,
                    link: mbLink
                },
                success: function (data) {
                    console.log("success");
                    toastr.success('{{\App\CPU\translate('Store_link_uploaded_successfully')}}');
                }
            });

        });

        

        
    </script>

    <script>
        function maintenance_mode() {
            @if(env('APP_MODE')=='demo')
            call_demo();
            @else
            Swal.fire({
                title: '{{\App\CPU\translate('Are you sure')}}?',
                text: '{{\App\CPU\translate('Be careful before you turn on/off maintenance mode')}}',
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#377dff',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.get({
                        url: '{{route('admin.maintenance-mode')}}',
                        contentType: false,
                        processData: false,
                        beforeSend: function () {
                            $('#loading').show();
                        },
                        success: function (data) {
                            toastr.success(data.message);
                        },
                        complete: function () {
                            $('#loading').hide();
                        },
                    });
                } else {
                    location.reload();
                }
            })
            @endif
        };

        function currency_symbol_position(route) {
            $.get({
                url: route,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    toastr.success(data.message);
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        }
    </script>

    

    <script>
        $(document).ready(function () {
            $("#phone_verification_on").click(function () {
                @if(env('APP_MODE')!='demo')
                if ($('#email_verification_on').prop("checked") == true) {
                    $('#email_verification_off').prop("checked", true);
                    $('#email_verification_on').prop("checked", false);
                    const message = "{{\App\CPU\translate('Both Phone & Email verification can not be active at a time')}}";
                    toastr.info(message);
                }
                @else
                call_demo();
                @endif
            });
            $("#email_verification_on").click(function () {
                if ($('#phone_verification_on').prop("checked") == true) {
                    $('#phone_verification_off').prop("checked", true);
                    $('#phone_verification_on').prop("checked", false);
                    const message = "{{\App\CPU\translate('Both Phone & Email verification can not be active at a time')}}";
                    toastr.info(message);
                }
            });
        });


    </script>

    
@endpush
