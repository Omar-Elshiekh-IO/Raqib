<?php

// private static $executor;
// private static const OPERATORS = ['+', '-', '*', '/', '(', ')', '.', ' ', '^'];

// private static array $errors = [];

namespace App\Helpers;

class FormulaValidator
{

  // make the localization of these vars

  private const VARIABLES = [
    'base_salary',
    'allowances',
    'commission',
    'insurance',
    'overtime',
    'late_minutes',
    'excuse_deductions',
    'loan_deductions',
    'leave_deductions',
    'saturation_deductions',
    'other_payments'
  ];

  private const ARABIC_VARIABLES = [
    "الراتب الأساسي" => "base_salary",
    "البدلات" => "allowances",
    "العمولة" => "commission",
    "التأمين" => "insurance",
    "العمل الإضافي" => "overtime",
    "دقائق التأخير" => "late_minutes",
    "خصومات الأعذار" => "excuse_deductions",
    "خصومات القروض" => "loan_deductions",
    "خصومات الإجازات" => "leave_deductions",
    "خصومات التشبع" => "saturation_deductions",
    "المدفوعات الأخرى" => "other_payments",
  ];

  private static function translateArabicToEnglish(string $formula): string
  {
    $translatedFormula = $formula;
    foreach (self::ARABIC_VARIABLES as $arabic => $english) {
      $translatedFormula = str_replace($arabic, $english, $translatedFormula);
    }

    return $translatedFormula;
  }

  private static function isEmptyFormula(string $formula): bool
  {
    return trim($formula) === '';
  }

  private static function hasBalanceParentheses(string $formula): bool
  {
    $stack = [];
    $closeToOpen = [')' => '('];

    $chars = str_split($formula);

    foreach ($chars as $c) {
      if ($c === '(') {
        $stack[] = $c;
      } else if (isset($closeToOpen[$c])) {
        if (!empty($stack) && end($stack) === $closeToOpen[$c]) {
          array_pop($stack);
        } else {
          return false;
        }
      }
    }

    return empty($stack);
  }

  private static function hasDoubleOperators(string $formula): bool
  {
    return preg_match('/[\+\-\*\/\^]{2,}/', str_replace(' ', '', $formula));
  }

  private static function endsWithOperator(string $formula): bool
  {
    return preg_match('/[+\-*\/^]$/', trim($formula));
  }

  private static function checkUnknownVariables(string $formula): array
  {
    preg_match_all('/[a-zA-Z_][a-zA-Z0-9_]*/', $formula, $matches);
    $variables = array_unique($matches[0]);
    $unknowns = array_diff($variables, self::VARIABLES);
    return $unknowns;
  }

  private static function hasDivisionByZero(string $formula): bool
  {
    return preg_match('/\/\s*0+(?:\.0*)?(?![0-9.])/', $formula);
  }

  private static function startsWithInvalidOperator(string $formula): bool
  {
    return preg_match('/^[\*\/\^]/', trim($formula));
  }

  private static function hasMisplacedOperators(string $formula): bool
  {
    // Illegal patterns like: */, /*, +*, -/, etc.
    // return preg_match('/([\+\*\/\^]{1})\s*([\+\*\/\^]{1})/', $formula);
    return preg_match('/([\+\*\/\^])\s*([\+\-\*\/\^])|([\-])\s*([\*\/\^])/', $formula);
  }

  private static function hasValidCharacters(string $formula): bool
  {
    return preg_match('/^[a-zA-Z0-9_+\-*\/^().\s]+$/', $formula);
  }

  private static function hasEmptyParentheses(string $formula): bool
  {
    return preg_match('/\(\s*\)/', $formula);
  }

  private static function hasConsecutiveVariables(string $formula): bool
  {
    $cleanFormula = preg_replace('/\s+/', '', $formula);
    $varPattern = '(?:' . implode('|', array_map('preg_quote', self::VARIABLES)) . ')';

    // Look for variable followed by variable without operator/parenthesis
    return preg_match('/' . $varPattern . '(?![+\-*\/^()])' . $varPattern . '/', $cleanFormula);
  }

