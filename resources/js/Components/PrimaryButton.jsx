import { Link } from '@inertiajs/react';

export default function PrimaryButton({ 
    className = '', 
    disabled, 
    children, 
    href, 
    asLink = false,
    ...props 
}) {
    const baseClasses = "inline-flex items-center gap-2 bg-blue-600 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-blue-200 hover:bg-blue-700 transition transform hover:-translate-y-1 " + className;

    if (href || asLink) {
        return (
            <Link
                href={href}
                className={baseClasses}
                {...props}
            >
                {children}
            </Link>
        );
    }

    return (
        <button
            {...props}
            className={baseClasses}
            disabled={disabled}
        >
            {children}
        </button>
    );
}
