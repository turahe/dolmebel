function phoneNumberMask(input: string): string {
    return input.startsWith("62") ? "9999 999999 99999" : "9999 9999 9999 9999";
}

export { phoneNumberMask };
