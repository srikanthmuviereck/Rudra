<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Rudra Connect - Payslip</title>
    <style>

        body{
            font-family: Arial, Helvetica, sans-serif !important;
            /* letter-spacing: -0.3px; */
        }

        .invoice-wrapper{ margin: auto; }

        table{
            width: 100%;
            border-collapse:collapse;
            border: 1px solid black;
            margin-top: 20px !important;
        }

        table td{line-height:25px;padding-left: 8px;font-size: 14px !important;}

        .companyName{
            font-size: 20px !important;
        }

        .addr{
            font-size: 14px !important;
            font-weight: 700;
        }

    </style>
</head>
<body>
    <div class="row invoice-wrapper">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <center>
                        <h2 class="companyName">
                            RUDRA CORPORATE SERVICES
                        </h2>
                        <p class="addr">
                           D.No: 3-1-104/A, Krishna Nagar, 9th Lane, Sri Venkateswara Nilayam, Guntur - 522 006
                        </p>
                    </center>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table border="1">
                        <tr>
                            <td><strong>Name</strong></td>
                            <td>{{$name}}</td>
                            <td><strong>Month & Year</strong></td>
                            <td>{{$monthandyear}}</td>
                        </tr>
                        <tr>
                            <td><strong>Emp. Id</strong></td>
                            <td>{{$empid}}</td>
                            <td><strong>Client Name</strong></td>
                            <td>{{$clientname}}</td>
                        </tr>
                        <tr>
                            <td><strong>Designation</strong></td>
                            <td>{{$designation}}</td>
                            <td><strong>Bank</strong></td>
                            <td>{{$bank}}</td>
                        </tr>
                        <tr>
                            <td><strong>UAN</strong></td>
                            <td>{{$uan}}</td>
                            <td><strong>Bank A/C No</strong></td>
                            <td>{{$bankaccno}}</td>
                        </tr>
                        <tr>
                            <td><strong>ESI No</strong></td>
                            <td>{{$esino}}</td>
                            <td><strong>Bank IFSC Code</strong></td>
                            <td>{{$bankifsccode}}</td>
                        </tr>
                        <tr>
                            <td colspan="4" style="padding: 10px 0px;"></td>
                        </tr>
                        <tr>
                            <td><strong>No. of Duties : </strong> <span> {{$noofduties}} </span> </td>
                            <td><strong>OT : </strong> <span> {{$overtime}} </span> </td>
                            <td><strong>Total Working Days : </strong></td>
                            <td>{{$totalworkingdays}}</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center;font-weight:bold; ">Earnings</td>
                            <td colspan="2" style="text-align: center;font-weight:bold; ">Deduction</td>
                        </tr>
                        <tr>
                            <td><strong>Basic Pay</strong></td>
                            <td>{{$basicpay}}</td>
                            <td><strong>EPF</strong></td>
                            <td>{{$epf}}</td>
                        </tr>
                        <tr>
                            <td><strong>DA</strong></td>
                            <td>{{$dapay}}</td>
                            <td><strong>ESI</strong></td>
                            <td>{{$esi}}</td>
                        </tr>
                        <tr>
                            <td><strong>OT</strong></td>
                            <td>{{$otpay}}</td>
                            <td><strong>Uniform Deduction</strong></td>
                            <td>{{$uniformdeduction}}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><strong>Advance</strong></td>
                            <td>{{$advance}}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><strong>Others</strong></td>
                            <td>{{$others}}</td>
                        </tr>
                        <tr>
                            <td><strong>Gross Salary</strong></td>
                            <td>{{$totaldeduction}}</td>
                            <td><strong>Total Deduction</strong></td>
                            <td>{{$gross_salary}}</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center;font-weight:bold; ">Net Pay</td>
                            <td colspan="2" style="text-align: left;font-weight:bold; ">{{$net_pay}}</td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <strong>In Word : </strong> {{$netpayinwords}}  
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <strong>
                                    This is a computer-generated pay slip and does not require any further authentication
                                </strong>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>    
</body>
</html>