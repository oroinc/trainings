module.exports = {
    content: [
        "./src/**/Resources/public/js/**/*.{js,jsx}"
    ],
    theme: {
        extend: {},
    },
    plugins: [
        require('@tailwindcss/typography'),
        require('@tailwindcss/forms'),
        require('@tailwindcss/aspect-ratio')
    ]
}
