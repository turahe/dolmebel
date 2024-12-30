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

import { describe, it, expect, beforeEach } from 'vitest';
import countryManager from '@/CountryManager'; // Adjust the import path as necessary
import { Country } from '@/interface';

const mockCountryData: Country[] = [
    { name: 'United States', code: 'US' },
    { name: 'Canada', code: 'CA' },
    { name: 'Mexico', code: 'MX' }
];

describe('CountryManager', () => {
    beforeEach(() => {
        countryManager.overwrite(mockCountryData);
    });

    it('should get the correct code for a given name', () => {
        expect(countryManager.getCode('United States')).toBe('US');
        expect(countryManager.getCode('Canada')).toBe('CA');
        expect(countryManager.getCode('Mexico')).toBe('MX');
    });

    it('should get the correct name for a given code', () => {
        expect(countryManager.getName('US')).toBe('United States');
        expect(countryManager.getName('CA')).toBe('Canada');
        expect(countryManager.getName('MX')).toBe('Mexico');
    });

    it('should return all country names', () => {
        expect(countryManager.getNames()).toEqual(['United States', 'Canada', 'Mexico']);
    });

    it('should return all country codes', () => {
        expect(countryManager.getCodes()).toEqual(['US', 'CA', 'MX']);
    });

    it('should return the name map', () => {
        expect(countryManager.getNameList()).toEqual({
            'united states': 'US',
            'canada': 'CA',
            'mexico': 'MX'
        });
    });

    it('should return the code map', () => {
        expect(countryManager.getCodeList()).toEqual({
            'us': 'United States',
            'ca': 'Canada',
            'mx': 'Mexico'
        });
    });

    it('should overwrite country data', () => {
        const newCountryData: Country[] = [
            { name: 'France', code: 'FR' },
            { name: 'Germany', code: 'DE' }
        ];

        countryManager.overwrite(newCountryData);

        expect(countryManager.getNames()).toEqual(['France', 'Germany']);
        expect(countryManager.getCodes()).toEqual(['FR', 'DE']);
        expect(countryManager.getCode('France')).toBe('FR');
        expect(countryManager.getName('DE')).toBe('Germany');
    });

    it('should return the full country data', () => {
        expect(countryManager.getData()).toEqual(mockCountryData);
    });

    it('should return undefined for non-existent names and codes', () => {
        expect(countryManager.getCode('Unknown')).toBeUndefined();
        expect(countryManager.getName('XX')).toBeUndefined();
    });
});
