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

export default function contactForm() {
    return {
        formData: {
            name: '',
            email: '',
            message: '',
        },
        message: '',

        submitData() {
            this.message = '';

            fetch('/contact', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(this.formData),
            })
                .then(() => {
                    this.message = 'Form sucessfully submitted!';
                })
                .catch(() => {
                    this.message = 'Ooops! Something went wrong!';
                });
        },
    };
}
