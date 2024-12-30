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

import countryData from '@/data/country';
import { Country } from '@/interface';

const nameMap: Record<string, string> = {};
const codeMap: Record<string, string> = {};

(countryData as Country[]).forEach(mapCodeAndName);

function mapCodeAndName(country: Country): void {
    nameMap[country.name.toLowerCase()] = country.code;
    codeMap[country.code.toLowerCase()] = country.name;
}

export function overwrite(countries: Country[]): void {
    if (!countries || !countries.length) return;
    countries.forEach((country: Country) => {
        const foundIndex: number = (countryData as Country[]).findIndex((item: Country) => {
            return item.code === country.code;
        });
        (countryData as Country[])[foundIndex] = country;
        mapCodeAndName(country);
    });
}

export function getCode(name: string): string | undefined {
    return nameMap[name.toLowerCase()];
}

export function getName(code: string): string | undefined {
    return codeMap[code.toLowerCase()];
}

export function getNames(): string[] {
    return (countryData as Country[]).map((country: Country) => {
        return country.name;
    });
}

export function getCodes(): string[] {
    return (countryData as Country[]).map((country: Country) => {
        return country.code;
    });
}

export function getCodeList(): Record<string, string> {
    return codeMap;
}

export function getNameList(): Record<string, string> {
    return nameMap;
}

export function getData(): Country[] {
    return countryData as Country[];
}
