import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                poppins: ['Poppins', ...defaultTheme.fontFamily.sans],
                'poppins-400': ['Poppins 400', ...defaultTheme.fontFamily.sans],
                'poppins-500': ['Poppins 500', ...defaultTheme.fontFamily.sans],
                'poppins-600': ['Poppins 600', ...defaultTheme.fontFamily.sans],
                'poppins-700': ['Poppins 700', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    500: '#308478',
                    600: '#236b5b',
                },
                basecol: '#F5F5F5',
            },
        },
    },

    plugins: [forms],
};
