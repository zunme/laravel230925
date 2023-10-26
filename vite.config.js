import { viteStaticCopy } from 'vite-plugin-static-copy'
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import {svelte} from "@sveltejs/vite-plugin-svelte";

export default defineConfig({
    plugins: [
        laravel({
            input: [
				//'resources/css/app.css', 'resources/js/app.js','resources/js/jquery.js', 
				'resources/js/svelte.js'],
            refresh: true,
        }),
		svelte(),
		/*
		viteStaticCopy({
			targets: [
				{
					src: 'resources/js/defaultjs.js',
					dest: 'js'
				},
			]
		})
		*/
    ],
	resolve: {
        alias: {
            '@': '/resources/js/',
        },
    },
});
