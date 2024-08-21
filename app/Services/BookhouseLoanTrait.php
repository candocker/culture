<?php

namespace ModuleCulture\Services;

use Swoolecan\Foundation\Helpers\DatetimeTool;

trait BookhouseLoanTrait
{
    public function myLoan()
    {
        $monthObj = DatetimeTool::getCarbonObj('2019-05');
        $currentMonthObj = DatetimeTool::getCarbonObj();

        $firstInterest = '281.55';
        $loanAmount = 1970000;
        $loanPeriod = 312;
        $loans = [
            ['interestRate' => 5.145, 'loanNum' => 20, 'loanAmount' => '1907133.24'],
            ['interestRate' => 4.995, 'loanNum' => 24, 'loanAmount' => '1822537.11'],
            ['interestRate' => 4.645, 'loanNum' => 8, 'loanAmount' => '1791037.78'],
            ['interestRate' => 4.719, 'loanNum' => 1, 'loanAmount' => '1785855.42'],
            ['interestRate' => 4.306, 'loanNum' => 3, 'loanAmount' => '1774218.19'],
            ['interestRate' => 4.2, 'loanNum' => 12, 'loanAmount' => '1721679.55'],
            ['interestRate' => 3.85, 'loanNum' => 244],
        ];
        $totalGahterData = [];
        $results = [];
        foreach ($loans as $loan) {
            $currentLoanNum = $loan['loanNum'];
            $result = $this->calculateEqualInstallmentPaymentSelf($loanAmount, $loanPeriod, $loan['interestRate'], $currentLoanNum);
            $loanPeriod -= $currentLoanNum;
            $last = $result[$currentLoanNum];
            $loanAmount = $loan['loanAmount'] ?? $last['remainingAmount'];

            $fResult = $this->formatResult($result, $monthObj, $currentMonthObj, $totalGatherData);
            $fResult['base'] = $loan;
            $results[] = $fResult;
        }
        return ['results' => $results, 'totalGatherData' => $totalGatherData];
    }

    public function formatResult($result, $monthObj, $currentMonthObj, & $totalGatherData)
    {
        $elems = ['principal', 'interest', 'monthlyPayment'];
        $eTypes = ['', 'Dealed', 'Total'];
        $gatherData = [];
        foreach ($elems as $elem) {
            foreach ($eTypes as $type) {
                $gatherData[$elem . $type] = 0;
            }
        }
        $totalGatherData = empty($totalGatherData) ? $gatherData : $totalGatherData;

        $nodealed = false;
        foreach ($result as & $data) {
            $monthObj = $monthObj->addMonth(1);
            $monthValue = $monthObj->format('Y-m');
            if ($monthObj->gt($currentMonthObj)) {
                $nodealed = true;
            }

            $data['monthValue'] = $monthValue;
            if ($monthValue == '2019-06') {
                $data['interest'] = '281.55';
            }
            foreach ($elems as $elem) {
                $gatherData[$elem . 'Total'] += $data[$elem];
                $totalGatherData[$elem . 'Total'] += $data[$elem];
                if ($nodealed) {
                    $gatherData[$elem] += $data[$elem];
                    $totalGatherData[$elem] += $data[$elem];
                } else {
                    $gatherData[$elem . 'Dealed'] += $data[$elem];
                    $totalGatherData[$elem . 'Dealed'] += $data[$elem];
                }
            }
        }
        return ['infos' => $result, 'gatherData' => $gatherData];
    }

    function calculateEqualInstallmentPaymentSelf($loanAmount, $loanPeriod, $interestRate, $validPeriod)
    {
        //var_dump($loanAmount);
        $monthlyInterestRate = $interestRate / 12 / 100;
        //$numOfMonthlyPayments = $loanPeriod * 12;
        $numOfMonthlyPayments = $loanPeriod;

        $monthlyPayment = $loanAmount * $monthlyInterestRate * pow(1 + $monthlyInterestRate, $numOfMonthlyPayments)
            / (pow(1 + $monthlyInterestRate, $numOfMonthlyPayments) - 1);

        $result = [];

        //for ($i = 1; $i <= $numOfMonthlyPayments; $i++) {
        for ($i = 1; $i <= $validPeriod; $i++) {
            $interest = $loanAmount * $monthlyInterestRate;
            $principal = $monthlyPayment - $interest;
            $remainingAmount = $loanAmount - $principal;

            $result[$i] = [
                'month' => $i,//期数
                'principal' => round($principal, 2),//期数
                'interest' => round($interest, 2),//月供本金
                'monthlyPayment' => round($monthlyPayment, 2),//月供总额
                'remainingAmount' => round($remainingAmount, 2),//剩余本金
            ];

            $loanAmount = $remainingAmount;
        }

        return $result;
    }

