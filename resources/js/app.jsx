import "./bootstrap";
import "../css/app.css";

import { createRoot } from "react-dom/client";
import { createInertiaApp } from "@inertiajs/react";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";

const appName = import.meta.env.VITE_APP_NAME || "ANPUNDUNG";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        const pages = import.meta.glob([
            './Pages/**/*.jsx',
            '../../Modules/**/resources/assets/js/Pages/**/*.jsx'
        ]);

        // Standard Pages
        const path = `./Pages/${name}.jsx`;
        if (pages[path]) {
            return resolvePageComponent(path, pages);
        }

        // Modules: Attempt to map "Module/Page" -> "Modules/Module/.../Page.jsx"
        const parts = name.split('/');
        const moduleName = parts[0];
        const pageName = parts.slice(1).join('/');

        // Construct path: ../../Modules/[Module]/resources/assets/js/Pages/[Page].jsx
        // Note: The structure I created is Modules/Laporan/resources/assets/js/Pages/Index.jsx
        // So name="Laporan/Index" maps to .../Pages/Index.jsx
        
        const modulePath = `../../Modules/${moduleName}/resources/assets/js/Pages/${pageName}.jsx`;

        if (pages[modulePath]) {
            return resolvePageComponent(modulePath, pages);
        }

        // Fallback for standard resolvePageComponent to throw its usual error if not found
        return resolvePageComponent(path, pages);
    },
    setup({ el, App, props }) {
        const root = createRoot(el);
        root.render(<App {...props} />);
    },
    progress: {
        color: "#4B5563",
    },
});
