@extends('layouts.app')
@section('title')
{{ $data['title'] }}
@endsection
@section('custom_style')
<style>
    body {
        overflow: hidden;
    }
</style>
@endsection
@section('main')
<div class="content-body">
    <section id="basic-form-layouts">
        <div class="row match-height">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="basic-layout-form">Add {{ $data['module'] }}</h4>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <form action="{{ route('update_expense') }}" id='add_form' name="add_form" method="POST" enctype="multipart/form-data">
                                <input type="hidden" value="{{ $expense['id'] }}" id="id" name="id" />
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" placeholder="Name" id='name' name="name" value="{{ old('name', $expense->name) }}">
                                                @error('name')
                                                <label id="name-error" class="error" for="name">{{ $errors->first('name') }}</label>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="amount"> Amount</label>
                                                <input type="number" class="form-control" placeholder="Expense Amount" id='amount' name="amount" value="{{ old('amount', $expense->amount) }}">
                                                @error('amount')
                                                <label id="name-error" class="error" for="amount">{{ $errors->first('amount') }}</label>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="datepicker">Transaction Date </label>
                                                <input type="text" name="transaction_date" id="date" class="form-control datepicker" placeholder="Select Date" autocomplete="off" value="{{ date('d-m-Y',strtotime($expense['transaction_date'])) }}" readonly />
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="name">Transaction Type</label>
                                                <select id="transaction_type" name="transaction_type" class="select2 form-control">
                                                    <option value="">Select Transaction Type</option>
                                                    <option <?php if (old('transaction_type', $expense['transaction_type']) == 1) {
                                                                echo 'selected';
                                                            } ?> value="1">Credit</option>
                                                    <option <?php if (old('transaction_type', $expense['transaction_type']) == 0) {
                                                                echo 'selected';
                                                            } ?> value="0">Debit</option>
                                                </select>
                                                <label id="name-error" class="error" for="transaction_type">{{ $errors->first('amount') }}</label>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">Description</label>
                                                <textarea class="form-control description" id="description" name="description">
                                                {{ $expense->description }}
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn shadow-primary waves-effect waves-light btn-square btn-primary">
                                        <i class="fa fa-check-square-o"></i> Update & Save
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
<script src="{{ asset('public/assets/plugins/ckeditor/ckeditor.js') }}"></script>
@section('custom_script')
<script>
    $(document).ready(function() {
        $('.select2').select2();
        CKEDITOR.replace('description');
        $("#add_form").validate({
            rules: {
                name: {
                    required: true
                },
                transaction_type: {
                    required: true
                },
                amount: {
                    required: true
                },
            },
            messages: {
                name: {
                    required: "Please Enter Expsense Type.",
                },
                transaction_type: {
                    required: "Please Enter Expsense name."
                },
                amount: {
                    required: "Please Enter Amount."
                },
            }
        });

    });
</script>
@endsection