@section('title', 'Salary Head')
@section('sub-title', 'Salary Head')
@extends('layout.app')

@section('content')

@if(session()->has('message'))
<div class="alert alert-success fade show" role="alert">
    <i class="bi bi-check-circle me-1"></i>
    {{ session()->get('message') }}
</div>
@endif
<form action="{{ url('salaryHead') }}" method="POST">
    @csrf
    <div class="modal-body">

        <div class="row mb-3 mt-4">
            <label for="title" class="col-sm-3 col-form-label required">Head Title</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="head_title" id="title">
                @if ($errors->has('head_title'))
                <span class="text-danger">{{ $errors->first('head_title') }}</span>
                @endif
            </div>
        </div>
        <div class="row mb-3 mt-4">
            <label for="title" class="col-sm-3 col-form-label required">Compile</label>
            <div class="col-sm-9">
            <div id="formulaContainer">
                <a onclick="showFormula('BASIC')">BASIC</a>
                <a onclick="showFormula('Add')">Add</a>
                <a onclick="showFormula('Sub')">Sub</a>
                <a onclick="showFormula('100')">100</a>
                <a onclick="showFormula('Mul')">Mul</a>
                <a onclick="showFormula('Div')">Div</a>
           </div>
            

            </div>
        </div>
        <div class="row mb-3 mt-4">
            <label for="title" class="col-sm-3 col-form-label required">Formula</label>
            <div class="col-sm-9">
            <textarea id="formulaOutput" name="formulaOutput" rows="4" cols="50">

            </textarea>
            </div>
        </div>
        <div class="row mb-3">
            <label for="content" class="col-sm-3 col-form-label required">Select the option</label>
            <div class="col-sm-3">
                <input type="radio" id="wid_formula" name="method" value="wid_formula" checked>
                  <label for="wid_formula">Make Formula </label>
            </div>
            <div class="col-sm-3">
                <input type="radio" id="fixed" name="method" value="fixed">
                  <label for="fixed">Fixed</label>
            </div>
        </div>

        <div id="formula_div">
            <div class="row mb-3">
                <label for="content" class="col-sm-3 col-form-label required">Formula</label>
                <div class="col-sm-3">
                    <select name="salary_component">
                        <option value="Bacic_salary">Basic salary </option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <select name="symbol">
                        <option value="+"> + </option>
                        <option value="-">- </option>
                        <option value="/"> / </option>
                        <option value="%"> % </option>
                        <option value="*"> * </option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="percentage" id="title" placeholder="Enter the percentage">
                </div>
            </div>
        </div>
    </div>
    <div id="only_amt">
        <div class="row mb-3 mt-4">
            <label for="title" class="col-sm-3 col-form-label required">Amount</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="amount" id="title">
            </div>
        </div>
    </div>

    <div class="modal-footer">

        <button type="submit" class="btn btn-default">Save</button>
    </div>
</form>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        // By default, hide the amount div and show the formula div
        $('#only_amt').hide();
        $('#formula_div').show();

        $("input[name='method']").click(function() {
            var selectedValue = $(this).val();
            if (selectedValue == "wid_formula") {
                $('#only_amt').hide();
                $('#formula_div').show();
            } else if (selectedValue == "fixed") {
                $('#only_amt').show();
                $('#formula_div').hide();
            }
        });
    });
</script>
<script>
        function showFormula(value) {
            // Get the textarea element
            var textarea = document.getElementById("formulaOutput");

            // Append the clicked button's value to the textarea content
            textarea.value += value + " ";
        }
    </script>



@endsection