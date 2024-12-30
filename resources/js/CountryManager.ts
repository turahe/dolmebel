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

class CountryManager {
    private nameMap: Record<string, string> = {};
    private codeMap: Record<string, string> = {};

    constructor(data: Country[]) {
        this.initializeMaps(data);
    }

    private initializeMaps(data: Country[]): void {
        data.forEach(this.mapCodeAndName.bind(this));
    }

    private mapCodeAndName(country: Country): void {
        this.nameMap[country.name.toLowerCase()] = country.code;
        this.codeMap[country.code.toLowerCase()] = country.name;
    }

    public overwrite(countries: Country[]): void {
        if (!countries || !countries.length) return;
        countries.forEach((country: Country) => {
            const foundIndex: number = countryData.findIndex((item: Country) => {
                return item.code === country.code;
            });
            countryData[foundIndex] = country;
            this.mapCodeAndName(country);
        });
    }

    public getCode(name: string): string | undefined {
        return this.nameMap[name.toLowerCase()];
    }

    public getName(code: string): string | undefined {
        return this.codeMap[code.toLowerCase()];
    }

    public getNames(): string[] {
        return countryData.map((country: Country) => country.name);
    }

    public getCodes(): string[] {
        return countryData.map((country: Country) => country.code);
    }

    public getCodeList(): Record<string, string> {
        return this.codeMap;
    }

    public getNameList(): Record<string, string> {
        return this.nameMap;
    }

    public getData(): Country[] {
        return countryData;
    }
}

const countryManager = new CountryManager(countryData as Country[]);
export default countryManager;
