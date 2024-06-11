<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
        }
        .header p {
            margin: 5px 0;
        }
        .content {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .left, .right {
            width: 48%;
        }
        .left p, .right p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .totals {
            text-align: right;
        }
        .totals p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Pay Slip</h1>
            <p>TechMarbles Web Solutions Pvt. Ltd.</p>
            <p>F-8, Phase 8, First Floor, Industrial Area, Mohali, Punjab.</p>
            <h2>Pay Slip for the Month of: {{ \Carbon\Carbon::parse($employee->created_at)->format('d-m-Y') }}</h2>
        </div>

        <div class="content">
            <div class="left">
                <p><strong>Employee Name:</strong> {{ $employee->name }}</p>
                <p><strong>Department:</strong> {{ $employee->department }}</p>
                <p><strong>Bank A/c No.:</strong> {{ $employee->account_no }}</p>
                <p><strong>UAN No.:</strong> {{ $employee->uan_no }}</p>
                <p><strong>Payable Days:</strong> {{ $employee->payable_days }}</p>
            </div>
            <div class="right">
                <p><strong>Employee Code:</strong> {{ $employee->employee_code }}</p>
                <p><strong>DOJ (MM/DD/YYYY):</strong> {{ $employee->doj }}</p>
                <p><strong>Designation:</strong> {{ $employee->designation }}</p>
                <p><strong>ESI No.:</strong> {{ $employee->esiNo }}</p>
                <p><strong>PAN No.:</strong> {{ $employee->pan_no }}</p>
            </div>
        </div>

        <table class="salary-details">
            <thead>
                <tr>
                    <th>Salary Heads</th>
                    <th>Current Month</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>Basic</td><td>{{ $employee->basic }}</td></tr>
                <tr><td>HRA</td><td>{{ $employee->hra }}</td></tr>
                <tr><td>CA</td><td>{{ $employee->ca }}</td></tr>
                <tr><td>SPL Allowance</td><td>{{ $employee->spl_all }}</td></tr>
                <tr><td>Bonus</td><td>{{ $employee->bonus_if_any }}</td></tr>
                <tr><td>Over Time</td><td>{{ $employee->over_time }}</td></tr>
            </tbody>
        </table>

        <table class="deductions">
            <thead>
                <tr>
                    <th>Deductions</th>
                    <th>Current Month</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>PF</td><td>{{ $employee->epf }}</td></tr>
                <tr><td>ESI</td><td>{{ $employee->esi_salary }}</td></tr>
                <tr><td>Medical Insurance</td><td>{{ $employee->medical_insurance }}</td></tr>
                <tr><td>Prof. Tax</td><td>{{ $employee->professional_tax }}</td></tr>
                <tr><td>TDS</td><td>{{ $employee->tds_2024_2025 }}</td></tr>
                <tr><td>Loan</td><td>{{ $employee->loan_if_any }}</td></tr>
            </tbody>
        </table>

        <div class="totals">
            <p>Total: {{ $employee->total_earned_salary }}</p>
            <p>Net Payable (Rs): {{ $employee->net_payable }}</p>
        </div>
    </div>
</body>
</html>