    function calculateEqualInstallmentPayment($loanAmount, $loanPeriod, $interestRate)
    {
        $monthlyInterestRate = $interestRate / 12 / 100;
        $numOfMonthlyPayments = $loanPeriod * 12;

        $monthlyPayment = $loanAmount * $monthlyInterestRate * pow(1 + $monthlyInterestRate, $numOfMonthlyPayments)
            / (pow(1 + $monthlyInterestRate, $numOfMonthlyPayments) - 1);

        $result = [];

        for ($i = 1; $i <= $numOfMonthlyPayments; $i++) {
            $interest = $loanAmount * $monthlyInterestRate;
            $principal = $monthlyPayment - $interest;
            $remainingAmount = $loanAmount - $principal;

            $result[$i] = [
                'month' => $i,//期数
                'principal' => round($principal, 2),//期数
                'interest' => round($interest, 2),//月供本金
                'monthlyPayment' => round($monthlyPayment, 2),//月供总额
                'remainingAmount' => round($remainingAmount, 2),//剩余本金
            ];

            $loanAmount = $remainingAmount;
        }

        return $result;
    }

    public function calculateEqualInstallmentPayment2($loanAmount, $loanPeriod, $interestRate)
    {
        $monthlyPrincipal = $loanAmount / ($loanPeriod * 12);
        $monthlyInterest = $loanAmount * ($interestRate / 100) / 12;
        $remainingAmount = $loanAmount;

        $result = [];

        for ($i = 1; $i <= $loanPeriod * 12; $i++) {
            $interest = $remainingAmount * ($interestRate / 100) / 12;
            $principal = $monthlyPrincipal;
            $remainingAmount -= $monthlyPrincipal;

            $monthlyPayment = $principal + $interest;

            $result[$i] = [
                'month' => $i,//期数
                'principal' => round($principal, 2),//月供本金
                'interest' => round($interest, 2),//月供利息
                'monthlyPayment' => round($monthlyPayment, 2),//月供总额
                'remainingAmount' => round($remainingAmount, 2),//剩余本金
            ];
        }

        return $result;
    }

    // 测试组合贷款计算()等额本息
    function calculateCombinationLoan($commercialLoanAmount, $commercialLoanPeriod, $commercialInterestRate, $fundLoanAmount, $fundLoanPeriod, $fundInterestRate)
    {
        // 计算商业贷款的还款计划
        $commercialRepayments = calculateEqualInstallmentPayment($commercialLoanAmount, $commercialLoanPeriod, $commercialInterestRate);

        // 计算公积金贷款的还款计划
        $fundRepayments = calculateEqualInstallmentPayment($fundLoanAmount, $fundLoanPeriod, $fundInterestRate);

        $arr_ti = $commercialRepayments;
        $arr_ti_duan = $fundRepayments;

        $newArray = [];
        foreach ($arr_ti as $is => $repayment) {
                $shangye_monthlyPayment = $repayment["monthlyPayment"] ?: 0;
                $jijin_monthlyPayment = $arr_ti_duan[$is]["monthlyPayment"] ?: 0;

            $newArray[] = [
                "month" => $repayment["month"],
                "jijin_monthlyPayment" => round($jijin_monthlyPayment, 2),
                "shangye_monthlyPayment" => round($shangye_monthlyPayment, 2),
                "monthlyPayment" => round(($repayment["monthlyPayment"] + $arr_ti_duan[$is]["monthlyPayment"]), 2),
                "interest" => round(($repayment["interest"] + $arr_ti_duan[$is]["interest"]), 2),
            ];
        }
        return $newArray;
    }

    // 测试组合贷款计算(等额本金)
    function calculatePrincipaltionLoan($commercialLoanAmount, $commercialLoanPeriod, $commercialInterestRate, $fundLoanAmount, $fundLoanPeriod, $fundInterestRate)
    {
        // 计算商业贷款的还款计划
        $commercialRepayments = calculateEqualPrincipalPayment($commercialLoanAmount, $commercialLoanPeriod, $commercialInterestRate);

        // 计算公积金贷款的还款计划
        $fundRepayments = calculateEqualPrincipalPayment($fundLoanAmount, $fundLoanPeriod, $fundInterestRate);

        $arr_ti = $commercialRepayments;
        $arr_ti_duan = $fundRepayments;


        $newArray = [];
        foreach ($arr_ti as $is => $repayment) {
                $shangye_monthlyPayment = $repayment["monthlyPayment"] ?: 0;
                $jijin_monthlyPayment = $arr_ti_duan[$is]["monthlyPayment"] ?: 0;

            $newArray[] = [
                "month" => $repayment["month"],
                "jijin_monthlyPayment" => round($jijin_monthlyPayment, 2),
                "shangye_monthlyPayment" => round($shangye_monthlyPayment, 2),
                "monthlyPayment" => round(($repayment["monthlyPayment"] + $arr_ti_duan[$is]["monthlyPayment"]), 2),
                "interest" => round(($repayment["interest"] + $arr_ti_duan[$is]["interest"]), 2),
            ];
        }
        return $newArray;
    }
}
