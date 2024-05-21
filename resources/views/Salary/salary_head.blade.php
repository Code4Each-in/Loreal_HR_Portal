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
        <section class="main-section">
        <section class="cal2">
            <div class="design-button">
                <div class="cal-button ">
                    <button class="button-deisgn">Basic pay</button>
                    <button class="button-deisgn">Basic pay</button>
                    <button class="button-deisgn">Basic pay</button>
                    <button class="button-deisgn">Basic pay</button>
                    <button class="button-deisgn">Basic pay</button>
                    <button class="button-deisgn">Basic pay</button>
                    <button class="button-deisgn">Basic pay</button>
                    <button class="button-deisgn">Basic pay</button>
                    <button class="button-deisgn">Basic pay</button>

                </div>
            </div>

        </section>
        <section class="calculator">
            <input type="text" placeholder="0" id="inputBox">
            <div class="cal-section">
                <button class="operator">AC</button>
                <button class="operator">DEL</button>
                <button class="operator">%</button>
                <button class="operator">÷</button>
            </div>
            <div class="cal-section">
                <button>7</button>
                <button>8</button>
                <button>9</button>
                <button class="operator">x</button>
            </div>
            <div class="cal-section">
                <button>4</button>
                <button>5</button>
                <button>6</button>
                <button class="operator">-</button>
            </div>
            <div class="cal-section">
                <button>1</button>
                <button>2</button>
                <button>3</button>
                <button class="operator">+</button>
            </div>
            <div class="cal-section">

                <button>0</button>
                <button>.</button>
                <button class="operator">(</button>
                <button class="operator">)</button>

            </div>
        </section>

    </section>

        <div id="formula_div">
        <div class="row mb-3 mt-4">
            <label for="title" class="col-sm-3 col-form-label required">Compile</label>
            <div class="col-sm-9">
                <div id="formulaContainer">
                    <a onclick="showFormula('BASIC')">BASIC</a>
                    <a onclick="showFormula('Base Pay')">Base Pay</a>
                    <a onclick="showFormula('Basic %')">Basic %</a>
                    <a onclick="showFormula('Incentive')">Incentive</a>
                    <a onclick="showFormula('VPP %')">VPP %</a>

                    <a href="#" onclick="showFormula('(')">(</a>
                    <a href="#" onclick="showFormula(')')">)</a>
                    <a onclick="showFormula('+')">+</a>
                    <a onclick="showFormula('%')">%</a>
                    <a onclick="showFormula('-')">-</a>
                    
                    <a onclick="showFormula('*')">*</a>
                    <a onclick="showFormula('/')">/</a>
                    <a onclick="showFormula('.')">.</a>
                    <a onclick="showFormula('1')">1</a>
                    <a onclick="showFormula('2')">2</a>
                    <a onclick="showFormula('3')">3</a>
                    <a onclick="showFormula('4')">4</a>
                    <a onclick="showFormula('5')">5</a>
                    <a onclick="showFormula('6')">6</a>
                    <a onclick="showFormula('7')">7</a>
                    <a onclick="showFormula('8')">8</a>
                    <a onclick="showFormula('100')">100</a>
                </div>


            </div>
        </div>
        <div class="row mb-3 mt-4">
            <label for="title" class="col-sm-3 col-form-label required">Formula</label>
            <div class="col-sm-9">
                <textarea id="formulaOutput" name="formulaOutput" rows="4" cols="50">
            </textarea>
            <a id="clearFormula" onclick="clearFormulaOutput()">Clear</a>
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
@endsection

@section('js_scripts')
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
    // Append the clicked button's value to the textarea content
    function showFormula(value) {
        var textarea = document.getElementById("formulaOutput");
        textarea.value += value + " ";
    }

 // To clear the formulaOutput textarea
    function clearFormulaOutput() {
        var textarea = document.getElementById("formulaOutput");
        textarea.value = '';
    }
</script>

@endsection

