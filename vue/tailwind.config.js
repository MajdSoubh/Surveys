/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    content: ["index.html", "./src/**/*.{vue,ts,jsx,html,js}"],
    theme: {
        extend: {
            keyframes: {
                "fade-in-down": {
                    from: {
                        transform: "translateY(-0.75rem)",
                        opacity: "0",
                    },
                    to: {
                        transform: "translateY(0)",
                        opacity: "1",
                    },
                },
            },
            animation: {
                "fade-in-down": "fade-in-down 0.2s ease-in-out both",
            },
        },
    },
    plugins: [require("@tailwindcss/forms")],
};
