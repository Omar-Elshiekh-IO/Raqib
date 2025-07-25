<?php

// use App\Helpers\FormulaValidator;

// require 'FormulaValidator.php';

// $validator = new FormulaValidator();

// $testCases = [
//     // ✅ Valid numeric formulas
//     ['formula' => '1 + 2', 'expected' => true],
//     ['formula' => '(1 + 2) * 3.5', 'expected' => true],
//     ['formula' => '((5.2 + 3) * 2 - 4) / 2', 'expected' => true],
//     ['formula' => '4.5 * (2 - 0.5)', 'expected' => true],
//     ['formula' => '1 + 2 - 3 * 4 / 5 ^ 6', 'expected' => true],

//     // ❌ Invalid characters
//     ['formula' => '1 + 2$', 'expected' => false],
//     ['formula' => '3 @ 4', 'expected' => false],

//     // ❌ Unbalanced parentheses
//     ['formula' => '(1 + 2', 'expected' => false],
//     ['formula' => '1 + 2)', 'expected' => false],

//     // ❌ Two operators in a row
//     ['formula' => '1 ++ 2', 'expected' => false],
//     ['formula' => '3 -- 4', 'expected' => false],

//     // ❌ Starts or ends with invalid operator
//     ['formula' => '+1 + 2', 'expected' => false],
//     ['formula' => '1 + 2 -', 'expected' => false],

//     // ❌ Consecutive dots
//     ['formula' => '3..5 + 1', 'expected' => false],

//     // ❌ Dot after operator with no digit
//     ['formula' => '2 + .', 'expected' => false],

//     // ❌ Dot before operator
//     ['formula' => '2. + +3', 'expected' => false],

//     // ❌ Empty parentheses
//     ['formula' => '1 + () + 2', 'expected' => false],

//     // ❌ Operator right after (
//     ['formula' => '(+2 + 3)', 'expected' => false],

//     // ❌ Operator before )
//     ['formula' => '(2 + 3+)', 'expected' => false],

//     // ❌ Multiple errors
//     ['formula' => '(1 ++ 2 +)', 'expected' => false],
// ];

// foreach ($testCases as $index => $testCase) {
//     $result = $validator->validateFormula($testCase['formula']);
//     echo "Test Case #".($index + 1).": '{$testCase['formula']}'\n";
//     echo "Expected: " . ($testCase['expected'] ? 'Valid' : 'Invalid') . "\n";
//     echo "Result:   " . ($result['valid'] ? 'Valid' : 'Invalid') . "\n";
//     if (!$result['valid']) {
//         echo "Errors:\n";
//         var_dump($result['errors']);
//     }
//     echo str_repeat('-', 40) . "\n";
// }

use NXP\MathExecutor;
$formula = "a * b - c /";
$excutor = new MathExecutor();

$excutor->setVar('a',1000);
$excutor->setVar('b',50);
$excutor->setVar('c',600);

$result = $excutor->execute($formula);

echo $result;