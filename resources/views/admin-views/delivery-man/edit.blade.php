@extends('layouts.back-end.app')

@section('title',\App\CPU\translate('Update delivery-man'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{asset('/public/assets/back-end/img/deliveryman.png')}}" width="20" alt="">
                {{\App\CPU\translate('Update_Deliveryman')}}
            </h2>
        </div>
        <!-- End Page Title -->

        <div class="row">
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('admin.delivery-man.update',[$delivery_man['id']])}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="title-color d-flex">{{\App\CPU\translate('first')}} {{\App\CPU\translate('name')}}</label>
                                        <input type="text" value="{{$delivery_man['f_name']}}" name="f_name"
                                               class="form-control" placeholder="{{\App\CPU\translate('New delivery-man')}}"
                                               required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="title-color d-flex">{{\App\CPU\translate('last')}} {{\App\CPU\translate('name')}}</label>
                                        <input type="text" value="{{$delivery_man['l_name']}}" name="l_name"
                                               class="form-control" placeholder="{{\App\CPU\translate('Last Name')}}"
                                               required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="title-color d-flex">{{\App\CPU\translate('email')}}</label>
                                        <input type="email" value="{{$delivery_man['email']}}" name="email" class="form-control"
                                               placeholder="{{\App\CPU\translate('Ex : ex@example.com')}}"
                                               required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="title-color d-flex">{{\App\CPU\translate('phone')}}</label>
                                        <input type="text" name="phone" value="{{$delivery_man['phone']}}" class="form-control"
                                               placeholder="{{\App\CPU\translate('Ex : 017********')}}"
                                               required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="title-color d-flex">{{\App\CPU\translate('identity')}} {{\App\CPU\translate('type')}}</label>
                                        <select name="identity_type" class="form-control">
                                            <option
                                                value="passport" {{$delivery_man['identity_type']=='passport'?'selected':''}}>
                                                {{\App\CPU\translate('passport')}}
                                            </option>
                                            <option
                                                value="driving_license" {{$delivery_man['identity_type']=='driving_license'?'selected':''}}>
                                                {{\App\CPU\translate('driving')}} {{\App\CPU\translate('license')}}
                                            </option>
                                            <option value="nid" {{$delivery_man['identity_type']=='nid'?'selected':''}}>{{\App\CPU\translate('nid')}}
                                            </option>
                                            <option
                                                value="company_id" {{$delivery_man['identity_type']=='company_id'?'selected':''}}>
                                                {{\App\CPU\translate('company')}} {{\App\CPU\translate('id')}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="title-color d-flex">{{\App\CPU\translate('identity')}} {{\App\CPU\translate('number')}}</label>
                                        <input type="text" name="identity_number" value="{{$delivery_man['identity_number']}}"
                                               class="form-control"
                                               placeholder="{{\App\CPU\translate('Ex : DH-23434-LS')}}"
                                               required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="title-color d-flex">{{\App\CPU\translate('identity')}} {{\App\CPU\translate('image')}}</label>
                                        <div>
                                            <div class="row" id="coba">
                                                @foreach(json_decode($delivery_man['identity_image'],true) as $img)
                                                    <div class="col-md-4 mb-3">
                                                        <img height="150" src="{{asset('storage/app/public/delivery-man').'/'.$img}}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="title-color d-flex">{{\App\CPU\translate('password')}}</label>
                                <input type="text" name="password" class="form-control" placeholder="{{\App\CPU\translate('Ex : password')}}">
                            </div>

                            <div class="form-group">
                                <div class="d-flex mb-2 gap-2 align-items-center">
                                    <label class="title-color mb-0">{{\App\CPU\translate('deliveryman')}} {{\App\CPU\translate('image')}}</label>
                                    <span class="text-info">* ( {{\App\CPU\translate('ratio')}} 1:1 )</span>
                                </div>
                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" name="image" id="customFileEg1" class="custom-file-input"
                                            accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                        <label class="custom-file-label" for="customFileEg1">{{\App\CPU\translate('choose')}} {{\App\CPU\translate('file')}}</label>
                                    </div>
                                </div>
                                <center>
                                    <img class="upload-img-view" id="viewer"
                                         src="{{asset('storage/app/public/delivery-man').'/'.$delivery_man['image']}}" alt="delivery-man image"/>
                                </center>
                            </div>
                            <div class="d-flex justify-content-end gap-3">
                                <button type="reset" id="reset" class="btn btn-secondary px-4">{{\App\CPU\translate('reset')}}</button>
                                <button type="submit" class="btn btn--primary px-4">{{\App\CPU\translate('submit')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script_2')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this);
        });
    </script>

    <script src="{{asset('public/assets/back-end/js/spartan-multi-image-picker.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            $("#coba").spartanMultiImagePicker({
                fieldName: 'identity_image[]',
                maxCount: 5,
                rowHeight: '120px',
                groupClassName: 'col-2',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{asset('public/assets/back-end/img/400x400/img2.jpg')}}',
                    width: '100%'
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('Please only input png or jpg type file', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('File size too big', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });
    </script>
@endpush
