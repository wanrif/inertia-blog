const defaultTheme = require('tailwindcss/defaultTheme');
const svgToDataUri = require('mini-svg-data-uri');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./node_modules/flowbite/**/*.js",
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],
    darkMode: 'class',
    theme: {
        screens: {
            'sm': '576px',
            // => @media (min-width: 640px) { ... }

            'md': '768px',
            // => @media (min-width: 768px) { ... }

            'lg': '992px',
            // => @media (min-width: 1024px) { ... }

            'xl': '1200px',
            // => @media (min-width: 1280px) { ... }

            '2xl': '1458px',
            // => @media (min-width: 1536px) { ... }
        },
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                viga: ['Viga', 'Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'shark': {
                    '50': '#f4f5f7',
                    '100': '#e4e5e9',
                    '200': '#cbcdd6',
                    '300': '#a7aab9',
                    '400': '#7c8094',
                    '500': '#616579',
                    '600': '#535467',
                    '700': '#474757',
                    '800': '#3f3f4b',
                    '900': '#1e1e23',
                },
                'quill-gray': {
                    '50': '#f6f7f6',
                    '100': '#dfe1dd',
                    '200': '#c7cbc4',
                    '300': '#a3a99f',
                    '400': '#80877a',
                    '500': '#646c60',
                    '600': '#4f554c',
                    '700': '#41463f',
                    '800': '#363a35',
                    '900': '#30332e',
                },
                'accent': '#df4139',
                'accent-2': '#159dbc',
            },
            typography: ({ theme }) => ({
                dark: {
                    css: {
                        '--tw-prose-body': theme('colors.slate[800]'),
                        '--tw-prose-headings': theme('colors.slate[900]'),
                        '--tw-prose-lead': theme('colors.slate[700]'),
                        '--tw-prose-links': theme('colors.slate[900]'),
                        '--tw-prose-bold': theme('colors.slate[900]'),
                        '--tw-prose-counters': theme('colors.slate[600]'),
                        '--tw-prose-bullets': theme('colors.slate[400]'),
                        '--tw-prose-hr': theme('colors.slate[300]'),
                        '--tw-prose-quotes': theme('colors.slate[900]'),
                        '--tw-prose-quote-borders': theme('colors.slate[300]'),
                        '--tw-prose-captions': theme('colors.slate[700]'),
                        '--tw-prose-code': theme('colors.slate[900]'),
                        '--tw-prose-pre-code': theme('colors.slate[100]'),
                        '--tw-prose-pre-bg': theme('colors.slate[900]'),
                        '--tw-prose-th-borders': theme('colors.slate[300]'),
                        '--tw-prose-td-borders': theme('colors.slate[200]'),
                        '--tw-prose-invert-body': theme('colors.slate[200]'),
                        '--tw-prose-invert-headings': theme('colors.slate[200]'),
                        '--tw-prose-invert-lead': theme('colors.slate[300]'),
                        '--tw-prose-invert-links': theme('colors.white'),
                        '--tw-prose-invert-bold': theme('colors.white'),
                        '--tw-prose-invert-counters': theme('colors.slate[400]'),
                        '--tw-prose-invert-bullets': theme('colors.slate[600]'),
                        '--tw-prose-invert-hr': theme('colors.slate[700]'),
                        '--tw-prose-invert-quotes': theme('colors.slate[100]'),
                        '--tw-prose-invert-quote-borders': theme('colors.slate[700]'),
                        '--tw-prose-invert-captions': theme('colors.slate[400]'),
                        '--tw-prose-invert-code': theme('colors.white'),
                        '--tw-prose-invert-pre-code': theme('colors.slate[300]'),
                        '--tw-prose-invert-pre-bg': 'rgb(0 0 0 / 50%)',
                        '--tw-prose-invert-th-borders': theme('colors.slate[600]'),
                        '--tw-prose-invert-td-borders': theme('colors.slate[700]'),
                    }
                }
            }),
            backgroundImage: (theme) => ({
                'multiselect-caret': `url("${svgToDataUri(
                    `<svg viewBox="0 0 320 512" class="fill-current" xmlns="http://www.w3.org/2000/svg"><path d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z"></path></svg>`,
                )}")`,
                'multiselect-spinner': `url("${svgToDataUri(
                    `<svg viewBox="0 0 512 512" fill="${theme('colors.indigo.500')}" xmlns="http://www.w3.org/2000/svg"><path d="M456.433 371.72l-27.79-16.045c-7.192-4.152-10.052-13.136-6.487-20.636 25.82-54.328 23.566-118.602-6.768-171.03-30.265-52.529-84.802-86.621-144.76-91.424C262.35 71.922 256 64.953 256 56.649V24.56c0-9.31 7.916-16.609 17.204-15.96 81.795 5.717 156.412 51.902 197.611 123.408 41.301 71.385 43.99 159.096 8.042 232.792-4.082 8.369-14.361 11.575-22.424 6.92z"></path></svg>`,
                )}")`,
                'multiselect-remove': `url("${svgToDataUri(
                    `<svg viewBox="0 0 320 512" class="fill-current" xmlns="http://www.w3.org/2000/svg"><path d="M207.6 256l107.72-107.72c6.23-6.23 6.23-16.34 0-22.58l-25.03-25.03c-6.23-6.23-16.34-6.23-22.58 0L160 208.4 52.28 100.68c-6.23-6.23-16.34-6.23-22.58 0L4.68 125.7c-6.23 6.23-6.23 16.34 0 22.58L112.4 256 4.68 363.72c-6.23 6.23-6.23 16.34 0 22.58l25.03 25.03c6.23 6.23 16.34 6.23 22.58 0L160 303.6l107.72 107.72c6.23 6.23 16.34 6.23 22.58 0l25.03-25.03c6.23-6.23 6.23-16.34 0-22.58L207.6 256z"></path></svg>`,
                )}")`,
            }),
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('flowbite/plugin'),
    ],
};
