/** @type {import('tailwindcss').Config} */
export default {
	content: [
		'./src/**/*.{js,ts,jsx,tsx,css}',
	],
	theme: {
		extend: {
			spacing: {
				'layout': 'var(--spacing-layout)',
			}
		},
	},
	plugins: [],
};
