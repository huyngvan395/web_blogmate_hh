import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.blade.php'
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Roboto', ...defaultTheme.fontFamily.sans],
            },
            // backgroundImage: {
            //     "bg-image-initial": "asset('images/image-background-web/blog_bg_ini.jpeg')"
            // },
            height:  {
                '120': '48rem',
                '100': '45.5rem',
                '9/10': '90%'
            },
            maxWidth: {
                '9/10':"90%",
                '65/100':"65%"
            },
            transitionDuration: {
                '2000': '2000ms'
            },
            spacing:{
                '120': '42rem'
            },
            animation:{
                fade: "fade 2s",
                textShow: "textShow 1.5s ease-out",
                componentShowToTop:"componentShowToTop 1s",
                navigationShow:"navigationShow 1s ease-out"
            },
            keyframes:{
                fade:{
                    'from': {
                        opacity:"0.4"
                    },
                    'to' : {
                        opacity:"1"
                    }
                },
                textShow:{
                    'from':{
                        transform: 'translateY(15rem)',
                        opacity:'0'
                    },
                    'to':{
                        transform: 'translateY(0rem)',
                        opacity:'1'
                    }
                },
                componentShowToTop:{
                    'from':{
                        transform: 'translateY(10rem)',
                        opacity: '0'
                    },
                    'to':{
                        transform: 'translateY(0)',
                        opacity: '1'
                    }
                },
                navigationShow:{
                    'from':{
                        opacity: '0',
                        transform: 'translateY(-1rem)'
                    },
                    'to':{
                        opacity: '1',
                        transform: 'translateY(0)'
                    }
                }
                
            }
        },
    },

    plugins:
        [forms,
            function ({ addComponents }) {
                addComponents({
                    '.bg-after-slide::after': {
                        content: "''",
                        position: "absolute",
                        top: "0",
                        left: "0",
                        width: "100%",
                        height: "100%",
                        backgroundImage: "linear-gradient(to right, black, transparent)",
                        zIndex: "1"
                    }
                })
            }
        ],
};
