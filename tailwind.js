const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    prefix: 'ca-',
    // important: true,
    future: {
        removeDeprecatedGapUtilities: true,
        purgeLayersByDefault: true,
    },
    purge: {
        enabled: process.env.NODE_ENV === 'production',
        content: [
            '**/*.php',
            '**/*.html',
            '**/*.js',
        ],
    },
    theme: {
        fontFamily: {
            'sans': ['"NeoSansPro"', 'sans-serif'],
            'body': ['"NeoSansPro"', 'sans-serif'],
            'display': ['"NeoSansPro"', 'sans-serif'],
        },
        extend: {
            fontFamily: {
                sans: ['"NeoSansPro"', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#00b5eb',
                'primary-dark': '#008eb8',
                secondary: '#c7eaf5',
                text: '#444444',
                white: '#FFFFFF',
                lightgrey: '#eeeeee',
                santander: '#ed1717'

            },
            screens: {
                'xs': {'max': '375px'},
                '2xl': {'min': '1281px', 'max': '1366px'},
            },
            spacing: {
                '14': '3.25rem',
                '72': '18rem',
                '80': '20rem',
                '84': '21rem',
                '96': '24rem',
            }
        },

    },
    variants: {
        backgroundColor: ['responsive', 'hover', 'focus', 'active']
    },
    plugins: [
        function ({ addComponents }) {
            addComponents({
                '.container': {
                    maxWidth: '100%',
                    '@screen sm': {
                        maxWidth: '640px',
                    },
                    '@screen md': {
                        maxWidth: '768px',
                    },
                    '@screen lg': {
                        maxWidth: '1280px',
                    },
                    '@screen xl': {
                        maxWidth: '1366px',
                    },
                }
            })
        }
    ],
}
