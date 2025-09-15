const defaultTheme = require('tailwindcss/defaultTheme');
const forms = require('@tailwindcss/forms');
const typography = require('@tailwindcss/typography');
const daisyui = require('daisyui');

/** @type {import('tailwindcss').Config} */
module.exports = {
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
        primary: '#0f0f0f',
        'accent-blue': '#0052ff',
        'accent-pink': '#ff00c1',
        'light-gray': '#f8f8f8',
      },
    },
  },
  plugins: [forms, typography, daisyui],
  daisyui: {
    themes: [
      'light',
      {
        branddark: {
          primary: '#3E5641',
          'primary-content': '#F0F0F0',
          secondary: '#004D61',
          accent: '#822659',
          neutral: '#2a2a2a',
          'neutral-content': '#F0F0F0',
          'base-100': '#1A1A1A',
          'base-200': '#151515',
          'base-300': '#0F0F0F',
          'base-content': '#F0F0F0',
          info: '#0ea5e9',
          success: '#16a34a',
          warning: '#f59e0b',
          error: '#ef4444',
        },
      },
      'cupcake',
    ],
    darkTheme: 'branddark',
    base: true,
    styled: true,
    utils: true,
    logs: false,
  },
};
