/*
 * DolMebel - https://www.dolmebel.com
 *
 * @version   1.0.0
 *
 * @link      Releases - https://www.wach.id/releases
 * @link      Terms Of Service - https://www.wach.id/terms
 *
 * Copyright (c) 2024.
 *
 */

function phoneNumberMask(input: string): string {
    return input.startsWith('62') ? '9999 999999 99999' : '9999 9999 9999 9999';
}

export { phoneNumberMask };
