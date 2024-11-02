import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        react(),
    ],
});


// import { defineConfig } from 'vite';
// import laravel from 'laravel-vite-plugin';
// import react from '@vitejs/plugin-react';
//
// export default defineConfig({
//     plugins: [
//         laravel({
//             input: 'resources/js/app.js',
//           //  ssr: 'resources/js/ssr.js',
//             refresh: true,
//         }),
//         react(),
//     ],
//     esbuild: {
//         loader: "jsx",
//         include: /src\/.*\.jsx?$/,
//         exclude: [],
//     },
//     optimizeDeps: {
//         esbuildOptions: {
//             plugins: [
//                 {
//                     name: "load-js-files-as-jsx",
//                     setup(build) {
//                         build.onLoad({ filter: /src\/.*\.js$/ }, async (args) => ({
//                             loader: "jsx",
//                             contents: await fs.readFile(args.path, "utf8"),
//                         }));
//                     },
//                 },
//             ],
//         },
//     },
// });
