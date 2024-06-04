@section('title', 'Basic Grade Salary Master')
@section('sub-title', 'Basic Grade Salary Master')
@extends('layout.app')

@section('content')

@if(session()->has('message'))
<div class="alert alert-success fade show" role="alert">
    <i class="bi bi-check-circle me-1"></i> {{ session()->get('message') }}
</div>
@endif

<?php
$form_type = (old('formType') );
?>

    <form id="salaryForm" class="form-design" action="{{url('grade_salary_master')}}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="row mb-3 mt-4">
                <label for="grade" class="col-sm-3 col-form-label required">Grade <span class='asterisk'>*</span></label>
                <div class="col-sm-9">
                    <select class="form-select" name="grade" id="grade">
                        <option value="" selected>Select Grade</option>
                        @foreach($all_grades as $grade)
                        <option value="{{ $grade->id }}">{{ $grade->grade }}</option>
                        @endforeach
                    </select>
                        @if ($errors->has('grade'))
                            <span class="text-danger">{{ $errors->first('grade') }}</span>
                        @endif
                </div>
            </div>

            <div class="row mb-3 mt-4">
                <label for="title" class="col-sm-3 col-form-label required">Head Title <span class='asterisk'>*</span></label>
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
                                @foreach($all_master_head as $val)
                                <?php   $head_title = '{'. $val->head_title.'}' ?>
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
                    <label for="title" class="col-sm-3 col-form-label required">Formula<span class="asterisk">*</span></label>
                    <div class="col-sm-9">
                        <textarea id="formulaOutput" name="formulaOutput" rows="4" cols="50">
                        </textarea>

                    </div>
                </div>
            </div>
        </div>

        <div id="only_amt">
            <div class="row mb-3 mt-4">
                <label for="title" class="col-sm-3 col-form-label required">Amount<span class='asterisk'>*</span></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="amount" id="title">
                    @if ($errors->has('amount'))
                    <span class="text-danger">{{ $errors->first('amount') }}</span>
                    @endif
                </div>

            </div>
        </div>

        <div class="modal-footer back-btn">
            <button type="submit" class="btn btn-default">Save</button>
            <a href="{{ url('basic_grade_salary_master_listing') }}" class="btn btn-primary">Back</a>
           
           
        </div>
    </form>

    @endsection @section('js_scripts')
    <script>
        $(document).ready(function() {
            var formType = '{{ old('formType') }}';

        if (formType === 'fixed') {
            $('#only_amt').show();
            $('#formula_div').hide();

        }
        else{
            $('#only_amt').hide();
            $('#formula_div').show();
        }

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
    <script>
        document.getElementById('fixed').addEventListener('click', function() {

            let formAction = "{{url('grade_salary_master')}}";
            // Append the query string for fixed option
            formAction += "?formType=fixed";
            document.getElementById('salaryForm').setAttribute('action', formAction);
        });

        document.getElementById('wid_formula').addEventListener('click', function() {
            let formAction = "{{url('grade_salary_master')}}";
            formAction += "?formType=wid_formula";
            document.getElementById('salaryForm').setAttribute('action', formAction);

        });
    </script>

    <script>
        var formType = '{{ old('formType') }}';
        if (formType === 'fixed') {
            document.getElementById('formula_div').style.display = 'none';
            document.getElementById('fixed').checked = true;
            document.getElementById('fixed').click();
        }
    </script>

    @endsection