  private static function hasMissingOperatorsAroundParentheses(string $formula): bool
  {
    $cleanFormula = str_replace(' ', '', $formula);
    return preg_match('/\d\(|\)\d|[a-zA-Z_]\(|\)[a-zA-Z_]/', $cleanFormula);
  }

  private static function hasOperatorAfterOpenParentheses(string $formula): bool
  {
    return preg_match('/\(\s*[\+\*\/\^]/', $formula);
  }

  private static function hasOperatorBeforeCloseParentheses(string $formula): bool
  {
    return preg_match('/[\+\-\*\/\^]\s*\)/', $formula);
  }

  private static function hasInvalidDecimals(string $formula): bool
  {
    // Check for multiple decimal points in a number like 5.5.5 or basic_salary..5
    return preg_match('/\d+\.\d*\.|\.\d*\.|\.\{2,}/', $formula);
  }

  private static function hasNumberVariableAdjacency(string $formula): bool
  {
    $cleanFormula = str_replace(' ', '', $formula);
    $varPattern = '(?:' . implode('|', array_map('preg_quote', self::VARIABLES)) . ')';

    // Check for patterns like: 5basic_salary or basic_salary5
    // Use word boundaries to ensure we match complete variables
    return preg_match('/\d' . $varPattern . '\b|\b' . $varPattern . '\d/', $cleanFormula);
  }

  public static function getSupportedVariables(): array
  {
    return self::VARIABLES;
  }

  public static function validateFormula(string $formula): string
  {
    $translatedFormula = self::translateArabicToEnglish($formula);

    if (self::isEmptyFormula($translatedFormula)) {
      return "Invalid Formula: Formula is empty.";
    }

    if (!self::hasValidCharacters($translatedFormula)) {
      return "Invalid Formula: Invalid characters found.";
    }

    if (!self::hasBalanceParentheses($translatedFormula)) {
      return "Invalid Formula: Unbalanced parentheses.";
    }

    if (self::startsWithInvalidOperator($translatedFormula)) {
      return "Invalid Formula: Starts with an operator.";
    }

    $unknowns = self::checkUnknownVariables($translatedFormula);
    if (!empty($unknowns)) {
      return "Invalid Formula: Contains unknown variables: " . implode(', ', $unknowns);
    }

    if (self::hasNumberVariableAdjacency($translatedFormula)) {
      return "Invalid Formula: Numbers and variables must be separated by operators.";
    }

    if (self::hasInvalidDecimals($translatedFormula)) {
      return "Invalid Formula: Invalid decimal number format.";
    }

    if (self::hasConsecutiveVariables($translatedFormula)) {
      return "Invalid Formula: Two or more consecutive variables.";
    }

    if (self::hasDivisionByZero($translatedFormula)) {
      return "Invalid Formula: Can not divide by zero.";
    }

    if (self::hasEmptyParentheses($translatedFormula)) {
      return "Invalid Formula: Empty parentheses.";
    }

    if (self::hasDoubleOperators($translatedFormula) || self::hasMisplacedOperators($translatedFormula)) {
      return "Invalid Formula: Invalid operator sequence.";
    }

    if (self::hasOperatorAfterOpenParentheses($translatedFormula)) {
      return "Invalid Formula: Invalid operator after opening parenthesis.";
    }

    if (self::hasOperatorBeforeCloseParentheses($translatedFormula)) {
      return "Invalid Formula: Invalid operator before closing parenthesis.";
    }

    if (self::hasMissingOperatorsAroundParentheses($translatedFormula)) {
      return "Invalid Formula: Missing operators around parentheses.";
    }

    if (self::endsWithOperator($translatedFormula)) {
      return "Invalid Formula: Ends with an operator.";
    }

    return $translatedFormula;
  }
}


//   public function checkInvalidCharacters(string $formula): array
// {
//     $invalidChars = [];

//     $cleanFormula = preg_replace('/[a-zA-Z0-9_\s]/', '', $formula);

//     for ($i = 0; $i < strlen($cleanFormula); $i++) {
//         $char = $cleanFormula[$i];
//         if (!in_array($char, $this->allowedOperators)) {
//             $invalidChars[] = $char;
//         }
//     }

