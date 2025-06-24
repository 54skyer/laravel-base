<?php

namespace App\Rules;

use App\Enum\Environment;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rules\Password;

class PasswdEasy implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // 非生产环境使用 简单密码规则
        if (App::environment(Environment::PROD)) {
            $passwordRule = Password::min(8);

            if (!$passwordRule->passes($attribute, $value)) {
                $fail("密码最少需要8个字符");
            }

            $passwordRule->letters()->mixedCase()->numbers();
            if (!$passwordRule->passes($attribute, $value)) {
                $fail("密码必须同时包含大小写字母和数字");
            }
        } else {
            $passwordRule = Password::min(6);

            if (!$passwordRule->passes($attribute, $value)) {
                $fail("密码最少需要6个字符");
            }
        }
    }
}
