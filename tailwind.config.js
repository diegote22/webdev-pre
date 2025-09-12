import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';
import daisyui from 'daisyui';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './node_modules/daisyui/dist/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['"Clash Display"', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'primary': '#0f0f0f',
                'accent-blue': '#0052ff',
                'accent-pink': '#ff00c1',
                'light-gray': '#f8f8f8',
            }
        },
    },

    plugins: [forms, typography, daisyui],

    daisyui: {
        themes: ['light', 'dark', 'cupcake'],
        darkTheme: 'dark',
        base: true,
        styled: true,
        utils: true,
        logs: false,
    },
};
