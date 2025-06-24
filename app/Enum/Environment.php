<?php

namespace App\Enum;

/** 开发环境 */
enum Environment: string
{
    // 本地
    case LOCAL = 'local';

    // 开发
    case DEV = 'dev';

    // 测试
    case TEST = 'test';

    // 生产
    case UAT = 'uat';

    // 生产
    case PROD = 'prod';

    public function translate(): string
    {
        return match ($this) {
            self::LOCAL => "本地环境",
            self::DEV => "开发环境",
            self::TEST => "测试环境",
            self::UAT => "UAT环境",
            self::PROD => "生产环境",
        };
    }
}
