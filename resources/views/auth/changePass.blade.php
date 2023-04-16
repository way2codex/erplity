@extends('layouts.app')
@section('title')
{{$data['title']}}
@endsection
@section('custom_style')

@endsection
@section('main')

<div class="content-body">
    <section id="basic-form-layouts">
        <div class="row match-height">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="basic-layout-form">{{$data['module']}}</h4>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <form action="{{ route('passwordUpdate') }}" id='add_form' name="add_form" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="new_password">New Password</label>
                                                <input type="password" class="form-control" placeholder="New Password" id='new_password' name="new_password" value="{{ old('new_password') }}">
                                                @error('new_password')
                                                        <label id="name-error" class="error" for="new_password">{{ $errors->first('new_password')}}</label>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="new_confirm_password">New Confirm Password</label>
                                                <input type="password" class="form-control" placeholder="New Confirm Password" id='new_confirm_password' name="new_confirm_password" value="{{ old('new_confirm_password') }}">
                                                @error('new_confirm_password')
                                                        <label id="name-error" class="error" for="new_confirm_password">{{ $errors->first('new_confirm_password')}}</label>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-actions text-center">
                                    <button type="submit" class="btn shadow-primary waves-effect waves-light btn-square btn-primary">
                                        <i class="fa fa-check-square-o"></i> Change Password
                                    </button>
                                    <a href="{{ route($data['route']) }}">
                                        <button type="button" class="btn shadow-danger waves-effect waves-light btn-square btn-danger mr-1">
                                            <i class="fa fa-times"></i> Cancel
                                        </button>
                                    </a>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('custom_script')
<script>
    $(document).ready(function() {
        $('.select2').select2();
        $("#add_form").validate({
            rules: {
                new_password: {
                    required: true,
                    minlength:6
                },
                new_confirm_password: {
                    required: true,
                    minlength:6,
                    equalTo: "#new_password"
                }
            },
            messages: {
                new_password: {
                    required: "Please enter a New Password.",
                },
                new_confirm_password: {
                    required: "Please enter a New Confirm Password.",
                    equalTo: 'New And Confirm Password Must Be Same.'
                },
            }
        });

    });
</script>
@endsection
