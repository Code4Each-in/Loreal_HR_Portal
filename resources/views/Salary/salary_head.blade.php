@section('title', 'Salary Head')
@section('sub-title', 'Salary Head')
@extends('layout.app')

@section('content')
<style>
    .calculator {
        border: 1px solid #717377;
        padding: 10px;
        border-radius: 16px;
        background: transparent;
        box-shadow: 0px 3px 15px rgba(113, 115, 119, 0.5);
    }

    .calculator input {
        width: 285px;
        border: none;
        padding: 7px;
        margin: 5px;
        background: #000;
        box-shadow: 0px 3px 15px rgba(84, 84, 84, 0.1);
        font-size: 30px;
        text-align: right;
        cursor: pointer;
    }

    .calculator input::placeholder {
        color: #ffffff;
    }

    .calculator a {
        border: none;
        width: 50px;
        height: 50px;
        margin: 12px 12px 0px;
        border-radius: 50%;
        background: #898989;
        color: #ffffff;
        font-size: 16px;
        box-shadow: -8px -8px 15px rgba(255, 255, 255, 0.1);
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .calculator .equalBtn {
        background-color: #fb7c14;
    }

    .calculator .operator {
        color: #6dee0a;
    }

    .cal-section {
        /* width: 100%; */
        display: flex;
        align-items: center;
        margin: 0px auto;
        justify-content: center;
        /* gap: 5px; */
    }

    section.main-section {
        display: flex;
        justify-content: center;
        margin: 0px auto;
        column-gap: 30px;
    }

    section.cal2 {
        border: 1px solid #717377;
        padding: 10px;
        border-radius: 16px;
        background: transparent;
        box-shadow: 0px 3px 15px rgba(113, 115, 119, 0.5);
    }

    a.button-deisgn {
        padding: 15px 30px;
        border: 1px solid #898989;
        background: #898989;
        color: #fff;
        border-radius: 5px;
        font-size: 20px;
        font-weight: 500;
        font-family: ui-monospace;
    }

    .design-button {
        overflow-y: scroll;
        padding: 14px 15px 0px;
        margin: 10px 0px 0px;
        height: 41vh;
    }

    a.button-deisgn:hover {
        border: 1px solid #71ee0a;
        background: #76dd4f;
        color: #fff;
    }

    .cal-button {
        padding: 5px;
        display: flex;
        flex-direction: column;
        row-gap: 10px;
    }
</style>

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

        <div id="formula_div">
            <section class="main-section">
            <section class="cal2">
                    <div class="design-button">
                        <h4>Salary Head</h4>
                        <div class="cal-button ">
                            <a onclick="showFormula('{BASIC}')" class="button-deisgn">Basic</a>
                            <a onclick="showFormula('{HRA}')" class="button-deisgn">HRA</a>
                            <a onclick="showFormula('{Edu}')" class="button-deisgn">Edu</a>
                            <a onclick="showFormula('{SP_ALW}')"  class="button-deisgn">Sp Alw</a>
                            <a onclick="showFormula('{WPS}')"  class="button-deisgn">WPS</a>
                            <a onclick="showFormula('{CAR}')"  class="button-deisgn">CAR</a>
                            <a onclick="showFormula('{MEAL}')"  class="button-deisgn">MEAL</a>
                            <a onclick="showFormula('{PF}')"  class="button-deisgn">PF</a>
                            <a onclick="showFormula('{TOTAL_BASE}')"  class="button-deisgn">TOTAL BASE</a>
                            <a onclick="showFormula('{VPP}')"  class="button-deisgn">VPP</a>
                          
                        </div>
                    </div>

                </section>
                <section class="cal2">
                    <div class="design-button">
                    <h4>Source Factor</h4>
                        <div class="cal-button ">
                            <a onclick="showFormula('{Basic_PAY}')" class="button-deisgn">Basic pay</a>
                            <a onclick="showFormula('{BASIC_PR}')" class="button-deisgn">Basic %</a>
                            <a onclick="showFormula('{INCENTIVE}')" class="button-deisgn">Incentive</a>
                            <a onclick="showFormula('{VPP_PR}')"  class="button-deisgn">VPP %</a>
                        </div>
                    </div>

                </section>
                <section class="calculator">
                    <!-- <input type="text" placeholder="0" id="inputBox"> -->
                    <div class="cal-section">
                        <a onclick="showFormula('AC')" class="operator">AC</a>
                        <a onclick="showFormula('/')" class="operator">/</a>
                        <a onclick="showFormula('%')" class="operator">%</a>
                        <a onclick="showFormula('÷')" class="operator">÷</a>
                    </div>
                    <div class="cal-section">
                        <a onclick="showFormula('7')">7</a>
                        <a onclick="showFormula('8')">8</a>
                        <a onclick="showFormula('9')">9</a>
                        <a onclick="showFormula('x')" class="operator">x</a>
                    </div>
                    <div class="cal-section">
                        <a onclick="showFormula('4')">4</a>
                        <a onclick="showFormula('5')">5</a>
                        <a onclick="showFormula('6')">6</a>
                        <a onclick="showFormula('-')" class="operator">-</a>
                    </div>
                    <div class="cal-section">
                        <a onclick="showFormula('1')">1</a>
                        <a onclick="showFormula('2')">2</a>
                        <a onclick="showFormula('3')">3</a>
                        <a onclick="showFormula('+')" class="operator">+</a>
                    </div>
                    <div class="cal-section">

                        <a onclick="showFormula('0')">0</a>
                        <a onclick="showFormula('.')">.</a>
                        <a onclick="showFormula('(')" class="operator">(</a>
                        <a onclick="showFormula(')')" class="operator">)</a>

                    </div>
                </section>

            </section>
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
    let input = document.getElementById('inputBox');
    let buttons = document.querySelectorAll('button');

    let string = "";
    let arr = Array.from(buttons);
    arr.forEach(button => {
        button.addEventListener('click', (e) => {
            if (e.target.innerHTML == '=') {
                string = eval(string);
                input.value = string;
            } else if (e.target.innerHTML == 'AC') {
                string = "";
                input.value = string;
            } else if (e.target.innerHTML == 'DEL') {
                string = string.substring(0, string.length - 1);
                input.value = string;
            } else {
                string += e.target.innerHTML;
                input.value = string;

            }
        })
    })
</script>

@endsection