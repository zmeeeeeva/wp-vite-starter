import path from 'path';
import fs from 'fs';

import {
	defineConfig,
	loadEnv,
} from 'vite';

import tailwindcss from '@tailwindcss/vite';
import react from '@vitejs/plugin-react-swc';
import mkcert from 'vite-plugin-mkcert';

export default defineConfig(({ mode }) => {
	const env = loadEnv(mode, process.cwd(), '');

	const {
		HOME,
		THEME_NAME,
		WP_HOST,
		VITE_PORT,
	} = env;

	return {
		root: '.',
		base: '',
		build: {
			manifest: true,
			outDir: path.resolve(__dirname, `web/app/themes/${THEME_NAME}/public`),
			emptyOutDir: true,
			rollupOptions: {
				input: {
					app: path.resolve(__dirname, 'src/scripts/app.js'),
				},
			},
		},
		plugins: [
			tailwindcss(),
			react({
				include: ['**/*.js', '**/*.jsx'],
				jsxRuntime: 'automatic',
			}),
			mkcert(),
		],
		css: {
			postcss: './postcss.config.js',
		},
		server: {
			https: {
				key: fs.readFileSync(
					`${HOME}/.config/valet/Certificates/${WP_HOST}.key`,
				),
				cert: fs.readFileSync(
					`${HOME}/.config/valet/Certificates/${WP_HOST}.crt`,
				),
			},
			host: `${WP_HOST}`,
			port: `${VITE_PORT}`,
			origin: `https://${WP_HOST}:${VITE_PORT}`,
			cors: true,
			hmr: {
				protocol: 'wss',
				host: WP_HOST,
				port: VITE_PORT,
			},
		},
	};
});
