import { viteStaticCopy } from 'vite-plugin-static-copy'
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js','resources/js/jquery.js'],
            refresh: true,
        }),
		
		viteStaticCopy({
			targets: [
				{
					src: 'resources/js/defaultjs.js',
					dest: 'js'
				},
			]
		})
		
    ],
	resolve: {
        alias: {
            '@': '/resources/js/',
        },
    },
});