//     return array_unique($invalidChars);
// }

//     public function validateFormula(string $formula): array {
//     $allowedCharsPattern = '/[^0-9a-zA-Z+\-*/^().\s]/';
//     $operators = ['+', '-', '*', '/', '^'];

//     // 1. Invalid characters
//     if (preg_match_all($allowedCharsPattern, $formula, $matches, PREG_OFFSET_CAPTURE)) {
//         $errors = [];
//         foreach ($matches[0] as $match) {
//             $errors[] = "Invalid character '{$match[0]}' at position {$match[1]}";
//         }
//         return ['valid' => false, 'errors' => $errors];
//     }

//     // Store original formula for accurate position reporting
//     $originalFormula = $formula;

//     // Remove whitespace
//     $formula = preg_replace('/\s+/', '', $formula);

//     // 2. Empty formula
//     if ($formula === '') {
//         return ['valid' => false, 'errors' => ['Formula is empty']];
//     }

//     $length = strlen($formula);
//     $prevChar = '';
//     $errors = [];

//     for ($i = 0; $i < $length; $i++) {
//         $char = $formula[$i];

//         // Check for operator at start (except unary -)
//         if ($i === 0 && in_array($char, $operators) && $char !== '-') {
//             $errors[] = "Formula cannot start with operator '$char'";
//         }

//         // Check for two consecutive operators
//         if (in_array($char, $operators) && in_array($prevChar, $operators)) {
//             // Allow negative sign after operators and opening parenthesis
//             if (!($char === '-' && ($prevChar === '(' || in_array($prevChar, $operators)))) {
//                 $errors[] = "Two operators in a row: '$prevChar$char' at position $i";
//             }
//         }

//         // Check for operator at end
//         if ($i === $length - 1 && in_array($char, $operators)) {
//             $errors[] = "Formula cannot end with operator '$char'";
//         }

//         // Check for consecutive dots (invalid decimal)
//         if ($char === '.' && $prevChar === '.') {
//             $errors[] = "Invalid decimal format: consecutive dots at position $i";
//         }

//         // Check for dot after operator without digit
//         if ($char === '.' && in_array($prevChar, $operators)) {
//             if ($i === $length - 1 || !ctype_digit($formula[$i + 1])) {
//                 $errors[] = "Invalid decimal format: dot after operator at position $i";
//             }
//         }

//         // Check for dot before operator without digit
//         if (in_array($char, $operators) && $prevChar === '.') {
//             $errors[] = "Invalid decimal format: dot before operator at position $i";
//         }

//         $prevChar = $char;
//     }

//     // 3. Parentheses check
//     if (!$this->hasBalanceParentheses($formula)) {
//         $errors[] = "Unbalanced parentheses";
//     }

//     // 4. Additional validations
//     $additionalErrors = $this->validateAdditionalRules($formula);
//     $errors = array_merge($errors, $additionalErrors);

//     if (!empty($errors)) {
//         return ['valid' => false, 'errors' => $errors];
//     }

//     return ['valid' => true];
// }

// private static function validateAdditionalRules(string $formula): array {
//     $errors = [];

//     // Check for empty parentheses
//     if (strpos($formula, '()') !== false) {
//         $errors[] = "Empty parentheses are not allowed";
//     }

//     // Check for function-like patterns without proper operators
//     if (preg_match('/[a-zA-Z]\(/', $formula)) {
//         $errors[] = "Function-like syntax detected but not supported";
//     }

//     // Check for multiple consecutive dots in numbers
//     if (preg_match('/\d+\..*\./', $formula)) {
//         $errors[] = "Invalid number format: multiple decimal points";
//     }

//     // Check for operators immediately after opening parenthesis (except -)
//     if (preg_match('/\([+*/^]/', $formula)) {
//         $errors[] = "Invalid operator immediately after opening parenthesis";
//     }

//     // Check for operators immediately before closing parenthesis
//     if (preg_match('/[+\-*/^]\)/', $formula)) {
//         $errors[] = "Invalid operator immediately before closing parenthesis";
//     }

//     return $errors;
// }