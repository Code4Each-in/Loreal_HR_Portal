@section('title', 'Update Salary Head')
@section('sub-title', 'Update Salary Head')
@extends('layout.app')

@section('content')

@if(session()->has('message'))
<div id="successMessage" class="alert alert-success fade show" role="alert">
    <i class="bi bi-check-circle me-1"></i>
    {{ session()->get('message') }}
</div>
@endif
<form action="{{ url('update_salary_head/'.$SalaryHead->id) }}" method="POST">
    @csrf
    <div class="modal-body">
    
        <div class="row mb-3 mt-4">
            <label for="title" class="col-sm-3 col-form-label required">Head Title</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="head_title" id="head_title" value="{{ $SalaryHead->head_title}}">
                @if ($errors->has('head_title'))
                <span class="text-danger">{{ $errors->first('head_title') }}</span>
                @endif
            </div>
        </div>
        <div class="row mb-3">
            <label for="content" class="col-sm-3 col-form-label required">Select the option</label>
            <div class="col-sm-3">
                <input type="radio" id="wid_formula" name="method" value="wid_formula" {{ ($SalaryHead->method=="wid_formula")? "checked" : "" }}>
                  <label for="wid_formula">Make Formula </label>
            </div>
            <div class="col-sm-3">
                <input type="radio" id="fixed" name="method" value="fixed" {{ ($SalaryHead->method=="fixed")? "checked" : "" }}>
                  <label for="fixed">Fixed</label>
            </div>
        </div>

        <div id="formula_div" <?php if ($SalaryHead->method == "fixed") { ?> style="display: none;" <?php } ?>>
            <section class="main-section">
                <section class="cal2">
                    <div class="design-button">
                        <h4>Salary Head</h4>
                        <div class="cal-button ">
                            @foreach($all_master_head as $val)

                            <?php $head_title = '{' . $val->head_title . '}' ?>
                            <a onclick="showFormula('{{$head_title}}')" data-salary-formula="" class="button-deisgn">{{ $val->head_title }}</a>

                            @endforeach


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
                            <a onclick="showFormula('{VPP_PR}')" class="button-deisgn">VPP %</a>
                        </div>
                    </div>

                </section>
                <section class="calculator">
                    <!-- <input type="text" placeholder="0" id="inputBox"> -->
                    <div class="cal-section">
                        <a onclick="clearFormulaOutput()" class="operator">AC</a>
                        <a onclick="showFormula('/')" class="operator">/</a>
                        <a onclick="showFormula('%')" class="operator">%</a>
                        <a onclick="showFormula('÷')" class="operator">÷</a>
                    </div>
                    <div class="cal-section">
                        <a onclick="showFormula('7')">7</a>
                        <a onclick="showFormula('8')">8</a>
                        <a onclick="showFormula('9')">9</a>
                        <a onclick="showFormula('*')" class="operator">x</a>
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
                    <textarea id="formulaOutput" name="formulaOutput" rows="4" cols="50">{{ $SalaryHead->formula}}</textarea>

                </div>
            </div>
        </div>

    </div>
    <div id="only_amt">
        <div class="row mb-3 mt-4">
            <label for="title" class="col-sm-3 col-form-label required">Amount</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="amount" id="title" value="{{ $SalaryHead->amount}}">
            </div>
        </div>
    </div>

    <!-- <div class="modal-footer">

        <button type="submit" class="btn btn-default">Save</button>
    </div> -->
    <div class="modal-footer back-btn">
        <button type="submit" class="btn btn-default">Save</button>
        <a href="{{ url('salary_head_listing') }}" class="btn btn-primary  back_btn">Back</a>
    </div>

</form>
@endsection

@section('js_scripts')
<script>
    $(document).ready(function() {
        // By default, hide the amount div and show the formula div
        @if($SalaryHead-> method == "fixed")
        $('#only_amt').show();
        $('#formula_div').hide();
        @endif

        @if($SalaryHead-> method == "wid_formula")
        $('#only_amt').hide();
        $('#formula_div').show();
        @endif

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
        textarea.value += value;
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

<script>
    $(document).ready(function() {
        $("#head_title").focus(function() {

        });
    });
</script>




@endsection