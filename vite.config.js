import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";

export default defineConfig({
    plugins: [
        react({
            include: "**/*.{jsx,tsx}",
        }),
        laravel({
            input: ["resources/css/app.css", "resources/js/app.jsx", "resources/js/report-modal-bridge.jsx"],
            refresh: true,
        }),
    ],
});
