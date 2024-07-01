<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="pdf.css" type="text/css">
    <title>{{ $title }}</title>
</head>
<body>
    <section class="salery-slip">
        <div class="container mt-5 mb-5">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="fw-bold text-center">Payslip</h1>
                    <div class="main-title lh-1 mb-2 ">
                        <span class="fw-normal">Payment slip for the month of {{ $month  }} {{ $year }}</span>
                    </div>
                    <div class="form-contact ">
                        <div class="div-class">
                            <div class="first-div">
                                <h3> Employee Name:</h3>
                            </div>
                            <div class="second-div">
                                <span class="fill-form">{{ $f_name }} {{ $l_name }}</span>
                            </div>
                        </div>

                        <div class="div-class1">
                            <div class="first-div">
                                <h3> Phone No :</h3>
                            </div>
                            <div class="second-div">
                                <span class="fill-form">{{ $phone }} </span>
                            </div>
                        </div>
                        <div class="div-class2">
                            <div class="first-div">
                                <h3> Month :</h3>
                            </div>
                            <div class="second-div">
                                <span class="fill-form">{{ $month }} </span>
                            </div>
                        </div>
                        <div class="div-class3">
                            <div class="first-div">
                                <h3> Year :</h3>
                            </div>
                            <div class="second-div">
                                <span class="fill-form">{{ $year }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="margin-top">
                    <table class="products box-shadow" style="box-shadow: 0 2px 12px rgba(0, 0, 0, 0.25), 0 2px 2px rgba(0, 0, 0, 0.22) ;">
                        <thead class="table-heading bg-dark m">
                            <tr>
                                <th scope="col">Salary Head</th>
                                <th scope="col">Amount</th>

                            </tr>
                        </thead>
                        <tbody class="text-table">
                             @php  $sal = 0 ; @endphp
                            @foreach($sal_head as $val)
                            <tr>
                                <td scope="row" class="text-design">{{ $val-> meta_key }}</th>
                                <td class="text-design1">{{ $val-> meta_value }}</td>
                            </tr>
                            @php  $sal = $sal +  $val-> meta_value ; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="net-pay-cont"><span class="total-div fw-bold text-right">Net Pay : {{ $sal }}</span></div>
            </div>
        </div>
        </div>
        </div>
    </section>


</body>

</html>